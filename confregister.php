<?php session_start(); 
$page_title = "Registration"; //title of page
$page_name="conferences"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<h3>Welcome on Conference registration page</h3>
<?php
require_once "./admin/classes/user.class.php";
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
	if(!eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$', $_POST[email]))
		$error .= "the email address is not valid<br />";
	if($_POST[passwd]=="")
		$error .= "the password is empty<br />";
	if($_POST[repeat]=="")
		$error .= "the repeated password is empty<br />";
	if($_POST[passwd] != $_POST[repeat])
		$error .= "the 2 inputs of the password are not the same";
	
		include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';

		$securimage = new Securimage();
	if ($securimage->check($_POST['captcha_code']) == false) {
	  // the code was incorrect
	  // you should handle the error so that the form processor doesn't continue
	
	  // or you can use the following code if there is no validation or you do not know how
	  echo "The security code entered was incorrect.<br /><br />";
	  echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	  exit;
	}	
	
	if($error=="") {	
		$user->setUsertable($usertable);
		$user->setUsername($_POST[username]);
		$user->setEmail($_POST[email]);
		$user->setPasswd($_POST[passwd]);
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
		$user->setStatus(1);
		$user->setConfirmed(true);
		$user->save();
		
		$user->sendConferenceRegister($confregistertitle,  $webmastername, $webmasteremail, $websiteurl, $_POST[passwd], $confpaymentpage, $confabstractpage);
		
		echo "<p>Congratulations! You are successfully registered for the conference.</p>";
		echo "<p><a href=\"conflogin.php?st=ok\">Click here to login and complete the conference registration.</a></p>";
		
	}
	else {
		echo "<div class=\"report\">";
		echo "<p>".$error."</p>";
		echo "</div>";
	}
	
} 
if(!isset($_POST[submit]) || $error!="") {
?>
<form class="bodyform" method="post" action="" name="form">
	<fieldset>
	  <div><strong><font color="Red" size="2" face="">
		<label><b>Username:</b></label>
		<input name="username" size="8" type="text" value="<?= htmlspecialchars($_POST[username], ENT_QUOTES);  ?>" />
	  </div>
	  <div>
		<label><b>Password:</b></label>
		<input name="passwd" size="8"  type="password" value="" />
	  </div>
	  <div>
		<label><b>Repeat password:</b></label>
		<input name="repeat" size="8"  type="password" value="" />
	  </div>
	   <div>
		<label>E-mail: *</label>
		<input name="email" size="8"  type="text" value="<?= htmlspecialchars($_POST[email], ENT_QUOTES);  ?>" />
	 
	 </strong></font>
	 
	  </div>
	  <div>
		<label>First name:</label>
		<input name="surname" size="8"  type="text" value="<?= htmlspecialchars($_POST[surname], ENT_QUOTES);  ?>" />
	  </div>
	  <div>
		<label>Middle names:</label>
		<input name="middlename" size="8"  type="text" value="<?= htmlspecialchars($_POST[middlename], ENT_QUOTES);  ?>" />
	  </div>
	  <div>
		<label>Last names:</label>
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
		<textarea name="address" rows="4"><?= htmlspecialchars($_POST[address], ENT_QUOTES); ?></textarea>
	  </div>
	  <div>
		<label>Country:</label>
		<select name="country">
    <option>Afghanistan</option>
    <option>Albania</option>
    <option>Algeria</option>
    <option>American Samoa</option>
    <option>Andorra</option>
    <option>Angola</option>
    <option>Anguilla</option>
    <option>Antarctica</option>
    <option>Antigua and Barbuda</option>
    <option>Argentina</option>
    <option>Armenia</option>
    <option>Aruba</option>
    <option>Australia</option>
    <option>Austria</option>
    <option>Azerbaijan</option>
    <option>Bahamas</option>
    <option>Bahrain</option>
    <option>Bangladesh</option>
    <option>Barbados</option>
    <option>Belarus</option>
    <option>Belgium</option>
    <option>Belize</option>
    <option>Benin</option>
    <option>Bermuda</option>
    <option>Bhutan</option>
    <option>Bolivia</option>
    <option>Bosnia and Herzegovina</option>
    <option>Botswana</option>
    <option>Bouvet Island</option>
    <option>Brazil</option>
    <option>British Indian Ocean Territory</option>
    <option>Brunei Darussalam</option>
    <option>Bulgaria</option>
    <option>Burkina Faso</option>
    <option>Burundi</option>
    <option>Cambodia</option>
    <option>Cameroon</option>
    <option>Canada</option>
    <option>Cape Verde</option>
    <option>Cayman Islands</option>
    <option>Central African Republic</option>
    <option>Chad</option>
    <option>Chile</option>
    <option>China</option>
    <option>Christmas Island</option>
    <option>Cocos Islands</option>
    <option>Colombia</option>
    <option>Comoros</option>
    <option>Congo</option>
    <option>Congo, Democratic Republic of the</option>
    <option>Cook Islands</option>
    <option>Costa Rica</option>
    <option>Cote dIvoire</option>
    <option>Croatia</option>
    <option>Cuba</option>
    <option>Cyprus</option>
    <option>Czech Republic</option>
    <option>Denmark</option>
    <option>Djibouti</option>
    <option>Dominica</option>
    <option>Dominican Republic</option>
    <option>Ecuador</option>
    <option>Egypt</option>
    <option>El Salvador</option>
    <option>Equatorial Guinea</option>
    <option>Eritrea</option>
    <option>Estonia</option>
    <option>Ethiopia</option>
    <option>Falkland Islands</option>
    <option>Faroe Islands</option>
    <option>Fiji</option>
    <option>Finland</option>
    <option>France</option>
    <option>French Guiana</option>
    <option>French Polynesia</option>
    <option>Gabon</option>
    <option>Gambia</option>
    <option>Georgia</option>
    <option>Germany</option>
    <option>Ghana</option>
    <option>Gibraltar</option>
    <option>Greece</option>
    <option>Greenland</option>
    <option>Grenada</option>
    <option>Guadeloupe</option>
    <option>Guam</option>
    <option>Guatemala</option>
    <option>Guinea</option>
    <option>Guinea-Bissau</option>
    <option>Guyana</option>
    <option>Haiti</option>
    <option>Heard Island and McDonald Islands</option>
    <option>Honduras</option>
    <option>Hong Kong</option>
    <option>Hungary</option>
    <option>Iceland</option>
    <option>India</option>
    <option>Indonesia</option>
    <option>Iran</option>
    <option>Iraq</option>
    <option>Ireland</option>
    <option>Israel</option>
    <option>Italy</option>
    <option>Jamaica</option>
    <option>Japan</option>
    <option>Jordan</option>
    <option>Kazakhstan</option>
    <option>Kenya</option>
    <option>Kiribati</option>
    <option>Kuwait</option>
    <option>Kyrgyzstan</option>
    <option>Laos</option>
    <option>Latvia</option>
    <option>Lebanon</option>
    <option>Lesotho</option>
    <option>Liberia</option>
    <option>Libya</option>
    <option>Liechtenstein</option>
    <option>Lithuania</option>
    <option>Luxembourg</option>
    <option>Macao</option>
    <option>Madagascar</option>
    <option>Malawi</option>
    <option>Malaysia</option>
    <option>Maldives</option>
    <option>Mali</option>
    <option>Malta</option>
    <option>Marshall Islands</option>
    <option>Martinique</option>
    <option>Mauritania</option>
    <option>Mauritius</option>
    <option>Mayotte</option>
    <option>Mexico</option>
    <option>Micronesia</option>
    <option>Moldova</option>
    <option>Monaco</option>
    <option>Mongolia</option>
    <option>Montenegro</option>
    <option>Montserrat</option>
    <option>Morocco</option>
    <option>Mozambique</option>
    <option>Myanmar</option>
    <option>Namibia</option>
    <option>Nauru</option>
    <option>Nepal</option>
    <option>Netherlands</option>
    <option>Netherlands Antilles</option>
    <option>New Caledonia</option>
    <option>New Zealand</option>
    <option>Nicaragua</option>
    <option>Niger</option>
    <option>Nigeria</option>
    <option>Norfolk Island</option>
    <option>North Korea</option>
    <option>Norway</option>
    <option>Oman</option>
    <option>Pakistan</option>
    <option>Palau</option>
    <option>Palestinian Territory</option>
    <option>Panama</option>
    <option>Papua New Guinea</option>
    <option>Paraguay</option>
    <option>Peru</option>
    <option>Philippines</option>
    <option>Pitcairn</option>
    <option>Poland</option>
    <option>Portugal</option>
    <option>Puerto Rico</option>
    <option>Qatar</option>
    <option>Romania</option>
    <option>Russian Federation</option>
    <option>Rwanda</option>
    <option>Saint Helena</option>
    <option>Saint Kitts and Nevis</option>
    <option>Saint Lucia</option>
    <option>Saint Pierre and Miquelon</option>
    <option>Saint Vincent and the Grenadines</option>
    <option>Samoa</option>
    <option>San Marino</option>
    <option>Sao Tome and Principe</option>
    <option>Saudi Arabia</option>
    <option>Senegal</option>
    <option>Serbia</option>
    <option>Seychelles</option>
    <option>Sierra Leone</option>
    <option>Singapore</option>
    <option>Slovakia</option>
    <option>Slovenia</option>
    <option>Solomon Islands</option>
    <option>Somalia</option>
    <option>South Africa</option>
    <option>South Georgia</option>
    <option>South Korea</option>
    <option>Spain</option>
    <option>Sri Lanka</option>
    <option>Sudan</option>
    <option>Suriname</option>
    <option>Svalbard and Jan Mayen</option>
    <option>Swaziland</option>
    <option>Sweden</option>
    <option>Switzerland</option>
    <option>Syrian Arab Republic</option>
    <option>Taiwan</option>
    <option>Tajikistan</option>
    <option>Tanzania</option>
    <option>Thailand</option>
    <option>The Former Yugoslav Republic of Macedonia</option>
    <option>Timor-Leste</option>
    <option>Togo</option>
    <option>Tokelau</option>
    <option>Tonga</option>
    <option>Trinidad and Tobago</option>
    <option>Tunisia</option>
    <option>Turkey</option>
    <option>Turkmenistan</option>
    <option>Tuvalu</option>
    <option>Uganda</option>
    <option>Ukraine</option>
    <option>United Arab Emirates</option>
    <option>United Kingdom</option>
    <option>United States</option>
    <option>United States Minor Outlying Islands</option>
    <option>Uruguay</option>
    <option>Uzbekistan</option>
    <option>Vanuatu</option>
    <option>Vatican City</option>
    <option>Venezuela</option>
    <option>Vietnam</option>
    <option>Virgin Islands, British</option>
    <option>Virgin Islands, U.S.</option>
    <option>Wallis and Futuna</option>
    <option>Western Sahara</option>
    <option>Yemen</option>
    <option>Zambia</option>
    <option>Zimbabwe</option>
</select>	  </div>
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
	  
	         
	  <div> <img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image"/> </div>	  
	  <div> <input type="text" name="captcha_code" size="10" maxlength="6" /></div> 
	  <div><a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false">  </div>				
	  <div>[ If not clear enough reload different Image by clicking here ]</a></div> <br clear=all>
	  
	  <input type="submit" name="submit" value="save and continue" class="submit" />
	  <input type="reset" value="reset" />
	</fieldset>
  </form>
<p><strong><font color="#151B54" size="2" face=""> Ensure that your email address exists, because we will henceforth use it as a communication mean to send you all information about the conference.</strong></font></p>
<?php
}
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>