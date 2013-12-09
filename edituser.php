<?php 
require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){
  $smarty->assign('session',$_SESSION);
  
  $user = $database->getUser($_GET['userid']);
  $smarty->assign('user',$user);
  
  $userTypes = $database->getUserTypes();
  $smarty->assign('userTypes',$userTypes);
  
  $smarty->display('edituser.tpl');
} else{ 
	echo "Go Away Now!";
}

?>
