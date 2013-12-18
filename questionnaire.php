<?php
require_once("config.php");
require_once("session.php");

// Candidate Info from DB
$candidateID = $database->getCandidateIDForUser($_SESSION['id']);
$candidateInfo = $database->returnDataForCandidate($candidateID);
$allCandAnswers = $database->returnAnswerDataForCandidate($candidateID);
$elecCandAnswers = $database->returnElectionAnswerDataForCandidate($candidateID);

// Election Info from DB
$electionID = $candidateInfo['electionID'];
$election = $database->lookupElectionWithId($electionID);
$questions = $database->returnQuestionData($electionID);
$eQuestions = $database->returnElectionQuestionData($electionID);

// In $eQuestions rename 'questionID' to 'id'
foreach ( $eQuestions as $k=>$v )
{
	$eQuestions[$k] ['id'] = $eQuestions[$k] ['questionID'];
	unset($eQuestions[$k]['questionID']);
}

// Timestamp
$date = new DateTime();
$timestamp = $date->getTimestamp();

if($session->checkSession())
{
	$smarty->assign('session',$_SESSION);
	
	// IF questionnaire has been submitted
	if(isset($_POST['submit']))
	{
		if($timestamp > $election['timestamp'])
		{
			$qArray = $eQuestions;
		}
		else
		{
			$qArray = $questions;
		}

		foreach ($qArray as $row) 
		{
			$qid = $row['id'];

			if (isset($_POST['A'.$qid]) && !empty($_POST['A'.$qid]))
			{
				// retrieve the value from the HTML radio button 'opinion'
				$answer = $_POST['A'.$qid];
				$justification = $_POST['A'.$qid.'text'];
				
				// check opinion parameter within bounds (stop some injection)
				if($answer > 0 && $answer <= 5)
				{
					$database->insertAnswer($answer, $justification, $qid, $candidateID);
					//echo 'ans:'.$answer.' just:'.$justification.' q:'.$qid.' cand:'.$candidateID;
				}
				else
				{
					echo 'ERROR (testAdd): incorrect opinion parameter<br>';
				}
			}
		}
		
		$smarty->assign('message', "Questionnaire Updated!");
		
		// Refresh data
		$allCandAnswers = $database->returnAnswerDataForCandidate($candidateID);
		$elecCandAnswers = $database->returnElectionAnswerDataForCandidate($candidateID);
	}
	
	if($timestamp > $election['timestamp']) // IF election is LIVE (meaning candidates should justify answers)
	{
		$smarty->assign('questions', $eQuestions);
		$smarty->assign('answers', $elecCandAnswers);
		$smarty->assign('live', 'yes');
	}
	else	// ELSE election is NOT LIVE (disable justifications)
	{
		$smarty->assign('questions', $questions);
		$smarty->assign('answers', $allCandAnswers);
		$smarty->assign('live', 'no');
	}
	
	$smarty->display('questionnaire.tpl');
}
else
{ 
	echo "Go Away Now!";
}
?>	