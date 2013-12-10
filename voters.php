<?php 
require_once('config.php');

$electionID = $database->getActiveElection();
$questions = $database->returnElectionQuestionData($electionID['0']['id']);
$smarty->assign('questions', $questions);

if(isset($_POST['submit']))
{
	foreach($questions as $row)
	{
		$i = $row['questionID'];
		$voterAnswers[$i] = $_POST['A'.$row['questionID']];
	}
	print_r($voterAnswers);
	$smarty->display('results.tpl');
}
else
{
	$smarty->display('voters.tpl');
}
?>