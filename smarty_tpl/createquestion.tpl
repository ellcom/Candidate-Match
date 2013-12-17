{include file="header.tpl" title="Create A New Question"}

<section id="main-matter">
<h1>Create a New Question</h1>

<form method="post" id="login">
	{if isset($message)}
	<span>{$message}</span>
	<div class="clear"></div>
	{/if}
	
	<label for="question">Question Text:</label>
	<input name="question" type="text"/>
	<div class="clear"></div>
	
	<label for="category">Category:</label>
	<input name="category" type="text"/>
	<div class="clear"></div>
	
	<label for="type">Add to Election: </label>
	<select name="election">
	{foreach $elections as $election}
	  <option value="{$election.id}">{$election.name}</option>
	{/foreach}
	</select>
	<div class="clear"></div>
	
	<button type="submit" name="submit">Create</button>
	<div class="clear"></div>
</form>
<div class="clear"></div>

</section>

{include file="footer.tpl"}
