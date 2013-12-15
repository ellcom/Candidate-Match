<?php
require_once("config.php");
require_once("session.php");

$electionID = $database->getActiveElection();
$questions = $database->returnQuestionData($electionID['0']['id']);
$smarty->assign('questions', $questions);

if($session->checkSession()){
	$smarty->assign('session',$_SESSION);
	
	if(isset($_POST['submit']))
	{
		foreach($questions as $row)
		{
			echo $_POST['A'.$row['id'].'text'];
		}
	
		$smarty->assign('message', "Questionnaire Updated!");
		$smarty->display('questionnaire.tpl');
	}
	else
	{
		// TODO Grab this candidate's current answers to fill out the questionnaire with currently completed questions
		
		
		$smarty->display('questionnaire.tpl');
	}
} else{ 
	echo "Go Away Now!";
}
?>	