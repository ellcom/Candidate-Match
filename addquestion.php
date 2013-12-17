<?php 
require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){
	
	if(isset($_POST['submit'])){
		$user = array();
		$message = "";
		
		if (empty(trim($_POST['election']))) {
			$message .= "Election Cannot be Blank";
		}elseif (empty(trim($_POST['question']))) {
			$message .= "Question Cannot be Blank";
		}else {
			$database->addQuestion($_POST['question'], $_POST['category'], $_POST['election']);
			header("Location: ./electionprofiler.php?id=".$_POST['election']);
		}
		
	}
	$smarty->assign('session',$_SESSION);
	
	if(!empty($message)){
		$smarty->assign('message',$message);
	}
	
	if(isset($_GET['id'])){
		$smarty->assign('election_id',$_GET['id']);
	}
	
	$smarty->assign('elections',$database->listElections());
	
	$smarty->display('createquestion.tpl');
} else{ 
	echo "Go Away Now!";
}

?>
