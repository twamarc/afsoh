<?php 
$page_name="downloads";//name of the page
$page_status=1; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>Add download</h3>
<?php
require "./classes/upload.class.php";
require "./classes/download.class.php";

$uploadfolder = "../downloads/";
$dbfile = "files";

$error = "";

if(isset($_POST[submit])) { 

	if($_POST[nature]!="other" && $_POST[nature]!="hard copy book")
		$up = true;
	else
		$up = false;

	if($up) {
		$upload = new Upload($_POST[file],$uploadfolder,$dbfile);
		$filter = array("-","+","_","&","=","\\","'","\""," ");
		$upload->setFilename(htmlspecialchars(str_replace($filter,"",$upload->getFilename()), ENT_QUOTES));
	}

	$price = "".((float)$_POST[price]);
	if ($up && !file_exists($uploadfolder)) 
		$error = "upload folder does not exist<br />";
	if($price != $_POST[price])
		$error .= "the price must be a double (ex. 9.1)<br />";
	if($_POST[title]=="")
		$error .= "the title is empty<br />";
	if($_POST[description]=="")
		$error .= "the description is empty<br />";
	
		
	if($up) {	
		if($upload->isUploaded()==false)
			$error .= "file is not uploaded";
		else if($upload->fileExists()==true)
			$error .= "a file with filenaam ".$upload->getFilename()." already exists";
		else if($upload->getSize()==0)
			$error .= "file is not uploaded - probable out of memory";
	}
	
	if($error=="") {
		if($up)
			$upload->doUpload(); 
		$download = new Download; 
		$download->setTitle(htmlspecialchars($_POST[title], ENT_QUOTES));
		$download->setDescription(htmlspecialchars($_POST[description], ENT_QUOTES));
		$download->setOrganized(htmlspecialchars($_POST[organized], ENT_QUOTES));
		$download->setLimit($_POST[limit]);
		$download->setNature($_POST[nature]);
		$download->setPrice($price);
		if($up)
			$download->setDownload_id($upload->getId());
		$download->save(); 
		
		
		echo "<p>The download is successfully uploaded.</p>";
		echo "<p><a href=\"downloads.php\">overview</a> - <a href=\"downloadadd.php\">add new download</a></p>";
	}
	else {
		echo "<div class=\"report\">";
		echo "<p>".$error."</p>";
		echo "</div>";
	}
} 

if(!isset($_POST[submit]) || $error!="" ) {
?>
<form class="bodyform" method="post" name="form" action=""  enctype="multipart/form-data">
	<fieldset>
	  <div>
		<label>title:</label>
		<input name="title" size="8" type="text" value="<?= $_POST[title];  ?>" />
	  </div>
	  <div>
		<label>price ($ US):</label>
		<input name="price" size="8" type="text" value="<?= $_POST[price];  ?>" />
	  </div>
	  <div>
		<label>file:</label>
		<input type="file" name="file" />
	  </div>
	  <div>
		When the nature of the item is "Hard copy book" or "Other", do not upload a file.
	  </div>
	  <div>
	  	<label>store limit:</label>
		<select name="limit">
	  	<?php
		if($_POST[limit]=="Stock out")
			echo "<option selected=\"selected\" value=\"Stock out\">Stock out</option>\n";
		else
			echo "<option value=\"Stock out\">Stock out</option>\n";
		if($_POST[limit]=="Unlimited")
			echo "<option selected=\"selected\" value=\"Unlimited\">Unlimited</option>\n";
		else
			echo "<option value=\"Unlimited\">Unlimited</option>\n";
	  	?>
		</select>
	  </div>
	  <div>
	  	<label>Nature of item:</label>
		<select name="nature">
	  	<?php
		if($_POST[nature]=="document")
			echo "<option selected=\"selected\" value=\"Electronic document\">Electronic document</option>\n";
		else
			echo "<option value=\"Electronic document\">Electronic document</option>\n";
		if($_POST[nature]=="CD or DVD")
			echo "<option selected=\"selected\" value=\"CD or DVD\">CD or DVD</option>\n";
		else
			echo "<option value=\"CD or DVD\">CD or DVD</option>\n";
		if($_POST[nature]=="electronic book")
			echo "<option selected=\"selected\" value=\"Electronic book\">Electronic book</option>\n";
		else
			echo "<option value=\"Electronic book\">Electronic book</option>\n";
		if($_POST[nature]=="hard copy book")
			echo "<option selected=\"selected\" value=\"Hard copy book\">Hard copy book</option>\n";
		else
			echo "<option value=\"Hard copy book\">Hard copy book</option>\n";
		if($_POST[nature]=="other")
			echo "<option selected=\"selected\" value=\"Other items\">Other items</option>\n";
		else
			echo "<option value=\"Other items\">Other items</option>\n";
	  	?>
		</select>
	  </div>
	  <div>
		<label>organized/partnership:</label>
		<textarea name="organized"><?= htmlspecialchars($_POST[organized], ENT_QUOTES);  ?></textarea>
	  </div>
	  <div>
		<label>description:</label>
		<textarea name="description"><?= htmlspecialchars($_POST[description], ENT_QUOTES);  ?></textarea>
	  </div>
	  <input type="submit" name="submit" value="add" />
	  <input type="reset" value="reset" />
	</fieldset>
  </form>
 <?php
 }
 ?>

<?php require "./includes/footer.inc.php" ?>