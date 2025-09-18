<?php

class AbstractMessage {

	var $userid;
	var $name;
	var $type;
	var $title;
	var $message;
	var $approval = false;
	var $date;
	var $id;
	
	function setUserid($userid) {
		$this->userid = $userid;
	}
	
	function getUserid() {
		return $this->userid;
	}
	
	function setType($type) {
		$this->type = $type;
	}
	
	function getType() {
		return $this->type;
	}
	
	function setTitle($title) {
		$this->title = $title;
	}
	
	function getTitle() {
		return $this->title;
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
	
	function setDate($date) {
		$this->date = $date;
	}
	
	function getDate() {
		return $this->date;
	}
	
	function setName($name) {
		$this->name = $name;
	}
	
	function getName() {
		return $this->name;
	}
	
	function setApproval($approval) {
		$this->approval = $approval;
	}
	
	function getApproval() {
		return $this->approval;
	}
	
	function save() {
		global $db;
		
		$date = date("Y-m-d",time());

		$sql = "INSERT INTO abstracts (userid, name, type, title, message, approval, date) VALUES (\"". $this->userid ."\",\"". $this->name ."\",\"". $this->type ."\",\"". $this->title ."\",\"". $this->message ."\",\"". $this->approval ."\",\"". $date ."\")";
		$result = $db->query($sql);
		if (DB::isError($result)) {
    		die ($result->getMessage());
		}
		
		$this->id = $db->getOne("SELECT id FROM abstracts WHERE userid='".$this->userid."' and title='".$this->title."' and date='".$date."'");
		return true;
	}
	
	
	function update() {
		global $db;
		
		if($this->id!="") {
			$sql = "UPDATE abstracts SET userid = \"". $this->userid ."\", type = \"". $this->type ."\", title = \"". $this->title ."\", message = \"". $this->message ."\", name = \"". $this->name ."\", approval = \"". $this->approval ."\" WHERE id=".$this->id."";
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
		
		$numrows = $db->getOne("SELECT count(*) FROM abstracts WHERE id=".$this->id);
		
		if($numrows==1)
			return true;
		else
			return false;
	}
	
	
	
	
	function init() {
		global $db;
		
		if($this->id==null || $this->validId()==false)
			return false;
		$sql = "SELECT id, userid, type, title, message, DATE_FORMAT(date, '%d/%m/%Y'), name, approval FROM abstracts WHERE id=".$this->id;
		$row = $db->getRow($sql);
		if (DB::isError($row)) {
			die ($row->getMessage());
		}
		
		$this->setUserid($row[1]);
		$this->setType($row[2]);
		$this->setTitle($row[3]);
		$this->setMessage($row[4]);
		$this->setDate($row[5]);
		$this->setName($row[6]);
		$this->setApproval($row[7]);
		
		return true;
	}
	
	//statische methode
	function getAllAbstracts() {
		global $db;
	
		$sql = "SELECT id, userid, type, title, message, DATE_FORMAT(date, '%d/%m/%Y'), name, approval FROM abstracts ORDER BY id";
		$result = $db->query($sql);
		if (DB::isError($row)) {
			die ($result->getMessage());
		}
		
		$array = array();
		
		while($row = $result->fetchrow()) {
			$abstract = new AbstractMessage;
			$abstract->setId($row[0]);
			$abstract->setUserid($row[1]);
			$abstract->setType($row[2]);
			$abstract->setTitle($row[3]);
			$abstract->setMessage($row[4]);
			$abstract->setDate($row[5]);
			$abstract->setName($row[6]);
			$abstract->setApproval($row[7]);
			$array[] = $abstract;
		}
		
		return $array;
	}
	
	//statische methode
	function getApprovedAbstracts($approved) {
		global $db;
	
		$sql = "SELECT id, userid, type, title, message, DATE_FORMAT(date, '%d/%m/%Y'), name, approval FROM abstracts WHERE approval='".$approved."' ORDER BY id ASC";
		$result = $db->query($sql);
		if (DB::isError($row)) {
			die ($result->getMessage());
		}
		
		$array = array();
		
		while($row = $result->fetchrow()) {
			$abstract = new AbstractMessage;
			$abstract->setId($row[0]);
			$abstract->setUserid($row[1]);
			$abstract->setType($row[2]);
			$abstract->setTitle($row[3]);
			$abstract->setMessage($row[4]);
			$abstract->setDate($row[5]);
			$abstract->setName($row[6]);
			$abstract->setApproval($row[7]);
			$array[] = $abstract;
		}
		
		return $array;
	}
	
	//statische methode
	function getAbstractsRange($start, $limit) {
		global $db;
	
		$sql = "SELECT id, userid, type, title, message, DATE_FORMAT(date, '%d/%m/%Y'), name, approval FROM abstracts ORDER BY id DESC LIMIT ".$start.",".$limit;
		$result = $db->query($sql);
		if (DB::isError($result)) {
			die ($result->getMessage());
		}
		
		$array = array();
		
		while($row = $result->fetchrow()) {
			$abstract = new AbstractMessage;
			$abstract->setId($row[0]);
			$abstract->setUserid($row[1]);
			$abstract->setType($row[2]);
			$abstract->setTitle($row[3]);
			$abstract->setMessage($row[4]);
			$abstract->setDate($row[5]);
			$abstract->setName($row[6]);
			$abstract->setApproval($row[7]);
			$array[] = $abstract;
		}
		
		return $array;
	}
	
	//statische methode
	function getAbstractCount($userid) {
		global $db;
		
		$numrows = $db->getOne("SELECT count(*) FROM abstracts WHERE userid=".$userid);
		
		return $numrows;
	}
	
}
?>
