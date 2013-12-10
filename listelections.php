<?php

require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){

	$list = $database->listElections();
	
	$smarty->assign('list',$list);
	$smarty->display('listelections.tpl');
	
} else{ 
	echo "Go Away Now!";
}

?>
