<?php
if($islogin!=true) { //als je niet op een loginpagina ben
	require_once ('./includes/connect.inc.php');
	require_once ('admin/classes/login.class.php');
	$login = (new Login())->getInstance();
	$login->init("users");
	$member = (new Login())->getInstance();
	$member->init("members");
	$conference = (new Login())->getInstance();
	$conference->init("conference");
	if(!$member->hasStatus($page_status) && $page_name!="no permission")
		header("location: nopermission.php");
	if(isset($conferencelogin) && $conferencelogin=true && $conference->isLogin()==false)
		header("location: confnopermission.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl">
<head>
<?php
if($page_title!="")
	echo "<title>PASH, Inc. - ".$page_title."</title>";
else
	echo "<title>PASH, Inc.</title>";
?>
<style type="text/css">@import url(./css/style.css);</style>
<style type="text/css">@import url(./css/lightbox.css);</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="KEYWORDS" content="Pan-African Society of Hypertension, Twagirumukiza Marc, IFHA,International Forum, Hypertension control,PASH, Hypertension, Africa, 
Hydrochrolothiazide, Enalapril,blood pressure, blacks, sub-saharan africa, STEPwise survey, European society of hypertension, European society of cardiology, International society of hypertension, ISH, World Hypertension Ligue, World hypertension day, societe francaise de cardiologie, cardiovascular disease,CVD,
World Action On Salt and Health, WASH, Non communicable diseases, hypertension in blacks, arterial stiffness, PASCAR" />
<meta name="DESCRIPTION" content="Pan-African Society of Hypertension (PASH Inc.) Initiative" />
<meta name="COPYRIGHT" content="PASH" />
<meta http-equiv="CONTENT-LANGUAGE" content="English" />
<meta name="RATING" content="General" />
<meta name="ROBOTS" content="index,follow" />
<meta name="REVISIT-AFTER" content="30 days" />
<script type="text/javascript" src="jscripts/email.js"></script>
<script type="text/javascript" src="jscripts/prototype.js"></script>
<script type="text/javascript" src="jscripts/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="jscripts/lightbox.js"></script>
<link rel="shortcut icon" href="images/favicon.ico" />
</head>
<body>
<a name="top" id="top"></a>
<div id="menu">
	<ul>
<?php
if ($page_name=="home")
	echo "		<li id=\"active\"><a href=\"index.php\">Home</a></li>\n";
else
	echo "		<li><a href=\"index.php\">Home</a></li>\n";
if ($page_name=="about")
	echo "		<li id=\"active\"><a href=\"about.php\">About us</a></li>\n";
else
	echo "		<li><a href=\"about.php\">About us</a></li>\n";
if ($page_name=="projects")
	echo "		<li id=\"active\"><a href=\"projects.php\">Projects </a></li>\n";
else
	echo "		<li><a href=\"projects.php\">Projects</a></li>\n";
if ($page_name=="membership")
	echo "		<li id=\"active\"><a href=\"membership.php\">Membership</a></li>\n";
else
	echo "		<li><a href=\"membership.php\">Membership</a></li>\n";
if ($page_name=="people")
	echo "		<li id=\"active\"><a href=\"people.php\">Who is who</a></li>\n";
else
	echo "		<li><a href=\"people.php\">Who is who</a></li>\n";
if ($page_name=="support")
	echo "		<li id=\"active\"><a href=\"support.php\">e-Shop</a></li>\n";
else
	echo "		<li><a href=\"support.php\">e-Shop</a></li>\n";
if ($page_name=="conferences")
	echo "		<li id=\"active\"><a href=\"indexconf.php\">Conferences</a></li>\n";
else
	echo "		<li><a href=\"indexconf.php\">Conferences</a></li>\n";
if ($page_name=="journal")
	echo "		<li id=\"active\"><a href=\"journal.php\">Media Center</a></li>\n";
else
	echo "		<li><a href=\"journal.php\">Media Center</a></li>\n";
if ($page_name=="partners")
	echo "		<li id=\"active\"><a href=\"partners.php\">Partners</a></li>\n";
else
	echo "		<li><a href=\"partners.php\">Partners</a></li>\n";
if ($page_name=="search")
	echo "		<li id=\"active\"><a href=\"search.php\">Search</a></li>\n";
else
	echo "		<li><a href=\"search.php\">Search</a></li>\n";
if ($page_name=="links")
	echo "		<li id=\"active\"><a href=\"links.php\">Links</a></li>\n";
else
	echo "		<li><a href=\"links.php\">Links</a></li>\n";
?>
	</ul>
</div>
<div id="header">
<div id="login">
<?php
if(!$islogin && $member->isLogin()) {

 echo "You are logged in with <b>".$member->getName()."</b>.";

} else {
?>
<form class="loginform" method="post" action="login.php">
<table class="logintable">
<tr class="legende">
<td colspan="2">Members</td>
</tr>
<tr>
<td>Username:</td>
<td><input name="user" size="8" type="text" value="" /></td>
<td><input type="submit" name="submit" class="submit" value="Log In" /></td>
</tr>
<tr>
<td>Password:</td>
<td><input name="pass" size="7" type="password" /></td>
<td class="center"><a href="forgotpassword.php">forgotten?</a></td>
</tr>
</table>
<p>First time? Please <a href="register.php">click here</a> to register.</p>
</form>
<?php
}
?>
</div>
</div>
<div id="headertext">
<h2>Welcome on Pan-African Society of Hypertension (PASH Inc.) Initiative website </h2>
</div>
<?php
if ($page_name=="conferences") {
?>
<div id="content">
<div id="left">
	<ul>
		<li><a href="indexconf.php">Welcome message</a></li>
		<li><a href="general.php">General information</a></li>
		<li><a href="organisation.php">Organizing committees</a></li>
		<li><a href="updates.php">Conference updates</a></li>
		<li><a href="program.php">Program</a></li>
		<li><a href="tours.php">Tours and exclusion</a></li>
		<li><a href="hotel.php">Hotel accommodation</a></li>
		<li><a href="conferencelinks.php">Links</a></li>
		<?php if($conference->isLogin()) { ?>
		<li><a href="payment.php">Conference payment</a></li>
		<li><a href="abstract.php">Abstract submission</a></li>
		<li><a href="confchangepass.php">Change password</a></li>
		<li><a href="conflogout.php">Logout</a></li>
		<?php } else { ?>
		<li><a href="confregisterinfo.php">Registration</a></li>
		<li><a href="conflogin.php">Login</a></li>
		<?php }?>
	</ul>
</div>
<div id="right">
<?php
} elseif($page_name=="membership"){
?>
<div id="content">
<div id="left">
	<ul>
		<li><a href="membership.php">Membership</a></li>
		<?php if($member->isLogin()) { ?>
		<li><a href="changepass.php">Change password</a></li>
		<li><a href="logout.php">Logout</a></li>
		<?php } else { ?>
		<li><a href="login.php">Login</a></li>
		<li><a href="register.php">Registration</a></li>
		<?php }?>
	</ul>
</div>
<div id="right">
<?php
} else {
?>
<div id="bigcontent">
<?php
}
?>
