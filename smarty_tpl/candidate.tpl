<p>Candidate Page</p>

<form method="post" id="questions">
	{if isset($message)}
	<span>{$message}</span>
	{/if}
	{$i = 0}
	{foreach $questions as $row}
		<label for="Q{$i++}">Q{$i}: {$row.questionText}</label> 
		<br><br>
			<input type="radio" name="A{$row.questionID}" value="1"><label>Strongly Disagree</label>
			<input type="radio" name="A{$row.questionID}" value="2"><label>Disagree</label>
			<input type="radio" name="A{$row.questionID}" value="3"><label>No Opinion</label>
			<input type="radio" name="A{$row.questionID}" value="4"><label>Agree</label>
			<input type="radio" name="A{$row.questionID}" value="5"><label>Strongly Agree</label><br>
		<br><br>
	{/foreach}
	<input type="submit" name="submit" value="Submit" onclick="">
</form>
