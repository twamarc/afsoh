<?php
require "./includes/connect.inc.php";
require "./admin/classes/login.class.php";

$conference = (new Login())->getInstance();
$conference->init("conference");


$error = "";
if(isset($_POST[submit])) {
	if($_POST[user]=="")
		$error .= "Your username is empty<br />";
	else if(!ereg("^[a-zA-Z0-9_]{3,16}$",$_POST[user]))
		$error .= "Your username has not the correct format<br />";
	if($_POST[pass]=="")
		$error .= "your password is empty";
	if($error=="") {
			$conference->loginByUsername($_POST[user],$_POST[pass]);
		if($conference->isLogin()==false)
			$error .= "login failed";
	}
}

if($conference->isLogin()==true) {
	if($conference->hasPaid() || (isset($_GET[st]) && $_GET[st]=="ok"))
		header("location: abstract.php?log=ok");
	else
		header("location: payment.php?log=ok");
}

$islogin = true;
?>
<?php 
$page_title = "Login"; //title of page
$page_name="conferences"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<h3>Login</h3>
<?php

if($error!="") {     
	echo "<div class=\"report\">";
	echo "<p>".$error."</p>";
	echo "</div>";
}
?>
<form class="bodyform" method="post" action="">
	<fieldset>
	  <div>
		<label>username:</label>
		<input name="user" size="8" type="text" value="<?= htmlspecialchars($_POST[user],ENT_QUOTES); ?>" />
	  </div>
	  <div>
		<label>password:</label>
		<input name="pass" size="8" type="password" />
	  </div>
	  <input type="submit" name="submit" class="submit" value="login" />
	  <input type="reset" value="reset" />
	</fieldset>
  </form>
   <p>Not yet registered for the coming conference? Please <a href="confregister.php">click here</a> to register.<br />
 Forgotten your password? Please <a href="confforgotpassword.php">click here</a>.</p>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
