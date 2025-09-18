<?php 
$page_name="payment";//name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
$conferencelogin = true; //you must be logged in for the conference
require "./includes/header.inc.php";
?>
<h3>Registration and accomodation booking form</h3>
<p><a href="conferences.php"><< Go back to members overview</a></p>
<?php
require_once "./classes/payment.class.php";

$pay = new Payment;
$pay->setUserid($_GET[id]);
$init = $pay->initByUserid();

	
if(isset($_GET[id]) && $init==true) { 
?>
<form class="bodyformlarge" method="post" action="" name="form">
	<fieldset>
	  <table>
	  <tr class="legende">
	  <td>Attendance and Social Events</td>
	  <td>Thursday 06 May 2010</td>
	  <td>Friday 07 May 2010</td>
	  <td>Saturday 08 May 2010</td>
	  </tr>
	  <tr>
	  <td><p>I will be attending the <b>Hypertension Teaching Seminar in
		  Africa</b> organized by the International Society of Hypertension (ISH)
	      Low and Middle Income Countries Committee.</p></td>
	  <td><?php if($pay->semi_preco) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->post_sem_day1) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->post_sem_day2) echo "x"; else echo "&nbsp;"; ?></td>
	  </tr>
	  <tr>
	  <td><p>I will be attending the <b>Scientific Meeting on
		Hypertension.</p></td>
	  <td><?php if($pay->ifha_preco) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->ifha_day1) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->ifha_day2) echo "x"; else echo "&nbsp;"; ?></td>
	  </tr>
	  <tr>
	  <td><p>I will attend the Welcome Reception</p></td>
	  <td><?php if($pay->rece_preco) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->rece_day1) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->rece_day2) echo "x"; else echo "&nbsp;"; ?></td>
	  </tr>
	  <tr>
	  <td><p>I will attend the Musical Recital (places are limited) </p></td>
	  <td><?php if($pay->gala_preco) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->gala_day1) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->gala_day2) echo "x"; else echo "&nbsp;"; ?></td>
	  </tr>
	  <tr>
	  <td><p>I will attend the Conference Dinner</p></td>
	  <td><?php if($pay->close_preco) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->close_day1) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->close_day2) echo "x"; else echo "&nbsp;"; ?></td>
	  </tr>
	  <tr>
	  <td><p>I will require single (or double) accommodation.</p></td>
	  <td><?php if($pay->hotel_preco) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->hotel_day1) echo "x"; else echo "&nbsp;"; ?></td>
	  <td><?php if($pay->hotel_day2) echo "x"; else echo "&nbsp;"; ?></td>
	  </tr>
	  </table>
	  <p>&nbsp;</p>
	  <div>
		<label><b>Payment date:</b></label>
		<?=$pay->getDate(); ?>
	  </div>
	  <div>
		<label><b>Registration Fee:</b></label>
		<?php
		if($pay->getType()=="member")
			echo "50.00$ US (Members)";
		elseif($pay->getType()=="nonmember")
			echo "75.00$ US (Non-members)";
		elseif($pay->getType()=="student")
			echo "25.00$ US (Trainee/Student)";
		?>
	  </div>
	  <div>
		<label><b>Payment method:</b></label>
		<?=$pay->getMethod(); ?>
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
} else 
	echo "<p>No payment information found.</p>";
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>