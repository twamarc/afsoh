<?php 
$page_name="abstracts";//name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/headersimple.inc.php";
?>
<h2><center><font color=red > Members who have registered online to AfSoH <br> <br>Detailed list for internal use only </font></center></h2>
<?php
require_once "./classes/user.class.php";
$usertable = "members";


echo "<table> \n";
echo "<tr class=\"legende\">\n";
echo "<td rowspan=\"2\">N&deg;</td>\n";
echo "<td rowspan=\"2\">Date</td>\n";
echo "<td rowspan=\"2\">Membership years</td>\n";
echo "<td colspan=\"5\" class=\"center\">Author</td>\n";
echo "</tr>\n";
echo "<tr class=\"legende\">\n";
echo "<td>PIN</td>\n";
echo "<td>Names</td>\n";
echo "<td>Title</td>\n";
echo "<td>Address</td>\n";
echo "<td>Country</td>\n";
echo "<td>Email</td>\n";
echo "</tr>\n";
 
$conferences = User::getAllUsers($usertable);
$count = 0;
foreach($conferences as $item) {	
	$count++;
	echo "<tr>\n";
	echo "<td>\n";
    echo $count."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo $item->getDate()."\n";
	echo "</td>\n";
	echo "<td>\n";
	$date = strtotime(ereg_replace("(.*)/(.*)/(.*)","\\1-\\2-\\3",$item->getDate()));
	$years = floor((time()-$date)/(365*24*60*60));
	if($years == 1)
		echo "1 year\n";
	else
		echo $years." years\n";
	echo "</td>\n";
	echo "<td>\n";
	
    echo $item->getFax()."\n";
	echo "</td>\n";
	echo "<td>\n";

    echo $item->getName()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo $item->getTitle()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo nl2br($item->getAddress())."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo $item->getCountry()."\n";
	echo "</td>\n";
	echo "<td>\n";
    echo $item->getEmail()."\n";
	echo "</td>\n";
	echo "</tr>\n";
}	

echo "</table>\n<p>";

?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footersimple.inc.php" ?>