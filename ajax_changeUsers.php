<?php 
require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){

	if(isset($_POST['active'])){
		$database->setActive($_POST['ids'],$_POST['active']);
		echo "1";
	}elseif (isset($_POST['delete'])) {
		$database->deleteUsers($_POST['ids']);
		echo "1";
	}else{
		echo "-1";
	}
	
} else{ 
	echo "0";
}

?>
