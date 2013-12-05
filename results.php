<?php 
require_once('config.php');
require_once('database.php');
$smarty->display('results.tpl');

?>
<div id="alldiv">
	<div id="allSprysdiv">
<?php

	$data = $database->returnDataForCandidates();
	$size = sizeof($data);

	// for the number of candidates create the set ammount of sprys
	for ($i = 0; $i < $size; $i++)
	{
		$candidateData = $data[$i];
		$name = $candidateData['name'];
		$age = $candidateData['age']; 	
		$gender = $candidateData['gender'];
		$course = $candidateData['course'];
		$website = $candidateData['manifestoLink'];
		$candidateid = $candidateData['id'];

		$questions = $database->returnElectionQuestionData();
		
		// Create candidate name array for the Graph
		$graph_names[$i] = $name;
		
		
		//print_r($candidateData);

		
echo '	<div id="CollapsiblePanel'.$i.'" class="CollapsiblePanel">
			<div class="CollapsiblePanelTab" tabindex="0">
				<div id="name">
					'.$name.'
				</div>
				<div id="rank">
					Ranking '.($i+1).'
				</div>
			</div>
			<div class="CollapsiblePanelContent">
				<div id="top">
					<div id="topLeft">
						<img src="zito.jpg" width="120" height="120"  alt=""/>
					</div>
					<div id="topRight">
						NAME: '. $name.'
						<br/>Age: '.$age.'
						<br/>Gender: '.$gender.'
						<br/>Course: '.$course.'
						<br/>Website: <a href="'.$website.'">Click here for Manifesto</a>
					</div>
				</div>
				<div id="Bottom">
					<div  style="height:118px;width:420spx;border:1px solid #ccc;padding-left:10px;font:16px/26px Georgia, Garamond, Serif;overflow:auto;">';

						$candidatesAnswers = $database->returnElectionAnswerDataForCandidate($i+1);
						$qsize = sizeof($candidatesAnswers);

						for ($j=0; $j < $qsize; $j++)
						{ 
							$questionID = $candidatesAnswers[$j]['questionID'];
							$answer = $candidatesAnswers[$j]['answer'];
							$justification = $candidatesAnswers[$j]['justification'];

							$questionsQuestionID = $questions[$j]['questionID'];

							// checking q's corresponds
							if ($questionID == $questionsQuestionID)
							{
								$questionText = $questions[$j]['questionText'];
							}
							else
							{
								$questionText = 'error';
							}

							echo '<p>Q'.$questionID.': '.$questionText.'?
							<br/>Their answer:<span>'.$answer.'</span>
							<br/>Your Answer: <span>agree</span>
							<br/><span>'.$justification.'</span></p>';
						}
echo '				</div>
				</div>
			</div>
		</div>';
	}
	
	// Convert php arrays into JS arrays for the graph
	$js_graph_names = json_encode($graph_names);
?>

		<!-- trying to implement graph here just for testing -->
		<canvas id="graph1" height="400" width="400"></canvas>

		<script>
			
			var data = {
			labels : <?php echo $js_graph_names; ?>,
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					data : [10,50,25,12,3]
				},
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data : [20,30,40,43,22]
				}
			]
		}
			
			var ctx = document.getElementById("graph1").getContext("2d");
			var jGraph1 = new Chart(ctx).Radar(data);

		</script>
		br>The graph does work, it just looks stupid if there's only 2 candidates
	</div>
</div>

<script type="text/javascript">
var CollapsiblePanel0  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel0",  {contentIsOpen:true});
var CollapsiblePanel1  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1",  {contentIsOpen:false});
var CollapsiblePanel2  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2",  {contentIsOpen:false});
var CollapsiblePanel3  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel3",  {contentIsOpen:false});
var CollapsiblePanel4  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel4",  {contentIsOpen:false});
var CollapsiblePanel5  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel5",  {contentIsOpen:false});
var CollapsiblePanel6  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel6",  {contentIsOpen:false});
var CollapsiblePanel7  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel7",  {contentIsOpen:false});
var CollapsiblePanel8  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel8",  {contentIsOpen:false});
var CollapsiblePanel9  = new Spry.Widget.CollapsiblePanel("CollapsiblePanel9",  {contentIsOpen:false});
var CollapsiblePanel10 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel10", {contentIsOpen:false});
var CollapsiblePanel11 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel11", {contentIsOpen:false});
var CollapsiblePanel12 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel12", {contentIsOpen:false});
var CollapsiblePanel13 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel13", {contentIsOpen:false});
var CollapsiblePanel14 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel14", {contentIsOpen:false});
var CollapsiblePanel15 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel15", {contentIsOpen:false});
var CollapsiblePanel16 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel16", {contentIsOpen:false});
var CollapsiblePanel17 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel17", {contentIsOpen:false});
var CollapsiblePanel18 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel18", {contentIsOpen:false});
var CollapsiblePanel19 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel19", {contentIsOpen:false});
var CollapsiblePanel20 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel20", {contentIsOpen:false});
var CollapsiblePanel21 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel21", {contentIsOpen:false});
var CollapsiblePanel22 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel22", {contentIsOpen:false});
var CollapsiblePanel23 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel23", {contentIsOpen:false});
var CollapsiblePanel24 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel24", {contentIsOpen:false});
var CollapsiblePanel25 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel25", {contentIsOpen:false});
</script>

</body>
</html>
