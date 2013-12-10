<?php 
require_once('config.php');

$questions = $database->returnElectionQuestionData();

$smarty->assign('questions', $questions);
$smarty->display("voters.tpl");

// ===== ADDING TO THE DB ======
// adding new candidate answers to the database 
// check opinion has been set and is not empty.
foreach ($questionArray as $row) 
{
	$questionID = $row['id'];

	if (isset($_GET['A'.$questionID.'']) && !empty($_GET['A'.$questionID.'']))
	{
		// retrieve the value from the HTML radio button 'opinion'
		$input = $_GET['A'.$questionID.''];
		
		// check opinion parameter within bounds (stop some injection)
		if($input > 0 && $input <= 5)
		{
			echo ''.$questionID.' Radio button '.$input.' selected.<br>';
			
			// candidate id should be obtained from session/login
			// 1 IS HERE AS A PLACEHOLDER
			$database->insertAnswer($input, $questionID, 1);
		}
		else
		{
			echo 'ERROR (testAdd): incorrect opinion parameter<br>';
		}
	}
}
?>