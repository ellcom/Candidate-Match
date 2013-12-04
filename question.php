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

?>