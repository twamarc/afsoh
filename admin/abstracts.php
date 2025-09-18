<?php 
$page_name="abstracts";//name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>Abstracts</h3>
<?php
require "./classes/abstract.class.php";
$limit = 100;
if(isset($_GET['start'])): $start = $_GET['start']; else: $start = 0; endif;
 
if(isset($_GET[approve]) && isset($_GET[abstractid]) && $login->hasStatus(1)) { //approve abstract
	echo "<div class=\"report\">";
		$abstract = new AbstractMessage;
		$abstract->setId($_GET[abstractid]);
		$abstract->init();
		if($_GET[approve]=="yes") {
			echo "<p>The abstract is successfully approved.</p>";
			$abstract->setApproval(true);
		} else if($_GET[approve]=="no") {
			echo "<p>The abstract is successfully selected as not approved.</p>";
			$abstract->setApproval(false);
		}
		$abstract->update();

	echo "</div>";
}
echo "<p><a href=\"abstracts/abstracts.php\" target=\"_blank\">>> Show pdf with the approved abstracts (for printing).</a></p>";
echo "<p><a href=\"abstractsfull.php\" target=\"_blank\">>> Show large database display.</a></p>";
echo "<table> \n";
echo "<tr class=\"legende\">\n";
echo "<td>Authors</td>\n";
echo "<td>Title</td>\n";
echo "<td>More information</td>\n";
echo "<td></td>\n";
echo "</tr>\n";
 
$abstracts = AbstractMessage::getAbstractsRange($start,$limit);
foreach($abstracts as $item) {	
	echo "<tr>\n";
	echo "<td>\n";
    echo $item->getName()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo $item->getTitle()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo "<a href=\"abstract.php?id=".$item->getId()."\">click here for more information</a>";		
	echo "</td>\n";
	echo "<td class=\"edit\">\n";
	if($login->hasStatus(1)) {
		if(!$item->getApproval())
    		echo "<a href=\"abstracts.php?abstractid=".$item->getId()."&approve=yes&start=".$start."\" title=\"not approved - click to approve\"><img src=\"../images/delete.png\" alt=\"not approved - click to approve\" class=\"rightsmall\" /></a>";		
		else
    		echo "<a href=\"abstracts.php?abstractid=".$item->getId()."&approve=no&start=".$start."\" title=\"approved - click to not approve\"><img src=\"../images/add.png\" alt=\"approved - click to not approve\" class=\"rightsmall\" /></a>";
	}
	echo "</td>\n";
	echo "</tr>\n";
}	

echo "</table>\n<p>";
$numrows = $db->getOne('SELECT count(*) FROM abstracts');
if($start > 0) {
    echo "<a href=\"abstracts.php?start=".($start - $limit)."\">< back</a> ";
}
if (($start + $limit) < $numrows) {
    echo "<a href=\"abstracts.php?start=".($start + $limit)."\">next ></a>";
}
echo "</p>";
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>