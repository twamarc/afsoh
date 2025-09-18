<?php 
$page_title = "Payment"; //title of page
$page_name="support"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<h3>AfSoH Initiative Secure Payment Page - Pay securely online</h3>

<p align="left"><font color="Blue" size=3"" face="Arial Narrow"><strong>Why to use PayPal instead of directly your credit card?</strong></font><br/>
<font color="Black" size=3"" face="Arial Narrow">
<UL>
	<LI><strong>Pay securely for your online purchases</strong><br/>
We don&#8217;t expose your financial information (this page is extremely secured)</LIhttp://gator920.hostgator.com:2082/frontend/x3/filemanager/editit_code.html?__cpanel__temp__charset__=us-ascii&dir=%2fhome%2fifha%2fpublic_html&file=paysupport.php>

	<LI><strong>Accepted worldwide</strong><br/>
PayPal is accessible to thousands of customers worldwide. However if you do not have a credit card, don't worry! Use a standard international bank transfer. However note that charges can apply and your payment may take more than 7 days to arrive</LI>

	<LI><strong>Easy to sign up, easy to use</strong><br/>
Signing up for a PayPal account is easy - it takes just a few minutes. Once you've signed up, you can send your payment in following minutes.</LI>
</font>
</UL>

<p align="left"><font color="Blue" size=3"" face="Arial Narrow"><strong>Choose now your method to pay!</strong></font></p>
<UL>
<LI><h4>By Cheque/International Bank Transfert</h4>
Payable to :<br><br>
African Society of Hypertension (AfSoH) Initiative<br />
Label/Communication: "AfSoH- <i>ABCDEFGH</i> " Please replace <i>ABCDEFGH</i> letters by the name of item you payed for <br /><br />
<font size="" ><strong>Name of the Bank:<br /></strong></font>
BNP PARIBAS FORTIS BANK <br /><br>
<font size=""><strong>Address of the Bank:</strong></font> <br />
Montagne du Parc/Warandeberg 3 <br />
B-1000 Brussels - Belgium <br /> <br />
<font size=""><strong>Codes of the Bank: <br /></strong></font>
IBAN: BE98 0014 6122 7093<br />
BIC/SWIFT: GEBABEBB<br />
<p>We will send you an email as soon as we receive the payment.</p><br>

Any trouble or need additional information? 
Please send an email the General Secretary at <a href="mailto:secretary@afsoh.com?Subject=AfSoH. via web-eShop:Questions/Comments/Suggestions&cc=twamarc@gmail.com">secretary@afsoh.com</a><br><br>


<?php
$init = false;
if(isset($_GET[id])) {
require_once ("./admin/classes/download.class.php");
$download = new Download();
$init = $download->init($_GET[id]);
if($init) {
	echo "<b>AMOUNT: ".$download->getPrice()." dollars</b><br />";
	echo "<b>DESCRIPTION: ".$download->getTitle()."</b>";
}
}
?>
</LI>

<LI><h4>By Paypal/Credit card</h4>
<p>Please note credit card and paypal payments are subject to an additional charge (2.95% + $0.30).
<?php
require_once("includes/config.inc.php");
if($paypal[business]=="the_email_address_of_your_paypal_account@afsoh.com")
	echo "<i>not available yet</i>";
else {
?>
<form method="post" class="bodyform" action="process.php">
<?php
$am = "";
if($init) 
	$am = $download->getPrice();
else if (isset($_GET[amount]))
	$am = $_GET[amount];
if($am=="") {
?>
<p>Amount: <input type="text" name="amount" value=""> $ US</p>
<input type="hidden" name="success_url" value="support.php">
<?php
}
else {
?>
<p>Amount: <input type="hidden" name="amount" value="<?=$am; ?>"><b><?=$am; ?> $ US</b></p>
<input type="hidden" name="invoice" value="<?=sha1(md5(microtime()*rand(1,10)))."-".$_GET[id]; ?>">
<input type="hidden" name="success_url" value="download.php">
<?php
}
?>
<input type="hidden" name="item_name" value="AfSoH Initiative - Payment">
<input type="hidden" name="first_name" value="support">
<input type="submit"  class="submit" value="Click here to proceed please - You will be directed to the secured PayPal Website">
</form>
<?php
}
?></LI>
</UL>
</p>
<div class="top"><a href="#top">top</a></div>


<?php require "./includes/footer.inc.php" ?>