<?php 
require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){
  $smarty->assign('session',$_SESSION);
  
  $users = $database->listUsers();
  $smarty->assign('users',$users);
  
  $smarty->display('list.tpl');
} else{ 
	echo "Go Away Now!";
}

?>
