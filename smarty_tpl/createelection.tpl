{include file="header.tpl" title="Create Election"}

<section id="main-matter">
<h1>Create a New Election</h1>

<form method="post" id="login">
	{if isset($message)}
	<span>{$message}</span>
	<div class="clear"></div>
	{/if}
	
	<label for="name">Name: </label>
	<input name="name" type="text"/>
	<div class="clear"></div>
	
	<label for="active">Close Hour: </label>
	{html_select_time display_minutes=false display_seconds=false}
	<div class="clear"></div>
	
	<label for="active">Close Day: </label>
	{html_select_date display_months=false display_years=false }
	<div class="clear"></div>
	
	<label for="active">Close Month: </label>
	{html_select_date display_days=false display_years=false }
	<div class="clear"></div>
	
	<label for="active">Close Year: </label>
	{html_select_date display_days=false display_months=false end_year="+1" }
	<div class="clear"></div>
	
	<label for="active">Active: </label>
	<select name="active">
	  <option value="1">Yes</option>
	  <option value="0">No</option>
	</select>
	<div class="clear"></div>
	
	<button type="submit" name="submit">Create</button>
	<div class="clear"></div>
</form>
<div class="clear"></div>

</section>

{include file="footer.tpl"}
