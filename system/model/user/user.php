<?php
require_once (LIB_PATH.DS.'dbclass'.DS.'dbclass.php');
require_once (LIB_PATH.DS.'dbobject'.DS.'dbobject.php');
class Signup extends dbObject{
	protected static $tName = "user_reg";
	protected static $db_fields  = array('id', 'user_name', 'email', 'password', 'email_auth_code', 
	 'status', 'create_at', 'update_at' );
	public $id;
	public $user_name;
	public $email;
	public $password;
	public $email_auth_code;
	public $status;
	public $create_at;
	public $update_at;





	public static function authenticate($email="", $password="") {
		global $db;
		$email = $db->SQLEscape($email);
		$password = $db->SQLEscape($password);

		$sql  = "SELECT * FROM  ".static::$tName;
		$sql .= " WHERE email ='{$email}' ";
		$sql .= "AND password ='".sha1($password)."' ";
		$sql .= "LIMIT 1";
		$rsArray = static::findBySql($sql);
		return !empty($rsArray) ? array_shift($rsArray) : false;
	}

	public static function authenticateadmin($email="", $password="") {
		global $db;
		$email = $db->SQLEscape($email);
		$password = $db->SQLEscape($password);
		$type = "admin";

		$sql  = "SELECT * FROM  ".static::$tName;
		$sql .= " WHERE email ='{$email}' ";
		$sql .= "AND password ='".sha1($password)."' ";
		$sql .= "AND type ='{$type}' ";
		$sql .= "LIMIT 1";
		$rsArray = static::findBySql($sql);
		return !empty($rsArray) ? array_shift($rsArray) : false;
	}

	public static function activate($email="", $code="") {
		global $db;
		$email = $db->SQLEscape($email);
		$code = $db->SQLEscape($code);

		$sql  = "SELECT * FROM  ".static::$tName;
		$sql .= " WHERE email ='{$email}' ";
		$sql .= "AND email_auth_code ='{$code}' ";
		$sql .= "LIMIT 1";
		$rsArray = static::findBySql($sql);
		return !empty($rsArray) ? array_shift($rsArray) : false;
	}



}
