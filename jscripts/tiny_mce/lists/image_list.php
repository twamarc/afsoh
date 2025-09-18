<?php

Header("content-type: application/x-javascript");

require "../../../../includes/connect.inc.php";


echo "var tinyMCEImageList = new Array(";
	// Name, URL

$sql = "SELECT name, folder FROM images ORDER BY name";
$result = $db->query($sql);
if (DB::isError($result)) {
    die ($result->getMessage());
}
$image=""; //zodat laatste element in de tabel niet einigt met een ,
while($row = $result->fetchrow()) {	
	if($image!="")
		echo $image.",";
	$image = "[\"".$row[0]."\", \"".$row[1]."th/".$row[0]."\"]";
}
echo $image;

echo ");";

?>
