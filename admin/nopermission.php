<?php
$page_name = "no permission"; // name of the page
// Assuming the $login object is created and initialized elsewhere in the code.
// For demonstration purposes, let's create a simple UserAuthentication class.
class UserAuthentication {
    private $loggedIn = false;

    public function __construct() {
        // Your logic to check if the user is logged in.
        // For simplicity, we'll set it to true in this example.
        $this->loggedIn = true;
    }

    public function isLogin() {
        return $this->loggedIn;
    }
}

// Create and initialize the $login object.
$login = new UserAuthentication();

// Assuming the $login object has a method called `isLogin()` to check if the user is logged in.
// For example, the `isLogin()` method might return true if the user is logged in and false otherwise.
// function isLogin() {
//     // Your logic to check if the user is logged in.
//     return true; // or false
// }

$page_name = "no permission"; // name of the page
$page_status = 0; // who can visit this page; 0 = everyone who is logged in, 1 = only the admin

require "./includes/header.inc.php";
?>

<h3>No permission</h3>

<?php
if (isset($login) && $login->isLogin()) {
?>
    <p>You do not have permission to visit this page.</p>
    <p><a href="../index.php">>> Go back to the homepage</a></p>
<?php
} else {
?>
    <p>You must be logged in to visit this page.</p>
    <p><a href="login.php">>> Login</a></p>
<?php
}
?>

<div class="top"><a href="#top">top</a></div>

<?php require "./includes/footer.inc.php"; ?>

