<?php

echo '<form>';

foreach ($questionArray as $row) 
{
	// retrieves the specific data rows
	$questionID = $row['id'];
	$questionText = $row['QuestionText'];
	// prints out the data recieved
	echo 'Q'.$questionID.': '.$questionText.'<br><br>';
	echo '	<input type="radio" name="A'.$questionID.'" value="1">Strongly Disagree
			<input type="radio" name="A'.$questionID.'" value="2">Disagree
			<input type="radio" name="A'.$questionID.'" value="3">No Opinion
			<input type="radio" name="A'.$questionID.'" value="4">Agree
			<input type="radio" name="A'.$questionID.'" value="5">Strongly Agree<br><br>';
}

echo '<input type="submit" value="Submit">';
echo '</form>';




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