<?php
class Session {

	

	function __construct() {
		session_cache_limiter('private');
		session_cache_expire(30);
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
		$this->cookieEater();
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
			$this->cookieEater();
			return false;
		}
	}

	function cookieEater() {
		if (isset($_SERVER['HTTP_COOKIE'])) {
		    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		    foreach($cookies as $cookie) {
		        $parts = explode('=', $cookie);
		        $name = trim($parts[0]);
		        setcookie($name, '', time()-1000);
		        setcookie($name, '', time()-1000, '/');
		    }
		}
	}
}

$session = new Session();

?>
