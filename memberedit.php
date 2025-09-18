<?php 
$page_name="members";//name of the page
$page_status=1; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>Edit member</h3>
<?php

require_once "./classes/user.class.php";
$usertable = "members";

$user = new User;
$init = $user->initById($_GET[id],$usertable);
	
if(isset($_GET[id]) && $init==true) { 


	$error = "";
	if(isset($_POST[submit])) {
		if($_POST[username]=="")
			$error .= "the username is empty<br />";
		if($_POST[email]=="")
			$error .= "the email is empty<br />";
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
			$user->setEmail($_POST[email]);
			$user->setSurname($_POST[surname]);
			$user->setMiddlename($_POST[middlename]);
			$user->setFamilyname($_POST[familyname]);
			$user->setTitle($_POST[title]);
			$user->setInstitution($_POST[institution]);
			$user->setAddress($_POST[address]);
			$user->setPhone($_POST[phone]);
			$user->setFax($_POST[fax]);
			if (isset($_POST['confirmed'])) 
				$user->setConfirmed(true);
			else
				$user->setConfirmed(false);
			$succ = $user->update();

			echo "<p>The member is successfully updated.</p>";
			echo "<p><a href=\"members.php\">overview</a> - <a href=\"memberadd.php\">add new member</a></p>";
		}
		else {
			echo "<div class=\"report\">";
			echo "<p>".$error."</p>";
			echo "</div>";
		}
	}
if(!isset($_POST[submit]) || $error!="" ) {
echo "<p><a href=\"members.php\">< back to members overview</a></p>";
?>
<form class="bodyform" method="post" action="" name="form">
	<fieldset>
		<div>
		<label>Registered on:</label>
		<input name="username" size="8"  type="text" value="<?=$user->getDate(); ?>" disabled="disabled" />
	  </div>
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
	   <div>
		<label>E-mail:</label>
		<input name="email" size="8"  type="text" value="<?=$user->getEmail(); ?>" />
	  </div>
	  <div>
		<label>First name:</label>
		<input name="surname" size="8"  type="text" value="<?=$user->getSurname(); ?>" />
	  </div>
	  <div>
		<label>Middle names:</label>
		<input name="middlename" size="8"  type="text" value="<?=$user->getMiddlename(); ?>" />
	  </div>
	  <div>
		<label>Last name:</label>
		<input name="familyname" size="8"  type="text" value="<?=$user->getFamilyname(); ?>" />
	  </div>
	  <div>
		<label>Academic title:</label>
		<input name="title" size="8"  type="text" value="<?=$user->getTitle(); ?>" />
	  </div>
	  <div>
		<label>Affiliation institution:</label>
		<input name="institution" size="8"  type="text" value="<?=$user->getInstitution(); ?>" />
	  </div>
	  <div>
		<label>Personnal addresses:</label>
		<input name="address" size="8"  type="text" value="<?=$user->getAddress(); ?>" />
	  </div>
	  <div>
		<label>Phone:</label>
		<input name="phone" size="8"  type="text" value="<?=$user->getPhone(); ?>" />
	  </div>
	  <div>
		<label>Fax:</label>
		<input name="fax" size="8"  type="text" value="<?=$user->getFax(); ?>" />
	  </div>
	  <div>
		<label>Account activated:</label>
		<?php
		if($user->isConfirmed()) {
		?>
		<input type="checkbox" name="confirmed" checked="checked" /> (selected: yes, not selected: no)
		<?php
		} else {
		?>
		<input type="checkbox" name="confirmed" /> (selected: yes, not selected: no)
		<?php
		}?>
	  </div>
	  
	  <input type="submit" name="submit" value="edit" class="submit" />
	  <input type="reset" value="reset" />
	</fieldset>
  </form>
  <p>Leave the password fields empty if you do not want to change the password.</p>
<?php
	}
} else  {
	echo "<p>The member is not found in the database.</p>";
	echo "<p><a href=\"members.php\">overview</a> - <a href=\"memberadd.php\">add new member</a></p>";
}

?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>