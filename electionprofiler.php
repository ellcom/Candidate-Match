<?php

require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){
	
	// Need an ID for the election
	if(!isset($_GET['id']) || empty($_GET['id']) || is_int($_GET['id'])){
		header("Location: ./listelections.php");
		exit;
	}
	
	// Get the election Row
	$election = $database->lookupElectionWithId($_GET['id']);
	// Send away if the election doesn't exist.
	if(is_null($election)){
		header("Location: ./listelections.php");
		exit;
	}

	// Gather Candidates on the election
	$candidates = $database->candidatesForElectionId($_GET['id']);
	$questions = $database->listQuestionsForElection($_GET['id']);
	
	$smarty->assign('election', $election);
	$smarty->assign('candidates', $candidates);
	$smarty->assign('questions', $questions);
	
	
	$smarty->assign('session',$_SESSION);
	$smarty->display('electionprofiler.tpl');
}

?>