<?php 
$page_name="links";//name of the page
$page_status=1; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>Add link</h3>
<?php
require_once "./classes/link.class.php";

$error = "";
$link = new Link;
if(isset($_POST[submit])) {
	if($_POST[country]=="")
			$error .= "the country/region is empty";
	if($_POST[organisation]=="")
		$error .= "the organisation is empty";
	if($_POST[mission]=="")
		$error .= "the mission is empty";
	
	if($error=="") {	
		$link->setCountry(htmlspecialchars($_POST[country], ENT_QUOTES));
		$link->setOrganisation(htmlspecialchars($_POST[organisation], ENT_QUOTES));
		$link->setMission(htmlspecialchars($_POST[mission], ENT_QUOTES));
		$link->setAddress($_POST[address]);
		$link->setArrange(Link::getMaxArrange()+1);
		$link->save();
		
		echo "<p>The link is successfully added.</p>";
		echo "<p><a href=\"links.php\">overview</a> - <a href=\"linkadd.php\">add new link</a></p>";
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
	  <div>
		<label>country/region:</label>
		<input name="country" size="8" type="text" value="<?= htmlspecialchars($_POST[country], ENT_QUOTES);  ?>" />
	  </div>
	  <div>
		<label>organisation:</label>
		<input name="organisation" size="8" type="text" value="<?= htmlspecialchars($_POST[organisation], ENT_QUOTES);  ?>" />
	  </div>
	  <div>
		<label>mission:</label>
		<input name="mission" size="8" type="text" value="<?= htmlspecialchars($_POST[mission], ENT_QUOTES);  ?>" />
	  </div>
	  <div>
		<label>web or email address:</label>
		<input name="address" size="8" type="text" value="<?= $_POST[address];  ?>" />
	  </div>
	  <input type="submit" name="submit" class="submit" value="add" />
	  <input type="reset" value="reset" />
	</fieldset>
  </form>
<?php
}
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
