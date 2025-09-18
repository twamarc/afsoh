<?php 
$page_name="conference members";//name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>Conference Members</h3>
<?php
echo "<p><a href=\"conferencesfull.php\" target=\"_blank\">>> Show large database display.</a></p>";

require_once "./classes/user.class.php";
$usertable = "conference";


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
		echo "<p><a href=\"conferences.php?start=".$start."\">no</a> - <a href=\"conferences.php?delete=".$_GET[delete]."&ok=ok&start=".$start."\">yes</a></p>";
	}
	echo "</div>";
}

if($login->hasStatus(1))
	echo "<p><a href=\"conferenceadd.php\">add member</a></p>"; 
echo "<table> \n";
echo "<tr class=\"tabelheader\">\n";
echo "<td colspan=\"2\">Members (not paid)</td>\n";
echo "</tr>\n";
$users = User::getPaidUsers($usertable,false);
foreach($users as $item) {	
	echo "<tr>\n";
	echo "<td>\n";
    echo $item->getName()."\n";
	echo "</td>\n";
	echo "<td class=\"edit\">";
	if($login->hasStatus(1)) { 
    	echo "<a href=\"conferences.php?delete=".$item->getId()."\" title=\"delete member\"><img src=\"../images/delete.png\" alt=\"delete member\" class=\"rightsmall\" /></a>";
		echo "<a href=\"conferenceedit.php?id=".$item->getId()."\" title=\"edit member\"><img src=\"../images/edit.png\" alt=\"edit member\" class=\"rightsmall\" /></a>\n";
	}
	echo "</td>\n";
	echo "</tr>\n";
}	
echo "</table>\n";
echo "<p>&nbsp;</p>";
echo "<table> \n";
echo "<tr class=\"tabelheader\">\n";
echo "<td colspan=\"3\">Members (paid)</td>\n";
echo "</tr>\n";
$users = User::getPaidUsers($usertable,true);
foreach($users as $item) {	
	echo "<tr>\n";
	echo "<td>\n";
	if($item->getSurname()=="" && $item->getFamilyname()=="")
    	echo $item->getUsername()."\n";
	else
		echo $item->getSurname()." ".$item->getMiddlename()." ".$item->getFamilyname()."\n";
	echo "</td>\n";
	echo "<td>\n";
		echo "<a href=\"payment.php?id=".$item->getId()."\">click here to see the payment information</a>";
	echo "</td>\n";
	echo "<td class=\"edit\">";
	if($login->hasStatus(1)) { 
    	echo "<a href=\"conferences.php?delete=".$item->getId()."\" title=\"delete member\"><img src=\"../images/delete.png\" alt=\"delete member\" class=\"rightsmall\" /></a>";
		echo "<a href=\"conferenceedit.php?id=".$item->getId()."\" title=\"edit member\"><img src=\"../images/edit.png\" alt=\"edit member\" class=\"rightsmall\" /></a>\n";
	}
	echo "</td>\n";
	echo "</tr>\n";
}	
echo "</table>\n";
 ?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
