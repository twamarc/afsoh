<?php 
$page_name="news"; //name of the page
$page_status=0; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<h3>Add news</h3>
<?php
require_once "./classes/news.class.php";

$error = "";
$news = new News;
if(isset($_POST[submit])) {
	if($_POST[title]=="")
		$error .= "your title is empty<br />";
	if($_POST[date]=="")
		$error .= "your date is empty<br />";
	if($_POST[elm1]=="")
		$error .= "your message is empty";
	
	if($error=="") {	
		$news->setTitle(htmlspecialchars($_POST[title], ENT_QUOTES));
		$news->setDate($_POST[date]);
		$news->setMessage($_POST[elm1]);
		$news->save();
		
		echo "<p>The newsmessage is successfully added.</p>";
		echo "<p><a href=\"news.php\">overview</a> - <a href=\"newsadd.php\">add new message</a></p>";
	}
	else {
		echo "<div class=\"report\">";
		echo "<p>".$error."</p>";
		echo "</div>";
	}
	
} 
if(!isset($_POST[submit]) || $error!="") {
echo "<p><a href=\"news.php\">< back to news overview</a></p>";
?>
<form class="bodyform" method="post" action="" name="form">
	<fieldset>
	  <div>
		<label>title:</label>
		<input name="title" size="8" type="text" value="<?= htmlspecialchars($_POST[title], ENT_QUOTES);  ?>" />
	  </div>
	  <div>
		<label>date:</label>
		<input name="date" size="8" type="text" value="<?= date("d/m/Y",time());  ?>" /> <a href="#"
   		 onClick="cal.select(document.forms['form'].date,'anchor','dd/MM/yyyy'); return false;"
   		 name="anchor" id="anchor">select</a>
	  </div>
	  <div>
		<label>message:</label>
	  </div>
	  	<br />&nbsp;<br /><textarea id="elm1" name="elm1" ><?= str_replace('\\"','"',$_POST[elm1]); ?></textarea>
	  <input type="submit" name="submit" value="add" class="submit" />
	  <input type="reset" value="reset" />
	</fieldset>
  </form>
  <p>* Use the "Toggle fullscreen mode" to insert large text.</p>
<?php
}
?>
<div class="top"><a href="#top">top</a></div>
<?php require "./includes/footer.inc.php" ?>
