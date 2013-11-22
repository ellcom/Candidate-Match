<?php 

class Database extends PDO {

	function __construct() {
    	try {
    		parent::__construct('mysql:dbname=match;host=localhost', getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    		$this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('DBStatement', array($this)));
		} catch (PDOException $e) {
			throw $e;
		}
	}
	
	function authenticationCredentials($username, $password) {
		$statement = $this->prepare("SELECT * FROM users WHERE username = :username AND password = :password LIMIT 1");
		$statement->bindValue(':username',$username);
		$password = $this->encryptPassword($password);
		$statement->bindValue(':password', $password);
		$statement->execute();
		if($statement->rowCount() == 0){
			return false;
		}else{
				return $statement->fetch(PDO::FETCH_ASSOC);
		}
	}
	
	function addUserToDatabase($username, $password, $type, $active=true) {
	
		$statement = $this->prepare("INSERT INTO `users` (`id`, `username`, `password`, `type`, `active`) VALUES (NULL,:username,:password,:type,:active)");
		$statement->bindParam(':username',$username);
		$password = $this->encryptPassword($password);
		$statement->bindParam(':password',$password);
		$statement->bindParam(':type',$type);
		$statement->bindParam(':active',$active);
		
		return $statement->execute();
	}
	
	function changeUserPassword($username, $password, $newPassword){
		$statement = $this->prepare("UPDATE `users` SET password = :newPassword WHERE username = :username AND password = :password");
		
		$newPassword = $this->encryptPassword($newPassword);
		$password = $this->encryptPassword($password);
		
		$statement->bindParam(':newPassword', $newPassword);
		$statement->bindParam(':username', $username);
		$statement->bindParam(':password', $password);
		
		return $statement->execute();
	}
	
	private function encryptPassword($password){
		return hash("sha256","^7~Q?zÉ".$password);
	}
}

class DBStatement extends PDOStatement {

    public $dbh;

    protected function __construct($dbh) {
        $this->dbh = $dbh;
        $this->setFetchMode(PDO::FETCH_OBJ);
    }
    
    public function foundRows() {
        $rows = $this->dbh->prepare('SELECT found_rows() AS rows', array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => TRUE));
        $rows->execute();
        $rowsCount = $rows->fetch(PDO::FETCH_OBJ)->rows;
        $rows->closeCursor();
        return $rowsCount;
    }
}
?>