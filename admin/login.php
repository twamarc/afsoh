<?php
// Ensure no BOM/whitespace before this line. No closing tag at EOF.

$page_title = "Admin Login";

// Path-safe includes
require_once __DIR__ . "/classes/login.class.php";

// Select which table to use (default "users"; allow ?table=members)
$allowedTables = ["users","members"];
$table = isset($_GET["table"]) && in_array($_GET["table"], $allowedTables, true) ? $_GET["table"] : "users";

$login = Login::getInstance();
$login->init($table);

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $u = trim($_POST["username"] ?? "");
    $p = trim($_POST["password"] ?? "");
    if ($u !== "" && $p !== "") {
        $login->loginByUsername($u, $p);
        if ($login->isLogin()) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "Please enter username and password.";
    }
}

// Render page
require_once __DIR__ . "/includes/header.inc.php";
?>
<div class="container" style="max-width:480px;margin:40px auto;">
  <h1>Admin Login</h1>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></div>
  <?php endif; ?>
  <form method="post" action="login.php<?= isset($_GET["table"]) ? "?table=" . urlencode($table) : "" ?>">
    <div class="form-group">
      <label for="username">Username</label>
      <input class="form-control" type="text" id="username" name="username" required autofocus>
    </div>
    <div class="form-group" style="margin-top:10px;">
      <label for="password">Password</label>
      <input class="form-control" type="password" id="password" name="password" required>
    </div>
    <button class="btn btn-primary" type="submit" style="margin-top:15px;">Sign in</button>
  </form>
</div>
<?php
require_once __DIR__ . "/includes/footer.inc.php";