<?php
require "./includes/connect.inc.php";
require "./admin/classes/login.class.php";

$member = (new Login())->getInstance();
$member->setUsertable("members");
$member->logOut();

$islogin = true;
?>
<?php 
$page_title = "Login"; //title of page
$page_name="membership"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>

<h3>Log out</h3>
<p>You are successfully logged out.</p>
<p><a href="login.php">Login</a> - <a href="index.php">Back to website</a></p>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>

