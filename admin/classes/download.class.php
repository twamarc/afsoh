<?php

class Download {

	var $title;
	var $organized;
	var $limit;
	var $description;
	var $price;
	var $download_id;
	var $nature;
	var $id;
	
	function save() {
		global $db;
		$sql = "INSERT INTO downloads (title, organized, stocklimit, description, price, download_id, nature) VALUES (\"". $this->title ."\",\"". $this->organized ."\",\"". $this->limit ."\",\"". $this->description ."\",\"". $this->price ."\",\"". $this->download_id ."\",\"". $this->nature ."\")";
		$result = $db->query($sql);
		if (DB::isError($result)) {
    		die ($result->getMessage());
		}
		return true;
	}
	
	function update() {
		global $db;
		
		if($this->id!="") {
			$sql = "UPDATE downloads SET title = \"". $this->title ."\" , organized = \"". $this->organized ."\" , stocklimit = \"". $this->limit ."\" , description = \"". $this->description ."\" , price = \"". $this->price ."\" , download_id = \"". $this->download_id ."\" , nature = \"". $this->nature ."\" WHERE id=".$this->id."";
			$result = $db->query($sql);
			if (DB::isError($result)) {
				die ($result->getMessage());
			}
			return true;
		}
		return false;
	}
	
	function delete() {
		global $db;
		
		if($this->id!="") {
			$sql = "DELETE FROM downloads WHERE id=".$this->id."";
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
		
		$numrows = $db->getOne("SELECT count(*) FROM downloads WHERE id=".$this->id);
		
		if($numrows==1)
			return true;
		else
			return false;
	}
	
	function init($id) {
		global $db;
		 
		$this->setId($id);
		
		if($this->id==null || $this->validId()==false)
			return false;
		$sql = "SELECT id, title, organized, stocklimit, description, price, download_id, nature FROM downloads WHERE id=".$this->id;
		$row = $db->getRow($sql);
		if (DB::isError($row)) {
			die ($row->getMessage());
		}
		
		$this->setTitle($row[1]);
		$this->setOrganized($row[2]);
		$this->setLimit($row[3]);
		$this->setDescription($row[4]);
		$this->setPrice($row[5]);
		$this->setDownload_id($row[6]);
		$this->setNature($row[7]);
		
		return true;
	}

	
	function setTitle($title) {
		$this->title = $title;
	}
	
	function getTitle() {
		return $this->title;
	}
	
	function setOrganized($organized) {
		$this->organized = $organized;
	}
	
	function getOrganized() {
		return $this->organized;
	}
	
	function setLimit($limit) {
		$this->limit = $limit;
	}
	
	function getLimit() {
		return $this->limit;
	}
	
	function setDescription($description) {
		$this->description = $description;
	}
	
	function getDescription() {
		return $this->description;
	}
	
	function setPrice($price) {
		$this->price = $price;
	}
	
	function getPrice() {
		return $this->price;
	}
	
	function setDownload_id($download_id) {
		$this->download_id = $download_id;
	}
	
	function getDownload_id() {
		return $this->download_id;
	}
	
	function setNature($nature) {
		$this->nature = $nature;
	}
	
	function getNature() {
		return $this->nature;
	}
	
	function setId($id) {
		$this->id = $id;
	}
	
	function getId() {
		return $this->id;
	}
	
	//statische methode
	function getAllDownloads() {
		global $db;
	
		$sql = "SELECT id, title, organized, stocklimit, description, price, download_id, nature FROM downloads ORDER BY id";
		$result = $db->query($sql);
		if (DB::isError($row)) {
			die ($result->getMessage());
		}
		
		$array = array();
		
		while($row = $result->fetchrow()) {
			$download = new Download;
			$download->setId($row[0]);
			$download->setTitle($row[1]);
			$download->setOrganized($row[2]);
			$download->setLimit($row[3]);
			$download->setDescription($row[4]);
			$download->setPrice($row[5]);
			$download->setDownload_id($row[6]);
			$download->setNature($row[7]);
			
			$array[] = $download;
		}
		
		return $array;
	}
	
	//statische methode
	function getDownloadsRange($start, $limit) {
		global $db;
	
		$sql = "SELECT id, title, organized, stocklimit, description, price, download_id, nature FROM downloads ORDER BY id LIMIT ".$start.",".$limit;
		$result = $db->query($sql);
		if (DB::isError($result)) {
			die ($result->getMessage());
		}
		
		$array = array();
		
		while($row = $result->fetchrow()) {
			$download = new Download;
			$download->setId($row[0]);
			$download->setTitle($row[1]);
			$download->setOrganized($row[2]);
			$download->setLimit($row[3]);
			$download->setDescription($row[4]);
			$download->setPrice($row[5]);
			$download->setDownload_id($row[6]);
			$download->setNature($row[7]);
			
			$array[] = $download;
		}
		
		return $array;
	}
	
	
}
?>