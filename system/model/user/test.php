<?php
require_once (LIB_PATH.DS.'dbclass'.DS.'dbclass.php');
require_once (LIB_PATH.DS.'dbobject'.DS.'dbobject.php');
class Test extends dbObject{

    protected static $tName = "test_user";
	protected static $db_fields  = array('id', 'email', 'password', 'date');
   
    public $id;
	public $email;
	public $password;
	public $date;

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
}