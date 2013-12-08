<?php 
require_once("config.php");
require_once("session.php");

if(isset($_POST['username']) && isset($_POST['password'])){
	$loginResult = $database->authenticationCredentials($_POST['username'], $_POST['password']);
	
	if($loginResult == NULL){
			$smarty->assign("message","Login Failed, Try again.");
			$smarty->assign("username",$_POST['username']);
	} elseif($loginResult['active'] == 1) {
		$session->login($loginResult['id']);
		header("Location: /dashboard.php",true, 301);
	}else{
		$smarty->assign("message","There's been a problem of sorts, contact an administrator.");
		$smarty->assign("username",$_POST['username']);
	}
}

$smarty->display("login.tpl");

?>
