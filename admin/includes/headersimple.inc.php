<?php 
		if($islogin!=true) { //als je niet op een loginpagina bent
			require_once ('../includes/connect.inc.php');
			require_once ('./classes/login.class.php');
			$login = (new Login())->getInstance();
			$login->init("users");
			if(($login->isLogin()==false || !$login->hasStatus($page_status)) && $page_name!="no permission")
				header("location: nopermission.php");
		}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl">
<head>
	<?php
	if($page_title!="")
		echo "<title>AfSoH Initiative - ".$page_title."</title>";
	else
		echo "<title>AfSoH Initiative </title>";
	?>
<style type="text/css">@import url(../css/style.css);</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="KEYWORDS" content="African Society of Hypertension (AfSoH) Initiative" />
<meta name="DESCRIPTION" content="PASH,Inc., AfSoH Initiative, Pan-African Society of Hypertension, African Society of Hypertension (AfSoH) Initiative, Marc Twagirumukiza, Hypertension, Africa, T4" />
<meta name="COPYRIGHT" content="PASH,Inc." />
<meta http-equiv="CONTENT-LANGUAGE" content="English" />
<meta name="RATING" content="General" />
<meta name="ROBOTS" content="index,follow" />
<meta name="REVISIT-AFTER" content="30 days" />
</head>
<body>
<a name="top" id="top"></a>
<div id="simplecontent">
