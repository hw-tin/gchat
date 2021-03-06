<?php
require_once "Models/Role.php";
require_once "DAL/db.php";
require_once "DAL/dbInfo.php";


class UserRole
{
	private $_id;
	private $_userId;
	private $_roleId;
	private $_dateAssigned;
	private $_roomId;
	
	public function __construct($userId, $roleId, $dateAssigned = NULL, $id = NULL, $roomId = NULL){
		$this->_id = $id;
		$this->_userId = $userId;
		$this->_roleId = $roleId;
		$this->_dateAssigned = $dateAssigned;
		$this->_roomId = $roomId;
		return $this;
	}
	
	public function create(){
		$sql = "INSERT INTO userRole (userId, roleId, dateAssigned, roomId) ".
		"VALUES (?, ?, ?, ?)";
		
		$stmt = DB::$db->prepare($sql);
		$this->_dateAssigned = date('Y-m-d G:i:s');
		$stmt->bind_param("iisi", $this->_userId ,$this->_roleId ,$this->_dateAssigned ,$this->_roomId);
		$stmt->execute();
		return TRUE;	
	}
	//samo je create napravljen ostatak provjerit radi li kako treba i editovat
	public function edit(){
		
		$sql = "UPDATE userrole SET userId=?, roleId=?, dateAssigned=?, roomId=?
								WHERE id = ?";

		$stmt = DB::$db->prepare($sql);
		$stmt->bind_param("iisii",$this->_userId, $this->_roleId, $this->_dateAssigned, $this->_roomId, $this->_id);
		$stmt->execute();
		return TRUE;
	}
	
	public function delete(){
		$sql = "DELETE FROM userrole WHERE id = ?";
		
		$stmt = DB::$db->prepare($sql);
		
		$stmt->bind_param("i", $this->_id);
		
		$stmt->execute();
		return TRUE;
		
	}
	
	public function findInDB(){
		
		$sql = "SELECT * FROM userRole WHERE userId = ? AND roleId = ?";

		$stmt = DB::$db->prepare($sql);
		
		$stmt->bind_param("ii", $this->_userId, $this->_roleId);
		
		$result = $stmt->execute();
		$result = $stmt->get_result();
		
		if($result->num_rows == 0) return false;
		
		$obj = $result->fetch_object();
		
		
		$this->_id = $obj->id;
		return $this;
	}
	
}

?>
