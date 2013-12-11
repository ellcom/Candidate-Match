<?php 
require_once('config.php');
require_once('match.php');

$electionID = $database->getActiveElection();
$questions = $database->returnElectionQuestionData($electionID['0']['id']);
$smarty->assign('questions', $questions);

if(isset($_POST['submit']))
{
	$voterAnswers = array();
	foreach($questions as $row)
	{
		array_push($voterAnswers, array('questionID'=>$row['questionID'], 'answer'=>$_POST['A'.$row['questionID']]));
	}
	print_r($voterAnswers);
	echo '<br><br>';

	// match object
	$candidateAnswers = $database->returnCandidateElectionAnswerData($electionID['0']['id']);

	$matchObj = new match($candidateAnswers, $voterAnswers);
	$voterSimilarities = $matchObj->calculateDifferences();

	print_r($voterSimilarities);

	$smarty->display('results.tpl');
}
else
{
	$smarty->display('voters.tpl');
}
?>