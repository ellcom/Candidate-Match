<?php 
require_once("config.php");
require_once("session.php");


if($session->checkSession()){
  $smarty->assign('session',$_SESSION);
  
  if(isset($_POST['password1']) && isset($_POST['password2'])){
  	if($_POST['password1'] != $_POST['password2']){
  		$smarty->assign("message","New Passwords Don't Match");
  	} elseif (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%]{8,40}$/',$_POST['password1'])) {
  		$smarty->assign("message","New Passwords must be 8 charactors (40 max) in length, contain 1 digit, 1 upercase and 1 lowercase letter");
  	}else{
<<<<<<< HEAD
  		if($database->changeMyPassword($_SESSION['id'],$_POST['password0'],$_POST['password1'])){
  			header("Location: /dashboard.php",true, 301);
=======
  		if($database->changeUserPassword($_SESSION['username'],$_POST['password0'],$_POST['password1'])){
  			header("Location: ./dashboard.php",true, 301);
>>>>>>> 7485398f057532eeca919d6e12ad2fa6a3309383
  		} else {
  			$smarty->assign("message","Invalid Password");
  		}
  	}
  }
  
  
  $smarty->display('password.tpl');
} else{ 
	echo "Go Away Now!";
}

?>
