<?php

class Payment {

	var $userid;
	var $type; //member, nonmember, student
	var $method = ""; //paypal, credit card...
	var $date;
	var $id;
	var $message;
	var $semi_preco = false;
	var $post_sem_day1 = false;
	var $post_sem_day2 = false;
	var $ifha_preco = false;
	var $ifha_day1 = false;
	var $ifha_day2 = false;
	var $rece_preco = false;
	var $rece_day1 = false;
	var $rece_day2 = false;
	var $gala_preco = false;
	var $gala_day1 = false;
	var $gala_day2 = false;
	var $close_preco = false;
	var $close_day1 = false;
	var $close_day2 = false;
	var $hotel_preco = false;
	var $hotel_day1 = false;
	var $hotel_day2 = false;
	
	function setUserid($userid) {
		$this->userid = $userid;
	}
	
	function getUserid() {
		return $this->user;
	}
	
	function setType($type) {
		$this->type = $type;
	}
	
	function getType() {
		return $this->type;
	}
	
	function setMethod($method) {
		$this->method = $method;
	}
	
	function getMethod() {
		return $this->method;
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
	
	
	function save() {
		global $db;
		
		$date = date("Y-m-d",time());

		$sql = "INSERT INTO payment (userid, type, message, date, method, sem_preco, post_sem_day1, post_sem_day2, ifha_preco, ifha_day1, ifha_day2, rece_preco, rece_day1, rece_day2, gala_preco, gala_day1, gala_day2, close_preco, close_day1, close_day2, hotel_preco, hotel_day1, hotel_day2) VALUES (\"". $this->userid ."\",\"". $this->type ."\",\"". $this->message ."\",\"". $date ."\",\"". $this->method ."\",\"". $this->sem_preco ."\",\"". $this->post_sem_day1 ."\",\"". $this->post_sem_day2 ."\",\"". $this->ifha_preco ."\",\"". $this->ifha_day1 ."\",\"". $this->ifha_day2 ."\",\"". $this->rece_preco ."\",\"". $this->rece_day1 ."\",\"". $this->rece_day2 ."\",\"". $this->gala_preco ."\",\"". $this->gala_day1 ."\",\"". $this->gala_day2 ."\",\"". $this->close_preco ."\",\"". $this->close_day1 ."\",\"". $this->close_day2 ."\",\"". $this->hotel_preco ."\",\"". $this->hotel_day1 ."\",\"". $this->hotel_day2 ."\")";
		$result = $db->query($sql);
		if (DB::isError($result)) {
    		die ($result->getMessage());
		}
		
		$this->id = $db->getOne("SELECT id FROM payment WHERE userid='".$this->userid."' and date='".$date."'");
		return true;
	}
	
	
	function update() {
		global $db;
		
		if($this->id!="") {
			$sql = "UPDATE payment SET userid = \"". $this->userid ."\", type = \"". $this->type ."\", message = \"". $this->message ."\", method = \"". $this->method ."\", sem_preco = \"". $this->sem_preco ."\", post_sem_day1 = \"". $this->post_sem_day1 ."\", post_sem_day2 = \"". $this->post_sem_day2 ."\", ifha_preco = \"". $this->ifha_preco ."\", ifha_day1 = \"". $this->ifha_day1 ."\", ifha_day2 = \"". $this->ifha_day2 ."\", rece_preco = \"". $this->rece_preco ."\", rece_day1 = \"". $this->rece_day1 ."\", rece_day2 = \"". $this->rece_day2 ."\", gala_preco = \"". $this->gala_preco ."\", gala_day1 = \"". $this->gala_day1 ."\", gala_day2 = \"". $this->gala_day2 ."\", close_preco = \"". $this->close_preco ."\", close_day1 = \"". $this->close_day1 ."\", close_day2 = \"". $this->close_day2 ."\", hotel_preco = \"". $this->hotel_preco ."\", hotel_day1 = \"". $this->hotel_day1 ."\", hotel_day2 = \"". $this->hotel_day2 ."\" WHERE id=".$this->id."";
			$result = $db->query($sql);
			if (DB::isError($result)) {
				die ($result->getMessage());
			}
			return true;
		}
		return false;
	}
	
	
	function validUserId() {
		global $db;
		
		$numrows = $db->getOne("SELECT count(*) FROM payment WHERE userid=".$this->userid);
		
		if($numrows==1)
			return true;
		else
			return false;
	}
	
	
	function initByUserid() {
		global $db;
		
		if($this->userid==null || $this->validUserId()==false)
			return false;
		$sql = "SELECT id, userid, type,  message, DATE_FORMAT(date, '%d/%m/%Y'), method, sem_preco, post_sem_day1, post_sem_day2, ifha_preco, ifha_day1, ifha_day2, rece_preco, rece_day1, rece_day2, gala_preco, gala_day1, gala_day2, close_preco, close_day1, close_day2, hotel_preco, hotel_day1, hotel_day2 FROM payment WHERE userid=".$this->userid;
		$row = $db->getRow($sql);
		if (DB::isError($row)) {
			die ($row->getMessage());
		}
		
		$this->setId($row[0]);
		$this->setUserid($row[1]);
		$this->setType($row[2]);
		$this->setMessage($row[3]);
		$this->setDate($row[4]);
		$this->setMethod($row[5]);
		$this->sem_preco = $row[6];
		$this->post_sem_day1 = $row[7];
		$this->post_sem_day2 = $row[8];
		$this->ifha_preco = $row[9];
		$this->ifha_day1 = $row[10];
		$this->ifha_day2 = $row[11];
		$this->rece_preco = $row[12];
		$this->rece_day1 = $row[13];
		$this->rece_day2 = $row[14];
		$this->gala_preco = $row[15];
		$this->gala_day1 = $row[16];
		$this->gala_day2 = $row[17];
		$this->close_preco = $row[18];
		$this->close_day1 = $row[19];
		$this->close_day2 = $row[20];
		$this->hotel_preco = $row[21];
		$this->hotel_day1 = $row[22];
		$this->hotel_day2 = $row[23];
		
		return true;
	}
	
	function useridExists($userid) {
		global $db;
		
		$numrows = $db->getOne("SELECT count(*) FROM payment WHERE userid=".$userid);
		
		if($numrows==1)
			return true;
		else
			return false;
	}

}
?>