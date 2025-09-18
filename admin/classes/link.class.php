<?php

class Link {

	var $country;
	var $organisation;
	var $mission;
	var $address;
	var $arrange;
	var $id;
	
	function save() {
		global $db;
		$sql = "INSERT INTO links (country, organisation, mission, address, arrange) VALUES (\"". $this->country ."\",\"". $this->organisation ."\",\"". $this->mission ."\",\"". $this->address ."\",\"". $this->arrange ."\")";
		$result = $db->query($sql);
		if (DB::isError($result)) {
    		die ($result->getMessage());
		}
		return true;
	}
	
	function update() {
		global $db;
		
		if($this->id!="") {
			$sql = "UPDATE  links SET country = \"". $this->country ."\" , organisation = \"". $this->organisation ."\" , mission = \"". $this->mission ."\", address = \"". $this->address ."\", arrange = \"". $this->arrange ."\" WHERE id=".$this->id."";
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
			$sql = "DELETE FROM links WHERE id=".$this->id."";
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
		
		$numrows = $db->getOne("SELECT count(*) FROM links WHERE id=".$this->id);
		
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
		$sql = "SELECT id, country, organisation, mission, address, arrange FROM links WHERE id=".$this->id;
		$row = $db->getRow($sql);
		if (DB::isError($row)) {
			die ($row->getMessage());
		}
		
		$this->setCountry($row[1]);
		$this->setOrganisation($row[2]);
		$this->setMission($row[3]);
		$this->setAddress($row[4]);
		$this->setArrange($row[5]);
		
		return true;
	}
	
	function setCountry($country) {
		$this->country = $country;
	}
	
	function getCountry() {
		return $this->country;
	}
	
	function setOrganisation($organisation) {
		$this->organisation = $organisation;
	}
	
	function getOrganisation() {
		return $this->organisation;
	}
	
	function setMission($mission) {
		$this->mission = $mission;
	}
	
	function getMission() {
		return $this->mission;
	}
	
	function setAddress($address) {
		$this->address = $address;
	}
	
	function getAddress() {
		return $this->address;
	}
	
	function setArrange($arrange) {
		$this->arrange = $arrange;
	}
	
	function getArrange() {
		return $this->arrange;
	}
	
	function setId($id) {
		$this->id = $id;
	}
	
	function getId() {
		return $this->id;
	}
	
	//statische methode
	function getAllLinks() {
		global $db;
	
		$sql = "SELECT id, country, organisation, mission, address, arrange FROM links ORDER BY arrange";
		$result = $db->query($sql);
		if (DB::isError($row)) {
			die ($result->getMessage());
		}
		
		$array = array();
		
		while($row = $result->fetchrow()) {
			$link = new Link;
			$link->setId($row[0]);
			$link->setCountry($row[1]);
			$link->setOrganisation($row[2]);
			$link->setMission($row[3]);
			$link->setAddress($row[4]);
			$link->setArrange($row[5]);
			$array[] = $link;
		}
		
		return $array;
	}
	
	//statische methode
	function getLinksRange($start, $limit) {
		global $db;
	
		$sql = "SELECT id, country, organisation, mission, address, arrange FROM links ORDER BY arrange LIMIT ".$start.",".$limit;
		$result = $db->query($sql);
		if (DB::isError($result)) {
			die ($result->getMessage());
		}
		
		$linkarray = array();
		
		while($row = $result->fetchrow()) {
			$link = new Link;
			$link->setId($row[0]);
			$link->setCountry($row[1]);
			$link->setOrganisation($row[2]);
			$link->setMission($row[3]);
			$link->setAddress($row[4]);
			$link->setArrange($row[5]);
			$linkarray[] = $link;
		}
		
		return $linkarray;
	}
	
	function moveUp() {
		global $db;
		
		if($this->arrange != $this->getMinArrange()) {
			$previousarrange = $this->getPreviousArrange($this->arrange);
			$previousid = $db->getOne("SELECT id FROM links WHERE arrange=".$previousarrange);
			$sql = "UPDATE links SET arrange = ". $this->arrange ." WHERE id=".$previousid."";
			$result = $db->query($sql);
			if (DB::isError($result)) {
				die ($result->getMessage());
			}
			$this->arrange = $previousarrange;
			$this->update();
			return true;
		}
		return false;

	}
	
	function moveDown() {
		global $db;
		
		if($this->arrange != $this->getMaxArrange()) {
			$nextarrange = $this->getNextArrange($this->arrange);
			$nextid = $db->getOne("SELECT id FROM links WHERE arrange=".$nextarrange);
			$sql = "UPDATE links SET arrange = ". $this->arrange ." WHERE id=".$nextid."";
			$result = $db->query($sql);
			if (DB::isError($result)) {
				die ($result->getMessage());
			}
			$this->arrange = $nextarrange;
			$this->update();
			return true;
		}
		return false;

	}
	
	//statische methode
	function getMaxArrange() {
		global $db;
		
		$maxarrange = $db->getOne("SELECT max(arrange) FROM links");
		
		return $maxarrange;
	}
	
	//statische methode
	function getMinArrange() {
		global $db;
		
		$minarrange = $db->getOne("SELECT min(arrange) FROM links");
		
		return $minarrange;
	}
	
	//statische methode
	function getIdFromArrange($arrange) {
		global $db;
		
		$minid = $db->getOne("SELECT id FROM links WHERE arrange = ".$arrange);
		
		return $minid;
	}
	
	//statische methode
	function getNextArrange($arrange) {
		global $db;
		
		$nextarrange = $db->getOne("SELECT min(arrange) FROM links WHERE arrange > ".$arrange." LIMIT 1");
		
		return $nextarrange;
	}
	
	//statische methode
	function getPreviousArrange($arrange) {
		global $db;
		
		$previousarrange = $db->getOne("SELECT max(arrange) FROM links WHERE arrange < ".$arrange." LIMIT 1");
		
		return $previousarrange;
	}
	
	
}
?>
