<?php
require "../includes/connect.inc.php";
require "./classes/login.class.php";

$login = (new Login())->getInstance();
$login->init("users");

if($login->isLogin()==false)
	header("location: login.php");

$error = "";
if(isset($_POST[submit])) {
	if($_POST[old]=="")
		$error .= "your old password is empty<br />";
	if($_POST[pass]=="")
		$error .= "your new password is empty<br />";
	if($_POST[repeat]=="")
		$error .= "your repeated password is empty";
	if($error=="") {
		if(md5($_POST[old])!=$login->getPasswd())
			$error .= "your old password is not correct";
		else if($_POST[pass] != $_POST[repeat])
			$error .= "the 2 inputs of the new password are not the same";
		else {
			$login->setPasswd($_POST[pass]);
			$login->update();
		}
	}
}
$islogin = true;
?>
<?php 
$page_name="changepass";//name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>Change password</h3>
<?php

if($error!="") {
	echo "<div class=\"report\">";
	echo "<p>".$error."</p>";
	echo "</div>";
}
if($error=="" && isset($_POST[submit])) {
	echo "<p>Your password is successfully changed.</p>";
}
else {
?>
<form class="bodyform" method="post" action="">
	<fieldset>
	  <div>
		<label>old password:</label>
		<input name="old" size="8" type="password" />
	  </div>
	  <div>
		<label>new password:</label>
		<input name="pass" size="8" type="password" />
	  </div>
	  <div>
		<label>repeat new password:</label>
		<input name="repeat" size="8" type="password" />
	  </div>
	  <input type="submit" name="submit" value="change" class="submit" />
	  <input type="reset" value="reset" />
	</fieldset>
  </form>
<?php
}
?>
<div class="top"><a href="#top">top</a></div>

<?php require "./includes/footer.inc.php" ?>

