<?php 
$page_title = "Confirm account"; //title of page
$page_name="membership"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<h3>Confirm account</h3>
<?php
require_once "./admin/classes/user.class.php";
$usertable = "members";

$user = new User;
$init = $user->initByCode($_GET[code],$usertable);
	
if(isset($_GET[code]) && $init==true) { 
$user->setConfirmed(true);
$user->sendActivatedEmail($registerconfirmtitle, $webmastername, $webmasteremail, $websiteurl);
$user->update();
echo "<p><strong> Congratulations! <br/>Your email address is now verified! <br/><br/>Now, we invite you to have a look on the membership fees and proceed to the membership fees payment, otherwise your registration will stay pending and automatically deleted without notice after 30 days. <br/>For this please use the membership tab, on this website.</strong><br><br> </p>\n";
echo "<p>You can login at <a href=\"login.php\">the loginpage</a>.</p>\n";
}
else {
echo "<p>The activation code is not correct.</p>\n";
echo "<p><a href=\"register.php\">>> Register</p>\n";
}
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>