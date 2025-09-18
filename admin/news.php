<?php 
$page_name="news"; //name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>News</h3>
<?php
require_once "./classes/news.class.php";
$limit = 9; //max messages on one page

 if(isset($_GET['start'])): $start = $_GET['start']; else: $start = 0; endif;

if(isset($_GET[delete]) && $login->hasStatus(1)) { //delete message
	echo "<div class=\"report\">";
	if(isset($_GET[ok]) && $_GET[ok]=="ok") {
		$news = new News;
		$news->setId($_GET[delete]);
		$deleted = $news->delete();

		if($deleted==true)
			echo "<p>The newsmessage is successfully deleted.</p>";
		else
			echo "<p>The newsmessage is not deleted.</p>";
	}
	else { 
		echo "<p>Are you sure you want to delete the newsmessage?</p>";
		echo "<p><a href=\"news.php?start=".$start."\">no</a> - <a href=\"news.php?delete=".$_GET[delete]."&ok=ok&start=".$start."\">yes</a></p>";
	}
	echo "</div>";
}

if($login->hasStatus(1))
	echo "<p><a href=\"newsadd.php\">add news</a></p>";
echo "<table> \n";
echo "<tr class=\"tabelheader\">\n";
echo "<td colspan=\"3\">News</td>\n";
echo "</tr>\n";

 
$news = News::getMessagesRange($start,$limit);
foreach($news as $item) {	
	echo "<tr>\n";
	echo "<td class=\"newsdate\">\n";
    echo $item->getDate()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo "<a href=\"newsedit.php?id=".$item->getId()."\" title=\"edit message\">".$item->getTitle()."</a>\n";
	echo "</td>\n";
	echo "<td class=\"edit\">\n";
	echo "<a href=\"news.php?delete=".$item->getId()."&start=".$start."\" title=\"delete message\"><img src=\"../images/delete.png\" alt=\"delete message\" class=\"rightsmall\" /></a>";
	echo "<a href=\"newsedit.php?id=".$item->getId()."\" title=\"edit message\"><img src=\"../images/edit.png\" alt=\"edit message\" class=\"rightsmall\" /></a>\n";
	echo "</td>\n";
	echo "</tr>\n";
}	

echo "</table>\n<p>";
$numrows = $db->getOne('SELECT count(*) FROM news');
if($start > 0) {
    echo "<a href=\"news.php?start=".($start - $limit)."\">< back</a> ";
}
if (($start + $limit) < $numrows) {
    echo "<a href=\"news.php?start=".($start + $limit)."\">next ></a>";
}
echo "</p>";
 ?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
