<?php 
$page_title = "Payment"; //title of page
$page_name="conferences"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
$conferencelogin=true; //conference member must login
require "./includes/header.inc.php";
?>
<h3>Registration and accomodation booking form</h3> <font size="3" color="red"><strong>
 <p>&nbsp</p></strong></font>
<?php
if(isset($_GET[log]) && $_GET[log]=="ok" && !isset($_POST[submit])) {
	echo "<div class=\"report\">";
	echo "<p>You have successfully logged in.</p>";
	echo "</div>";
}
if(isset($_GET[abst]) && $_GET[abst]=="ok" && !isset($_POST[submit])) {
	echo "<div class=\"report\">";
	echo "<p>The abstracts is successfully added.</p>";
	echo "</div>";
}
?>
<?php
require_once "./admin/classes/payment.class.php";

if($conference->hasPaid()) {
	echo "<p class=\"info\">You have allready paid.</p>";
} elseif($conference->getPaymentCode()=="paid") {
	echo "<p class=\"info\"> Dear participants, &nbsp;We thank you for the payment. &nbsp;We have not yet received your payment. &nbsp;We will send you an email if we receive it.</p>";
} elseif(Payment::useridExists($conference->getId())) {
	echo "<p class=\"info\">Note !: You have already submitted required information. Now you must pay (next page) to complete this registration.</p>";
	echo "<p><a href=\"pay.php\">>> Go to payment page and complete your registration.</a></p>";
}
if(Payment::useridExists($conference->getId())) {
$pay = new Payment;
$pay->setUserid($conference->getId());
$pay->initByUserid();
?>
<form class="bodyformlarge" method="post" action="" name="form">
	<fieldset>
	  <table>
	  <tr class="legende">
	  <td>Attendance and Social Events</td>
	  <td>Pre-conference Symposia</td>
	  <td>Day one of the conference</td>
	  <td>Day twoo of the conference</td>
	  </tr>
	  <tr>
	  <td><p>I will be attending the <b>Pre-conference Symposium </b> <br/>organized by the Adhoc Working Group.<br><br/><br/>
		  <i>Please note that, unless covered by organizers grant -and notified to the participants, participants will have to cover accommodation, meals and the travel. </i></p></td>
	  <td><?php if($pay->sem_preco) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->post_sem_day1) echo "x"; else echo "&nbsp;"; ?></td>
          <td></td>
	  </tr>
	  <tr>
	  <td><p>I will be attending the <b>Scientific Meeting. </b> <br/><br/>
			<i>Please note that, unless covered by organizers grant -and notified to the participants, participants will have to cover accommodation, evening meals and the travel.</b></i></p></td>
          <td></td>
	  <td><?php if($pay->ifha_day1) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->ifha_day2) echo "x"; else echo "&nbsp;"; ?></td>
	  </tr>
	  <tr>
	  <td><p>I will attend the Welcome Reception </p></td>
	  <td><?php if($pay->rece_preco) echo "x"; else echo "&nbsp;"; ?></td>
          <td></td>
          <td></td>
	  </tr>
	  <tr>
	  <td><p>I will attend the Musical Recital (places are limited).</p></td>
          <td></td>
	  <td><?php if($pay->gala_day1) echo "x"; else echo "&nbsp;"; ?></td>
          <td></td>
	  </tr>
	  <tr>
	  <td><p>I will attend the Conference Dinner.</p></td>
           <td></td>
          <td></td>	
	  <td><?php if($pay->close_day2) echo "x"; else echo "&nbsp;"; ?></td>
	  </tr>
	  <tr>
	  <td><p>I will require single accommodation. <br/><br/> <i>(if double, please indicate it below in dedicated space) </i></p></td>
	  <td><?php if($pay->hotel_preco) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->hotel_day1) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->hotel_day2) echo "x"; else echo "&nbsp;"; ?></td>
	  </tr>
	  </table>
	  <p>&nbsp;</p>
	  <div>
		<label><b>Registration Fee:</b></label>
		<?php
		if($pay->getType()=="member")
			echo "450.00$ US (Members)";
		elseif($pay->getType()=="nonmember")
			echo "750.00$ US (Non-members)";
		elseif($pay->getType()=="student")
			echo "300.00$ US (Trainee/Student)";
		?>
	  </div>
	  <div>
		<label><b>Special requirements:</b></label>
	  </div>
	  <div>
		<p><?=nl2br($pay->getMessage()); ?></p>
	  </div>
	</fieldset>
  </form>
<?php
} else {
$error = "";
$payment = new Payment;
if(isset($_POST[submit])) {

	if($_POST[type]=="select")
		$error .= "you must select a type<br />";
	
	if($error=="") {	
		$conference->sendConferencePaymentinfo($confpaymentinfotitle,  $webmastername, $webmasteremail, $websiteurl, $confabstractpage, $confpaypage);
		$payment->setType(htmlspecialchars($_POST[type], ENT_QUOTES));
		$payment->setMessage(htmlspecialchars($_POST[message], ENT_QUOTES));
		$payment->setUserid($conference->getId());
		if (isset($_POST['semi_preco'])) 
			$payment->semi_preco = true;
		else
			$payment->semi_preco = false;
		if (isset($_POST['post_sem_day1'])) 
			$payment->post_sem_day1 = true;
		else
			$payment->post_sem_day1 = false;
	
		if (isset($_POST['ifha_day1'])) 
			$payment->ifha_day1 = true;
		else
			$payment->ifha_day1 = false;
		if (isset($_POST['ifha_day2'])) 
			$payment->ifha_day2 = true;
		else
			$payment->ifha_day2 = false;
		if (isset($_POST['rece_preco'])) 
			$payment->rece_preco = true;
		else
			$payment->rece_preco = false;
	
		if (isset($_POST['gala_day1'])) 
			$payment->gala_day1 = true;
		else
			$payment->gala_day1 = false;
		
		
		if (isset($_POST['close_day2'])) 
			$payment->close_day2 = true;
		else
			$payment->close_day2 = false;
		if (isset($_POST['hotel_preco'])) 
			$payment->hotel_preco = true;
		else
			$payment->hotel_preco = false;
		if (isset($_POST['hotel_day1'])) 
			$payment->hotel_day1 = true;
		else
			$payment->hotel_day1 = false;
		if (isset($_POST['hotel_day2'])) 
			$payment->hotel_day2 = true;
		else
			$payment->hotel_day2 = false;
		$payment->save();
		
		echo "<p>The payment data is successfully added.</p>";
		echo "<p><a href=\"pay.php\">>> Pay to complete your registration.</a></p>";
	}
	else {
		echo "<div class=\"report\">";
		echo "<p>".$error."</p>";
		echo "</div>";
	}
	
} 
if(!isset($_POST[submit]) || $error!="") {
?>
<p>Payment includes: access to all scientific sessions and social events, conference materials, and does not cover accommodation. 
Individuals may book accommodation directly from the website or  <b><a href="www.agpalacehotel.com">Go to this website</a></b>  to book directly from the hotel.</p>
<p>Please tick relevant boxes.</p>
<form class="bodyformlarge" method="post" action="" name="form">
	<fieldset>
	  <table>
	  <tr class="legende">
	  <td>Attendance and Social Events</td>
	  <td>Day One of the conference</td>
	  <td>Day two of the conference</td>
	  <td>Day three of the conference</td>
	  </tr>
	  <tr>
	  <td><p>I will be attending the <b>Pre-conference Symposia</p></td>
	  <td><input type="checkbox" name="semi_preco" /></td>
	  <td><input type="checkbox" name="post_sem_day1" /></td>
	  <td></td>
	  </tr>
	  <tr>
	  <td><p>I will be attending the <b>Scientific Meeting</b></p></td>
          <td></td>
	  <td><input type="checkbox" name="ifha_day1" /></td>
	  <td><input type="checkbox" name="ifha_day2" /></td>
	  </tr>
	  <tr>
	  <td><p>I will attend the Welcome Reception </p></td>
	  <td><input type="checkbox" name="rece_preco" /></td>
          <td></td>
          <td></td>
	  </tr>
	  <tr>
	  <td><p>I will attend the Gala evening (Musical Recital, places are limited).</p></td>
          <td></td>
	  <td><input type="checkbox" name="gala_day1" /></td>
          <td></td>
	  </tr>
	  <tr>
	  <td><p>I will attend the Conference Dinner.</p></td>
          <td></td>
          <td></td>
	  <td><input type="checkbox" name="close_day2" /></td>
	  </tr>
	  <tr>
	  <td><p>I will require single accommodation. <br> <i>Notes: If you need a double room or other type(suite, etc) 
	          or personal private transport, please indicate that below in dedicated space.</br></i>
	          <br> Note also that you have to make your own hotel booking, unless you are covered by a organizers grant. 
	          Alternatively you can contact by mail <a href="mailto:secretary@pash-onweb.com?CC=admin@pash-onweb.com, twamarc@gmail.com">Chairman Local organizer</A>to get help. </br></p></td>
	  <td><input type="checkbox" name="hotel_preco" /></td>
	  <td><input type="checkbox" name="hotel_day1" /></td>
	  <td><input type="checkbox" name="hotel_day2" /></td>
	  </tr>
	  </table>
	  <p>&nbsp;</p>
	  <div>
		<label>Registration Fee:</label>
		<select name="type">
		<?php
		if($_POST[type]=="select")
			echo "<option value=\"select\" selected=\"selected\">select...</option>";
		else
			echo "<option value=\"select\">select...</option>";
		if($_POST[type]=="member")
			echo "<option value=\"member\" selected=\"selected\">450.00$ US (Members)</option>";
		else
			echo "<option value=\"member\">450.00$ US (Members)</option>";
		if($_POST[type]=="nonmember")
			echo "<option value=\"nonmember\" selected=\"selected\">750.00$ US (Non-members)</option>";
		else
			echo "<option value=\"nonmember\">750.00$ US (Non-members)</option>";
		if($_POST[type]=="student")
			echo "<option value=\"student\" selected=\"selected\">300.00$ US (Trainee/Student)</option>";
		else
			echo "<option value=\"student\">300.00$ US (Trainee/Student)</option>";
		?>
		</select>
	  </div>
	  <div>
		<label>Please indicate any special requirements:</label>
		<textarea name="message" rows="10"><?= htmlspecialchars($_POST[message], ENT_QUOTES); ?></textarea>
	  </div>
	  <input type="submit" name="submit" value="save and continue" class="submit" />
	  <input type="reset" value="reset" />
	</fieldset>
  </form>
  
<?php
}
}
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>