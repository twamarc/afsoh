<?php 
$page_name="news"; //name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>Edit news</h3>
<?php
require_once "./classes/news.class.php";

$news = new News;
$init = $news->init($_GET[id]);
	
if(isset($_GET[id]) && $init==true) { 


	$error = "";
	if(isset($_POST[submit])) {
		if($_POST[title]=="")
			$error .= "your title is empty<br />";
		if($_POST[date]=="")
			$error .= "your date is empty<br />";
		if($_POST[elm1]=="")
			$error .= "your message is empty";
		
		if($error=="") {	
			$news->setTitle(htmlspecialchars($_POST[title], ENT_QUOTES));
			$news->setDate(htmlspecialchars($_POST[date], ENT_QUOTES));
			$news->setMessage($_POST[elm1]);
			$succ = $news->update();

			echo "<p>The newsmessage is successfully updated</p>";
			echo "<p><a href=\"news.php\">overview</a> - <a href=\"newsadd.php\">add new message</a></p>";
		}
		else {
			echo "<div class=\"report\">";
			echo "<p>".$error."</p>";
			echo "</div>";
		}
	}
if(!isset($_POST[submit]) || $error!="" ) {
echo "<p><a href=\"news.php\">< back to news overview</a></p>";
?>
<form class="bodyform" method="post" action="" name="form">
	<fieldset>
	  <div>
		<label>title:</label>
		<input name="title" size="8" type="text" value="<?= $news->getTitle();  ?>" />
	  </div>
	  <div>
		<label>date:</label>
		<input name="date" size="8" type="text" value="<?= $news->getDate();  ?>" /> <a href="#"
   		 onClick="cal.select(document.forms['form'].date,'anchor','dd/MM/yyyy'); return false;"
   		 name="anchor" id="anchor">select</a>
	  </div>
	  <div>
		<label>message:</label>
	  </div>
	  <br />&nbsp;<br /><textarea id="elm1" name="elm1" ><?= $news->getMessage(); ?></textarea>
	  <input type="submit" name="submit" value="edit" class="submit" />
	  <input type="reset" value="reset" />
	</fieldset>
  </form>
  <p>* Use the "Toggle fullscreen mode" to insert large text.</p>
<?php
	}
} else  {
	echo "<p>News message is not found in the database.</p>";
	echo "<p><a href=\"news.php\">overview</a> - <a href=\"newsadd.php\">add new message</a></p>";
}
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
