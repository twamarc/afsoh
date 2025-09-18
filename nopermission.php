<?php 
$page_title = "no permission"; //title of page
$page_name="home"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<h3>Sorry! You have not yet permission to view this content</h3>
<p>Please note that this is an intranet content. <br> <br> You must have a full membership to visit this page. <br> The full membership is obtained after registration and payment of the membership fee as indicated <a href="membership.php"> on this page about memberships </a>.<br>  Please follow the two options below and reload the page </p> <br> <br> 
<p><a href="login.php">>> Login</a></p> <p>
<p><a href="register.php">>> Register</a></p>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>