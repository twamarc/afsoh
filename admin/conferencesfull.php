<?php 
$page_name="abstracts";//name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/headersimple.inc.php";
?>
<h3>Conference members</h3>
<?php
require_once "./classes/user.class.php";
require_once "./classes/abstract.class.php";
require_once "./classes/payment.class.php";
$usertable = "conference";


echo "<table> \n";
echo "<tr class=\"legende\">\n";
echo "<td rowspan=\"2\">N&deg;</td>\n";
echo "<td rowspan=\"2\">Date</td>\n";
echo "<td rowspan=\"2\">Number of abstracts submitted</td>\n";
echo "<td colspan=\"5\" class=\"center\">Author</td>\n";
echo "<td rowspan=\"2\">PASH Inc. Membership fees</td>\n";
echo "</tr>\n";
echo "<tr class=\"legende\">\n";
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
	echo AbstractMessage::getAbstractCount($item->getId())."\n";
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
	$pay = new Payment;
	$pay->setUserid($item->getId());
	$init = $pay->initByUserid();
	if($init) {
		if($pay->getType()=="member")
			$payment = "450.00$ US";
		elseif($pay->getType()=="nonmember")
			$payment = "750.00$ US";
		elseif($pay->getType()=="student")
			$pament = "300.00$ US";
	} else
		$payment = "";
	echo "<td>\n";
    echo $payment."\n";
	echo "</td>\n";
	
	echo "</tr>\n";
}	

echo "</table>\n<p>";

?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footersimple.inc.php" ?>
