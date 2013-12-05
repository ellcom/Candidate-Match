<?php
// Debug mode?
$DEBUG_MODE = TRUE;
if($DEBUG_MODE){ error_reporting(-1); } else { error_reporting(0); }

// Push Away unwanted attention
if (strpos($_SERVER["REQUEST_URI"], 'config.php') !== FALSE){
	die("This page isn't user accessable, please go away!");
}

// Change to your apache directory for the site
<<<<<<< HEAD
define("ROOT_FOLDER","/Users/elliot/Sites/Candidate-Match");
// Change to your Smarty folder
define("SMARTY_FOLDER", "/Users/elliot/Sites/Smarty-3.1.15");
=======
$ROOT_FOLDER = "C:\xampp\htdocs\Candidate-Match";
// Change to your Smarty folder
$SMARTY_FOLDER = "C:\Users\Garlen\Downloads\Smarty-3.1.15";
>>>>>>> 85652023fb36ef9ebc90ce5eecbee67b8928d5ac

// Database
// This should be set as a sysenv var when pushed to the deployment server
putenv("MYSQL_USER=root");
putenv("MYSQL_PASSWORD=root");
require_once(ROOT_FOLDER."/database.php");
$database = new Database;

// Smarty Config
define("TEMPLATE_FOLDER",ROOT_FOLDER."/smarty_tpl");
require_once(SMARTY_FOLDER."/libs/Smarty.class.php");
$smarty = new Smarty;
$smarty->setTemplateDir(TEMPLATE_FOLDER);
$smarty->debugging = $DEBUG_MODE; 

?>