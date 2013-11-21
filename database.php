<?php 

class Database extends PDO {

	function __construct() {
    	parent::__construct('mysql:dbname=match;host=localhost', getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    	$this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('DBStatement', array($this)));
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