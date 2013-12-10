<?php

require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){
	
	if(isset($_POST['submit'])){
		if(empty(trim($_POST['name']))){
			$message = "Election must have a name";
		}else{
			$timestamp = mktime($_POST['Time_Hour'], 0, 0, $_POST['Date_Month'], $_POST['Date_Day'], $_POST['Date_Year']);
		
			if($database->createElection($_POST['name'],$timestamp,$_POST['active'])){
				header("Location: ./dashboard.php",true,301);
				exit;
			}else {
				$message = "Election must have a unique name";
			}
		}
	}
	
	if(isset($message)) $smarty->assign('message',$message);
	$smarty->display('createelection.tpl');
	
} else{ 
	echo "Go Away Now!";
}

?>
