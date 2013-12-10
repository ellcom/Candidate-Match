{include file="header.tpl" title="Voters"}

<section id="main-matter">
	<h1>Voter's Page</h1>
	
	<form method="post" id="questions">
	{if isset($message)}
	<span>{$message}</span>
	{/if}
	{$i = 0}
	{foreach $questions as $row}
		<label for="Q{$i++}">Q{$i}: {$row.questionText}</label> 
		<br><br>
			<input type="radio" name="A{$row.questionID}" value="1" onclick="document.getElementById('radio_info{$row.questionID}').innerHTML = '1';"><label>Strongly Disagree</label>
			<input type="radio" name="A{$row.questionID}" value="2" onclick="document.getElementById('radio_info{$row.questionID}').innerHTML = '2';"><label>Disagree</label>
			<input type="radio" name="A{$row.questionID}" value="3" onclick="document.getElementById('radio_info{$row.questionID}').innerHTML = '3';"><label>No Opinion</label>
			<input type="radio" name="A{$row.questionID}" value="4" onclick="document.getElementById('radio_info{$row.questionID}').innerHTML = '4';"><label>Agree</label>
			<input type="radio" name="A{$row.questionID}" value="5" onclick="document.getElementById('radio_info{$row.questionID}').innerHTML = '5';"><label>Strongly Agree</label><br>
			<span style=color:red ID="radio_info{$row.questionID}"></span>
		<br><br>
	{/foreach}
	<input type="submit" name="submit" value="Submit">
	</form>
</section>

{include file="footer.tpl"}