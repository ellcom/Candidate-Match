<?php 
require_once('config.php');
require_once('match.php');

$electionID = $database->getActiveElection();
$questions = $database->returnElectionQuestionData($electionID['0']['id']);
$smarty->assign('questions', $questions);

if(isset($_POST['submit']))
{
	$voterAnswers = array();
	foreach($questions as $row)
	{
		array_push($voterAnswers, array('questionID'=>$row['questionID'], 'answer'=>$_POST['A'.$row['questionID']]));

		// adds the answer as a record to voteranswers in db
		$database->addUserAnswer($row['questionID'], $_POST['A'.$row['questionID']]);
	}
	print_r($voterAnswers);
	echo '<br><br>';

	// match object
	$candidateAnswers = $database->returnCandidateElectionAnswerData($electionID['0']['id']);

	$matchObj = new match($candidateAnswers, $voterAnswers);
	$voterSimilarities = $matchObj->calculateDifferences();

	print_r($voterSimilarities);
	
	// change to simple arrays
	$graphNamesPHP = array();
	$graphValsPHP = array();
	foreach($voterSimilarities as $row)
	{
		$candidateInfo = $database->returnDataForCandidate($electionID['0']['id'], $row['candidateID']);
		print_r($candidateInfo);
		array_push($graphNamesPHP, $candidateInfo['name']);
		array_push($graphValsPHP, $row['similarity']);
	}
	print_r($graphNamesPHP);
	print_r($graphValsPHP);
	
	// convert to JSON arrays
	$graphNamesJS = json_encode($graphNamesPHP);
	$graphValsJS = json_encode($graphValsPHP);
	
	$smarty->display('results.tpl');
	
	// generate graph
	?>
	<script>
		var data =
		{
			labels : <?php echo $graphNamesJS; ?>,
			datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				data : <?php echo $graphValsJS ?>
			}
			]
		}
		var ctx1 = document.getElementById("graph1").getContext("2d");
		var jGraph1 = new Chart(ctx1).Bar(data);
		
		var ctx2 = document.getElementById("graph2").getContext("2d");
		var jGraph2 = new Chart(ctx2).Radar(data);
		
		var ctx3 = document.getElementById("graph3").getContext("2d");
		var jGraph3 = new Chart(ctx3).Line(data);
	</script>
	<?php

	
}
else
{
	$smarty->display('voters.tpl');
}
?>