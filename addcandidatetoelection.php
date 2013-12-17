<?php

require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){


	// Get the election Row
	$election = $database->lookupElectionWithId($_GET['eid']);
	// Send away if the election doesn't exist.
	if(is_null($election)){
		header("Location: ./listelections.php");
		exit;
	}
	
	
	if(isset($_POST['submit'])){
		$database->addCandidateToElection($_POST['username'], $_POST['course'], $_POST['age'], $_POST['gender'], $_POST['link'], $_GET['eid']);
		header("Location: ./electionprofiler.php?id=".$_GET['eid']);
	}
	
	
	$usernames = $database->listUnassignedCandidates();
	
	$smarty->assign('usernames', $usernames);
	$smarty->assign('election', $election);
	
	$smarty->assign('session',$_SESSION);
	$smarty->display('addcandidatetoelection.tpl');

} else{ 
	echo "Go Away Now!";
}

?>