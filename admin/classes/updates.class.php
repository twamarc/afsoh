<?php

class Updates {

	var $message;
	var $id = 1;
	
	function update() {
		global $db;
		
		if($this->id!="") {
			$sql = 'UPDATE updates SET message = \''. $this->message .'\' WHERE id='.$this->id.'';
			$result = $db->query($sql);
			if (DB::isError($result)) {
				die ($result->getMessage());
			}
			return true;
		}
		return false;
	}
	
	
	function validId() {
		global $db;
		
		$numrows = $db->getOne("SELECT count(*) FROM updates WHERE id=".$this->id);
		
		if($numrows==1)
			return true;
		else
			return false;
	}
	
	function init() {
		global $db;
		
		if($this->id==null || $this->validId()==false)
			return false;
		$sql = "SELECT id, message FROM updates WHERE id=".$this->id;
		$row = $db->getRow($sql);
		if (DB::isError($row)) {
			die ($row->getMessage());
		}
		
		$this->setMessage($row[1]);
		
		return true;
	}
	
	function setMessage($message) {
		$this->message = $message;
	}
	
	function getMessage() {
		return $this->message;
	}
	
	function setId($id) {
		$this->id = $id;
	}
	
	function getId() {
		return $this->id;
	}
	
	//statische methode
	//past het bericht aan zodat het goed wordt weergegeven op de website
	function transform($message) {
		$message = ereg_replace('alt="[ ]+"','alt=""',$message); //alt-tekst met enkel spaties in leegmaken
		$message = ereg_replace('<img( title="[^"]*" [^s]*)src="\.\./([^"]*)"([^>]*)>','<img\\1src="\\2"\\3>',$message); // "../" vooraan url van een afbeelding verwijderen
		$message = ereg_replace('<img( title="[^"]*" [^s]*)src="([^"]*)th/([^"]*)"([^>]*)>','<a href="\\2show/\\3"  rel="lightbox">\\0</a>',$message); // als je op thumb klikt zie je grote afbeelding
		$message = str_replace('jscripts/tiny_mce/plugins/emotions/img','admin/jscripts/tiny_mce/plugins/emotions/img',$message);///smilies goed laten weergeven
		
		return $message;
	}
}
?>
