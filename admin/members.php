<?php 
$page_name="members";//name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>AfSoH Members</h3>
<?php
echo "<p><a href=\"membersfull.php\" target=\"_blank\">>> Show large database display.</a></p>";

require_once "./classes/user.class.php";
$limit = 100; //maximaal aantal leden die per pagina worden weergegeven
$usertable = "members";

 if(isset($_GET['start'])): $start = $_GET['start']; else: $start = 0; endif;


if(isset($_GET[delete]) && $login->hasStatus(1)) {
	echo "<div class=\"report\">";
	if(isset($_GET[ok]) && $_GET[ok]=="ok") {
		$user = new User;
		$user->setId($_GET[delete]);
		$user->setUsertable($usertable);
		$deleted = $user->delete();

		if($deleted==true)
			echo "<p>The member is successfully deleted.</p>";
		else
			echo "<p>The member is not deleted.</p>";
	}
	else { 
		echo "<p>Are you sure you want to delete this member?</p>";
		echo "<p><a href=\"members.php?start=".$start."\"> <font color=blue> |>>> No <<<| </font> </a> &nbsp;  Please choose between the two options &nbsp; <a href=\"members.php?delete=".$_GET[delete]."&ok=ok&start=".$start."\"> <font color=blue> |>>> Yes <<<| </font> </a></p>";
	}
	echo "</div>";
}

if($login->hasStatus(1))
	echo "<p><a href=\"memberadd.php\">add member</a></p>"; 
echo "<table> \n";
echo "<tr class=\"tabelheader\">\n";
echo "<td colspan=\"2\">Members</td>\n";
echo "</tr>\n";

 
$users = User::getUsersRange($start,$limit,$usertable);
foreach($users as $item) {	
	echo "<tr>\n";
	echo "<td>\n";
	
    echo $item->getName()."\n";
	echo "</td>\n";
	echo "<td class=\"edit\">";
	if($login->hasStatus(1)) { 
    	echo "<a href=\"members.php?delete=".$item->getId()."&start=".$start."\" title=\"delete member\"><img src=\"../images/delete.png\" alt=\"delete member\" class=\"rightsmall\" /></a>";
		echo "<a href=\"memberedit.php?id=".$item->getId()."\" title=\"edit member\"><img src=\"../images/edit.png\" alt=\"edit member\" class=\"rightsmall\" /></a>\n";
	}
	echo "</td>\n";
	echo "</tr>\n";
}	

echo "</table>\n<p>";
$numrows = $db->getOne('SELECT count(*) FROM '.$usertable);
if($start > 0) {
    echo "<a href=\"members.php?start=".($start - $limit)."\">< back</a> ";
}
if (($start + $limit) < $numrows) {
    echo "<a href=\"members.php?start=".($start + $limit)."\">next ></a>";
}
echo "</p>";
 ?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>