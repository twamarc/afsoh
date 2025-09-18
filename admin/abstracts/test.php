<?php
$text="hallo dit is een hele lange tekst vol met zever zodat het zeker langer zal zijn, in de toekomst, dan hondert karakters, spannend! Steven";
$messages = explode("<br />", nl2br(" ".$text));
	foreach($messages as $message) {
		echo "message: ".$message."<br />";
		$messagewords = explode(" ",$message);
		$i = 0;
		while($i<sizeof($messagewords)) {
			$messageline = $messagewords[$i];
			echo "9. ".$messageline." - ".$i."<br />";
			while($i<sizeof($messagewords) && strlen($messageline." ".$messagewords[($i+1)])<100) {
				$i++;
				$messageline .= " ".$messagewords[$i]; 
			}
			echo "14. ".$messageline." - ".$i."<br />";
			$i++;
		}
	}
?>