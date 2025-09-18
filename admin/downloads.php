<?php 
$page_name="downloads";//name of the page
$page_status=1; //who can visit this page; 0 = everyone who is logged in, 1 = only the admin
require "./includes/header.inc.php";
?>
<?php
require_once "./classes/download.class.php";
require_once "./classes/upload.class.php";

$uploadfolder = "../downloads/";
$dbfiles = "files";

if(isset($_GET[delete])) {
	echo "<div class=\"report\">";
	$error = "";
	if(isset($_GET[ok]) && $_GET[ok]=="ok") {
		$download = new Download;
		$download->init($_GET[delete]);
		if($download->getDownload_id()!=0) {
			$upload = new Upload("","","");
			$upload->init($download->getDownload_id(),$dbfiles);
			$folders = array();
			$folders[] = $upload->getFolder();
			$deletefile = $upload->deleteFolders($folders);
			if($deletefile == false) {
				$error = "ok";
				echo "<p>The download is not deleted.</p>";
			}
		}
		$deletedownload = $download->delete();
		
		
		if($deletedownload == false) {
			$error = "ok";
			echo "<p>The download is not deleted.</p>";
		}

		if($error=="") {
			echo "<p>The download is successfully deleted.</p>";
		}
	}
	else { 
		echo "<p>Are you sure you want to delete this download?</p>";
		echo "<p><a href=\"downloads.php\"><strong>No</strong></a> - <a href=\"downloads.php?delete=".$_GET[delete]."&ok=ok\"><strong>Yes</strong></a></p>";
	}
	echo "</div>";
}

echo "<p><a href=\"downloadadd.php\">add download</a></p>";
echo "<table> ";
echo "<tr class=\"tabelheader\">";
echo "<td colspan=\"2\">Downloads</td>";
echo "</tr>";
 
$downloads = Download::getAllDownloads();
foreach($downloads as $item) {	
	
		echo "<tr>\n";
		echo "<td>\n";
		echo "<a href=\"downloadedit.php?id=".$item->getId()."\" title=\"edit download\">".$item->getTitle()."</a>\n";
		echo "</td>\n";
		echo "<td class=\"right\">\n";
		echo "<a href=\"downloadedit.php?id=".$item->getId()."\" title=\"edit download\"><img src=\"../images/edit.png\" alt=\"edit download\" class=\"rightsmall\" /></a>";
		echo "<a href=\"downloads.php?delete=".$item->getId()."\" title=\"delete downloade\"><img src=\"../images/delete.png\" alt=\"delete download\" class=\"rightsmall\" /></a>";
		echo "</td>\n";
		echo "</tr>\n";
}
echo "</table>";

?>

<?php require "./includes/footer.inc.php"; ?>