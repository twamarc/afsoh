<?php 
$page_title = "Abstract"; //title of page
$page_name="conferences"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
$conferencelogin=true; //conference member must login
require "./includes/header.inc.php";
?>
<h3>Abstract</h3>
<?php
if(isset($_GET[log]) && $_GET[log]=="ok" && !isset($_POST[submit])) {
	echo "<div class=\"report\">";
	echo "<p>You have successfully logged in.</p>";
	echo "</div>";
}
?>
<?php
require_once "./admin/classes/abstract.class.php";
$error = "";
$abstract = new AbstractMessage;
if(isset($_POST[submit])) {
	if($_POST[name]=="")
		$error .= "the authors field is empty<br />";
	if(strlen($_POST[name])>2500)
		$error .= "the authors field is to long (max 2500 characters)<br />";
	if($_POST[type]=="select")
		$error .= "you must select a type<br />";
	if($_POST[title]=="")
		$error .= "the title is empty<br />";
	if(strlen($_POST[title])>2500)
		$error .= "the title is to long (max 2500 characters)<br />";
	if(strlen($_POST[message])>5000)
		$error .= "the abstract is to long (max 2500 characters)<br />";
	if($_POST[message]=="")
		$error .= "the abstract is empty";
	
	if($error=="") {	
		$abstract->setName(htmlspecialchars($_POST[name], ENT_QUOTES));
		$abstract->setType(htmlspecialchars($_POST[type], ENT_QUOTES));
		$abstract->setTitle(htmlspecialchars($_POST[title], ENT_QUOTES));
		$abstract->setMessage(htmlspecialchars($_POST[message], ENT_QUOTES));
		$abstract->setUserid($conference->getId());
		$abstract->save();
		$conference->sendConferenceAbstract($confabstracttitle,  $webmastername, $webmasteremail, $websiteurl, $confpaymentpage);
		
		if(!$conference->hasPaid()) {
		?>
			<script type="text/javascript">
<!--
window.location = "payment.php?abst=ok"
//-->
</script>

		<?php
		}
		echo "<p>The abstracts is successfully added.</p>";
		
		
	}
	else {
		echo "<div class=\"report\">";
		echo "<p>".$error."</p>";
		echo "</div>";
	}
	
} 
if(!isset($_POST[submit]) || $error!="") {
?>
<p>Select your manuscript type. Enter the authors and affiliations, title and abstract.<br />
Ensure the abstract is okay. You can not change the abstract after submitting.</p>
<form class="bodyformlarge" method="post" action="" name="form">
	<fieldset>
	  <div>
		<label>Authors and affiliations:<br />(max 2500 characters)</label>
		<textarea name="name" rows="5"><?= htmlspecialchars($_POST[name], ENT_QUOTES); ?></textarea>
	  </div>
	  <div>
		<label>type:</label>
		<select name="type">
		<?php
		if($_POST[type]=="select")
			echo "<option value=\"select\" selected=\"selected\">select...</option>";
		else
			echo "<option value=\"select\">select...</option>";
		if($_POST[type]=="Review and/or Meta-analysis")
			echo "<option value=\"Review and/or Meta-analysis\" selected=\"selected\">Review and/or Meta-analysis</option>";
		else
			echo "<option value=\"Review and/or Meta-analysis\">Review and/or Meta-analysis</option>";
		if($_POST[type]=="Epidemiological and/or Survey")
			echo "<option value=\"Epidemiological and/or Survey\" selected=\"selected\">Epidemiological and/or Survey</option>";
		else
			echo "<option value=\"Epidemiological and/or Survey\">Epidemiological and/or Survey</option>";
		if($_POST[type]=="Clinical trial")
			echo "<option value=\"Clinical trial\" selected=\"selected\">Clinical trial</option>";
		else
			echo "<option value=\"Clinical trial\">Clinical trial</option>";
		if($_POST[type]=="Experimental study")
			echo "<option value=\"Experimental study\" selected=\"selected\">Experimental study</option>";
		else
			echo "<option value=\"Experimental study\">Experimental study</option>";
		if($_POST[type]=="Original research")
			echo "<option value=\"Original research\" selected=\"selected\">Original research</option>";
		else
			echo "<option value=\"Original research\">Original research</option>";
		if($_POST[type]=="Other types")
			echo "<option value=\"Other types\" selected=\"selected\">Other types</option>";
		else
			echo "<option value=\"Other types\">Other types</option>";
		?>
		</select>
	  </div>
	  <div>
		<label>title:<br />(max 2500 characters)</label>
		<textarea name="title" rows="5"><?= htmlspecialchars($_POST[title], ENT_QUOTES); ?></textarea>
	  </div>
	  <div>
		<label>abstract:<br />(max 2500 characters)</label>
		<textarea name="message" rows="10"><?= htmlspecialchars($_POST[message], ENT_QUOTES); ?></textarea>
	  </div>
	  <?php
	  if(!$conference->hasPaid()) {
	  ?>
	  <input type="submit" name="submit" value="save and continue" class="submit" />
	  <?php
	  } else {
	  ?>
	  <input type="submit" name="submit" value="add" class="submit" />
	  <?php
	  }
	  ?>
	  
	  <input type="reset" value="reset" />
	</fieldset>
  </form>
  
<?php
}
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>