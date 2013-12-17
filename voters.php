<?php 
require_once('config.php');

$activeElections = $database->getActiveElection();

$smarty->assign('elections', $activeElections);
$smarty->display('voters.tpl');
	
?>