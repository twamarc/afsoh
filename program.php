<?php 
$page_title = "Program"; //title of page
$page_name="conferences"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<h3>Program</h3>
<?php
require_once ("./admin/classes/program.class.php");

$program = new Program;
$init = $program->init();	
echo Program::transform($program->getMessage());
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
