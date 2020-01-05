<?php
require_once (LIB_PATH.DS.'dbclass'.DS.'dbclass.php');
class dbObject{
	protected static $tName;
	protected static $db_fields = array();
	public static function findAll() {
		return static::findBySql("SELECT * FROM ".static::$tName);

	}

	public static function findByDynamicFields($field_name="", $value="") {
		global $db;
		$str = "SELECT * FROM ".static::$tName." WHERE `{$field_name}`='".$db->SQLEscape($value)."' LIMIT 1";
		$rsArray = static::findBySql($str);
	
		return !empty($rsArray) ? array_shift($rsArray) : false;

	}

	public static function findByDynamicValues($address="", $vehicle="") {
		global $db;
		$str = "SELECT * FROM ".static::$tName." WHERE (`address` LIKE '".$db->SQLEscape($address."%")."' OR `local_government_area` LIKE '".$db->SQLEscape($address."%")."') AND `vehicle_type` LIKE '".$db->SQLEscape($vehicle."%")."'";
		$rsArray = static::findBySql($str);
	
		return !empty($rsArray) ? array_shift($rsArray) : false;

	}

	public static function findById($id=0) {
		global $db;
		$rsArray = static::findBySql("SELECT * FROM ".static::$tName." WHERE id=".$db->SQLEscape($id)." LIMIT 1");
		return !empty($rsArray) ? array_shift($rsArray) : false;

	}

	public static function findByIdAndBounty($id=0, $type="") {

		global $db;
		$rs = $db->query("SELECT * FROM ".static::$tName." WHERE owner=".$db->SQLEscape($id)." AND type='".$db->SQLEscape($type)."'");
		$objArray = array();
		while ($row = $db->fetchQuery($rs)){
			$objArray[] = static::instantiate($row);
		}
		return $objArray;

	}

	public static function findByUserIdAndId($id=0, $userid=0) {
		global $db;
		$rsArray = static::findBySql("SELECT * FROM ".static::$tName." WHERE id=".$db->SQLEscape($id)." AND debioUserID=".$userid." LIMIT 1");
		return !empty($rsArray) ? array_shift($rsArray) : false;

	}

	public static function findBySql($sql="") {
		global $db;
		$rs = $db->query($sql);
		$objArray = array();
		while ($row = $db->fetchQuery($rs)){
			$objArray[] = static::instantiate($row);
		}
		return $objArray;
	}

	public static function count_all(){
		global $db;
		$sql = " SELECT COUNT(*) FROM ".static::$tName;
		$rs = $db->query($sql);
		$row = $db->fetchQuery($rs);
		return array_shift($row);
	}

	public static function dynamic_check ($col_name1= "", $obj_name1=""){
		global $db;
		$col_name = $db->SQLEscape($col_name1);
		$obj_name = $db->SQLEscape($obj_name1);

		
		$sql  = "SELECT id FROM ".static::$tName;
		$sql .= " WHERE `{$col_name1}` ='{$obj_name1}' ";
		$sql .= "LIMIT 1";
		$result = $db->query($sql);
		if ($db->numRows($result) > 0){
			return true;
		}else {
			return false;
		}
	}


	public static function get_driver_img ($user_id=0){
		global $db;
		//  $user_id = $db->SQLEscape($user_id);

		$rsArray = static::findBySql("SELECT `img1`, `img2`, `img3`, `img4`, `img5` FROM ".static::$tName." WHERE id=".$db->SQLEscape($user_id)." LIMIT 1");
			return !empty($rsArray) ? array_shift($rsArray) : false;



	
		// $sql  = "SELECT `img1`, `img2`, `img3`, `img4`, `img5` FROM ".static::$tName;
		//  $sql .= "WHERE `id`='{$user_id}' ";
		//  $sql .= "LIMIT 1";
		//  $result = $db->query($sql);
		//  $main_result = $db->fetchAll($result);

		// return $main_result;
	}


	public static function count_all_by_query($sql){
		global $db;

		$rs = $db->query($sql);
		$row = $db->fetchQuery($rs);
		return array_shift($row);
	}

	public static function count_sent_thirty_days($id){
		global $db;
		$sql = " SELECT COUNT(*) FROM ".static::$tName;
		$sql .= " WHERE debioSentDate > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
		$sql .=" AND debioUserID=".$db->SQLEscape($id);
		$rs = $db->query($sql);
		$row = $db->fetchQuery($rs);
		return array_shift($row);
	}

	public static function count_all_by_id($id){
		$id = $id;
		global $db;
		$sql =" SELECT COUNT(*) FROM ".static::$tName;
		$sql .=" WHERE owner_id =".$db->SQLEscape($id);
		$sql .= " AND hide = 0 ";
		$rs = $db->query($sql);
		$row = $db->fetchQuery($rs);
		return array_shift($row);
	}

	public static function count_all_by_id_orders($id){
		$id = $id;
		global $db;
		$sql =" SELECT DISTINCT `order_id` FROM ".static::$tName;
		$sql .=" WHERE buyer_id =".$db->SQLEscape($id);

		$rs = $db->query($sql);
		$row = $db->numRows($rs);
		return $row;
	}

	public static function count_all_by_id_pending($id){
		$id = $id;
		global $db;
		$sql =" SELECT COUNT(*) FROM ".static::$tName;
		$sql .=" WHERE owner_id =".$db->SQLEscape($id);
		$sql .= " AND hide = 0 AND authorize = 0";
		$rs = $db->query($sql);
		$row = $db->fetchQuery($rs);
		return array_shift($row);
	}

	public static function count_all_by_id_active($id){
		$id = $id;
		global $db;
		$sql =" SELECT COUNT(*) FROM ".static::$tName;
		$sql .=" WHERE owner_id =".$db->SQLEscape($id);
		$sql .= " AND hide = 0 AND authorize = 1";
		$rs = $db->query($sql);
		$row = $db->fetchQuery($rs);
		return array_shift($row);
	}

	public static function instantiate($record){
		$calledClass = get_called_class();
		$obj = new $calledClass;
		foreach ($record as $attr => $value) {
			if ($obj->hasAttr($attr)) {
				$obj->$attr = $value;
			}
		}

		return $obj;
	}

	private function hasAttr($attr) {

		return array_key_exists($attr, $this->attributes());
	}

	protected function attributes() {
		// return an array of attribute names and their values
		$attributes = array();
		foreach(static::$db_fields as $field) {
			if(property_exists($this, $field)) {
				$attributes[$field] = $this->$field;
			}
		}
		return $attributes;
	}

	protected function sanitized_attributes() {
		global $db;
		$clean_attributes = array();
		// sanitize the values before submitting
		// Note: does not alter the actual value of each attribute
		foreach($this->attributes() as $key => $value){
			if($value != ""){
				$clean_attributes[$key] = $db->SQLEscape($value);
			}
		}
		return $clean_attributes;
	}

	public function save() {
		// A new record won't have an debioUserID yet.
		return isset($this->id) ? $this->update() : $this->create();
	}

	public function create() {
		global $db;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		//print_r($attributes);
		$sql = "INSERT INTO ".static::$tName." (id,";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES (null,'";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		//echo $sql;
		if($db->query($sql)) {
			$this->id = $db->lastInsertedId();
			return true;
		} else {
			return false;
		}
			

	}

	public function update() {
		global $db;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".static::$tName." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $db->SQLEscape($this->id);
		$db->query($sql);
		return ($db->affectedRows() == 1) ? true : false;
	}

	public function delete() {
		global $db;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
		$sql = "DELETE FROM ".static::$tName;
		$sql .= " WHERE id=". $db->SQLEscape($this->id);
		$sql .= " LIMIT 1";
		$db->query($sql);
		return ($db->affectedRows() == 1) ? true : false;

		// NB: After deleting, the instance of User still
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update()
		// after calling $user->delete().
	}

}
