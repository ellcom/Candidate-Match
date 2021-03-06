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
				<label for="Q{$i++}{*Print and Increment $i*}">Q{$i}: {$row.questionText}</label> 
				<br><br>
				<div class="radio">
					<input type="radio" name="A{$row.id}" id="{$row.id}1" value="1"><label for="{$row.id}1">Strongly Disagree</label><br>
					<input type="radio" name="A{$row.id}" id="{$row.id}2" value="2"><label for="{$row.id}2">Disagree</label><br>
					<input type="radio" name="A{$row.id}" id="{$row.id}3" value="3"><label for="{$row.id}3">No Opinion</label><br>
					<input type="radio" name="A{$row.id}" id="{$row.id}4" value="4"><label for="{$row.id}4">Agree</label><br>
					<input type="radio" name="A{$row.id}" id="{$row.id}5" value="5"><label for="{$row.id}5">Strongly Agree</label>
				</div>
				<div class="justification">
					<label>Justification:</label><textarea name="A{$row.id}text" maxlength="200" class="questionnaire" {if $live eq 'no'} readonly {/if}>{$answers[$i-1].justification}</textarea> 
				</div>
			</div>
			{literal}
			<script>
				(function check(){
					document.getElementById("{/literal}{$row.id}{$answers[$i-1].answer}{literal}").checked = true;
					check();
				}());
			</script>
			{/literal}
		{/foreach}
		<input type="submit" name="submit" value="Submit">
	</form>
	
</section>

{if $live eq 'yes'}
<script src="./scripts/questionnaire.js" type="text/javascript"></script>
{/if}

{include file="footer.tpl"}