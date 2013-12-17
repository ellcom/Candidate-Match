{include file="header.tpl" title="Edit Question"}

<section id="main-matter">
<h1>Edit Question</h1>

<form method="post" id="login">
	{if isset($message)}
	<span>{$message}</span>
	<div class="clear"></div>
	{/if}
	
	<input name="id" type="hidden" value="{$question.id}" />
	
	<label for="id" class="locked">Id:</label>
	<input name="id" type="text" disabled="true" value="{$question.id}"/>
	<div class="clear"></div>
	
	<label for="question">Question:</label>
	<input name="question" type="text" value="{$question.questionText}"/>
	<div class="clear"></div>
	
	<label for="category">Category: </label>
	<input name="category" type="text" value="{$question.category}"/>
	<div class="clear"></div>

	<label for="election">Election: </label>
	<select name="election">
	{foreach $elections as $election}
	  <option value="{$election.id}" {if $election.id eq $question.electionID}selected{/if}>{$election.name}</option>
	{/foreach}
	</select>
	<div class="clear"></div>
	
	<button type="submit" name="submit">Save Changes</button>
	<div class="clear"></div>
</form>
<div class="clear"></div>

<p><a href="./electionprofiler.php?id={$question.electionID}">Back To Profiler</a></p>
</section>

{include file="footer.tpl"}
