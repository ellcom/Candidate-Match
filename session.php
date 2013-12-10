<?php
class Session {

	

	function __construct() {
		session_start();
	}
	
	function login($userID) {
		global $database;
		$result = $database->insertSession($userID,session_id());
		
		// Save this stuff in the session as it'll come in useful for page descriptions
		$_SESSION['id'] = $userID;
		$_SESSION['username'] = $result['username'];
		$_SESSION['name'] = $result['name'];
		$_SESSION['email'] = $result['email'];
		$_SESSION['type'] = $result['type'];
	}
	
	function isAdmin() {
		return isset($_SESSION['type']) && $_SESSION['type'] == 'admin';
	}
	
	function isCandidate() {
		return isset($_SESSION['type']) && $_SESSION['type'] == 'candidate';
	}
	
	function logout() {
		global $database;
		$sessionID = session_id();
		session_destroy(); // <-- We don't need this anymore as we'll be out of the session
		return $database->deleteSession($sessionID);
	}
	
	function checkSession() {
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
	
	function isAdmin(){
		global $database;
		$sessionID = session_id();
		$userID = $database->lookupSession($sessionID);
		$user = $database->getUser($userID);
		if ($user['type'] != "admin") {
			return false;
		} else {
			return true;
		}
	}

}

$session = new Session();

?>
