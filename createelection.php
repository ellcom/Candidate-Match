<?php

require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){
	
	if(isset($_POST['submit'])){
		if(empty(trim($_POST['name']))){
			$message = "Election must have a name";
		}else{
			$open_timestamp = mktime($_POST['Open_Time_Hour'], 0, 0, $_POST['Open_Date_Month'], $_POST['Open_Date_Day'], $_POST['Open_Date_Year']);
			$close_timestamp = mktime($_POST['Close_Time_Hour'], 0, 0, $_POST['Close_Date_Month'], $_POST['Close_Date_Day'], $_POST['Close_Date_Year']);
			
			$insertID = $database->createElection($_POST['name'],$open_timestamp, $close_timestamp);
			
			if($insertID){
				header("Location: ./electionprofiler.php?id=$insertID");
				exit;
			}else {
				$message = "Election must have a unique name";
			}
		}
	}
	$smarty->assign('session',$_SESSION);
	if(isset($message)) $smarty->assign('message',$message);
	$smarty->display('createelection.tpl');
	
} else{ 
	echo "Go Away Now!";
}

?>
