<?php 
require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){
	
	if(isset($_POST['submit'])){
		$user = array();
		$message = "";
		
		if(empty(trim($_POST['name']))){
			$message .= "Name can't be blank";
		}elseif (empty(trim($_POST['username']))) {
			$message .= "Username can't be blank";
		}elseif (empty(trim($_POST['password']))) {
			$message .= "Password can't be blank";
		}elseif (empty(trim($_POST['email']))) {
			$message .= "Email can't be blank";
		}elseif($database->addUserToDatabase($_POST['username'], $_POST['password'], $_POST['email'], $_POST['name'], $_POST['type'], $_POST['active'])) {
			header("Location: ./dashboard.php",true,301);
		}else{
			$message .= "Username Exists";
		}
		
		$user['name'] = $_POST['name'];
		$user['username'] = $_POST['name'];
		$user['active'] = $_POST['active'];
		$user['type'] = $_POST['type'];
		$user['email'] = $_POST['email'];
	}
	$smarty->assign('session',$_SESSION);
	$userTypes = $database->getUserTypes();
	
	if(!empty($message)){
		$smarty->assign('message',$message);
	}
	
	if(isset($user)){
		$smarty->assign('user',$user);
	}
	
	
	$smarty->assign('userTypes',$userTypes);
	
	$smarty->display('createuser.tpl');
} else{ 
	echo "Go Away Now!";
}

?>
