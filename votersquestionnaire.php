<?php 
require_once('config.php');

$electionID = $_GET["election"];
$questions = $database->returnElectionQuestionData($electionID);

$smarty->assign('electionID', $electionID);
$smarty->assign('questions', $questions);

$smarty->display('votersquestionnaire.tpl');

?>