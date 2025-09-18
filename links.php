<?php 
$page_title = "Links"; //title of page
$page_name="links"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<?php
require_once ("./admin/classes/links.class.php");
require_once ("./admin/classes/link.class.php");
?>
<h3>List of Cardiovascular Health Organisations in Africa</h3>
<?php
$links = Link::getAllLinks($start,$limit);
echo "<table> \n";
echo "<tr class=\"legende\">\n";
echo "<td>Country/Region</td>\n";
echo "<td>Organisation</td>\n";
echo "<td>Mission</td>\n";
echo "<td>Web or e-mail address</td>\n";
echo "</tr>\n";
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
	if(strstr($item->getAddress(),'@'))
    	echo "<a href=\"mailto:".$item->getAddress()."\">".$item->getAddress()."<a/>\n";
	else	
    	echo "<a href=\"".$item->getAddress()."\">".$item->getAddress()."<a/>\n";	
	echo "</td>\n";
	echo "</tr>\n";
}	
echo "</table>\n";
?>
<div class="top"><a href="#top">top</a></div>

<h3>International organisations</h3>
<?php
$links = new Links;
$init = $links->init();	
echo Links::transform($links->getMessage());
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
