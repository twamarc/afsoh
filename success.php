<?php 
$page_title = "Payment"; //title of page
$page_name="home"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<h3>Payment successfully completed</h3>
<?php
if($_GET[first_name]=="support") {
	echo "<p>Thank you for the payment!!</p>";
	echo "<p><a href=\"index.php\">Go back to the homepage.</a></p>";
} else {
	require_once "./admin/classes/user.class.php";
	require_once "./admin/classes/payment.class.php";
	$payuser = new User;
	$codeok = $payuser->initByPaymentCode($_GET[invoice],"conference");
	if(!$codeok) {
		echo "<p>Error occurs during the payment. Invoice code unvalid.</p>";
		echo "<p>Please <a href=\"contact.php\">contact us</a> to solve this problem.</p>";
	} else {
		$payuser->setPaid(true);
		$payuser->update();
		$pay = new Payment;
		$pay->setUserid($payuser->getId());
		$pay->initByUserid();
		$pay->setMethod("By Paypal/Credit card");
		$pay->update();
		$payuser->sendConferencePayment($confpaymenttitle,  $webmastername, $webmasteremail, $websiteurl, $confabstractpage);
		echo "<p>We have receive your payment and you have successfully complete your registration.</p>";
		echo "<p><a href=\"abstract.php\">add an abstract</a> - <a href=\"conferences.php\">conference information</a></p>";
	}
}
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
