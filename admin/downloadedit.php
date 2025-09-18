<?php 
$page_name="downloads";//name of the page
$page_status=1; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>Edit download</h3>
<?php
require "./classes/upload.class.php";
require "./classes/download.class.php";

$download = new Download;
$upload = new Upload("","","");
$init = $download->init($_GET[id]);

$uploadfolder = "../downloads/";
$dbfile = "files";
	
if(isset($_GET[id]) && $init==true) { 

	if($download->getDownload_id()!=0)
		$uploaded = $upload->init($download->getDownload_id(),$dbfile);

	$error = "";
	if(isset($_POST[submit])) {
	
		if($_POST[nature]!="document" && $_POST[nature]!="hard copy book" && $download->getDownload_id()==0)
			$error .= "for this nature of the item you must add a file<br />";
		$price = "".((float)$_POST[price]);
		if($price != $_POST[price])
			$error .= "the price must be a double (ex. 9.1)<br />";
		if($_POST[title]=="")
			$error .= "the title is empty<br />";
		if($_POST[description]=="")
			$error .= "the description is empty<br />";
		
		if($error=="") {	
			$download->setTitle(htmlspecialchars($_POST[title], ENT_QUOTES));
			$download->setDescription(htmlspecialchars($_POST[description], ENT_QUOTES));
			$download->setOrganized(htmlspecialchars($_POST[organized], ENT_QUOTES));
			$download->setLimit($_POST[limit]);
			$download->setNature($_POST[nature]);
			$download->setPrice($price);
			$download->setDownload_id($upload->getId());
			$download->update();

			echo "<p>The download is successfully updated</p>";
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
		<input name="title" size="8" type="text" value="<?= $download->getTitle();  ?>" />
	  </div>
	  <div>
		<label>price ($ US):</label>
		<input name="price" size="8" type="text" value="<?= $download->getPrice();  ?>" />
	  </div>
	  <div>
		<label>file:</label>
		<?php
		if($download->getDownload_id()!=0)
			echo "<a href=\"".$upload->getFolder().$upload->getFilename()."\" target=\"_blank\">".$upload->getFilename()."</a>\n";
		else
			echo "<i>no file uploaded</i>";
		?>
	  </div>
	  <div>
		When the nature of the item is "hard copy book" or "other", do not upload a file.
	  </div>
	  <div>
	  	<label>store limit:</label>
		<select name="limit">
	  	<?php
		if($download->getLimit()=="Stock out")
			echo "<option selected=\"selected\" value=\"Stock out\">Stock out</option>\n";
		else
			echo "<option value=\"Stock out\">Stock out</option>\n";
		if($download->getLimit()=="Unlimited")
			echo "<option selected=\"selected\" value=\"Unlimited\">Unlimited</option>\n";
		else
			echo "<option value=\"Unlimited\">Unlimited</option>\n";
	  	?>
		</select>
	  </div>
	  <div>
	  	<label>nature of item:</label>
		<select name="nature">
	  	<?php
		if($download->getNature()=="document")
			echo "<option selected=\"selected\" value=\"Electronic document\">Electronic document</option>\n";
		else
			echo "<option value=\"document\">Electronic document</option>\n";
		if($download->getNature()=="CD or DVD")
			echo "<option selected=\"selected\" value=\"CD or DVD\">CD or DVD</option>\n";
		else
			echo "<option value=\"CD or DVD\">CD or DVD</option>\n";
		if($download->getNature()=="electronic book")
			echo "<option selected=\"selected\" value=\"Electronic book\">Electronic book</option>\n";
		else
			echo "<option value=\"electronic book\">Electronic book</option>\n";
		if($download->getNature()=="hard copy book")
			echo "<option selected=\"selected\" value=\"Hard copy book\">Hard copy book</option>\n";
		else
			echo "<option value=\"Hard copy book\">Hard copy book</option>\n";
		if($download->getNature()=="other")
			echo "<option selected=\"selected\" value=\"Other items\">other items</option>\n";
		else
			echo "<option value=\"Other items\">Other items</option>\n";
	  	?>
		</select>
	  </div>
	  <div>
		<label>organized/partnership:</label>
		<textarea name="organized"><?= $download->getOrganized();  ?></textarea>
	  </div>
	  <div>
		<label>description:</label>
		<textarea name="description"><?= $download->getDescription();  ?></textarea>
	  </div>
	  <input type="submit" name="submit" value="edit" />
	  <input type="reset" value="reset" />
	</fieldset>
  </form>
<?php
	}
} else 
	echo "<p>Press release is not found in the database.</p>";
?>
<?php require "./includes/footer.inc.php" ?>