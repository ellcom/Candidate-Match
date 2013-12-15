{include file="header.tpl" title="Admin"}

<section id="main-matter">

	<h1>Hello {$session.name|default:"John Doe"}</h1>

	<h2>Candidate Questionnaire</h2>
	
	{if isset($message)}
		<span>{$message}</span>
		<br><br><br>
	{/if}

	
	<form method="post" id="questions">
		{$i = 0}
		{foreach $questions as $row}
			<div class="question">
				<label for="Q{$i++}">Q{$i}: {$row.questionText}</label> 
				<br><br>
				<div class="radio">
					<input type="radio" name="A{$row.id}" value="1"><label>Strongly Disagree</label><br>
					<input type="radio" name="A{$row.id}" value="2"><label>Disagree</label><br>
					<input type="radio" name="A{$row.id}" value="3"><label>No Opinion</label><br>
					<input type="radio" name="A{$row.id}" value="4"><label>Agree</label><br>
					<input type="radio" name="A{$row.id}" value="5"><label>Strongly Agree</label>
				</div>
				<div class="justification">
					<label>Justification:</label><textarea name="A{$row.id}text" maxlength="200" class="questionnaire"></textarea> 
				</div>
			</div>
		{/foreach}
		<input type="submit" name="submit" value="Submit" onclick="">
	</form>
	
</section>

{include file="footer.tpl"}