{include file="header.tpl" title="Voters"}

<section id="main-matter">
	<h1>Voter's Page: {$myvar|default:"Paul"}</h1>
	
	<form name="questions">
	{$i = 1}
		{foreach $questions as $row}
			Q{$i++}: {$row.questionText}
			<br><br>
				<input type="radio" name="A{$row.questionID}" value="1" onclick="document.getElementById('radio_info{$row.questionID}').innerHTML = '1';">Strongly Disagree
				<input type="radio" name="A{$row.questionID}" value="2" onclick="document.getElementById('radio_info{$row.questionID}').innerHTML = '2';">Disagree
				<input type="radio" name="A{$row.questionID}" value="3" onclick="document.getElementById('radio_info{$row.questionID}').innerHTML = '3';">No Opinion
				<input type="radio" name="A{$row.questionID}" value="4" onclick="document.getElementById('radio_info{$row.questionID}').innerHTML = '4';">Agree
				<input type="radio" name="A{$row.questionID}" value="5" onclick="document.getElementById('radio_info{$row.questionID}').innerHTML = '5';">Strongly Agree<br>
				<span style=color:red ID="radio_info{$row.questionID}"></span>
			<br><br>
		{/foreach}
		<input type="submit" value="Submit">
	</form>
</section>

{include file="footer.tpl"}