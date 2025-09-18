<?php

require_once('user.class.php');

class ConferenceUser extends User {

	var $surname;
	var $middlename;
	var $familyname;
	var $title;
	var $institution;
	var $address;
	var $phone;
	var $paid = false;
	var $paymentCode;
	
	
	function getSurname() {
		return $this->surname;
	}
	function setSurname($surname) {
		$this->surname = $surname;
	}
	function getMiddlename() {
		return $this->middlename;
	}
	function setMiddlename($middlename) {
		$this->middlename = $middlename;
	}
	function getFamilyname() {
		return $this->familyname;
	}
	function setFamilyname($familyname) {
		$this->familyname = $familyname;
	}
	function getTitle() {
		return $this->title;
	}
	function setTitle($title) {
		$this->title = $title;
	}
	function getInstitution() {
		return $this->institution;
	}
	function setInstitution($institution) {
		$this->institution = $institution;
	}
	function getAddress() {
		return $this->address;
	}
	function setAddress($address) {
		$this->address = $address;
	}
	function getPhone() {
		return $this->phone;
	}
	function setPhone($phone) {
		$this->phone = $phone;
	}
	function isPaid() {
		return $this->paid;
	}
	function setPaid($paid) {
		$this->paid = $paid;
	}
	function getPaymentCode() {
		return $this->paymentCode;
	}
	function setPaymentCode($paymentCode) {
		$this->paymentCode = $paymentCode;
	}
	
	function save() {
		global $db;
		
		$this->setPaymentCode(sha1(md5(microtime()*rand(1,10))));
		User::save();
		$this->update();
		
		return true;
	}
																														
	
	function update() {
		global $db;
		
		User::update();
		
		if($this->id!="") {
			$sql = "UPDATE  ". $this->usertable ." SET surname='".$this->surname."', middlename='".$this->middlename."', familyname='".$this->familyname."', title='".$this->title."', institution='".$this->institution."', address='".$this->address."', phone='".$this->phone."', paid='".$this->paid."', paymentcode='".$this->paymentCode."'  WHERE id=".$this->id."";
			$result = $db->query($sql);
			if (DB::isError($result)) {
				die ($result->getMessage());
			}
		}

	}
	
	function validPaymentCode() {
		global $db;
		
		$numrows = $db->getOne("SELECT count(*) FROM ". $this->usertable ." WHERE paymentcode=".$this->paymentCode);
		
		if($numrows==1)
			return true;
		else
			return false;
	}
	
	function initById($id,$usertable) {
		global $db;
		
		$ok = User::initById($id,$usertable);
		if(!ok)
			return false;
			
		$sql = "SELECT surname, middlename, familyname, title, institution, address, phone, paid, paymentcode FROM ".$this->usertable." WHERE id=".$this->id;
		$row = $db->getRow($sql);
		if (DB::isError($row)) {
			die ($row->getMessage());
		}
		
		$this->setSurname($row[0]);
		$this->setMiddlename($row[1]);
		$this->setFamilyname($row[2]);
		$this->setTitle($row[3]);
		$this->setInstitution($row[4]);
		$this->setAddress($row[5]);
		$this->setPhone($row[6]);
		$this->setPaid($row[7]);
		$this->setPaymentCode($row[8]);
		
		return true;
		
	}
	
	function initByCode($code,$usertable) {
		global $db;
		
		$ok = User::initByCode($code,$usertable);
		if(!ok)
			return false;
			
		$sql = "SELECT surname, middlename, familyname, title, institution, address, phone, paid, paymentcode FROM ".$this->usertable." WHERE code=".$this->code;
		$row = $db->getRow($sql);
		if (DB::isError($row)) {
			die ($row->getMessage());
		}
		
		$this->setSurname($row[0]);
		$this->setMiddlename($row[1]);
		$this->setFamilyname($row[2]);
		$this->setTitle($row[3]);
		$this->setInstitution($row[4]);
		$this->setAddress($row[5]);
		$this->setPhone($row[6]);
		$this->setPaid($row[7]);
		$this->setPaymentCode($row[8]);
		
		return true;
		
	}
	
	
	function initByPaymentCode($code,$usertable) {
		global $db;
		
		$this->setPaymentCode($code);
		$this->setUsertable($usertable);
		
		if($this->paymentCode==null || $this->validPaymentCode()==false)
			return false;
			
		$sql = "SELECT surname, middlename, familyname, title, institution, address, phone, paid, paymentcode, id FROM ".$this->usertable." WHERE paymentcode=".$this->paymentCode;
		$row = $db->getRow($sql);
		if (DB::isError($row)) {
			die ($row->getMessage());
		}
		
		$this->setSurname($row[0]);
		$this->setMiddlename($row[1]);
		$this->setFamilyname($row[2]);
		$this->setTitle($row[3]);
		$this->setInstitution($row[4]);
		$this->setAddress($row[5]);
		$this->setPhone($row[6]);
		$this->setPaid($row[7]);
		$this->setId($row[8]);
		
		return User::initById($this->id,$this->usertable);
		
	}
	
	//statische methode
	function setPaymentId($id, $usertable) {
		$user = new ConferenceUser();
		$ok = $user->initById($code,$usertable);
		if($ok) {
			$user->setPaid(true);
			return true;
		} else {
			return false;
		}
	}
	
	//statische methode
	function setPaymentCode($code, $usertable) {
		$user = new ConferenceUser();
		$ok = $user->initByPaymentCode($code,$usertable);
		if($ok) {
			$user->setPaid(true);
			return true;
		} else {
			return false;
		}
	}
	
}
