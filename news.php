<?php 
$page_title = "News"; //title of page
$page_name="home"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<?php
require "./admin/classes/news.class.php";

$limit = 10; //aantal nieuwsitems per pagina

if(isset($_GET['start'])): $start = $_GET['start']; else: $start = 0; endif;
echo "<h3>News</h3>\n";

$numrows = $db->getOne('SELECT count(*) FROM news');
if(($start > 0) || (($start + $limit) < $numrows)) {
 	echo "<p>\n";
	if($start > 0) 
		echo "<span class=\"left\"><a href=\"newsoverview.php?start=".($start - $limit)."\">< back</a></span>\n";
	else
		echo "<span class=\"left\">&nbsp;</span>\n";
	if (($start + $limit) < $numrows) 
		echo "<span class=\"right\"><a href=\"newsoverview.php?start=".($start + $limit)."\">next ></a></span>\n";
	else
		echo "<span class=\"right\">&nbsp;</span>\n";
	echo "</p>\n";
}

echo "<table> \n";
echo "<tr class=\"tabelheader\">\n";
echo "<td colspan=\"2\">overview</td>\n";
echo "</tr>\n";
$news = News::getMessagesRange($start,$limit);
foreach($news as $item) {	
	echo "<tr>\n";
	echo "<td class=\"newsdate\">\n";
    echo $item->getDate()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo "<a href=\"newsitem.php?id=".$item->getId()."\">".$item->getTitle()."</a>\n";
	echo "</td>\n";
	echo "</tr>\n";
}
echo "</table>";
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
