<?php 

$page_name="conference members";//name of the page

$page_status=1; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin

require "./includes/header.inc.php";

?>

<h3>Edit member</h3>

<?php



require_once "./classes/user.class.php";

$usertable = "conference";



$user = new User;

$init = $user->initById($_GET[id],$usertable);

	

if(isset($_GET[id]) && $init==true) { 





	$error = "";

	if(isset($_POST[submit])) {

		if($_POST[username]=="")

			$error .= "the username is empty<br />";

		if($_POST[email]=="")

			$error .= "the email is empty<br />";

		if($_POST[passwd]!="" || $_POST[repeat]!="") { 

			if($_POST[passwd]=="")

				$error .= "the passwd is empty<br />";

			if($_POST[repeat]=="")

				$error .= "the repeated password is empty<br />";

			if($_POST[passwd] != $_POST[repeat])

				$error .= "the 2 inputs of the password are not the same";

		}

		

		if($error=="") {	

			$user->setUsertable($usertable);

			if($_POST[passwd]!="")

				$user->setPasswd($_POST[passwd]);

			$user->setUsername($_POST[username]);

			$user->setEmail($_POST[email]);

			$user->setSurname($_POST[surname]);

			$user->setMiddlename($_POST[middlename]);

			$user->setFamilyname($_POST[familyname]);

			$user->setTitle($_POST[title]);

			$user->setInstitution($_POST[institution]);

			$user->setAddress($_POST[address]);

			$user->setCountry($_POST[country]);

			$user->setPhone($_POST[phone]);

			$user->setFax($_POST[fax]);
			
			$user->setTravel($_POST[travel]);
			$user->setTraveltext($_POST[traveltext]);
			$user->setAccommodation($_POST[accommodation]);
			$user->setAccommodationtext($_POST[accommodationtext]);
			$user->setRegistration($_POST[registration]);
			$user->setRegistrationtext($_POST[registrationtext]);
			$user->setComments($_POST[comments]);

			if (isset($_POST['paid'])) {

				$user->setPaid(true);

				$user->sendConferencePayment($confpaymenttitle,  $webmastername, $webmasteremail, $websiteurl, $confabstractpage);

			} else

				$user->setPaid(false);

			$succ = $user->update();



			echo "<p>The member is successfully updated.</p>";

			echo "<p><a href=\"conferences.php\">overview</a> - <a href=\"conferenceadd.php\">add new member</a></p>";

		}

		else {

			echo "<div class=\"report\">";

			echo "<p>".$error."</p>";

			echo "</div>";

		}

	}

if(!isset($_POST[submit]) || $error!="" ) {

echo "<p><a href=\"conferences.php\">< back to members overview</a></p>";

?>

<form class="bodyform" method="post" action="" name="form">

	<fieldset>

		<div>

		<label>Registered on:</label>

		<input name="username" size="8"  type="text" value="<?=$user->getDate(); ?>" disabled="disabled" />

	  </div>

	  <div>

		<label>Username:</label>

		<input name="username" size="8"  type="text" value="<?=$user->getUsername(); ?>" />

	  </div>

	  <div>

		<label>New password:</label>

		<input name="passwd" size="8"  type="password" value="" />

	  </div>

	  <div>

		<label>Repeat password:</label>

		<input name="repeat" size="8"  type="password" value="" />

	  </div>

	   <div>

		<label>E-mail:</label>

		<input name="email" size="8"  type="text" value="<?=$user->getEmail(); ?>" />

	  </div>

	  <div>

		<label>Surnames:</label>

		<input name="surname" size="8"  type="text" value="<?=$user->getSurname(); ?>" />

	  </div>

	  <div>

		<label>Middle names:</label>

		<input name="middlename" size="8"  type="text" value="<?=$user->getMiddlename(); ?>" />

	  </div>

	  <div>

		<label>Family name:</label>

		<input name="familyname" size="8"  type="text" value="<?=$user->getFamilyname(); ?>" />

	  </div>

	  <div>

		<label>Academic title:</label>

		<input name="title" size="8"  type="text" value="<?=$user->getTitle(); ?>" />

	  </div>

	  <div>

		<label>Affiliation institution:</label>

		<input name="institution" size="8"  type="text" value="<?=$user->getInstitution(); ?>" />

	  </div>

	  <div>

		<label>Personnal addresses:</label>

		<input name="address" size="8"  type="text" value="<?=$user->getAddress(); ?>" />

	  </div>

	  <div>

		<label>Country:</label>

		<input name="country" size="8"  type="text" value="<?=$user->getCountry(); ?>" />

	  </div>

	  <div>

		<label>Phone:</label>

		<input name="phone" size="8"  type="text" value="<?=$user->getPhone(); ?>" />

	  </div>

	  <div>

		<label>Fax:</label>

		<input name="fax" size="8"  type="text" value="<?=$user->getFax(); ?>" />

	  </div>
	  
	  <div>
	  <label>Travel Grant:</label>
	  <div>
	  <input type="radio" name="travel" value="not applicable" <?php if($user->getTravel()=="not applicable") echo "checked=\"checked\""; ?> />not applicable<br />
	  <input type="radio" name="travel" value="none" <?php if($user->getTravel()=="none") echo "checked=\"checked\""; ?> />none<br />
	  <input type="radio" name="travel" value="requested from" <?php if($user->getTravel()=="requested from") echo "checked=\"checked\""; ?>/>requested from:
	  <label></label><textarea name="traveltext"><?= $user->getTraveltext();  ?></textarea></div>
	  </div>
	  
	  <div>
	  <label>Accommodation Grant:</label>
	  <div>
	  <input type="radio" name="accommodation" value="not applicable" <?php if($user->getAccommodation()=="not applicable") echo "checked=\"checked\""; ?> />not applicable<br />
	  <input type="radio" name="accommodation" value="none" <?php if($user->getAccommodation()=="none") echo "checked=\"checked\""; ?> />none<br />
	  <input type="radio" name="accommodation" value="requested from" <?php if($user->getAccommodation()=="requested from") echo "checked=\"checked\""; ?> />requested from:
	  <label></label><textarea name="accommodationtext"><?= $user->getAccommodationtext();  ?></textarea></div>
	  </div>
	  
	  <div>
	  <label>Registration Grant:</label>
	  <div>
	  <input type="radio" name="registration" value="not applicable" <?php if($user->getRegistration()=="not applicable") echo "checked=\"checked\""; ?> />not applicable<br />
	  <input type="radio" name="registration" value="none" <?php if($user->getRegistration()=="none") echo "checked=\"checked\""; ?> />none<br />
	  <input type="radio" name="registration" value="requested from" <?php if($user->getRegistration()=="requested from") echo "checked=\"checked\""; ?> />requested from:
	  <label></label><textarea name="registrationtext"><?= $user->getRegistrationtext();  ?></textarea></div>
	  </div>
	  
	  <div>
	  <label>Other comments:</label>
	  <textarea name="comments"><?= $user->getComments();  ?></textarea>
	  </div>

	  <div>

		<label>Member paid:</label>

		<?php

		if($user->hasPaid()) {

		?>

		<input type="checkbox" name="paid" checked="checked" /> (selected: yes, not selected: no)

		<?php

		} else {

		?>

		<input type="checkbox" name="paid" /> (selected: yes, not selected: no)

		<?php

		}?>

	  </div>

	  

	  <input type="submit" name="submit" value="edit" class="submit" />

	  <input type="reset" value="reset" />

	</fieldset>

  </form>

  <p>Leave the password fields empty if you do not want to change the password.</p>

<?php

	}

} else  {

	echo "<p>The member is not found in the database.</p>";

	echo "<p><a href=\"conferences.php\">overview</a> - <a href=\"conferenceadd.php\">add new member</a></p>";

}



?>

<div class="top"><a href="#top">top</a></div>

<?php require "./includes/footer.inc.php" ?>

