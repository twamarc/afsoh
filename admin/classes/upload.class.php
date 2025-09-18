<?php

/*
 De database tabel, $this->table, waar de bestandsnamen worden opgeslaan heeft deze vorm:
 CREATE TABLE `files` (
  `id` int(15) NOT NULL auto_increment,
  `folder` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
 ) TYPE=MyISAM AUTO_INCREMENT=5 ;
*/

class Upload {

	var $id;
	var $file;
	var $folder;
	var $filename;
	var $table;
	
	function Upload($file, $folder, $table) {
		$this->setFilename($file);
		$this->setFolder($folder);
		$this->setTable($table);
		$this->filename = $_FILES['file']['name']; 
		$this->filename = str_replace("%20", " ", $this->filename);
	}
	
	//als deze methode niet overschreven wordt in subklasse heeft deze altijd true terug
	function validType() {
			return true;
	}
	
	function doUpload() {
		global $db;
		
		if($this->table=="")
			return false;
			
		if($_FILES['file']['size']==0)
			return false;
		
		move_uploaded_file($_FILES['file']['tmp_name'],$this->folder.$this->filename)  or die ("Couldn't copy");
		$sql = "INSERT INTO ".$this->table." (name, folder) VALUES ('". $this->filename ."','". $this->folder ."')";
		$result = $db->query($sql);
		if (DB::isError($result)) {
    		die ($result->getMessage());
		}
		
		$this->id = $db->getOne("SELECT id FROM ". $this->table ." WHERE name = '". $this->filename ."' and folder = '". $this->folder ."'");
	}
	
	function getSize() {
		return $_FILES['file']['size'];
	}
	
	function isUploaded() {
		if($_FILES['file']['tmp_name']=="")
			return false;
		else
			return true;
	}
	
	function fileExists() {
		if(is_file($this->folder.$this->filename))
			return true;
		else
			return false;
	}
	
	function fileExistsFolder($folder) {
		if(is_file($folder.$this->filename))
			return true;
		else
			return false;
	}
	
	function validId() {
		global $db;
		
		if($this->table=="")
			return false;
		
		$numrows = $db->getOne("SELECT count(*) FROM ".$this->table." WHERE id=".$this->id);
		
		if($numrows==1)
			return true;
		else
			return false;
	}
	
	//lokale variabelen initaliseren
	function init($id,$table) {
		global $db;
		 
		$this->setId($id);
		$this->setTable($table);
		
		if($this->id=="" || $this->validId()==false || $this->table=="")
			return false;
		$sql = "SELECT id, name, folder FROM ".$this->table." WHERE id=".$this->id;
		$row = $db->getRow($sql);
		if (DB::isError($row)) {
			die ($row->getMessage());
		}
		
		$this->setFilename($row[1]);
		$this->setFolder($row[2]);
		
		return true;
	}
	
	function getId() {
		return $this->id;
	}
	
	function setId($id) {
		$this->id = $id;
	}

	
	function getFolder() {
		return $this->folder;
	}
	
	function setFolder($folder) {
		$this->folder = $folder;
	}
	
	function getTable() {
		return $this->table;
	}
	
	function setTable($table) {
		$this->table = $table;
	}
	
	function getFilename() {
		return $this->filename;
	}
	
	function setFilename($filename) {
		$this->filename = $filename;
	}
	
	function getExtension() {
		return ereg_replace('^.*\.(.*)$','\\1',$this->filename);
	}
	
	function delete() {
		return $this->deleteFile($this->filename,$this->folder,$this->table);
	}
	
	function deleteFolders($folders) {
		return $this->deleteFile($this->filename,$this->folder,$this->table,$folders);
	}
	
	//statische methode
	function getUploadRange($start, $limit, $table) {
		global $db;
	
		$sql = "SELECT id, name, folder FROM ".$table." ORDER BY name LIMIT ".$start.",".$limit;
		$result = $db->query($sql);
		if (DB::isError($result)) {
			die ($result->getMessage());
		}
		
		$uploadarray = array();
		
		while($row = $result->fetchrow()) {
			$upload = new Upload("","","");
			$upload->setId($row[0]);
			$upload->setFilename($row[1]);
			$upload->setFolder($row[2]);
			$uploadarray[] = $upload;
		}
		
		return $uploadarray;
	}
	
	//statische methode
	function getAllUploads($table) {
		global $db;
	
		$sql = "SELECT id, name, folder FROM ".$table." ORDER BY name";
		$result = $db->query($sql);
		if (DB::isError($result)) {
			die ($result->getMessage());
		}
		
		$uploadarray = array();
		
		while($row = $result->fetchrow()) {
			$upload = new Upload("","","");
			$upload->setId($row[0]);
			$upload->setFilename($row[1]);
			$upload->setFolder($row[2]);
			$uploadarray[] = $upload;
		}
		
		return $uploadarray;
	}
	
	//statische functie
	//$folders is een array met extra mappen waarin een kopie van de afbeelding staat (bv. thumbnail van de afbeelding)
	function deleteFile($filename, $folder, $table, $folders = null) {
		global $db;
		
		if($table=="") {
			return false;
		}
		
		$fileexists = false;
		foreach($folders as $subfolder) { //kijken of er een bestand in een van de mappen bestaat
			if(is_file($subfolder.$filename)) 
				$fileexists = true;
		}
		if(is_file($folder.$filename))
			$fileexists = true;
		
		if($fileexists) { //controleren of het bestand bestaat
			$inDatabase = $db->getOne("SELECT count(*) FROM ".$table." WHERE name = '". $filename ."' and folder = '". $folder ."'");
			if($inDatabase == 0) { //controleren of het bestand in de database zit
				return false;
				}
			@unlink($folder.$filename); //bestand verwijderen
			foreach($folders as $item) {	
				if($item != null && is_file($item.$filename)) //als er een kopie van het bestand bestaat, ook verwijderen
					@unlink($item.$filename);
			}
			$sql = "DELETE FROM ".$table." WHERE name = '". $filename ."' AND folder = '". $folder ."'";
			$result = $db->query($sql); //bestand verwijderen uit de database
			if (DB::isError($result)) {
    			die ($result->getMessage());
			}
			return true;
		} else {
			return false;
		}
		
	}

}

?>
