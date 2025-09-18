<?php
/* AUTH_COMPAT */
if (!function_exists('af_has_status')) {
    /**
     * Flexible status/role checker:
     * - Tries hasStatus/has_status/hasRole/inRole if they exist
     * - Else compares getStatus()/->status to expected value(s)
     * Usage: af_has_status($who, 'admin') or af_has_status($who, ['admin','editor'])
     */
    function af_has_status($who, $expected) {
        if (!is_object($who)) return false;
        $list = is_array($expected) ? $expected : [$expected];

        foreach ($list as $e) {
            // Prefer native methods if present
            if (method_exists($who, 'hasStatus')) { try { if (af_has_status($who, $e)) return true; } catch (Throwable $t) {} }
            if (method_exists($who, 'has_status')) { try { if ($who->has_status($e)) return true; } catch (Throwable $t) {} }
            if (method_exists($who, 'hasRole'))   { try { if ($who->hasRole($e))   return true; } catch (Throwable $t) {} }
            if (method_exists($who, 'inRole'))    { try { if ($who->inRole($e))    return true; } catch (Throwable $t) {} }

            // Fallback: direct status compare
            $st = null;
            if (method_exists($who, 'getStatus')) { $st = $who->getStatus(); }
            elseif (property_exists($who, 'status')) { $st = $who->status; }

            if ($st !== null) {
                if (is_numeric($e) && (int)$st === (int)$e) return true;
                if (is_string($e) && is_string($st) && strcasecmp((string)$st, (string)$e) === 0) return true;
            }
        }
        return false;
    }
}

// Pick an auth object for static-like checks
$auth = (isset($login) && is_object($login)) ? $login :
        ((isset($UserAuthentication) && is_object($UserAuthentication)) ? $UserAuthentication : null);
/* /AUTH_COMPAT */

/* ADMIN_HEADER_GUARD */
if (function_exists('ob_get_level') && ob_get_level() === 0) { ob_start(); }
$islogin    = isset($islogin) ? (bool)$islogin
           : ((isset($login) && is_object($login) && method_exists($login,'isLogin')) ? $login->isLogin() : false);
$page_name  = $page_name  ?? '';
$page_title = $page_title ?? ($page_name !== '' ? $page_name : 'Admin');
/* /ADMIN_HEADER_GUARD */
/* TITLE_GUARD */
$page_title = $page_title ?? 'Admin';
/* /TITLE_GUARD */ 

		if($islogin!=true) { //als je niet op een loginpagina bent

			require_once ('../includes/connect.inc.php');

			require_once ('./classes/login.class.php');

			$login = (new Login())->getInstance();

			$login->init("users");

			if(($login->isLogin()==false || !af_has_status($login, $auth, $page_status)) && $page_name!="no permission")

				header("location: nopermission.php");

		}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl">

<head>
<?php
if($page_title!="")
	echo "<title>AfSoH - ".$page_title."</title>";
else
	echo "<title>AfSoH</title>";
?>

<style type="text/css">@import url(../css/style.css);</style>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="KEYWORDS" content="Pan-African Society of Hypertension, Inc.(PASH)" />

<meta name="DESCRIPTION" content="Pan-African Society of Hypertension, Inc.(PASH)" />

<meta name="COPYRIGHT" content="PASH,Inc." />

<meta http-equiv="CONTENT-LANGUAGE" content="English" />

<meta name="RATING" content="General" />

<meta name="ROBOTS" content="index,follow" />

<meta name="REVISIT-AFTER" content="30 days" />

<script language="JavaScript" src="jscripts/CalendarPopup.js"></script>

<script language="JavaScript">

var cal = new CalendarPopup();

</script>

<?php

if($page_name!="downloads" && $page_name!="conference members") {

?>

<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">

	tinyMCE.init({

		// General options

		mode : "textareas",

		theme : "advanced",

		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",



		// Theme options

		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect,|,absolute|,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking,pagebreak",

		theme_advanced_buttons2 : "cut,copy,paste,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",

		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,advhr,|,print,|,ltr,rtl,|,fullscreen",

		theme_advanced_toolbar_location : "top",

		theme_advanced_toolbar_align : "left",

		theme_advanced_statusbar_location : "bottom",

		theme_advanced_resizing : true,



		// Example content CSS (should be your site CSS)

		content_css : "../css/styletiny.css",



		// Drop lists for link/image/media/template dialogs

		//template_external_list_url : "jscripts/tiny_mce/lists/template_list.js",

		//external_link_list_url : "jscripts/tiny_mce/lists/link_list.js",

		//external_image_list_url : "jscripts/tiny_mce/lists/image_list.php",

		//media_external_list_url : "jscripts/tiny_mce/lists/media_list.js",



		// Replace values for the template plugin

		template_replace_values : {

			username : "Some User",

			staffid : "991234"

		}

	});

</script>

<?php

}

?>

<!-- CSS_INJECT_START -->
<link rel="stylesheet" href="/css/style.css?v=20250918012720">
<link rel="stylesheet" href="/css/styletiny.css?v=20250918012720">
<link rel="stylesheet" href="/css/lightbox.css?v=20250918012720">
<link rel="stylesheet" href="/css/blinking.css?v=20250918012720">
<!-- CSS_INJECT_END -->
</head>

<body>

<a name="top" id="top"></a>

<div id="menu">

	<ul>

		<li id="active"><a href="#">Administration</a></li>

		<li><a href="../index.php">Website</a></li>

	</ul>

</div>

<div id="header">

</div>

<div id="headertext">

<h2>Welcome to African Society of Hypertension (AfSoH) Initiative website</h2>

</div>

<div id="content">

<div id="left">

	<ul>

		<li><a href="index.php">Home</a></li>

<?php

if(isset($login) && $login->isLogin()==true) {

?>

		<li><a href="news.php">News</a></li>

		<li><a href="members.php">AfSoH members</a></li>

<?php

if(af_has_status($login, $auth, 1))

{

?>

		<li><a href="program.php">Conference program</a></li>

		<li><a href="updates.php">Conference updates</a></li>

<?php

}

?>

		<li><a href="conferences.php">Conference members</a></li>

		<li><a href="abstracts.php">Conference abstracts</a></li>
		
		<li><a href="downloads.php">Downloads</a></li>

		<li><a href="links.php">Links</a></li>

		<li><a href="users.php">Board users</a></li>

		<li><a href="changepass.php">Change password</a></li>

		<li><a href="logout.php">Logout</a></li>

<?php

}

?>

	</ul>

</div>

<div id="right">

