<?php 
$page_name="program"; //name of the page
$page_status=1; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>Conference Program</h3>
<?php
require_once "./classes/program.class.php";

$program = new Program;
$init = $program->init();
	
if($init==true) { 

	if(isset($_POST[submit])) {
		$program->setMessage($_POST[elm1]);
		$succ = $program->update();

		echo "<div class=\"report\"><p>The page is successfully updated.</p></div>";
	}
?>
<form class="bodyform" method="post" action="" name="form">
	<fieldset>
	  <br />&nbsp;<br /><textarea id="elm1" name="elm1" ><?= str_replace('\\"','"',$program->getMessage()); ?></textarea>
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
