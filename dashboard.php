<?php 
require_once("config.php");
require_once("session.php");


if($session->checkSession()){
  $smarty->assign('session',$_SESSION);
  $smarty->display('dashboard.tpl');
} else{ 
	echo "Go Away Now!";
}


?>
