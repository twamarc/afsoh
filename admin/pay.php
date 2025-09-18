<?php 
$page_title = "Payment"; //title of page
$page_name="conferences"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
$conferencelogin=true; //conference member must login
require "./includes/header.inc.php";
?>
<h3>Conference registration payment</h3>
<?php
require_once "./admin/classes/payment.class.php";

if($conference->hasPaid() || $conference->getPaymentCode()=="paid") {
		?>
			<script type="text/javascript">
<!--
window.location = "payment.php"
//-->
</script>

		<?php
}

if(Payment::useridExists($conference->getId()))  {
$pay = new Payment;
$pay->setUserid($conference->getId());
$pay->initByUserid();

if(isset($_POST[submit])) {
$conference->setPaymentCode("paid");
$pay->setMethod("By Cheque/Bank Draft");
$pay->update();
$conference->updatePaymentCode();
		?>
			<script type="text/javascript">
<!--
window.location = "payment.php"
//-->
</script>

		<?php
}
echo "<p>You must pay  <b>";
if($pay->getType()=="member")
	echo "450.00$ US (Members)";
elseif($pay->getType()=="nonmember")
	echo "750.00$ US (Non-members)";
elseif($pay->getType()=="student")
	echo "300.00$ US (Trainee/Student)";
echo "</b>  to complete your registration for the conference.</p>";
?>
<p><font size="3" color="red"><strong> By Cheque/Bank Transfer</strong></font></p>
<p><font size="3" color="blue"><strong>Payable to :<br /><br> </strong></font>
PASH,Inc.<br />
Label/Communication: PASH Inc. Conference <br /><br />
<font size="" ><strong>Name of the Bank:<br /></strong></font>
BNP PARIBAS FORTIS BANK <br /><br>
<font size=""><strong>Address of the Bank:</strong></font> <br />
Montagne du Parc/Warandeberg 3 <br />
B-1000 Brussels - Belgium <br /> <br />
<font size=""><strong>Codes of the Bank: <br /></strong></font>
IBAN: BE98 0014 6122 7093<br />
BIC/SWIFT: GEBABEBB<br />
<p>We will send you an email as soon as we receive the payment.</p><br>

<p>You chose this option? Then click on this button and go on to process the bank transfer in standard way (via your bank)</p><br>
<form class="bodyform" method="post" action="" name="form">
<input type="submit" name="submit" value="Click here to confirm the payment" class="submit" />
</form>
<div class="top"><a href="#top">top</a></div>
<p><font size="3" color="red"><strong>By Paypal/Credit card</strong></font><p>
<p>Please note credit card and Paypal payments are subject to an additional charge (2.95% + $0.30).</p>
<p>We will send you an email as we have received the payment.</p><br /><br />
<p>You chose this option? Then click on this button below:</p>
<?php
require_once("includes/config.inc.php");
if($paypal[business]=="the_email_address_of_your_paypal_account@gmail.com")
	echo "<i>not available yet</i>";
else {
?>

<form method="post" class="bodyform" action="process.php">
<?php
if($pay->getType()=="member")
	echo "<input type=\"hidden\" name=\"amount\" value=\"51.8\">";
elseif($pay->getType()=="nonmember")
	echo "<input type=\"hidden\" name=\"amount\" value=\"51.8\">";
elseif($pay->getType()=="student")
	echo "<input type=\"hidden\" name=\"amount\" value=\"26.1\">";
?>

<input type="hidden" name="item_name" value="African Scientific Meeting on Hypertension">
<input type="hidden" name="invoice" value="<?=$conference->getPaymentCode(); ?>">
<input type="hidden" name="first_name" value="<?=$conference->getSurname(); ?>">
<input type="hidden" name="last_name" value="<?=$conference->getFamilyname(); ?>">
<input type="hidden" name="email" value="<?=$conference->getEmail(); ?>">
<input type="hidden" name="success_url" value="success.php">
<input type="submit"  class="submit" value="Click here to pay online (Credit Cards through Secured Paypal website)">
</form>
<?php
}
?>
<div class="top"><a href="#top">top</a></div>
<?php
} else {
?>
<p>You must insert your payment information before visiting this page.</p>
<p><a href="payment.php">>> Insert payment information</a></p>
<?php
}
?>

<?php require "./includes/footer.inc.php" ?>