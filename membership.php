<?php 
$page_title = "Membership"; //title of page
$page_name="membership"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>

<h4><strong><font color="Blue">General Information about AfSoH Membership</font></strong></h4>
<?php
if(isset($_GET[log]) && $_GET[log]=="ok") {
	echo "<div class=\"report\">";
	echo "<p>You have successfully logged in.</p>";
	echo "</div>";
}
?>
<p></p>

<p><font color="#000066" >Dear Colleague, <br> 
Congratulations, you are logged into the membership page!<br> 
If you are redirected here after registration, we invite you to have a look on <a href="http://www.afsoh.com/membership_fees.php">the membership fees</a> and proceed to the <a href="http://www.afsoh.com/paysupport.php"> 
membership payment by this link </a> to get your membership card, otherwise your registration will stay pending.<br><br> 
If you have not yet registrerd for AfSoH membership, 
we invite you to  <a href="http://www.afsoh.com/register.php"><font color="#0000FF">click here and register today </font></a>. 
</font></p><p></p>
<p><font color="#000066" >After the payment you will receive your membership card of a validity of your subscription, bearing 
    the <font color="#FF0000"><strong>AfSoH. Membership ID </strong></font>, in following format: <a href="images/afsoh_id_explanation.jpg"><font color="#FF0000">00-XY00.Z0000</font> (Explanation here). </a></p> 
<p>The membership ID is lifelong, but if membership fees are not paid, the ID is not active. If your ID has been de-activated, please renew your membership to activate it. </font></p>
<p>Note that, only members with membership ID can be elected for <font color="#FF0000"><strong> "Fellowship African Society of Hypertension- FASH", </strong></font> a title which is awarded by AfSoH scientific meeting. Members with active membership are also the only to benefit from grants, free publications, special calls and announcements, and many other benefits</p> 
<h4><strong><font color="Blue">The 5 categories of AfSoH members are:</font></strong></h4>
<p><strong>Organizations' membership</strong>: Open to all Scientists orgnisations, involved in cardiovascular field (every institution or society is represented in Genaeral assembly by delegates proportionally to the number of its members - one delegate per a set of 10 members.</p>
<p><strong>Full individual membership</strong>: Open to all individual Scientists involved in cardiovascular field all over the world. Also cardiologists, cardiothoracic surgeons, cardiac pathologists, cardiac anaesthesiologists, cardiac pharmacologists, cardiac epidemiologists and other cardiac related medical specialists practicing or involved in research.</p>
<p><strong>Fellow membership</strong>: Open to students, technicians/technologists experts in hypertension and cardiac care. This category is also opened for junior nurses in the intensive care units, cardiothoracic or cardiology wards or theatres, and any other paramedical staff involved in cardiovascular medicine or surgery e.g. physiotherapists, cardiac rehabilitation staff, etc.</p>
<p><strong>Honorary membership</strong>: Open to any person who has shown a recognisable interest in the AfSoH by regular contacts, participation in the AfSoH's activities or by direct or indirect to the Society.</p>
<p><strong>Life membership</strong>: Which shall either be through a consistant support to the AfSoH or through a decision of the AfSoH advisory cuncil</p>
<p>&nbsp;</p>
</font></p>

<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>