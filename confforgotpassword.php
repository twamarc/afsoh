<?php 
$page_title = "Forgot password"; //title of page
$page_name="conferences"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<h3>Forgot password</h3>
<p>Insert your username and we will send you a new password.</p>
<?php
require_once "./admin/classes/user.class.php";
$usertable = "conference";

$error = "";
$user = new User;
if(isset($_POST[submit])) {
	if($_POST[username]=="")
		$error .= "the username is empty<br />";
	$init = $user->initByUsername($_POST[username],$usertable);
	if(!$init)
		$error .= "we do not find the username in the databse<br />";
	if($error=="") {	
		$newpass = substr(sha1(md5(microtime()*rand(1,10))),1,10);
		$user->setPasswd($newpass);
		$user->update();
		$user->sendForgotEmail($confchangepasstitle, $webmastername, $webmasteremail, $websiteurl, $newpass, $confchangepage);
		
		echo "<p>The password is successfully changed.</p>";
		echo "<p>You will receive an e-mail with your new password.</p>";
		echo "<p><a href=\"index.php\">>> Go back to the homepage</a></p>";
	}
	else {
		echo "<div class=\"report\">";
		echo "<p>".$error."</p>";
		echo "</div>";
	}
	
} 
if(!isset($_POST[submit]) || $error!="") {
?>
<form class="bodyform" method="post" action="" name="form">
	<fieldset>
	  <div>
		<label>Username:</label>
		<input name="username" size="8" type="text" value="<?= htmlspecialchars($_POST[username], ENT_QUOTES);  ?>" />
	  </div>
	  <input type="submit" name="submit" value="ask new password" class="submit" />
	  <input type="reset" value="reset" />
	</fieldset>
  </form>
<?php
}
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
