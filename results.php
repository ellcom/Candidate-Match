<?php
require_once('config.php');
require_once('match.php');

if(isset($_POST['submit']))
{
	$electionID = $_GET["election"];
	$eQuestions = $database->returnElectionQuestionData($electionID);
	$candData = $database->returnDataForCandidates($electionID);
	
	// Spry data
	$data = array();
	foreach($candData as $row)
	{
		$candAnswers = $database->returnElectionAnswerDataForCandidate($row['id']);

		$qArray = array();
		$i = 0;
		foreach($eQuestions as $subrow)
		{
			array_push($qArray, array($subrow['questionID'], $subrow['questionText'], $candAnswers[$i]['answer'], $candAnswers[$i]['justification'], $_POST['A'.$subrow['questionID']]));
			$i++;
		}

		array_push($data, array($row, $qArray));
	}

	$smarty->assign('data', $data);

	// Graph data
	$voterAnswers = array();
	foreach($eQuestions as $row)
	{
		array_push($voterAnswers, array('questionID'=>$row['questionID'], 'answer'=>$_POST['A'.$row['questionID']]));

		// adds the answer as a record to voteranswers in db
		$database->addUserAnswer($row['questionID'], $_POST['A'.$row['questionID']]);
	}

	// match object
	$candidateAnswers = $database->returnCandidateElectionAnswerData($electionID);

	$matchObj = new match($candidateAnswers, $voterAnswers);
	$voterSimilarities = $matchObj->calculateDifferences();

	// change to simple arrays
	$graphNamesPHP = array();
	$graphValsPHP = array();
	foreach($voterSimilarities as $row)
	{
		$candidateInfo = $database->returnDataForCandidate($row['candidateID']);
		array_push($graphNamesPHP, $candidateInfo['name']);
		array_push($graphValsPHP, $row['similarity']);
	}

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
?>