<?php

class Room
{
	public $_id;
	public $_type;
	public $_status;
	public $_password;
	public $_name;
	public $_description;
	public $_userCount;
	public $_userMax;
	public $_creatorId;
	
	public function __construct($type, $status, $password, $name, $description, $userCount, $userMax, $creatorId, $id = NULL){
			$this->_id = $id;
			$this->_type = $type;
			$this->_status = $status;
			$this->_password = $password;
			$this->_name = $name;
			$this->_description = $description;
			$this->_userCount = $userCount;
			$this->_userMax = $userMax;
			$this->_creatorId = $creatorId;
			return $this;
		}
		
	// treba jos dodati kako ubaciti ID od kreatora
	public function create(){
		$sql = "INSERT INTO room (type, status, password, name, description, userCount, userMax, creatorId) ".
		"VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		
		$stmt = DB::$db->prepare($sql);
		$stmt->bind_param("sssssiii", $this->_type, $this->_status, $this->_password,
						  $this->_name, $this->_description, $this->_userCount, $this->_userMax, $this->_creatorId);
						  
		$stmt->execute();
		return TRUE;	
	}
	
	public function edit(){
		
		$sql = "UPDATE room SET type=?,	status=?, password=?,
								name=?, description=?, userMax=?
							WHERE id = ?";

		$stmt = DB::$db->prepare($sql);
		$stmt->bind_param("ssssiii", $this->_type, $this->_status, $this->_password,
						  $this->_name, $this->_description, $this->_userMax, $this->_id);
		$stmt->execute();
		return TRUE;
	}
	
	public function delete(){
		$sql = "UPDATE room SET type=?,	status=?, password=?,
								name=?, description=?, userMax=?
							WHERE id = ?";
		
		$stmt = DB::$db->prepare($sql);
		
		$this->_status = "Inactive";
		
		$stmt->bind_param("sssssii", $this->_type, $this->_status, $this->_password,
						  $this->_name, $this->_description, $this->_userMax, $this->_id);
		$stmt->execute();
		return TRUE;
		
	}
	
}

?>
