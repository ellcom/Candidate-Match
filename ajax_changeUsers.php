<?php 
require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){

	$database->setActive($_POST['ids'],$_POST['active']);
	echo "1";
	
} else{ 
	echo "0";
}

?>
