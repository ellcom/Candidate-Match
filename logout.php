<?php 
require_once("config.php");
require_once("session.php");

if($session->logout() == 1){
	header("Location: ./login.php");
}
?>