<?php
require "../includes/connect.inc.php";
require "./classes/login.class.php";

$login = (new Login())->getInstance();
$login->setUsertable("users");
$login->logOut();

$islogin = true;
?>
<?php 
$page_name="admin"; //name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin 
require "./includes/header.inc.php";
?>

<h3>Log out</h3>
<p>You are successfully logged out.</p>
<p><a href="login.php">Login</a> - <a href="../index.php">Back to website</a></p>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>

