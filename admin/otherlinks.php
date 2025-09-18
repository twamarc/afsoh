<?php 
$page_name="links"; //name of the page
$page_status=1; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>Other links</h3>
<?php
require_once "./classes/links.class.php";

$links = new Links;
$init = $links->init();
	
if($init==true) { 

	if(isset($_POST[submit])) {
		$links->setMessage($_POST[elm1]);
		$succ = $links->update();

		echo "<div class=\"report\"><p>The page is successfully updated.</p><p><a href=\"links.php\">>> Go back to the links page</a></p></div>";
	}
?>
<form class="bodyform" method="post" action="" name="form">
	<fieldset>
	  <br />&nbsp;<br /><textarea id="elm1" name="elm1" ><?= str_replace('\\"','"',$links->getMessage()); ?></textarea>
	  <input type="submit" name="submit" value="save" class="submit" />
	</fieldset>
  </form>
  <p>* Use the "Toggle fullscreen mode" to insert large text.</p>
 <?php
 } else {
 echo "<p>This page can not be found in the database.</p>";
 }
 ?>
 <div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
