<?php
require_once "./includes/connect.inc.php";
require "./admin/classes/news.class.php";

$news = new News;
if(!is_numeric($_GET[id]))
exit;
$init = $news->init($_GET[id]);
?>
<?php 
if($news!=null)
	$page_title = $news->getTitle(); //title of page
else
	$page_title = ""; //title of page
$page_name="home"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<?php
if(isset($_GET[id]) && $init==true) { 
	echo "<h3>".$news->getTitle()."</h3>\n";
	echo "<p class=\"date\">news added on ".$news->getDate()."</p>";
	echo News::transform($news->getMessage());
} else 
	echo "<p>News message is not found in the database.</p>";
?>
<p><a href="news.php">>> News overview</a></p>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>