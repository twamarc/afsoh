<?php 
$page_name="users";//name of the page
$page_status=1; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>Edit user</h3>
<?php

require_once "./classes/user.class.php";
$usertable = "users";

$user = new User;
$init = $user->initById($_GET[id],$usertable);
	
if(isset($_GET[id]) && $init==true) { 


	$error = "";
	if(isset($_POST[submit])) {
		if($_POST[username]=="")
			$error .= "the username is empty<br />";
		if($_POST[passwd]!="" || $_POST[repeat]!="") { 
			if($_POST[passwd]=="")
				$error .= "the passwd is empty<br />";
			if($_POST[repeat]=="")
				$error .= "the repeated password is empty<br />";
			if($_POST[passwd] != $_POST[repeat])
				$error .= "the 2 inputs of the password are not the same";
		}
		
		if($error=="") {	
			$user->setUsertable($usertable);
			if($_POST[passwd]!="")
				$user->setPasswd($_POST[passwd]);
			$user->setUsername($_POST[username]);
			$succ = $user->update();

			echo "<p>The user is successfully updated.</p>";
			echo "<p><a href=\"users.php\">overview</a> - <a href=\"useradd.php\">add new user</a></p>";
		}
		else {
			echo "<div class=\"report\">";
			echo "<p>".$error."</p>";
			echo "</div>";
		}
	}
if(!isset($_POST[submit]) || $error!="" ) {
echo "<p><a href=\"users.php\">< back to users overview</a></p>";
?>
<form class="bodyform" method="post" action="" name="form">
	<fieldset>
	  <div>
		<label>Username:</label>
		<input name="username" size="8"  type="text" value="<?=$user->getUsername(); ?>" />
	  </div>
	  <div>
		<label>New password:</label>
		<input name="passwd" size="8"  type="password" value="" />
	  </div>
	  <div>
		<label>Repeat password:</label>
		<input name="repeat" size="8"  type="password" value="" />
	  </div>
	  <input type="submit" name="submit" value="edit" class="submit" />
	  <input type="reset" value="reset" />
	</fieldset>
  </form>
  <p>Leave the password fields empty if you do not want to change the password.</p>
<?php
	}
} else  {
	echo "<p>The user is not found in the database.</p>";
	echo "<p><a href=\"users.php\">overview</a> - <a href=\"useradd.php\">add new user</a></p>";
}

?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
