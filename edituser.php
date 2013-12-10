<?php 
require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){
	
	if(!isset($_GET['userid'])){
		header("Location: ./list.php", true, 302);
	}
	
	$user = $database->getUser($_GET['userid']);

	if($user == NULL){
		header("Location: ./list.php", true, 302);
	}

	if(isset($_POST['submit'])){
		echo "<!--";
		print_r($_POST);
		echo "-->\n";
		
		echo "<!--";
		print_r($user);
		echo "-->";
		
		$message = "";
		// Change Password
		if(!empty(trim($_POST['password']))){
			$database->changeUserPassword($user['id'], $_POST['password']);
			$message .= "Password Changed! \n";
		}
		// Change Username. Not Admin
		if($user['username'] != $_POST['username']  && $user['username'] != 'admin'){
			if(!$database->changeAttribute($user['id'], 'username', $_POST['username'], true)){
				$message .= "Username Cannot be Changed! \n";
			}
		}
		// Change Name
		if($user['name'] != $_POST['name']){
			$database->changeAttribute($user['id'], 'name', $_POST['name']);
		}
		// Change Email
		if($user['email'] != $_POST['email']){
			$database->changeAttribute($user['id'], 'email', $_POST['email']);
		}
		// Change Active. Not Admin
		if($user['active'] != $_POST['active'] && $user['username'] != 'admin'){
			$database->changeAttribute($user['id'], 'active', $_POST['active']);
		}
		// Change type. Not Admin
		if($user['type'] != $_POST['type'] && $user['username'] != 'admin'){
			$database->changeAttribute($user['id'], 'type', $_POST['type']);
		}
		
		$user = $database->getUser($_GET['userid']);
	}
  
  
  
  $userTypes = $database->getUserTypes();
  
  if(!empty($message)){
  	$smarty->assign('message',$message);
  }
  	
  $smarty->assign('userTypes',$userTypes);
  $smarty->assign('session',$_SESSION);
  $smarty->assign('user',$user);
  
  $smarty->display('edituser.tpl');
} else{ 
	echo "Go Away Now!";
}

?>
