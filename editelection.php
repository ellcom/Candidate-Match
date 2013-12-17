<?php 
require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){

	if(!isset($_GET['id'])){
		header("Location: ./dashboard.php");
	}
	
	$election = $database->lookupElectionWithId($_GET['id']);

	if($election == NULL){
		header("Location: ./dashboard.php");
	}

	if(isset($_POST['submit'])){
		
		if(empty(trim($_POST['name']))){
			$message = "Election must have a name";
		}else{
			$open_timestamp = mktime($_POST['Open_Time_Hour'], 0, 0, $_POST['Open_Date_Month'], $_POST['Open_Date_Day'], $_POST['Open_Date_Year']);
			$close_timestamp = mktime($_POST['Close_Time_Hour'], 0, 0, $_POST['Close_Date_Month'], $_POST['Close_Date_Day'], $_POST['Close_Date_Year']);
			
			if($open_timestamp >= $close_timestamp){
				$message = "Elections must start before they end";
			}else {
				if($open_timestamp != $election['timestamp']){
					$database->changeElectionAttribute($_GET['id'], 'timestamp', $open_timestamp);
				}
				
				if($close_timestamp != $election['end_timestamp']){
					$database->changeElectionAttribute($_GET['id'], 'end_timestamp', $close_timestamp);
				}
				
				if($_POST['name'] != $election['name']){
					$database->changeElectionAttribute($_GET['id'], 'name', $_POST['name']);
				}
				
				if($_POST['description'] != $election['description']){
					$database->changeElectionAttribute($_GET['id'], 'description', $_POST['description']);
				}
				
				
			}
			
		}
		
		
		$election = $database->lookupElectionWithId($_GET['id']);
	}
  
	if(!empty($message)){
		$smarty->assign('message',$message);
	}
  	
 	$smarty->assign('session',$_SESSION);
 	$smarty->assign('election',$election);
 	
 	$smarty->display('editelection.tpl');
} else{ 
	echo "Go Away Now!";
}

?>
