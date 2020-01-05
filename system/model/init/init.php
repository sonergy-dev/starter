<?php
//echo $_SERVER['DOCUMENT_ROOT'];
ini_set('display_errors', 1);
error_reporting(~1);
define("DS", "/");

define("SITE_ROOT", $_SERVER['DOCUMENT_ROOT']."/system");

define("LIB_PATH", SITE_ROOT.DS.'model');

require_once (LIB_PATH.DS.'db'.DS.'config.php');

require_once (LIB_PATH.DS.'func'.DS.'func.php');
require_once (LIB_PATH.DS.'dbclass'.DS.'dbclass.php');

require_once (LIB_PATH.DS.'dbobject'.DS.'dbobject.php');
require_once (LIB_PATH.DS.'token'.DS.'jwt.php');

require_once (LIB_PATH.DS.'user'.DS.'user.php');

require_once (LIB_PATH.DS.'user'.DS.'test.php');


