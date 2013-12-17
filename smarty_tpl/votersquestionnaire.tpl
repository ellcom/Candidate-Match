{include file="header.tpl" title="Voters"}

<section id="main-matter">
	<h1>Voter's Page</h1>
	
	<form method="post" id="questions">
		{if isset($message)}
		<span>{$message}</span>
		{/if}
		{$i = 0}
		{foreach $questions as $row}
		<div class="question">
			<label for="Q{$i++}{*Print and Increment $i*}">Q{$i}: {$row.questionText}</label> 
			<br><br>
			<div class="radio">
				<input type="hidden" selected value="0">
				<input type="radio" name="A{$row.questionID}" value="1" id="A{$row.questionID}_1"> <label for="A{$row.questionID}_1">Strongly Disagree</label><br>
				<input type="radio" name="A{$row.questionID}" value="2" id="A{$row.questionID}_2"> <label for="A{$row.questionID}_2">Disagree</label><br>
				<input type="radio" name="A{$row.questionID}" value="3" id="A{$row.questionID}_3"> <label for="A{$row.questionID}_3">No Opinion</label><br>
				<input type="radio" name="A{$row.questionID}" value="4" id="A{$row.questionID}_4"> <label for="A{$row.questionID}_4">Agree</label><br>
				<input type="radio" name="A{$row.questionID}" value="5" id="A{$row.questionID}_5"> <label for="A{$row.questionID}_5">Strongly Agree</label>
			</div>
		</div>
		{/foreach}
		<input type="submit" name="submit" value="Submit">
	</form>
</section>

<script src="./scripts/voters.js" type="text/javascript"></script>

{include file="footer.tpl"}