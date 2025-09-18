<?php 
$page_name="users";//name of the page
$page_status=1; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>Add user</h3>
<?php
require_once "./classes/user.class.php";
$usertable = "users";

$error = "";
$user = new User;
if(isset($_POST[submit])) {
	if($_POST[username]=="")
		$error .= "the username is empty<br />";
	else if(User::usernameExists($_POST[username],$usertable)==true)
		$error .= "the username already exists<br />";
	if($_POST[passwd]=="")
		$error .= "the passwd is empty<br />";
	if($_POST[repeat]=="")
		$error .= "the repeated password is empty<br />";
	if($_POST[passwd] != $_POST[repeat])
		$error .= "the 2 inputs of the password are not the same";
		
	
	if($error=="") {	
		$user->setUsertable($usertable);
		$user->setUsername($_POST[username]);
		$user->setPasswd($_POST[passwd]);
		$user->setConfirmed(true);
		$user->save();
		
		echo "<p>The user is successfully added</p>";
		echo "<p><a href=\"users.php\">overview</a> - <a href=\"useradd.php\">add new user</a></p>";
	}
	else {
		echo "<div class=\"report\">";
		echo "<p>".$error."</p>";
		echo "</div>";
	}
	
} 
if(!isset($_POST[submit]) || $error!="") {
echo "<p><a href=\"users.php\">< back to users overview</a></p>";
?>
<form class="bodyform" method="post" action="" name="form">
	<fieldset>
	  <div>
		<label>Username:</label>
		<input name="username" size="8" type="text" value="<?= htmlspecialchars($_POST[username], ENT_QUOTES);  ?>" />
	  </div>
	  <div>
		<label>Password:</label>
		<input name="passwd" size="8"  type="password" value="" />
	  </div>
	  <div>
		<label>Repeat password:</label>
		<input name="repeat" size="8"  type="password" value="" />
	  </div>
	  <input type="submit" name="submit" value="add" class="submit" />
	  <input type="reset" value="reset" />
	</fieldset>
  </form>
<?php
}
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
