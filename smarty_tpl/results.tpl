{include file="header.tpl" title="Results"}

<script src="http://cdnjs.cloudflare.com/ajax/libs/Chart.js/0.2.0/Chart.min.js" type="text/javascript"></script>
<script src="scripts/resultsGraph.js" type="text/javascript"></script>
<script src="scripts/tabs.js"></script>

<section id="main-matter">
	<h1>Results Page</h1>
	
	<div class="tabs">
		<a href ="#tab1" data-toggle="tab1">Bar</a>
		<a href ="#tab2" data-toggle="tab2">Star</a>
		<a href ="#tab3" data-toggle="tab3">Line</a>
	</div>
	
	<div class="tabContent">  
		<div id="tab1">
			<h5>Bar</h5>
			<canvas id="graph1" height="400" width="400"></canvas>
		</div>
	  
		<div id="tab2">
			<h5>Star</h5>
			<canvas id="graph2" height="400" width="400"></canvas>
		</div>
	  
		<div id="tab3">
			<h5>Line</h5>
			<canvas id="graph3" height="400" width="400"></canvas>
		</div>	  
	</div>
</section>

{include file="footer.tpl"}
