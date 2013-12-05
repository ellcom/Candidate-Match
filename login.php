<?php 
require_once("config.php");
require_once("session.php");

if(isset($_POST['username']) && isset($_POST['password'])){
	$loginResult = $database->authenticationCredentials($_POST['username'], $_POST['password']);
	
	if($loginResult == NULL){
			$smarty->assign("message","Login Failed, Try again.");
	} elseif($loginResult['active'] == 1) {
		$session->login($loginResult['id']);
		header("Location: /dashboard.php",true, 301);
	}else{
		$smarty->assign("message","There's been a problem of sorts, contact an administrator.");
	}
}

$smarty->display("login.tpl");

?>
