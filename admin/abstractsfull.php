<?php 
$page_name="abstracts";//name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/headersimple.inc.php";
?>
<h3>Abstracts</h3>
<?php
require "./classes/abstract.class.php";
require_once "./classes/user.class.php";
$usertable = "conference";

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

echo "<table> \n";
echo "<tr class=\"legende\">\n";
echo "<td rowspan=\"2\">N&deg;</td>\n";
echo "<td rowspan=\"2\">Date</td>\n";
echo "<td colspan=\"5\" class=\"center\">Authors</td>\n";
echo "<td rowspan=\"2\">Type</td>\n";
echo "<td rowspan=\"2\">Title</td>\n";
echo "<td rowspan=\"2\" class=\"edit\">Decision</td>\n";
echo "</tr>\n";
echo "<tr class=\"legende\">\n";
echo "<td>Names</td>\n";
echo "<td>Title</td>\n";
echo "<td>Address</td>\n";
echo "<td>Country</td>\n";
echo "<td>Email</td>\n";
echo "</tr>\n";
 
$abstracts = AbstractMessage::getAllAbstracts();
$count = 0;
foreach($abstracts as $item) {	
	$count++;
	echo "<tr>\n";
	echo "<td>\n";
    echo $count."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo $item->getDate()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo $item->getName()."\n";
	echo "</td>\n";
	$abstractUser = new User;
	$abstractUser->initById($item->getUserid(),$usertable);
	echo "<td>\n";
    echo $abstractUser->getTitle()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo nl2br($abstractUser->getAddress())."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo $abstractUser->getCountry()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo $abstractUser->getEmail()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo $item->getType()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo "<a href=\"abstract.php?id=".$item->getId()."\">".$item->getTitle()."</a>\n";
	echo "</td>\n";
	echo "<td class=\"edit\">\n";
	if($login->hasStatus(1)) {
		if(!$item->getApproval())
    		echo "<a href=\"abstractsfull.php?abstractid=".$item->getId()."&approve=yes\" title=\"not approved - click to approve\">not approved</a>";		
		else
    		echo "<a href=\"abstractsfull.php?abstractid=".$item->getId()."&approve=no\" title=\"approved - click to not approve\">approved</a>";
	}
	echo "</td>\n";
	echo "</tr>\n";
}	

echo "</table>\n<p>";

?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footersimple.inc.php" ?>
