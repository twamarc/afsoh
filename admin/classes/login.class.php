<?php

require_once __DIR__ . "/user.class.php";

class Login extends User
{
    /** @var bool */
    public $login = false;

    /** Singleton accessor (PHP 8 safe) */
    public static function getInstance(): self
    {
        static $instance = null;
        if (!$instance instanceof self) {
            $instance = new self();
        }
        return $instance;
    }

    /** Initialize from table & auto-login via cookies */
    public function init(string $usertable): void
    {
        $this->usertable = $usertable;

        if ($this->username === null) {
            $this->username = $_COOKIE[$this->usertable . "_username"] ?? null;
        }
        if ($this->passwd === null) {
            $this->passwd = $_COOKIE[$this->usertable . "_passwd"] ?? null;
        }
        if ($this->status === null) {
            $this->status = $_COOKIE[$this->usertable . "_status"] ?? null;
        }

        $this->login();
    }

    /** Perform login using current username/password */
    public function login(): bool
    {
        global $db;

        if (!empty($this->username) && !empty($this->passwd)) {
            $u = addslashes($this->username);
            $p = $this->passwd;

            $numrows = $db->getOne(
                "SELECT COUNT(*) FROM {$this->usertable}
                 WHERE username = '{$u}' AND passwd = '{$p}' AND confirmed = TRUE"
            );

            if ((int)$numrows === 1) {
                $this->login = true;

                setcookie($this->usertable . "_username", $this->username, time() + 36000, "/");
                setcookie($this->usertable . "_passwd",   $this->passwd,   time() + 36000, "/");

                $row = $db->getRow(
                    "SELECT id, status FROM {$this->usertable}
                     WHERE username = '{$u}' AND passwd = '{$p}'"
                );

                if (class_exists("DB") && method_exists("DB", "isError") && DB::isError($row)) {
                    die($row->getMessage());
                }

                $id     = is_array($row) ? ($row[0] ?? null) : (is_object($row) ? ($row->id ?? null) : null);
                $status = is_array($row) ? ($row[1] ?? null) : (is_object($row) ? ($row->status ?? null) : null);

                if ($status !== null) {
                    $this->setStatus($status);
                    setcookie($this->usertable . "_status", (string)$this->status, time() + 36000, "/");
                }

                if ($id !== null && method_exists("User", "initById")) {
                    User::initById($id, $this->usertable);
                }
            }
        }

        return (bool)$this->login;
    }

    public function loginByUsername($username, $passwd): void
    {
        $this->setUsername($username);
        $this->setPasswd($passwd);
        $this->login();
    }

    public function isLogin(): bool
    {
        return (bool)$this->login;
    }

    public function update(): void
    {
        try { @parent::update(); } catch (\Throwable $e) {}

        if ($this->isLogin()) {
            setcookie($this->usertable . "_username", $this->username, time() + 86400, "/");
            setcookie($this->usertable . "_passwd",   $this->passwd,   time() + 86400, "/");
            setcookie($this->usertable . "_status",   (string)$this->status, time() + 86400, "/");
        }
    }

    public function logOut(): void
    {
        setcookie($this->usertable . "_username", "", time() - 100, "/");
        setcookie($this->usertable . "_passwd",   "", time() - 100, "/");
        setcookie($this->usertable . "_status",   "", time() - 100, "/");

        $this->login    = false;
        $this->username = "";
        $this->passwd   = "";
        $this->status   = "";
    }
}