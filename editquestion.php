<?php 
require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){

	if(!isset($_GET['id'])){
		header("Location: ./dashboard.php");
	}
	
	$question = $database->getQuestion($_GET['id']);

	if($question == NULL){
		header("Location: ./dashboard.php");
	}

	if(isset($_POST['submit'])){
	
		echo "<!--";
		print_r($_POST);
		echo "-->\n";
		
		echo "<!--";
		print_r($question);
		echo "-->";
		
		$message = "";

		// Change of Question
		if(empty(trim($_POST['question']))){
			$message .= "Questions Cannot be Empty";
		}else{
			if($question['questionText'] != $_POST['question']){
				$database->changeQuestionAttribute($_GET['id'], 'questionText', $_POST['question']);
			}elseif($question['electionID'] != $_POST['election']) {
				$database->changeQuestionAttribute($_GET['id'], 'electionID', $_POST['election']);
			}elseif($question['category'] != $_POST['category']) {
				$database->changeQuestionAttribute($_GET['id'], 'category', $_POST['category']);
			}
		}
		
		$question = $database->getQuestion($_GET['id']);
	}
  
	if(!empty($message)){
		$smarty->assign('message',$message);
	}
  	
 	$smarty->assign('elections',$database->listElections());
 	$smarty->assign('session',$_SESSION);
 	$smarty->assign('question',$question);
 	
 	$smarty->display('editquestion.tpl');
} else{ 
	echo "Go Away Now!";
}

?>
