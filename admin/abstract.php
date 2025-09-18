<?php 
$page_name="abstracts";//name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
$conferencelogin = true; //you must be logged in for the conference
require "./includes/header.inc.php";
?>
<h3>Abstract</h3>
<?php
require_once "./classes/abstract.class.php";

$abstract = new AbstractMessage;
$abstract->setId($_GET[id]);
$init = $abstract->init();

if(isset($_GET[approve]) && $login->hasStatus(1)) { //approve abstract
	echo "<div class=\"report\">";
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
	
if(isset($_GET[id]) && $init==true) { 
echo "<table> \n";
echo "<tr>\n";
echo "<td>\n";
echo "<p><b>Date</b>:</p>".$abstract->getDate()."\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>\n";
echo "<p><b>Authors and affiliations</b>:</p>".nl2br($abstract->getName())."\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>\n";
echo "<p><b>Type</b>:</p>".$abstract->getType()."\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>\n";
echo "<p><b>Title</b>:</p>".nl2br($abstract->getTitle())."\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>\n";
echo "<p><b>Message</b>:</p>".nl2br($abstract->getMessage())."\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>\n";
if($login->hasStatus(1)) {
	if(!$abstract->getApproval())
		echo "<p>abstract is not approved - <a href=\"abstract.php?id=".$abstract->getId()."&approve=yes\">click here to approve the abstract</a></p>";		
	else
		echo "<p>abstract approved - <a href=\"abstract.php?id=".$abstract->getId()."&approve=no\">click here to not approve the abstract</a></p>";
}
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>\n";
echo "<p><a href=\"abstracts.php\"><< Go back to abstracts overview</a></p>\n";
echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";


} else 
	echo "<p>Abstract is not found in the database.</p>";
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
