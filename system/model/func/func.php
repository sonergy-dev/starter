<?php
require_once (LIB_PATH.DS.'dbclass'.DS.'dbclass.php');

date_default_timezone_set('Africa/Lagos');
$currtime2 = time();
$currtime = date('Y-m-d H:i:s', $currtime2);
//Use to redirect user to a specified location.

 function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

function countK($value='')
{
$views=$value;
 if($views > 1000)
 {$views_count=$views *1/1000;
 $views_k=round($views_count,PHP_ROUND_HALF_UP);
 return $views_k;}
else{return $views;}
}

function generate_token_with_time($var = null)
{
	$payload = [
        'iat' => time(),
        'iss' => 'api.drivershood.com',
        'exp' => time() + (6000),
        'hash_map'  => my_encrypt($var."-".time(), SECRETE_KEY)
      ];

      return $token = JWT::encode($payload, SECRETE_KEY);
}


function random_strings($length_of_string) {
  return substr(bin2hex(random_bytes($length_of_string)),
                                      0, $length_of_string);}


function ShowDate($timestamp)
{
	$stf = 0;
	$cur_time = time();
	$diff = $cur_time - $timestamp;
	$phrase = array('second','minute','hour','day','week','month','year','decade');
	$length = array(1,60,3600,86400,604800,2630880,31570560,315705600);
	for($i =sizeof($length)-1; ($i >=0)&&(($no =  $diff/$length[$i])<=1); $i--); if($i < 0) $i=0; $_time = $cur_time  -($diff%$length[$i]);
	$no = floor($no); if($no <> 1) $phrase[$i] .='s'; $value=sprintf("%d %s ",$no,$phrase[$i]);
	if(($stf == 1)&&($i >= 1)&&(($cur_time-$_time) > 0)) $value .= time_ago($_time);
	return $value.' ago ';
}


function ShowDateSingle($timestamp)
{
	$stf = 0;
	$cur_time = time();
	$diff = $cur_time - $timestamp;
	$phrase = array('s','m','h','d','w','m','y','d');
	$length = array(1,60,3600,86400,604800,2630880,31570560,315705600);
	for($i =sizeof($length)-1; ($i >=0)&&(($no =  $diff/$length[$i])<=1); $i--); if($i < 0) $i=0; $_time = $cur_time  -($diff%$length[$i]);
	$no = floor($no); if($no <> 1) $phrase[$i]; $value=sprintf("%d %s",$no,$phrase[$i]);
	if(($stf == 1)&&($i >= 1)&&(($cur_time-$_time) > 0)) $value .=time_ago($_time);
	return  str_replace(" ", "", $value);
}

function compress_image($source_url, $destination_url, $quality) {

       $info = getimagesize($source_url);

        if ($info['mime'] == 'image/jpeg')
              $image = imagecreatefromjpeg($source_url);

        elseif ($info['mime'] == 'image/gif')
              $image = imagecreatefromgif($source_url);

      elseif ($info['mime'] == 'image/png')
              $image = imagecreatefrompng($source_url);

        imagejpeg($image, $destination_url, $quality);
    return $destination_url;
    }

// Naira format
 function niajaFormat($r){
 	return "&#x20a6;".$r;
 }
// Strips out HTML, javascript and style tags, and Strip multi-line comments,
 function debioCleanInput($input) {
	$search = array(
			'@<script[^>]*?>.*?</script>@si', // Strip out javascript
			'@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
			'@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
			'@<![\s\S]*?--[ \t\n\r]*>@', // Strip multi-line comments
	);
	$output = preg_replace($search, '', $input);
	return $output;
}

 function debioCleanInput2($input) {
	$search = array(
			'@’@si', // Strip out javascript
			'@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
			'@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
			'@<![\s\S]*?--[ \t\n\r]*>@', // Strip multi-line comments
	);
	$output = preg_replace($search, '', $input);
	return $output;
}

function clean_html($value='')
{
	$search = array(

	 '@<script[^>]*?>.*?</script>@si', // Strip out javascript
	 '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
	 '@<![\s\S]*?--[ \t\n\r]*>@', // Strip multi-line comments
	 '/<div>(.*?)<\/div>/',
	 '/<br>(.*?)/',
	);

	$output = preg_replace($search, '$1', $value);
	return $output;

}
function debioCleanInput21($input) {
 $search = array(

	'@<script[^>]*?>.*?</script>@si', // Strip out javascript
 	'@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
 	'@<![\s\S]*?--[ \t\n\r]*>@', // Strip multi-line comments
 );
 $output = preg_replace($search, '', $input);
 return $output;
}

//Includes specified template name

function getTemplateByName($tName=""){

	require_once(SITE_ROOT.DS.'new'.DS.'layout'.DS.$tName);

}

 function check_if_obj_exits($colname="", $objname=""){
	global $db;
	$colname = $db->SQLEscape($colname);
	$objname = $db->SQLEscape($objname);

	$sql  = "SELECT id FROM user";
	$sql .= " WHERE {$colname} ='{$objname}' ";
	$sql .= "LIMIT 1";
	$result = $db->query($sql);
	if ($db->numRows($result) > 0){
		return true;
	}else {
		return false;
	}

}

	function check_if_obj_exits_table($table="", $colname="", $objname=""){
 	global $db;
 	$colname = $db->SQLEscape($colname);
 	$objname = $db->SQLEscape($objname);

 	$sql  = "SELECT id FROM {$table}";
 	$sql .= " WHERE {$colname} ='{$objname}' ";
 	$sql .= "LIMIT 1";
 	$result = $db->query($sql);
 	if ($db->numRows($result) > 0){
 		return true;
 	}else {
 		return false;
 	}

 }

 function check_if_obj_exits_table2($table="", $colname="", $objname="", $colname2="", $objname2=""){
 global $db;
 $colname = $db->SQLEscape($colname);
 $objname = $db->SQLEscape($objname);
 $objname2 = $db->SQLEscape($objname2);
 $colname2 = $db->SQLEscape($colname2);

 $sql  = "SELECT id FROM {$table}";
 $sql .= " WHERE {$colname} ='{$objname}' ";
 $sql .= " AND {$colname2} ='".sha1($objname2)."' ";
 $sql .= " AND status =1 ";
 $sql .= "LIMIT 1";
 $result = $db->query($sql);
 if ($db->numRows($result) > 0){
 	return true;
 }else {
 	return false;
 }

 }



 function delete_by_user($table="", $colname="", $objname="", $colname2="", $objname2=""){
 global $db;
 $colname = $db->SQLEscape($colname);
 $objname = $db->SQLEscape($objname);
 $objname2 = $db->SQLEscape($objname2);
 $colname2 = $db->SQLEscape($colname2);

 $sql  = "DELETE FROM {$table}";
 $sql .= " WHERE {$colname} ='{$objname}' ";
 $sql .= " AND {$colname2} ='{$objname2}' ";
 $sql .= "LIMIT 1";

 if ($db->query($sql)){
	 return true;
 }else {
	 return false;
 }

 }

 function deleteById($table="", $id=""){
	global $db;
	$id = $db->SQLEscape($id);
	
	
   
	$sql  = "DELETE FROM {$table}";
	$sql .= " WHERE `id` ='{$id}' ";
	$sql .= "LIMIT 1";
   
	if ($db->query($sql)){
		return true;
	}else {
		return false;
	}
   
 }

 function updateWages($id, $driver_id, $get_amount, $action){
	global $db;
	$post_time = time();
    
    $date = date('Y-m-d H:i:s', $post_time);
	   
	$sql  = "UPDATE `wages` SET `status`= '{$action}', `updated_at`='{$date}', `points`='1' WHERE `id`='{$id}'";
   
	if ($db->query($sql)){
		return true;
	}else {
		return false;
	}
   
 }

 function approveDriver($id){
	global $db;
	$post_time = time();
    
    $date = date('Y-m-d H:i:s', $post_time);
	   
	$sql  = "UPDATE `drivers` SET `has_paid`=1, `update_at`='{$date}' WHERE `id`='{$id}'";
   
	if ($db->query($sql)){
		return true;
	}else {
		return false;
	}
   
 }


 function updateWagesAndCustomeer($id="", $driver_id="", $amount="", $action=""){
	global $db;
	$commit = false;
	$db->autoCommit();
	$post_time = time();
    
    $date = date('Y-m-d H:i:s', $post_time);

	$amount_update = "UPDATE `customers` SET `wages`= {$amount}+`wages` WHERE `id`='{$driver_id}'";
	// echo $amount_update;
	
	$db->query($amount_update);
	$q1 = $db->affectedRows();

	echo $q1." Afted";
	if ($q1 > 0) {
		//  echo "succeeded at 1";
		$commit = true;
	} else {
		// echo "error at 1";
		$commit = false;
	}
		
	$insert_wages = "UPDATE `wages` SET `status`= '{$action}', `updated_at`='{$date}', `points`='1'  WHERE `id`='{$id}'";
	

	$db->query($insert_wages);
	$q2 = $db->affectedRows();


	if ($q2 > 0) {
		echo "succeeded at 2";
		$commit = true;
	} else {
		echo "error at 2";
		$commit = false;
    }


	if ($q1 > 0 && $q2 > 0) {
		// echo "Waeew aaa";
		$db->Commit();
		$commit = true;
	} else {
		$db->RollBack();
		$commit = false;
	}
	return $commit;
   
 }


function dynamic_check ($tn="", $col_name= "", $obj_name=""){
	global $db;
 $col_name = $db->SQLEscape($col_name);
 $tn = $db->SQLEscape($tn);
 $obj_name = $db->SQLEscape($obj_name);

$sql  = "SELECT id FROM {$tn}";
 $sql .= " WHERE `{$col_name}` ='{$obj_name}' ";
 $sql .= "LIMIT 1";
 $result = $db->query($sql);
 if ($db->numRows($result) > 0){
	 return true;
 }else {
	 return false;
 }
}

 function join_user_and_driver ($user_id= ""){
	global $db;
 $user_id = $db->SQLEscape($user_id);


$sql  = "SELECT `drivers`.`id`, `drivers`.`first_name`, `drivers`.`last_name`, `drivers`.`vehicle_type`, `hiredriver`.`work_term` FROM `drivers`";
 $sql .= " INNER JOIN `hiredriver` ON `drivers`.`id`=`hiredriver`.`driver_id` ";
 $sql .= "JOIN customers ON `hiredriver`.`user_id`=`customers`.`id` ";
$sql .= "WHERE `customers`.`id`='{$user_id}' ";
// echo $sql;
 $result = $db->query($sql);

 $main_result = $db->fetchAll($result);

 return $main_result;
 
}

function join_driver_and_payment ($driver_id= ""){
	global $db;
 $driver_id = $db->SQLEscape($driver_id);


$sql  = "SELECT `drivers`.*, `hiredriver`.`fees`, `hiredriver`.`date_created`, `hiredriver`.`daily_on_off`, `hiredriver`.`days_duration`, `hiredriver`.`work_spec`";
 $sql .= " FROM `drivers` JOIN `hiredriver` ON `drivers`.`id`=`hiredriver`.`driver_id`";
 $sql .= " WHERE `hiredriver`.`driver_id`='{$driver_id}'";

// echo $sql;
 $result = $db->query($sql);

 $main_result = $db->fetchAll($result);

 return $main_result;
 
}

function findByDynamicValues($address="", $vehicle="") {
	global $db;
	$address = $db->SQLEscape("%".$address."%");
	$vehicle = $db->SQLEscape("%".$vehicle."%");
	$sql = "SELECT * FROM `drivers` WHERE (`address` LIKE '{$address}' OR `local_government_area` LIKE '{$address}') AND `vehicle_type` LIKE '{$vehicle}' AND `has_paid`=1";
	$rsArray = $db->query($sql);

	$main_result = $db->fetchAll($rsArray);

	return $main_result;

}

/*( For Admin */
function join_user_and_driver2 ($user_id= ""){
	global $db;
 $user_id = $db->SQLEscape($user_id);


$sql  = "SELECT `drivers`.`first_name`, `drivers`.`last_name`, `drivers`.`vehicle_type`, `drivers`.`email`, `drivers`.`contact_number`, `drivers`.`address`, `drivers`.`years_of_experience` FROM `drivers`";
 $sql .= " JOIN `hiredriver` ON `drivers`.`id`=`hiredriver`.`driver_id` ";
 $sql .= "JOIN customers ON `hiredriver`.`user_id`=`customers`.`id` ";
$sql .= "WHERE `customers`.`id`='{$user_id}' ";
 $result = $db->query($sql);

 $main_result = $db->fetchAll($result);

 return $main_result;
 
}

function findCustomerByType($type="") {
	global $db;
	$type = $db->SQLEscape($type);
	$sql = "SELECT * FROM `customers` WHERE `type`='{$type}'";
	$rsArray = $db->query($sql);

	$main_result = $db->fetchAll($rsArray);

	return $main_result;

}

function getEmailCode($table="", $colname="", $objname="", $colname2="", $objname2=""){
	global $db;
	$colname = $db->SQLEscape($colname);
	$objname = $db->SQLEscape($objname);
	$objname2 = $db->SQLEscape($objname2);
	$colname2 = $db->SQLEscape($colname2);
   
	$sql  = "SELECT `user_name`, `email_auth_code` FROM {$table}";
	$sql .= " WHERE {$colname} ='{$objname}' ";
	$sql .= " AND {$colname2} ='".sha1($objname2)."' ";
	$sql .= "LIMIT 1";
	$rsArray = $db->query($sql);

	$main_result = $db->fetchAll($rsArray);

	return $main_result;

}

function findApprovedDrivers() {
	global $db;
	$sql = "SELECT * FROM `drivers` WHERE `has_paid`=1";
	$rsArray = $db->query($sql);

	$main_result = $db->fetchAll($rsArray);

	return $main_result;

}

function findEmployerReports($type="") {
	global $db;
	$type = $db->SQLEscape($type);
	$sql = "SELECT `report`.`id`, `customers`.`first_name` AS `cus_first`, `customers`.`last_name` AS `cus_last`, `drivers`.`first_name` AS `driv_first`, `drivers`.`last_name` AS `driv_last` FROM `report` INNER JOIN `customers` ON `customers`.`id`=`report`.`reporter_id` INNER JOIN `drivers` ON `drivers`.`id`=`report`.`reportee_id` WHERE `report`.`type`='{$type}'";
	// $sql = "";
	// $sql = "";
	// echo $sql;
	$rsArray = $db->query($sql);

	$main_result = $db->fetchAll($rsArray);

	return $main_result;

}

function findEmployerReportsById($id="") {
	global $db;
	$id = $db->SQLEscape($id);
	$sql = "SELECT `report`.*, `customers`.`first_name` AS `cus_first`, `customers`.`last_name` AS `cus_last`, `drivers`.`first_name` AS `driv_first`, `drivers`.`last_name` AS `driv_last` FROM `report` INNER JOIN `customers` ON `customers`.`id`=`report`.`reporter_id` INNER JOIN `drivers` ON `drivers`.`id`=`report`.`reportee_id` WHERE `report`.`id`='{$id}'";
	// $sql = "";
	// $sql = "";
	// echo $sql;
	$rsArray = $db->query($sql);

	$main_result = $db->fetchAll($rsArray);

	return $main_result;

}

function findDriverReports($type="") {
	global $db;
	$type = $db->SQLEscape($type);
	$sql = "SELECT `report`.`id`, `driva`.`first_name` AS `dri_first`, `driva`.`last_name` AS `dri_last`, `customers`.`first_name` AS `cus_first`, `customers`.`last_name` AS `cus_last` FROM `report` INNER JOIN `customers` AS `driva` ON `driva`.`id`=`report`.`reporter_id` INNER JOIN `customers` ON `customers`.`id`=`report`.`reportee_id` WHERE `report`.`type`='{$type}'";
	// $sql = "";
	// $sql = "";
	
	$rsArray = $db->query($sql);

	$main_result = $db->fetchAll($rsArray);

	return $main_result;

}

function findDriverReportsById($id="") {
	global $db;
	$id = $db->SQLEscape($id);
	$sql = "SELECT `report`.*, `driva`.`first_name` AS `dri_first`, `driva`.`last_name` AS `dri_last`, `customers`.`first_name` AS `cus_first`, `customers`.`last_name` AS `cus_last` FROM `report` INNER JOIN `customers` AS `driva` ON `driva`.`id`=`report`.`reporter_id` INNER JOIN `customers` ON `customers`.`id`=`report`.`reportee_id` WHERE `report`.`id`='{$id}'";
	// $sql = "";
	// $sql = "";
	
	$rsArray = $db->query($sql);

	$main_result = $db->fetchAll($rsArray);

	return $main_result;

}

function findWagesById( $value="") {
	global $db;
	
	$value = $db->SQLEscape($value);
	$sql = "SELECT * FROM `wages` WHERE `driver_id`='{$value}'";
	$rsArray = $db->query($sql);

	$main_result = $db->fetchAll($rsArray);

	return $main_result;

}

function join_drivers_and_payment (){
	global $db;
//  $user_id = $db->SQLEscape($user_id);


$sql  = "SELECT `drivers`.`first_name`, `drivers`.`last_name`, `driver_payment`.`email`, `driver_payment`.`message`, `driver_payment`.`reference`, `driver_payment`.`response`, `driver_payment`.`trans`, `driver_payment`.`trxref`, `driver_payment`.`status`, `driver_payment`.`amount`, `driver_payment`.`date` FROM `drivers`, `driver_payment`";
$sql .= "WHERE `drivers`.`id`=`driver_payment`.`driver_id` ";
 $result = $db->query($sql);

 $main_result = $db->fetchAll($result);

 return $main_result;
 
}

function join_customers_and_payment (){
	global $db;
//  $user_id = $db->SQLEscape($user_id);


$sql  = "SELECT `customers`.`first_name`, `customers`.`last_name`, `driver_payment`.`email`, `driver_payment`.`message`, `driver_payment`.`reference`, `driver_payment`.`response`, `driver_payment`.`trans`, `driver_payment`.`trxref`, `driver_payment`.`status`, `driver_payment`.`amount`, `driver_payment`.`date` FROM `customers`, `driver_payment`";
$sql .= "WHERE `customers`.`id`=`driver_payment`.`user_id` ";
 $result = $db->query($sql);

 $main_result = $db->fetchAll($result);

 return $main_result;
 
}

function tipUser($user, $post_author, $post_id, $tip_amount, $time)
{
	global $db;
	$commit = false;
	$db->autoCommit();

	$deduct_query_string = "UPDATE `user` SET `earnings` = `earnings`- {$tip_amount} WHERE `user`.`id` = '{$user}' AND `earnings` >= {$tip_amount}";
		$update_transaction = "INSERT INTO `espals_transaction`(`id`, `user_id`, `message`, `redirecturl`, `reference`, `response`, `status`, `trans`, `trxref`, `amount`, `date`)
	 VALUES (null,'{$user}','post tip','NA','{$post_author}','{$post_id}',1,'NA','NA','{$tip_amount}','{$time}')";

	// echo $deduct_query_string;
	// echo $credit_earnings_query_string;
	// echo $update_transaction;

	$db->query($deduct_query_string);
	$q1 = $db->affectedRows();
	$lat =  $db->lastInsertedId();

	if ($q1 > 0) {
		//echo "succeeded at 1";
		$commit = true;
	} else {

		//echo $add_withdrawal_query_string;
		$commit = false;
	}

	$credit_earnings_query_string = "UPDATE `user` SET `earnings` = `earnings`+ {$tip_amount} WHERE `user`.`id` = '{$post_author}';";

	$db->query($credit_earnings_query_string);
	$q2 = $db->affectedRows();

	if ($q2 > 0) {
		//echo "succeeded at 2";
		$commit = true;
	} else {
		$commit = false;
	}

	$db->query($update_transaction);
	$q3 = $db->affectedRows();

	if ($q1 > 0 && $q2 > 0 && $q3 > 0) {
		$db->Commit();
		$commit = true;
	} else {
		$db->RollBack();
		$commit = false;
	}
	return $commit;
}

function registerDriverAndCustomer($first_name="", $last_name="", $email="", $password="", $email_auth_code="", $address="", $type="", $contact_number="", $years_of_experience="", $local_government_area="", $description="", $vehicle_type="", $img_url="")
{
	global $db;
	$commit = false;
	$db->autoCommit();

	$post_time = time();
    
    $date = date('Y-m-d H:i:s', $post_time);
    $register_as_driver = "INSERT INTO `drivers`(`id`, `first_name`, `last_name`, `email`, `contact_number`, `years_of_experience`, `local_government_area`, `address`, `description`, `vehicle_type`, `img_url`, `img1`, `img2`, `img3`, `img4`, `img5`, `has_paid`, `status`, `create_at`, `update_at`)
     VALUES ('','{$first_name}','{$last_name}','{$email}','{$contact_number}','{$years_of_experience}','{$local_government_area}','{$address}','{$description}','{$vehicle_type}','{$img_url}','','','','','','','','{$date}','{$date}')";
	

	$db->query($register_as_driver);
	$q1 = $db->affectedRows();


	if ($q1 > 0) {
		// echo "succeeded at 1";
		$commit = true;
	} else {

		$commit = false;
    }

    $driver_id = $db->lastInsertedId();
    $register_as_customer = "INSERT INTO `customers`(`id`, `driver_id`, `first_name`, `last_name`, `email`, `password`, `email_auth_code`, `birth_date`, `phone`, `address`, `city`, `state`, `points`, `status`, `type`, `create_at`, `update_at`) 
    VALUES ('','{$driver_id}','{$first_name}','{$last_name}','{$email}','{$password}','{$email_auth_code}','','{$contact_number}','{$address}','','','','','{$type}','{$date}','{$date}')";
	// echo $register_as_customer;
	$db->query($register_as_customer);
	$q2 = $db->affectedRows();

	if ($q2 > 0) {
		// echo "succeeded at 2";
		$commit = true;
	} else {
		$commit = false;
	}

	if ($q1 > 0 && $q2 > 0) {
		$db->Commit();
		$commit = true;
	} else {
		$db->RollBack();
		$commit = false;
	}
	return $commit;
}

function wages_insert($driver_id="", $driver_name="", $amount="", $bank="", $acc_name="", $acc_number="")
{
	global $db;
	$commit = false;
	$db->autoCommit();

	$amount_update = "UPDATE `customers` SET `wages`= `wages` - {$amount} WHERE `id`='{$driver_id}' AND  `wages` >= {$amount}";
	// echo $amount_update;
	
	$db->query($amount_update);
	$q1 = $db->affectedRows();

	// echo $q1." Afted";
	if ($q1 > 0) {
		//  echo "succeeded at 1";
		$commit = true;
	} else {

		$commit = false;
	}
	$post_time = time();
    
    $date = date('Y-m-d H:i:s', $post_time);
	
	$insert_wages = "INSERT INTO `wages`(`id`, `driver_id`, `driver_name`, `amount`, `bank`, `acc_name`, `acc_number`, `created_at`)
	 VALUES (null,'{$driver_id}','{$driver_name}','{$amount}','{$bank}','{$acc_name}','{$acc_number}', '{$date}')";
	

	$db->query($insert_wages);
	$q2 = $db->affectedRows();


	if ($q2 > 0) {
		// echo "succeeded at 2";
		$commit = true;
	} else {

		$commit = false;
    }


	if ($q1 > 0 && $q2 > 0) {
		// echo "Waeew aaa";
		$db->Commit();
		$commit = true;
	} else {
		$db->RollBack();
		$commit = false;
	}
	return $commit;
}

function join_drivers_and_customer ($driver_id= ""){
	
	global $db;
	$driver_id = $db->SQLEscape($driver_id);
   
   
   	$sql  = "SELECT `customers`.`id`, `customers`.`first_name`, `customers`.`last_name`, `customers`.`state`, `customers`.`address`,";
	$sql .= " `hiredriver`.`work_term`, `hiredriver`.`work_spec`, `hiredriver`.`days_duration`, `hiredriver`.`vehicle_type`,";
	$sql .= " `hiredriver`.`accommodation`, `hiredriver`.`daily_on_off`, `hiredriver`.`date_created` FROM `hiredriver`";
	$sql .= " JOIN `customers` ON `customers`.`id`=`hiredriver`.`user_id` ";
	// $sql .= "JOIN customers ON `hiredriver`.`user_id`=`customers`.`id` ";
   $sql .= "WHERE `hiredriver`.`driver_id`='{$driver_id}' ";
//    echo $sql;
	$result = $db->query($sql);
   
	$main_result = $db->fetchAll($result);
   
	return $main_result;
 
}

function get_driver_img ($user_id= ""){
	global $db;
 $user_id = $db->SQLEscape($user_id);


$sql  = "SELECT `img1`, `img2`, `img3`, `img4`, `img5` FROM `drivers`";
$sql .= "WHERE `id`='{$user_id}' ";
 $result = $db->query($sql);

 $main_result = $db->findBySql($result);

 return $main_result;
 
}

function check_if_obj_exits_staff($colname="", $objname=""){
 global $db;
 $colname = $db->SQLEscape($colname);
 $objname = $db->SQLEscape($objname);

 $sql  = "SELECT id FROM users";
 $sql .= " WHERE `{$colname}` ='{$objname}' ";
 $sql .= "LIMIT 1";
 $result = $db->query($sql);
 if ($db->numRows($result) > 0){
	 return true;
 }else {
	 return false;
 }

}




function check_user($key)
{
	// global $main_id;

	$decrypt_token = my_decrypt($key->hash_map, SECRETE_KEY);

	$decode_id = explode("-", $decrypt_token);  

	$main_id = $decode_id[0];

	return $main_id;
}




function my_encrypt($data, $key) {
    // Remove the base64 encoding from our key
    $encryption_key = base64_decode($key);
    // Generate an initialization vector
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
    return base64_encode($encrypted . '::' . $iv);
}

function my_decrypt($data, $key) {
    // Remove the base64 encoding from our key
    $encryption_key = base64_decode($key);
    // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}




function output_message($message="") {
	if (!empty($message)) {
		return $message;
	} else {
	return "";
	}
	}



// 		if ($fetch['tSCoins'] > 5 && $fetch['debioActive'] == 0){

// 		}
// 		$result = mysqli_query($debioLink, $sql);

// 		$resultToArray = mysqli_fetch_array($result);

// 		$totalSmsP = $resultToArray['tSCPurchased'];
// 		$emailInArray = $resultToArray['debioEmail'];
// 		$totalcoins = $resultToArray['tSCoins'];
// 		$phoneInArray = $resultToArray['debioPhone'];
// 		$totalCreditT = $resultToArray['tSCTransfered'];
// 		$usernameInArray = $resultToArray['debioUsername'];
// 		$activeInArray = $resultToArray['debioActive'];
// 		$debioPassKey = $resultToArray['debioPassKey'];


function mailGod($value='')
{
	$message = '
	<html>
	<head>
	  <title>bitcaz Mail Center</title>

	</head>
	<body>
	<style>
	.msg_wrapper{
	  width: 100%;
	  max-width: 768px;
	  margin: 0 auto;
	  box-shadow: 0 2px 3px rgba(0,0,0,0.08);
	    border: 1px solid #ececec;
	  border-top: 4px solid #358CCE;

	  background: white;
	  padding: 10px;
	}
	*{
	  font-family: Arial;
	}

	.footer{
	  border-top: 4px solid #c9302c;
	  margin-top: 10px;
	  margin-bottom: 10px;
	}
	p{
	  line-height: 1;
	}
	.link-color{
	  color:#358CCE !important;
	}
	.logo_sec{
	  border-bottom: 1px solid #ececec;
	  padding-bottom: 10px;
	  margin-bottom: 20px;
	}

	.mail{

	}
	</style>
	  <div class="msg_wrapper">
	  <div class="logo_sec">
	  <a href="http://bitsense.biz/"><img src="https://bitsense.biz/img/logo.png" style="width: 100px;" /></a>
	  </div>

	<div class="mail">
	'.$value.'
	<br>
	  <b>Regards,</b>
	<p>Support Team | <b>bitsense.biz </b> |</p>
	<p>E-mail: support@bitsense.biz</p>
	<p>Web : <a href="http://bitsense.biz/" class="link-color">www.bitsense.biz</a> </p>
	<br>
	</div>
	  <div class="footer">
	  <p>This e-mail is confidential. It may also be legally privileged.
	If you are not the addressee you may not copy, forward, disclose
	or use any part of it. If you have received this message in error,
	please delete it and all copies from your system and notify the
	sender immediately by return e-mail.</p>
	<p>
	<br>
	Internet communications cannot be guaranteed to be timely,
	secure, error or virus-free. The sender does not accept liability
	for any errors or omissions.
	</p>

	<p>
	<br>
	Kemfe would never send you emails asking you to enter your account information on any site other than <a href="http://bitsense.biz/" class="link-color">www.bitsense.biz</a>  Any of such mails MUST be forwarded to spoof@bitsense.biz
	</p>
	  </div>
	  </div>

	</body>
	</html>
	';

return $message;
}
