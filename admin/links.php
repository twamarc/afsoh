<?php 
$page_name="links";//name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>List of Cardiovascular Health Organisations in Africa </h3>
<?php
require "./classes/link.class.php";
$limit = 8;
if(isset($_GET['start'])): $start = $_GET['start']; else: $start = 0; endif;
 
if(isset($_GET[delete]) && $login->hasStatus(1)) { //delete link
	echo "<div class=\"report\">";
	if(isset($_GET[ok]) && $_GET[ok]=="ok") {
		$link = new Link;
		$link->setId($_GET[delete]);
		$deleted = $link->delete();

		if($deleted==true)
			echo "<p>The link is successfully deleted.</p>";
		else
			echo "<p>The link is not deleted.</p>";
	}
	else { 
		echo "<p>Are you sure you want to delete the link?</p>";
		echo "<p><a href=\"links.php?start=".$start."\">no</a> - <a href=\"links.php?delete=".$_GET[delete]."&ok=ok&start=".$start."\">yes</a></p>";
	}
	echo "</div>";
}

else if(isset($_GET[up])) {
		$link = new Link;
		$link->init($_GET[up]);
		$link->moveUp();
}
else if(isset($_GET[down])) {
		$link = new Link;
		$link->init($_GET[down]);
		$link->moveDown();
}

if($login->hasStatus(1))
	echo "<p><a href=\"linkadd.php\">add link</a></p>";
echo "<table> \n";
echo "<tr class=\"legende\">\n";
echo "<td>Country/Region</td>\n";
echo "<td>Organisation</td>\n";
echo "<td>Mission</td>\n";
echo "<td>Web or e-mail address</td>\n";
echo "<td></td>\n";
echo "</tr>\n";
 
$links = Link::getLinksRange($start,$limit);
foreach($links as $item) {	
	echo "<tr>\n";
	echo "<td>\n";
    echo $item->getCountry()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo $item->getOrganisation()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo $item->getMission()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo $item->getAddress()."\n";
	echo "</td>\n";
	echo "<td class=\"edit3\">\n";
	if($login->hasStatus(1)) {
    	echo "<a href=\"links.php?delete=".$item->getId()."&start=".$start."\" title=\"delete link\"><img src=\"../images/delete.png\" alt=\"delete link\" class=\"rightsmall\" /></a>";
		echo "<a href=\"linkedit.php?id=".$item->getId()."\" title=\"edit link\"><img src=\"../images/edit.png\" alt=\"edit link\" class=\"rightsmall\" /></a>\n";
		if($item->getArrange() != Link::getMaxArrange())
			echo "<a href=\"links.php?down=".$item->getId()."&start=".$start."\" title=\"move down\"><img src=\"../images/down.png\" alt=\"move down\" class=\"rightsmall\" /></a>";
		if($item->getArrange() != Link::getMinArrange())
			echo "<a href=\"links.php?up=".$item->getId()."&start=".$start."\" title=\"move up\"><img src=\"../images/up.png\" alt=\"move up\" class=\"rightsmall\" /></a>\n";
	}
	echo "</td>\n";
	echo "</tr>\n";
}	

echo "</table>\n<p>";
$numrows = $db->getOne('SELECT count(*) FROM links');
if($start > 0) {
    echo "<a href=\"links.php?start=".($start - $limit)."\">< back</a> ";
}
if (($start + $limit) < $numrows) {
    echo "<a href=\"links.php?start=".($start + $limit)."\">next ></a>";
}
echo "</p>";
?>
<div class="top"><a href="#top">top</a></div>
<?php
if($login->hasStatus(1)) {
echo "<h3>International organisations</h3>\n";
echo "<p><a href=\"otherlinks.php\">>> Change the other links</a></p>\n";
echo "<div class=\"top\"><a href=\"#top\">top</a></div>\n";
}
?>
<?php require "./includes/footer.inc.php" ?>
