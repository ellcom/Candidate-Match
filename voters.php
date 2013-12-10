<?php 
require_once('config.php');

$questions = $database->returnElectionQuestionData(1);
$smarty->assign('questions', $questions);
$smarty->display('voters.tpl');
?>