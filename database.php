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
	
	//
	// AUTHENTICATION & USER SECTION
	//
	
	
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
	
	function addUserToDatabase($username, $password, $email, $name, $type, $active=true) {
		
		$statement = $this->prepare("SELECT * FROM `users` WHERE username = :username LIMIT 1");
		$statement->bindParam(':username',$username);
		$statement->execute();
		if($statement->rowCount() ==1){
			return false;
			// User already Exists
		}
			
		$statement = $this->prepare("INSERT INTO `users` (`id`, `username`, `password`, `email`, `name`, `type`, `active`) VALUES (NULL,:username,:password,:email,:name,:type,:active)");
		$statement->bindParam(':username',$username);
		$password = $this->encryptPassword($password);
		$statement->bindParam(':password',$password);
		$statement->bindParam(':type',$type);
		$statement->bindParam(':email',$email);
		$statement->bindParam(':name',$name);
		$statement->bindParam(':active',$active);
		
		return $statement->execute();
	}
	
	function changeMyPassword($id, $password, $newPassword){
		$statement = $this->prepare("UPDATE `users` SET password = :newPassword WHERE id = :id AND password = :password");
		
		$newPassword = $this->encryptPassword($newPassword);
		$password = $this->encryptPassword($password);
		
		$statement->bindParam(':newPassword', $newPassword);
		$statement->bindParam(':id', $id);
		$statement->bindParam(':password', $password);
		
		$statement->execute();
		return ($statement->rowCount() == 1);
	}
	
	function changeUserPassword($id, $password) {
		$statement = $this->prepare("UPDATE `users` SET password = :password WHERE id = :id");
		
		$password = $this->encryptPassword($password);
		
		$statement->bindParam(':id', $id);
		$statement->bindParam(':password', $password);
		
		$statement->execute();
		return ($statement->rowCount() == 1);
	}
	
	
	
	private function encryptPassword($password){
		return hash("sha256","^7~Q?zÉ".$password);
	}
	
	function listUsers() {
		$query = $this->query("SELECT id, username, email, name, type, active FROM users");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function setActive($ids,$active){
		$statement = $this->prepare("UPDATE `users` SET active = :active WHERE id = :id");
		$statement->bindParam(':active', $active);
		
		foreach ($ids as $id) {
			$statement->bindParam(':id',$id);
			$statement->execute();
		}
	}
	
	function getUser($id) {
		$statement = $this->prepare("SELECT id, username, email, name, type, active FROM users WHERE id = :id LIMIT 1");
		$statement->bindParam(':id',$id);
		$statement->execute();
		
		if($statement->rowCount() == 0){
			return NULL;
		}
		return $statement->fetch(PDO::FETCH_ASSOC);
	}
	
	function getUserTypes() {
		$query = $this->query("SELECT name FROM usertypes");
		return $query->fetchAll(PDO::FETCH_COLUMN);
	}
	
	function deleteUsers($ids) {
		$statement = $this->prepare("DELETE FROM `users` WHERE id = :id");
		
		foreach ($ids as $id) {
			$statement->bindParam(':id',$id);
			$statement->execute();
		}
	}
	
	function changeUserAttribute($id, $attr, $value, $locked=false){
		// Theres another function for that
		if($attr == 'password'){
			echo "ERROR:: USE Database::changeUserPassword(id, newPasswordPlainText);";
			return false;
		}
		// This is used to stop people having the same username for example.
		if($locked){
			$statement = $this->prepare("SELECT $attr FROM `users` WHERE id != :id and $attr = :value");
			$statement->bindParam(':id',$id);
			$statement->bindParam(':value',$value);
			$statement->execute();
			if($statement->rowCount() != 0) {
				return false;
			}
		}
		
		$statement = $this->prepare("UPDATE `users` SET $attr = :value WHERE id = :id LIMIT 1");
		$statement->bindParam(':id',$id);
		$statement->bindParam(':value',$value);
		$statement->execute();
		
		return ($statement->rowCount() == 1);
	}
	
	//
	// SESSION SECTION
	//
	
	function insertSession($userID, $sessionID) {
		$statement = $this->prepare("DELETE FROM `sessions` WHERE userID = :userID");
		$statement->bindParam(':userID',$userID);
		$statement->execute();
		
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

	//
	// Create / Modifiy Elections
	//
	function createElection($name, $endTimestamp,$active=true) {
		
		$statement = $this->prepare("SELECT * FROM `elections` WHERE name = :name LIMIT 1");
		$statement->bindParam(':name', $name);
		$statement->execute();
		
		if($statement->rowCount() == 1){
			return false;
		}
		
		
		$statement = $this->prepare("INSERT INTO `elections` (`name`,`timestamp`,`end_timestamp`,`active`) VALUES (:name,unix_timestamp(),:end_timestamp,:active)");
		$statement->bindParam(':name', $name);
		$statement->bindParam(':end_timestamp', $endTimestamp);
		$statement->bindParam(':active', $active);
		
		return $statement->execute();
	}
	
	function listElections() {
		$query = $this->query("SELECT * FROM `elections`");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function lookupElectionWithId($id) {
		$statement = $this->prepare("SELECT * FROM `elections` WHERE id = :id LIMIT 1");
		$statement->bindParam(':id',$id);
		$statement->execute();
		
		return $statement->fetch(PDO::FETCH_ASSOC);
	}
	
	function candidatesForElectionID($id) {
		$statement = $this->prepare(	"SELECT c.id as cid, u.id as uid, u.name as name, c.age as age, c.gender as gender, c.course as course, c.picture as picture, c.manifestoLink as link 
										FROM `candidates` as c JOIN `users` as u ON c.userID = u.id 
										WHERE c.electionID = :id;");
										
		$statement->bindParam(':id',$id);
		$statement->execute();
		
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	// Active: election that has not reached its end timestamp
	function getActiveElection() {
		$query = $this->prepare("SELECT * FROM `elections` WHERE end_timestamp > :timestamp;");
		$date = new DateTime();
		$timestamp = $date->getTimestamp();
		$query->bindParam(':timestamp',$timestamp);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	
	// Live: election that has passed its start timestamp and not reached its end timestamp
	function getLiveElection() {
		$query = $this->prepare("SELECT * FROM `elections` WHERE end_timestamp > :timestamp AND timestamp < :timestamp;");
		$date = new DateTime();
		$timestamp = $date->getTimestamp();
		$query->bindParam(':timestamp',$timestamp);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
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
		$add_query = $this->prepare("INSERT INTO candidateanswers VALUES (NULL, :questionID, :candidateID, :input, NULL)");
		$add_query->bindParam(':questionID', $questionID);
		$add_query->bindParam(':candidateID', $candidateID);
		$add_query->bindParam(':input', $input);

		return $add_query->execute();
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
	function addUserAnswer($questionID, $answer)
	{
		$check_query = $this->prepare("SELECT * FROM voteranswers WHERE questionID = :questionID AND answer = :answer");
		$check_query->bindParam(':questionID', $questionID);
		$check_query->bindParam(':answer', $answer);

		$check_query->execute();
		$result = $check_query->fetch(PDO::FETCH_ASSOC);
		
		if(sizeof($result) == 0)
		{
			$result = NULL;
		}

		if ($result == NULL) // add one
		{
			$add_query = $this->prepare("INSERT INTO voteranswers VALUES (NULL, :questionID, :answer, 1)");
			$add_query->bindParam(':questionID', $questionID);
			$add_query->bindParam(':answer', $answer);

			$add_query->execute();

			//echo "about to add<br>";
		}
		else // update one
		{
			//echo "<br>about to update: ";
			//print_r($result);

			$count = $result['count']+1;

			$update_query = $this->prepare("UPDATE voteranswers SET count = :count WHERE questionID = :questionID AND answer = :answer");
			$update_query->bindParam(':count', $count);
			$update_query->bindParam(':questionID', $questionID);
			$update_query->bindParam(':answer', $answer);

			$update_query->execute();
		}
		//echo "<br><br>";
	}

	// ==================================================
	// END FUNCTION insertAnswer


	// FUNCTION updateDivisiveness
	// ==================================================
	// updates the divisiveness of all questions in db
	function updateDivisiveness($electionID)
	{
		$tally = $this->tallyCandidateAnswers($electionID);

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
	function returnDivisiveness($electionID)
	{
		try
		{
			$check_query = $this->prepare("SELECT id, divisiveness, electionID FROM questions WHERE electionID = :electionID");
			$check_query->bindParam('electionID', $electionID);
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

	// FUNCTION getCandidateIDForUser
	// ==================================================
	// returns a associative array containing data about
	// a specific candidateID
	function getCandidateIDForUser($userID)
	{
		try // query the database
		{
			$statement = $this->prepare("SELECT c.id FROM candidates AS c INNER JOIN users AS u ON c.userID = u.id WHERE u.id = :userID");
			$statement->bindParam(':userID', $userID);
			$statement->execute();
		}
		catch (PDOexception $e) // or return an error
		{
			echo 'ERROR (func: returnCandidateData): '.$e->getMessage();
		}	

		$result = $statement->fetch(PDO::FETCH_ASSOC);

		$candidateID = $result['id'];

		return $candidateID;
	}
	// ==================================================
	// END FUNCTION getCandidateIDForUser


	// FUNCTION returnDataForCandidate
	// ==================================================
	// returns a associative array containing data about
	// a specific candidateID
	function returnDataForCandidates($electionID)
	{
		try // query the database
		{
			$statement = $this->prepare("SELECT c.id, c.age, c.gender, c.course, c.picture, c.manifestoLink, u.name FROM candidates AS c INNER JOIN users AS u ON c.userID = u.id WHERE c.electionID = :electionID ORDER BY c.id");
			$statement->bindParam(':electionID', $electionID);
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
			$statement = $this->prepare("SELECT c.id, c.electionID, c.age, c.gender, c.course, c.picture, c.manifestoLink, u.name FROM candidates AS c INNER JOIN users AS u ON c.userID = u.id WHERE c.id = :candidateID ORDER BY c.id");
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
			$statement = $this->prepare("SELECT id, questionText FROM questions ORDER BY id ASC");
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
	function returnElectionQuestionData($electionID) 
	{
		try // query the database
		{
			$statement = $this->prepare("SELECT eq.questionID, q.questionText FROM questions AS q INNER JOIN electionquestions AS eq ON q.id = eq.questionID WHERE q.electionID = :electionID ORDER BY eq.questionID");
			$statement->bindParam(':electionID', $electionID);
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
			$statement = $this->prepare("SELECT questionID, answer, justification FROM candidateanswers WHERE candidateID = :candidateID ORDER BY id");
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
			$statement = $this->prepare("SELECT candidateanswers.questionID, candidateanswers.answer, candidateanswers.justification FROM candidateanswers INNER JOIN electionquestions ON candidateanswers.questionID=electionquestions.questionID WHERE candidateanswers.candidateID = :candidateID ORDER BY electionquestions.questionID");
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
	function returnCandidateAnswerData($electionID) 
	{
		try // query the database
		{
			$statement = $this->prepare("SELECT c.questionID, c.candidateID, c.answer FROM candidateanswers AS c ORDER BY c.candidateID ASC, c.questionID ASC");
			$statement->execute();
		}
		catch (PDOexception $e) // or return an error
		{
			echo 'ERROR (func: returnCandidateAnswerData): '.$e->getMessage();
		}		

		// return data as an associative array
		$allData = $statement->fetchAll(PDO::FETCH_ASSOC);
		$candidateAnswerData = NULL;

		foreach ($allData as $row) 
		{
			$qID = $row['questionID'];

			$check_query = $this->prepare("SELECT id, divisiveness, electionID FROM questions WHERE electionID = :electionID AND id = :qID");
			$check_query->bindParam(':electionID', $electionID);
			$check_query->bindParam(':qID', $qID);
			$check_query->execute();

			$result = $check_query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($result as $question) {
				if ($question['electionID'] == $electionID) {
					// store each row in new array
					$candidateAnswerData[] = $row;
				}
			}
		}

		return $candidateAnswerData;
	}
	// ==================================================
	// END FUNCTION returnCandidateAnswerData


	// FUNCTION returnCandidateElectionAnswerData
	// ==================================================
	// returns a associative array containing all candid-
	// ate answers from the database.
	function returnCandidateElectionAnswerData($electionID) 
	{
		try // query the database
		{
			$statement = $this->prepare("SELECT candidateanswers.questionID, candidateanswers.candidateID, candidateanswers.answer FROM candidateanswers INNER JOIN electionquestions ON candidateanswers.questionID=electionquestions.questionID ORDER BY candidateID ASC, questionID ASC");
			$statement->execute();
		}
		catch (PDOexception $e) // or return an error
		{
			echo 'ERROR (func: returnCandidateElectionAnswerData): '.$e->getMessage();
		}		

		// return data as an associative array
		$allData = $statement->fetchAll(PDO::FETCH_ASSOC);
		$candidateElectionAnswerData = NULL;

		foreach ($allData as $row) 
		{
			$qID = $row['questionID'];

			$check_query = $this->prepare("SELECT id, divisiveness, electionID FROM questions WHERE electionID = :electionID AND id = :qID");
			$check_query->bindParam(':electionID', $electionID);
			$check_query->bindParam(':qID', $qID);
			$check_query->execute();

			$result = $check_query->fetchAll(PDO::FETCH_ASSOC);

			foreach ($result as $question) {
				if ($question['electionID'] == $electionID) {
					// store each row in new array
					$candidateElectionAnswerData[] = $row;
				}
			}
		}

		return $candidateElectionAnswerData;
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
	function tallyCandidateAnswers($electionID)
	{
		$candidateAnswerData = $this->returnCandidateAnswerData($electionID);

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
	function returnAnswerDataComparison($electionID, $candidateIDs)
	{
		$comparisonArray;

		// obtain data from the database
		foreach ($this->returnCandidateAnswerData($electionID) as $row) 
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


	// FUNCTION selectElectionQuestions
	// ==================================================
	// chooses the most divisive questions to use in the
	// election
	function selectElectionQuestions($electionID)
	{
		$questions = $this->returnDivisiveness($electionID);

		function divisiveness_sort($a, $b)
		{
			return $a['divisiveness']>$b['divisiveness'];
		}

		usort($questions, 'divisiveness_sort');

		print_r($questions);

		foreach ($questions as $row) 
		{
			$questionID = $row['id'];

			$check_query = $this->prepare("SELECT questionID FROM electionquestions WHERE questionID = :questionID");
			$check_query->bindParam(':questionID', $questionID);
			$check_query->execute();
			$result = $check_query->fetchAll(PDO::FETCH_ASSOC);

			$size_query = $this->prepare("SELECT * FROM electionquestions");
			$size_query->execute();
			$size = sizeof($size_query->fetchAll(PDO::FETCH_ASSOC));

			// WILL BE 20 IN FINAL VERSION
			if ($size >= 10) 
			{
				break;
			}

			if (sizeof($result) == 0)
			{
				$result = NULL;
			}

			if ($result == NULL)
			{
				//echo 'adding<br>';
				$questionID = $row['id'];
				$electionID = $row['electionID'];

				$add_query = $this->prepare("INSERT INTO electionquestions VALUES (NULL, :electionID, :questionID)");
				$add_query->bindParam(':electionID', $electionID);
				$add_query->bindParam(':questionID', $questionID);
				$add_query->execute();
			}
			else
			{
				//echo 'already present<br>';
			}
		}
	}
	// ==================================================
	// END FUNCTION selectElectionQuestions
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