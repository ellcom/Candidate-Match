{include file="header.tpl" title="Admin"}

<section id="main-matter">

	<h1>Hello {$session.name|default:"John Doe"}</h1>

	<h2>Candidate Questionnaire</h2>

	<form method="post" id="questions">
		{if isset($message)}
		<span>{$message}</span>
		{/if}
		{$i = 0}
		{foreach $questions as $row}
			<label for="Q{$i++}">Q{$i}: {$row.questionText}</label> 
			<br><br>
				<input type="radio" name="A{$row.id}" value="1"><label>Strongly Disagree</label>
				<input type="radio" name="A{$row.id}" value="2"><label>Disagree</label>
				<input type="radio" name="A{$row.id}" value="3"><label>No Opinion</label>
				<input type="radio" name="A{$row.id}" value="4"><label>Agree</label>
				<input type="radio" name="A{$row.id}" value="5"><label>Strongly Agree</label><br>
			<br><br>
		{/foreach}
		<input type="submit" name="submit" value="Submit" onclick="">
	</form>
	
</section>

{include file="footer.tpl"}