<?php 

$page_name="conference members";//name of the page

$page_status=1; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin

require "./includes/header.inc.php";

?>

<h3>Add member</h3>

<?php

require_once "./classes/user.class.php";

$usertable = "conference";



$error = "";

$user = new User;

if(isset($_POST[submit])) {

	if($_POST[username]=="")

		$error .= "the username is empty<br />";

	else if(User::usernameExists($_POST[username],$usertable)==true)

		$error .= "the username already exists<br />";

	if($_POST[email]=="")

		$error .= "the email is empty<br />";

	if($_POST[passwd]=="")

		$error .= "the passwd is empty<br />";

	if($_POST[repeat]=="")

		$error .= "the repeated password is empty<br />";

	if($_POST[passwd] != $_POST[repeat])

		$error .= "the 2 inputs of the password are not the same";

		

	

	if($error=="") {	

		$user->setUsertable($usertable);

		$user->setUsername($_POST[username]);

		$user->setPasswd($_POST[passwd]);

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

		$user->setConfirmed(true);

		if (isset($_POST['paid'])) {

			$user->setPaid(true);

			$user->sendConferencePayment($confpaymenttitle,  $webmastername, $webmasteremail, $websiteurl, $confabstractpage);

		} else {

			$user->setPaid(false);

			$user->sendConferenceRegister($confregistertitle,  $webmastername, $webmasteremail, $websiteurl, $_POST[passwd], $confpaymentpage, $confabstractpage);

		}

		$user->save();

		

		echo "<p>The member is successfully added</p>";

		echo "<p><a href=\"conferences.php\">overview</a> - <a href=\"conferenceadd.php\">add new member</a></p>";

	}

	else {

		echo "<div class=\"report\">";

		echo "<p>".$error."</p>";

		echo "</div>";

	}

	

} 

if(!isset($_POST[submit]) || $error!="") {

echo "<p><a href=\"conferences.php\">< back to members overview</a></p>";

?>

<form class="bodyform" method="post" action="" name="form">

	<fieldset>

	  <div>

		<label>Username:</label>

		<input name="username" size="8" type="text" value="<?= htmlspecialchars($_POST[username], ENT_QUOTES);  ?>" />

	  </div>

	  <div>

		<label>Password:</label>

		<input name="passwd" size="8"  type="password" value="" />

	  </div>

	  <div>

		<label>Repeat password:</label>

		<input name="repeat" size="8"  type="password" value="" />

	  </div>

	  <div>

		<label>E-mail:</label>

		<input name="email" size="8"  type="text" value="<?= htmlspecialchars($_POST[email], ENT_QUOTES);  ?>" />

	  </div>

	  <div>

		<label>Surnames:</label>

		<input name="surname" size="8"  type="text" value="<?= htmlspecialchars($_POST[surname], ENT_QUOTES);  ?>" />

	  </div>

	  <div>

		<label>Middle names:</label>

		<input name="middlename" size="8"  type="text" value="<?= htmlspecialchars($_POST[middlename], ENT_QUOTES);  ?>" />

	  </div>

	  <div>

		<label>Family name:</label>

		<input name="familyname" size="8"  type="text" value="<?= htmlspecialchars($_POST[familyname], ENT_QUOTES);  ?>" />

	  </div>

	  <div>

		<label>Academic title:</label>

		<input name="title" size="8"  type="text" value="<?= htmlspecialchars($_POST[title], ENT_QUOTES);  ?>" />

	  </div>

	  <div>

		<label>Affiliation institution:</label>

		<input name="institution" size="8"  type="text" value="<?= htmlspecialchars($_POST[institution], ENT_QUOTES);  ?>" />

	  </div>

	  <div>

		<label>Personnal addresses:</label>

		<input name="address" size="8"  type="text" value="<?= htmlspecialchars($_POST[address], ENT_QUOTES);  ?>" />

	  </div>

	  <div>

		<label>Country:</label>

		<input name="country" size="8"  type="text" value="<?= htmlspecialchars($_POST[country], ENT_QUOTES);  ?>" />

	  </div>

	  <div>

		<label>Phone:</label>

		<input name="phone" size="8"  type="text" value="<?= htmlspecialchars($_POST[phone], ENT_QUOTES);  ?>" />

	  </div>

	  <div>

		<label>Fax:</label>

		<input name="fax" size="8"  type="text" value="<?= htmlspecialchars($_POST[fax], ENT_QUOTES);  ?>" />

	  </div>
	  
	  <div>
	  <label>Travel Grant:</label>
	  <div>
	  <input type="radio" name="travel" value="not applicable" />not applicable<br />
	  <input type="radio" name="travel" value="none" />none<br />
	  <input type="radio" name="travel" value="requested from" />requested from:
	  <label></label><textarea name="traveltext"><?= htmlspecialchars($_POST[traveltext], ENT_QUOTES);  ?></textarea></div>
	  </div>
	  
	  <div>
	  <label>Accommodation Grant:</label>
	  <div>
	  <input type="radio" name="accommodation" value="not applicable" />not applicable<br />
	  <input type="radio" name="accommodation" value="none" />none<br />
	  <input type="radio" name="accommodation" value="requested from" />requested from:
	  <label></label><textarea name="accommodationtext"><?= htmlspecialchars($_POST[accommodationtext], ENT_QUOTES);  ?></textarea></div>
	  </div>
	  
	  <div>
	  <label>Registration Grant:</label>
	  <div>
	  <input type="radio" name="registration" value="not applicable" />not applicable<br />
	  <input type="radio" name="registration" value="none" />none<br />
	  <input type="radio" name="registration" value="requested from" />requested from:
	  <label></label><textarea name="registrationtext"><?= htmlspecialchars($_POST[registrationtext], ENT_QUOTES);  ?></textarea></div>
	  </div>
	  
	  <div>
	  <label>Other comments:</label>
	  <textarea name="comments"><?= htmlspecialchars($_POST[comments], ENT_QUOTES);  ?></textarea>
	  </div>

	  <div>

	  <label>Member paid:</label>

		<input type="checkbox" name="paid" /> (selected: yes, not selected: no)

	  </div>

	  <input type="submit" name="submit" value="add" class="submit" />

	  <input type="reset" value="reset" />

	</fieldset>

  </form>

<?php

}

?>

<div class="top"><a href="#top">top</a></div>

<?php require "./includes/footer.inc.php" ?>

