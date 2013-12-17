{include file="header.tpl" title="Results"}

<script src="http://cdnjs.cloudflare.com/ajax/libs/Chart.js/0.2.0/Chart.min.js" type="text/javascript"></script>
<script src="scripts/resultsGraph.js" type="text/javascript"></script>
<script src="scripts/tabs.js"></script>

<section id="main-matter">
	<h1>Results Page</h1>
	
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
		
		<div class="collapsiblePanelContainer">
		
			{$i = -1}
			{foreach $data as $row}
			
			<div class="CollapsiblePanel" id="CollapsiblePanel{$i++}{*print and increment $i*}">
				
				<div class="CollapsiblePanelTab" tabindex="0">
					{$row.0.name}
					#{i+1}{*Ranking*}
				</div>
				
				<div class="CollapsiblePanelContent">
					<div id="candidate">
						<div id="candImage">
							<img src="{$row.0.picture}" width="120" height="120"  alt=""/>
						</div>
						<div id="candInfo">
							NAME: {$row.0.name}
							<br/>Age: {$row.0.age}
							<br/>Gender: {$row.0.gender}
							<br/>Course: {$row.0.course}
							<br/>Website: <a href="{$row.0.manifestoLink}">Click here for Manifesto</a>
						</div>
					</div>
	
					<div id="Bottom">
						<div  id="qComparison">	
							{$j = 1}
							{foreach $row.1 as $subrow}
							<p>Q{$j++}: {$subrow.1}
							<br/>Their answer:<span>{$subrow.2}</span>
							<br/>Your Answer: <span>{$subrow.4}</span>
							<br/><span>{$subrow.3}</span></p>
							{/foreach}
						</div>
					</div>
				</div>
			</div>
			
			{/foreach}
			
		</div>
	</div>
	
</section>

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

{include file="footer.tpl"}
