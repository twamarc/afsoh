<?php
	//see also config.inc.php for paypal configuration
	 require_once __DIR__ . '/DB.php';
	 $user = 'ifha_ifha';
	 $pass = 'hypertafrica';
	 $host = 'localhost';
	 $db_name = 'ifha_ifha';
	 $dsn = "mysql://$user:$pass@$host/$db_name";
	 //$db = DB::connect($dsn, false);
	 //if (DB::isError($db)) {
    	//die ($db->getMessage());
	 //}
	 
	 $webmastername = "AfSoH";
	 $webmasteremail = "twamarc@gmail.com";
	 $websiteurl = "http://www.AfSoH.com/";
	 
	 $registertitle = "AfSoH Membership - activation";
	 $registerconfirm = "confirm.php";
	 
	 $registerconfirmtitle = "AfSoH Membership - activated";
	 
	 $changepasstitle = "AfSoH Membership - new password";
	 $changepage = "changepass.php";
	 
	 $confabstracttitle = "AfSoH Conference - abstract added";
	 $confregistertitle = "AfSoH Conference - registration";
	 $confpaymentinfotitle = "AfSoH Conference - payment information";
	 $confpaymenttitle = "AfSoH Conference - payment accepted";
	 $confchangepasstitle = "AfSoH Conference - new password";
	 $confchangepage = "confchangepass.php";
	 $confpaymentpage = "payment.php";
	 $confpaypage = "pay.php";
	 $confabstractpage = "abstract.php";
	 
?>