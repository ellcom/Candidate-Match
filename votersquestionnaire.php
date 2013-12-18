<?php 
require_once('config.php');

$electionID = $_GET["election"];

// Timestamp
$date = new DateTime();
$timestamp = $date->getTimestamp();

$election = $database->lookupElectionWithId($electionID);
if($timestamp > $election['timestamp'])
{
	$database->updateDivisiveness($electionID);
	$database->selectElectionQuestions($electionID);
}

$questions = $database->returnElectionQuestionData($electionID);

$smarty->assign('electionID', $electionID);
$smarty->assign('questions', $questions);

$smarty->display('votersquestionnaire.tpl');

?>