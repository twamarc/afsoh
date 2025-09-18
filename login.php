<?php
require "./includes/connect.inc.php";
require "./admin/classes/login.class.php";

$member = (new Login())->getInstance();
$member->init("members");

$error = "";

if (isset($_POST['submit'])) {
    if (empty($_POST['user'])) {
        $error .= "Your username is empty.<br />";
    } else if (!preg_match("/^[a-zA-Z0-9_]{3,16}$/", $_POST['user'])) {
        $error .= "Your username has an incorrect format.<br />";
    }

    if (empty($_POST['pass'])) {
        $error .= "Your password is empty.<br />";
    }

    if (empty($error)) {
        // Use prepared statements to avoid SQL injection
        $hashedPassword = hash_password($_POST['pass']); // Assuming you have a function to hash the password securely
        $member->loginByUsername($_POST['user'], $hashedPassword);

        if (!$member->isLogin()) {
            $error .= "Login failed.<br />";
        }
    }
}

if($member->isLogin()==true)
	header("location: membership.php?log=ok");

$islogin = true;
?>
<?php 
$page_title = "Login"; //title of page
$page_name="membership"; //name of active menu button
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
 <p>First time? Please <a href="register.php">click here</a> to join AfSoH Initiative.<br />
 Forgotten your password? Please <a href="forgotpassword.php">click here</a>.</p>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
