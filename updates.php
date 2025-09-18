<?php 
$page_title = "Conference updates"; //title of page
$page_name="conferences"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<h3>Conference updates</h3>
<?php
require_once ("./admin/classes/updates.class.php");

$updates = new Updates;
$init = $updates->init();	
echo Updates::transform($updates->getMessage());
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
