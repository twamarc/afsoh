<?php 
$page_title = "Download"; //title of page
$page_name="support"; //name of active menu button
$page_status=0; //who can visit this page; 0 = everyone, 1 = members
require "./includes/header.inc.php";
?>
<?php
require_once ("./admin/classes/download.class.php");
require_once ("./admin/classes/upload.class.php");

$dbfile = "files";

?>
<h3>Download file</h3>
<p>Thank you for the payment!</p>
<?php
if(isset($_GET[invoice])) {
	$did = substr(strstr($_GET[invoice],"-"),1);
	if($did != "" && is_numeric($did)) {
		$download = new Download();
		$init = $download->init($did);
		if($init) {
			if($download->getDownload_id()!=0) {
				$upload = new Upload("","","");
				$uploaded = $upload->init($download->getDownload_id(),$dbfile);
				echo "<p><a href=\"".$upload->getFolder().$upload->getFilename()."\" target=\"_blank\">dowload file</a></p>\n";
			} else {
				echo "<p>We will send your order soon.</p>";
				mail("twamarc@gmail.com", "New order", "Dear Marc,
				
You have received a payment for this item:
$download->getTitle()

Regards
", "From: PASH,Inc.<no-reply@pash-onweb.org>\nReturn-path: no-reply@pash-onweb.org");
			}
		}
	}
}
?>
<div class="top"><a href="#top">top</a></div>


<?php require "./includes/footer.inc.php" ?>