<?php
require_once("config.php");
require_once("session.php");

// Candidate Info
$candidateID = $database->getCandidateIDForUser($_SESSION['id']);
$candidateInfo = $database->returnDataForCandidate($candidateID);
$allCandAnswers = $database->returnAnswerDataForCandidate($candidateID);
$elecCandAnswers = $database->returnElectionAnswerDataForCandidate($candidateID);

// Election Info
$electionID = $candidateInfo['electionID'];
$election = $database->lookupElectionWithId($electionID);
$questions = $database->returnQuestionData($electionID);
$eQuestions = $database->returnElectionQuestionData($electionID);

// Timestamp
$date = new DateTime();
$timestamp = $date->getTimestamp();

// In $eQuestions rename 'questionID' to 'id' for smarty
foreach ( $eQuestions as $k=>$v )
{
	$eQuestions[$k] ['id'] = $eQuestions[$k] ['questionID'];
	unset($eQuestions[$k]['questionID']);
}

if($session->checkSession()){
	$smarty->assign('session',$_SESSION);
	
	if($timestamp > $election['timestamp']) // IF election is LIVE (meaning candidates should justify answers)
	{
		$smarty->assign('questions', $eQuestions);
		$smarty->assign('answers', $elecCandAnswers);
		$smarty->assign('live', 'yes');
		
		if(isset($_POST['submit'])) // IF questionnaire has been submitted
		{
			$smarty->assign('message', "Questionnaire Updated!");
			$smarty->display('questionnaire.tpl');
		}
		else
		{
			$smarty->display('questionnaire.tpl');
		}
	}
	else	// ELSE election is NOT LIVE (disable justifications)
	{
		$smarty->assign('questions', $questions);
		$smarty->assign('answers', $allCandAnswers);
		$smarty->assign('live', 'no');
		
		if(isset($_POST['submit'])) // IF questionnaire has been submitted
		{		
			$smarty->assign('message', "Questionnaire Updated!");
			$smarty->display('questionnaire.tpl');
		}
		else
		{
			$smarty->display('questionnaire.tpl');
		}
	}
} else{ 
	echo "Go Away Now!";
}
?>	