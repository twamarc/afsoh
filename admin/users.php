<?php 
$page_name="users";//name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>Users</h3>
<?php
require_once "./classes/user.class.php";
$limit = 9; //maximaal aantal leden die per pagina worden weergegeven
$usertable = "users";

 if(isset($_GET['start'])): $start = $_GET['start']; else: $start = 0; endif;


if(isset($_GET[delete]) && $login->hasStatus(1) && $_GET[delete] != 1) {
	echo "<div class=\"report\">";
	if(isset($_GET[ok]) && $_GET[ok]=="ok") {
		$user = new User;
		$user->setId($_GET[delete]);
		$user->setUsertable($usertable);
		$deleted = $user->delete();

		if($deleted==true)
			echo "<p>The user is successfully deleted.</p>";
		else
			echo "<p>The user is not deleted.</p>";
	}
	else { 
		echo "<p>Are you sure you want to delete this user?</p>";
		echo "<p><a href=\"users.php?start=".$start."\">no</a> - <a href=\"users.php?delete=".$_GET[delete]."&ok=ok&start=".$start."\">yes</a></p>";
	}
	echo "</div>";
}

if($login->hasStatus(1))
	echo "<p><a href=\"useradd.php\">add user</a></p>"; 
echo "<table> \n";
echo "<tr class=\"tabelheader\">\n";
echo "<td colspan=\"2\">Users</td>\n";
echo "</tr>\n";

 
$users = User::getUsersRange($start,$limit,$usertable);
foreach($users as $item) {	
	echo "<tr>\n";
	echo "<td>\n";
    echo $item->getUsername()."\n";
	echo "</td>\n";
	echo "<td class=\"edit\">";
	if($login->hasStatus(1)) { 
		if($item->getId() != 1)
    		echo "<a href=\"users.php?delete=".$item->getId()."&start=".$start."\" title=\"delete user\"><img src=\"../images/delete.png\" alt=\"delete user\" class=\"rightsmall\" /></a>";
		else
			echo "<img src=\"../images/delete_no.png\" alt=\"you can't delete yourself\" title=\"you can't delete yourself\" class=\"rightsmall\" />";
		echo "<a href=\"useredit.php?id=".$item->getId()."\" title=\"edit user\"><img src=\"../images/edit.png\" alt=\"edit user\" class=\"rightsmall\" /></a>\n";
	}
	echo "</td>\n";
	echo "</tr>\n";
}	

echo "</table>\n<p>";
$numrows = $db->getOne('SELECT count(*) FROM '.$usertable);
if($start > 0) {
    echo "<a href=\"users.php?start=".($start - $limit)."\">< back</a> ";
}
if (($start + $limit) < $numrows) {
    echo "<a href=\"users.php?start=".($start + $limit)."\">next ></a>";
}
echo "</p>";
 ?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
