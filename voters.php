<?php 
require_once('config.php');

if(isset($_POST['submit']))
{
	$voterAnswers[] = array('questionID'=> $candidateAnswerData[$i]['questionID'], 'answer'=> $_POST['']);
	echo trim($_POST['A2']);
	$smarty->display('results.tpl');
}
else
{
	$electionID = $database->getActiveElection();
	$questions = $database->returnElectionQuestionData($electionID['0']['id']);
	$smarty->assign('questions', $questions);
	$smarty->display('voters.tpl');
}
?>