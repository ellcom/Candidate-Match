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
			return NULL;
		}
		
		return  $statement->fetch(PDO::FETCH_ASSOC);	
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
		
		$statement->execute();
		return ($statement->rowCount() == 1);
	}
	
	private function encryptPassword($password){
		return hash("sha256","^7~Q?zÉ".$password);
	}
	
	
	function insertSession($userID, $sessionID) {
		$statement = $this->prepare("INSERT INTO `sessions` (`id`,`userID`,`sessionID`,`timestamp`,`lastSeen`) VALUES (NULL,:userID,:sessionID,UNIX_TIMESTAMP(),'login.php')");
		$statement->bindParam(':userID',$userID);
		$statement->bindParam(':sessionID',$sessionID);
		 
		$statement->execute();
		if($statement->rowCount() == 0){
			return NULL;
		}
		
		// Return user information.
		$statement = $this->prepare("SELECT username, email, name, type FROM users WHERE id = :id LIMIT 1");
		$statement->bindParam(':id',$userID);
		$statement->execute();
		return $statement->fetch(PDO::FETCH_ASSOC);
	}
	
	function updateSession($sessionID, $lastSeen){
		$statement = $this->prepare("UPDATE `sessions` SET lastSeen = :lastSeen, timestamp = UNIX_TIMESTAMP() WHERE sessionID = :sessionID");
		
		$statement->bindParam(':lastSeen',$lastSeen);
		$statement->bindParam(':sessionID',$sessionID);
		
		return $statement->execute();
	}
	
	function lookupSession($sessionID) {
		$statement = $this->prepare("SELECT 'userID' FROM sessions WHERE sessionID = :sessionID LIMIT 1");
		$statement->bindParam(':sessionID',$sessionID);
		
		$statement->execute();
		return $statement->fetchColumn();
	}
	
	function deleteSession($sessionID) {
		$statement = $this->prepare("DELETE FROM sessions WHERE sessionID = :sessionID LIMIT 1");
		$statement->bindParam(':sessionID',$sessionID);
		
		$statement->execute();
		
		return $statement->rowCount();
	}



	// =======================================================================================
	// ============================ ADDING/UPDATING DATA METHODS =============================
	// =======================================================================================

	// FUNCTION updateAnswer
	// ==================================================
	// updates an existing answer for a candidate in the
	// database.
	private function updateAnswer($input, $questionID, $candidateID) 
	{
		$update_query = $this->prepare("UPDATE candidateanswers SET answer = :input WHERE questionID = :questionID AND candidateID = :candidateID");
		$update_query->bindParam(':input', $input);
		$update_query->bindParam(':questionID', $questionID);
		$update_query->bindParam(':candidateID', $candidateID);

		return $update_query->execute();
	}	
	// ==================================================
	// END FUNCTION updateAnswer


	// FUNCTION addAnswer
	// ==================================================
	// adds a new answer in the database provided one do-
	// es not exist already
	private function addAnswer($input, $questionID, $candidateID) 
	{
		$update_query = $this->prepare("INSERT INTO candidateanswers VALUES (NULL, :questionID, :candidateID, :input, NULL)");
		$update_query->bindParam(':questionID', $questionID);
		$update_query->bindParam(':candidateID', $candidateID);
		$update_query->bindParam(':input', $input);

		return $update_query->execute();
	}
	// ==================================================
	// END FUNCTION addAnswer


	// FUNCTION checkForAnswer
	// ==================================================
	// checks if an answer exists for a candidate in the
	// database. If check_query is returned NULL, there 
	// is no question answer for that candidate.
	private function checkForAnswer($questionID, $candidateID) 
	{
		$check_query = $this->prepare("SELECT candidateID FROM candidateanswers WHERE questionID = :questionID AND candidateID = :candidateID");
		$check_query->bindParam(':questionID', $questionID);
		$check_query->bindParam(':candidateID', $candidateID);

		$check_query->execute();
		$check_query->fetchAll();

		if(sizeof($check_query) == 0)
		{
			$check_query = NULL;
		}

		return $check_query;
	}
	// ==================================================
	// END FUNCTION checkForAnswer


	// FUNCTION insertAnswer
	// ==================================================
	// attempts to add a candidate answer to the database
	// will change the existing answer if one already
	// exists
	function insertAnswer($input, $questionID, $candidateID)
	{
		$present = $this->checkForAnswer($questionID, $candidateID);

		if($present != NULL) // answer already exists, so update it
		{
			$this->updateAnswer($input, $questionID, $candidateID);
		}
		else // answer doesnt exist, so add it.
		{
			$this->addAnswer($input, $questionID, $candidateID);
		}
	}
	// ==================================================
	// END FUNCTION insertAnswer


	// FUNCTION updateDivisiveness
	// ==================================================
	// updates the divisiveness of all questions in db
	function updateDivisiveness()
	{
		$tally = $this->tallyCandidateAnswers();

		print_r($tally);

		foreach ($tally as $question) 
		{			
			// called from stats.php
			$statObj = new stats($question['tally']);
			$divisiveness = $statObj->getDivisiveness();
			$questionID = $question['questionID'];

			$update_query = $this->prepare("UPDATE questions SET divisiveness = :divisiveness WHERE id = :questionID");
			$update_query->bindParam(':divisiveness', $divisiveness);
			$update_query->bindParam(':questionID', $questionID);

			$update_query->execute();
		}
	}
	// ==================================================
	// END FUNCTION updateDivisiveness


	// FUNCTION returnDivisiveness
	// ==================================================
	// attempts to add a candidate answer to the database
	// will change the existing answer if one already
	// exists
	function returnDivisiveness()
	{
		try
		{
			$check_query = $this->prepare("SELECT divisiveness FROM questions");
			$check_query->execute();
		}
		catch (PDOexception $e) // or return an error
		{
			echo 'ERROR (func: returnCandidateData): '.$e->getMessage();
		}

		return $check_query->fetchAll(PDO::FETCH_ASSOC);
	}
	// ==================================================
	// END FUNCTION returnDivisiveness




	// =======================================================================================
	// ============================== RETURNING DATA METHODS =================================
	// =======================================================================================

	// FUNCTION returnDataForCandidate
	// ==================================================
	// returns a associative array containing data about
	// a specific candidateID
	function returnDataForCandidates()
	{
		try // query the database
		{
			$statement = $this->prepare("SELECT candidates.id, candidates.age, candidates.gender, candidates.course, candidates.picture, candidates.manifestoLink, users.name FROM candidates INNER JOIN users ON candidates.userID=users.id ORDER BY candidates.id");
			$statement->execute();
		}
		catch (PDOexception $e) // or return an error
		{
			echo 'ERROR (func: returnCandidateData): '.$e->getMessage();
		}	

		$candidateData = $statement->fetchAll(PDO::FETCH_ASSOC);

		return $candidateData;
	}
	// ==================================================
	// END FUNCTION returnDataForCandidate


	// FUNCTION returnDataForCandidate
	// ==================================================
	// returns a associative array containing data about
	// a specific candidateID
	function returnDataForCandidate($candidateID)
	{
		try // query the database
		{
			$statement = $this->prepare("SELECT candidates.id, candidates.age, candidates.gender, candidates.course, candidates.picture, candidates.manifestoLink, users.name FROM candidates INNER JOIN users ON candidates.userID=users.id  WHERE candidates.id = :candidateID ORDER BY candidates.id");
			$statement->bindParam(':candidateID', $candidateID);
			$statement->execute();
		}
		catch (PDOexception $e) // or return an error
		{
			echo 'ERROR (func: returnDataForCandidate): '.$e->getMessage();
		}	

		$candidateData = $statement->fetch(PDO::FETCH_ASSOC);

		return $candidateData;
	}
	// ==================================================
	// END FUNCTION returnDataForCandidate


	// FUNCTION returnQuestionData
	// ==================================================
	// returns a associative array containing all q's
	// from the db for printing out.
	function returnQuestionData() 
	{
		try // query the database
		{
			$statement = $this->prepare("SELECT id, QuestionText FROM questions ORDER BY id ASC");
			$statement->execute();
		}
		catch (PDOexception $e) // or return an error
		{
			echo 'ERROR (func: returnQuestionData): '.$e->getMessage();
		}		

		// return data as an associative array
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	// ==================================================
	// END FUNCTION returnQuestionData


	// FUNCTION returnElectionQuestionData
	// ==================================================
	// returns a associative array containing the chosen
	// q's (most divisive) from the db for printing out.
	function returnElectionQuestionData() 
	{
		try // query the database
		{
			$statement = $this->prepare("SELECT electionquestions.questionID, questions.questionText FROM questions INNER JOIN electionquestions ON questions.id=electionquestions.questionID ORDER BY electionquestions.questionID ASC");
			$statement->execute();
		}
		catch (PDOexception $e) // or return an error
		{
			echo 'ERROR (func: returnElectionQuestionData): '.$e->getMessage();
		}		

		// return data as an associative array
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	// ==================================================
	// END FUNCTION returnElectionQuestionData


	// FUNCTION returnAnswerDataForCandidate
	// ==================================================
	// Given an array of candidateID's
	// returns a 2D array containing the candidateID and
	// the candidates answer set for the questions.
	function returnAnswerDataForCandidate($candidateID)
	{
		try // query the database
		{
			$statement = $this->prepare("SELECT questionID, answer FROM candidateanswers WHERE candidateID = :candidateID ORDER BY id");
			$statement->bindParam('candidateID', $candidateID);
			$statement->execute();
		}
		catch (PDOexception $e) // or return an error
		{
			echo 'ERROR (func: returnCandidateAnswerData): '.$e->getMessage();
		}		

		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	// ==================================================
	// END FUNCTION returnAnswerDataForCandidate


	// FUNCTION returnAnswerDataForCandidate
	// ==================================================
	// Given an array of candidateID's
	// returns a 2D array containing the candidateID and
	// the candidates answer set for the questions.
	function returnElectionAnswerDataForCandidate($candidateID)
	{
		try // query the database
		{
			$statement = $this->prepare("SELECT candidateanswers.questionID, candidateanswers.answer, candidateanswers.justification FROM candidateanswers INNER JOIN electionquestions ON candidateanswers.questionID=electionquestions.questionID WHERE candidateanswers.candidateID = :candidateID ORDER BY id");
			$statement->bindParam('candidateID', $candidateID);
			$statement->execute();
		}
		catch (PDOexception $e) // or return an error
		{
			echo 'ERROR (func: returnCandidateAnswerData): '.$e->getMessage();
		}		

		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	// ==================================================
	// END FUNCTION returnAnswerDataForCandidate


	// FUNCTION returnCandidateAnswerData
	// ==================================================
	// returns a associative array containing all candid-
	// ate answers from the database.
	function returnCandidateAnswerData() 
	{
		try // query the database
		{
			$statement = $this->prepare("SELECT questionID, candidateID, answer FROM candidateanswers ORDER BY candidateID ASC, questionID ASC");
			$statement->execute();
		}
		catch (PDOexception $e) // or return an error
		{
			echo 'ERROR (func: returnCandidateAnswerData): '.$e->getMessage();
		}		

		// return data as an associative array
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	// ==================================================
	// END FUNCTION returnCandidateAnswerData


	// FUNCTION returnCandidateElectionAnswerData
	// ==================================================
	// returns a associative array containing all candid-
	// ate answers from the database.
	function returnCandidateElectionAnswerData() 
	{
		try // query the database
		{
			$statement = $this->prepare("SELECT candidateanswers.questionID, candidateanswers.candidateID, candidateanswers.answer FROM candidateanswers INNER JOIN electionquestions ON candidateanswers.questionID=electionquestions.questionID ORDER BY candidateID ASC, questionID ASC");
			$statement->execute();
		}
		catch (PDOexception $e) // or return an error
		{
			echo 'ERROR (func: returnCandidateAnswerData): '.$e->getMessage();
		}		

		// return data as an associative array
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	// ==================================================
	// END FUNCTION returnCandidateElectionAnswerData


	// FUNCTION returnCandidateAnswerDataForQuestion
	// ==================================================
	// returns a associative array containing all candid-
	// ate answers for one question from the database.
	function returnCandidateAnswerDataForQuestion($questionID) 
	{
		try // query the database
		{
			$statement = $this->prepare("SELECT candidateID, answer FROM candidateanswers WHERE questionID = :questionID ORDER BY candidateID ASC");
			$statement->bindParam(':questionID', $questionID);
			$statement->execute();
		}
		catch (PDOexception $e) // or return an error
		{
			echo 'ERROR (func: returnCandidateAnswerData): '.$e->getMessage();
		}		

		// return data as an associative array
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	// ==================================================
	// END FUNCTION returnCandidateAnswerDataForQuestion





	// =======================================================================================
	// ================================ MORE ADVANCED METHODS ================================
	// =======================================================================================

	// FUNCTION tallyCandidateAnswers
	// ==================================================
	// returns an associative array containing candidate
	// answer tallies for each question. For use in 
	// calculating the divisiveness of a question.
	function tallyCandidateAnswers()
	{
		$candidateAnswerData;

		// obtain data from the database
		foreach ($this->returnCandidateAnswerData() as $row) 
		{
			// store each row in new array
			$candidateAnswerData[] = $row;
		}

		// variable to store the tally as an array
		$candidateAnswerTally = NULL;

		// for each candidateAnswer record
		for ($i=0; $i < sizeof($candidateAnswerData); $i++) 
		{ 
			// determine if an array exists for the question already - if not, add one
			if ($candidateAnswerTally == NULL)
			{
				//echo 'Question not in tally yet - adding Q to tally<br>';
				$candidateAnswerTally[] = array('questionID'=> $candidateAnswerData[$i]['questionID'], 'tally'=>array(0,0,0,0,0)); 
			}
			else
			{
				// check if the value exists within the tally already
 				for ($j=0; $j < sizeof($candidateAnswerTally); $j++) { 
					if ($candidateAnswerData[$i]['questionID'] == $candidateAnswerTally[$j]['questionID'])
					{
						$found = true;
						break;
					}
					else // not found yet
					{
						$found = false;
					}
				}
				// if it isn't, generate a new array to store the information
				if ($found == false)
				{
					//echo 'Question not in tally yet - adding Q to tally<br>';
					$candidateAnswerTally[] = array('questionID'=>$candidateAnswerData[$i]['questionID'], 'tally'=>array(0,0,0,0,0)); 
				}
			}

			// adjust the according tally
			for ($j=0; $j < sizeof($candidateAnswerTally) ; $j++) { 
				if ($candidateAnswerTally[$j]['questionID'] == $candidateAnswerData[$i]['questionID'])
				{
					$array_slot = $candidateAnswerData[$i]['answer']-1;
					// add one to the appropriate tally slot.
					$candidateAnswerTally[$j]['tally'][$array_slot]++;
				}			
			}
		}
		return $candidateAnswerTally;
	}
	// ==================================================
	// END FUNCTION tallyCandidateAnswers


	// FUNCTION returnAnswerDataComparison
	// ==================================================
	// Given an array of candidateID's
	// returns a 2D array containing the candidateID and
	// the candidates answer set for the questions.
	function returnAnswerDataComparison($candidateIDs)
	{
		$comparisonArray;

		// obtain data from the database
		foreach ($this->returnCandidateAnswerData() as $row) 
		{
			// store each row in new array
			$candidateAnswerData[] = $row;
		}

		// set up the structure for id's
		foreach ($candidateIDs as $id) 
		{
			$comparisonArray[] = array('candidateID'=>$id, 'answers'=>array());
		}

		// add in the answers in ascending question order
		foreach ($candidateAnswerData as $row)
		{
			for ($i=0; $i < sizeof($comparisonArray); $i++) 
			{ 
				if ($comparisonArray[$i]['candidateID'] == $row['candidateID']) 
				{
					$comparisonArray[$i]['answers'][] = $row['answer']; 
				}
			}
		}

		return $comparisonArray;
	}
	// ==================================================
	// END FUNCTION returnAnswerDataComparison


	// FUNCTION compareUserAnswerToCandidates
	// ==================================================
	// returns an array containing the differences betw-
	// een a users answer and all candidate answers for a
	// given question.
	function compareUserAnswerToCandidates($userAnswer, $questionID)
	{
		$candidateAnswers = $this->returnCandidateAnswerDataForQuestion($questionID);

		foreach ($candidateAnswers as $row) 
		{
			$differences[] = abs($userAnswer - $row['answer']);
		}

		return $differences;
	}
	// ==================================================
	// END FUNCTION compareUserAnswerToCandidates

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