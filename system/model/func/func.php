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
