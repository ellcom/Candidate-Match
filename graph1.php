<?php 

class Graph1 extends PDO {

	function __construct() {
    	?>
		
		<canvas id="graph1" height="400" width="400"></canvas>

		<!-- The data below here:
			'labels' is the points of the graph, there can be any number I believe, we grab all candidate data from the DB
			'datasets' each element in here is a graph plotted, the only reason we would need more than one is maybe when comparing all candidates to each other
				otherwise we would just use one graph to show a voter's similarity to candidates
			'data' inside 'datasets' are the actual points on the plotted graph, these would be calculated using the similarity algorithms
				(possibly every time a question is answered)
			-->
		<script>
			
			var data = {
				labels : ["Candidate1","Candidate2","Candidate3","Candidate4","Candidate5","Candidate6","Candidate7"],
				datasets : [
					{
						fillColor : "rgba(220,220,220,0.5)",
						strokeColor : "rgba(220,220,220,1)",
						pointColor : "rgba(220,220,220,1)",
						pointStrokeColor : "#fff",
						data : [65,59,90,81,56,55,40]
					},
					{
						fillColor : "rgba(151,187,205,0.5)",
						strokeColor : "rgba(151,187,205,1)",
						pointColor : "rgba(151,187,205,1)",
						pointStrokeColor : "#fff",
						data : [28,48,40,19,96,27,100]
					}
				]
				
			}
			
			var ctx = document.getElementById("graph1").getContext("2d");
			var jGraph1 = new Chart(ctx).Radar(data, {scaleShowLabels : false, pointLabelFontSize : 10});

		</script>
	
		<?php
	}
}