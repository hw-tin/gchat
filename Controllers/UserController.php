<?php
require_once "DAL/db.php";
require_once "DAL/dbInfo.php";
require_once "Models/User.php";
require_once "Models/UserRole.php";
require_once "Factory/UserRoleFactory.php";
require_once "Models/Token.php";
require_once "Factory/UserFactory.php";
require_once "Controllers/RoleController.php";
require_once "Helpers/validate.php";
require_once "Factory/TokenFactory.php";

class UserController{		
	
	private $_params;
	
	public function __construct($params){
		$this->_params = $params;
	}
	
	public function register(){
		extract($this->_params);
		if(!($this->checkExist()===false)){
			return "Username is taken. <br>";
		}
		
		$validator = new validate();
		$result = $validator->registerForm($this->_params);
		
		if (!($result===TRUE)) return $result;
		
		$user = new User($username, $password, $firstName, $lastName, $email, $birthday);
		$sucess = $user->create();
		if($sucess){
			return "Registracija Uspjesna";
		}
		return false;
	}
	
	public function login(){
		
		if (!(isset($this->_params["username"]) && isset($this->_params["password"]))){
			return "You have not entered a username/password. <br>";
		}
		
		$user = $this->checkExist();
		
		if($user === false) return "User does not exist. <br>";
		
		if($user->_password != $this->_params["password"]){
			return "Invalid password <br>";
		}
		
		// Token creation for a logged in user
		$token = TokenFactory::build($user->_id);
		$token->create();
		
		return $token->_value;
	}
	
	public function logout(){
		
		$token = TokenFactory::getByValue($this->_params["token"]);
		
		$result = $token->delete();
		
		return $result;
	}
	
	
	public function edit(){
		$user = UserFactory::getById($this->_params["id"]);
		// uredba polja
		if ($this->_params["usernamme"]) {
			 $user->_username = $this->_params["username"];
		 }
		$user->edit();
		return $user;
	}
	
	public function checkExist(){		
		if(!isset($this->_params["id"])){
		$user = UserFactory::getByUsername($this->_params["username"]);
		return $user;
		}
		$user = UserFactory::getById($this->_params["id"]);
		return $user;
	}
	

//-------------------------------Roles section down bellow----------------------------------------
//napraviti provjeru da se nemoze dodati dupli zapis za istog usera i rolu

	public function addRole(){
		
		
		$user = $this->checkExist();
		if($user === false){
			return "User doesn't exist <br>";
		}
		
		$RC = new RoleController(array("id"=>$this->_params["roleId"], "name"=>$this->_params["roleName"]));
		$role = $RC->checkExist();
		if($role === false){
			return "Role doesn't exist <br>";
		}
		
		if(isset($this->_params["roomId"])){
			$RP = new UserRole($user->_id, $role->_id, $this->_params["roomId"]);
		} else {
			$RP = new UserRole($user->_id, $role->_id);
		}
		
		$check = $RP->findInDB();
		
		if($check != false){
			return("This user already has this role. <br>");
		}
		
		$RP->create();
		return true;
	}
	
}
?>
