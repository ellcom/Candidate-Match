<?php 
require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){

	if(isset($_POST['ids']) && isset($_POST['removeCandidatesFromElection'])){
		$database->removeFromElection($_POST['ids'],$_POST['removeCandidatesFromElection']);
		echo "1";
	}elseif(isset($_POST['ids']) && isset($_POST['removeQuestionsFromElection'])){
		$database->removeQuestionFromElection($_POST['ids'],$_POST['removeQuestionsFromElection']);
		echo "1";
	}else{
		echo "-1";
	}
	
} else{ 
	echo "0";
}

?>
