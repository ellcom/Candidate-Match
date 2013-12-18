{include file="header.tpl" title="Results"}

<script src="http://cdnjs.cloudflare.com/ajax/libs/Chart.js/0.2.0/Chart.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="scripts/resultsGraph.js" type="text/javascript"></script>
<script src="scripts/tabs.js"></script>
<script src="scripts/results.js"></script>

<section id="main-matter">
	<h1>Results Page</h1>

	<div class="clear"></div>
	
	<div class="results">
		<div class="tabContainer">
			<div class="tabs">
				<a href ="#tab1" data-toggle="tab1">Bar</a>
				<a href ="#tab2" data-toggle="tab2">Star</a>
				<a href ="#tab3" data-toggle="tab3">Line</a>
			</div>
			
			<div class="tabContent">  
				<div id="tab1">
					<h5>Bar</h5>
					<canvas id="graph1" height="300" width="300"></canvas>
				</div>
			  
				<div id="tab2">
					<h5>Star</h5>
					<canvas id="graph2" height="300" width="300"></canvas>
				</div>
			  
				<div id="tab3">
					<h5>Line</h5>
					<canvas id="graph3" height="300" width="300"></canvas>
				</div>	  
			</div>
		</div>
		
		<div class="collapsiblePanel">
			
			{$i = 1}
			{foreach $data as $row}
			
			<div class="collapsiblePanelTab" tabindex="0">
				#{$i++}{*print and increment $i*} - {$row.0.name}
			</div>
			
			<div class="collapsiblePanelContent">
				<div class="candidate">
					<div class="candImage">
						<img src="assets/test.jpg" width="120" height="120"  alt=""/>
					</div>
					<div class="candInfo">
						<p>NAME: {$row.0.name}
						<br/>Age: {$row.0.age}
						<br/>Gender: {$row.0.gender}
						<br/>Course: {$row.0.course}
						<br/>Website: <a href="{$row.0.manifestoLink}">Click here for Manifesto</a></p>
					</div>
				</div>

				<div class="qInfo">
					<div class="qComparison">	
						
						{$j = 1}
						{foreach $row.1 as $subrow}
						
						<p>Q{$j++}: {$subrow.1}
						<br/>Their answer: {$subrow.2}
						<br/>Your Answer: {$subrow.4}
						<br/>Justification: {$subrow.3}</p>
						
						{/foreach}
					
					</div>
				</div>
			</div>
			{/foreach}
		</div>
	</div>
	
	<div class="clear"></div>
	
</section>

{include file="footer.tpl"}
