<?php
class Session {

	

	function __construct() {
		session_start();
	}
	
	function login($userID) {
		global $database;
		$database->insertSession($userID,session_id());
	}
	
	function logout() {
		global $database;
		return $database->deleteSession(session_id());
	}
	
	function checkSession(){
		global $database;
		$sessionID = session_id();
		$userID = $database->lookupSession($sessionID);
		
		if($userID != null){
			$database->updateSession($sessionID,$_SERVER['REQUEST_URI']);
			return true;
		}else {
			return false;
		}
	}

}

$session = new Session();

?>