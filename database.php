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
	
	function authenticationCredentials($user, $password) {
		$statement = $this->prepare("SELECT * FROM users WHERE username = :username AND password = :password LIMIT 1");
		$statement->bindValue(':username',$user);
		$hashedPassword = hash("sha256","^7~Q?zÉ".$password);
		$statement->bindValue(':password', $hashedPassword);
		$statement->execute();
		if($statement->rowCount() == 0){
			return false;
		}else{
			return $statement->fetch(PDO::FETCH_ASSOC);
		}
	}
}

class DBStatement extends PDOStatement{
    public $dbh;

    protected function __construct($dbh){
        $this->dbh = $dbh;
        $this->setFetchMode(PDO::FETCH_OBJ);
    }
    
    public function foundRows(){
        $rows = $this->dbh->prepare('SELECT found_rows() AS rows', array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => TRUE));
        $rows->execute();
        $rowsCount = $rows->fetch(PDO::FETCH_OBJ)->rows;
        $rows->closeCursor();
        return $rowsCount;
    }
}
?>