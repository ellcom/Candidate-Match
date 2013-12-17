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
	
	<label for="description">Description: </label>
	<input name="description" type="text" value="{$election.description|default:""}"/>
	<div class="clear"></div>
	
	<br />	
	{* Start Hour*}
	<label for="Open_Time_Hour">Open Hour: </label>
	{html_select_time prefix='Open_Time_' display_minutes=false display_seconds=false}
	<div class="clear"></div>
	
	<label for="Open_Date_Day">Open Day: </label>
	{html_select_date prefix='Open_Date_' display_months=false display_years=false }
	<div class="clear"></div>
	
	<label for="Open_Date_Month">Open Month: </label>
	{html_select_date prefix='Open_Date_' display_days=false display_years=false }
	<div class="clear"></div>
	
	<label for="Open_Date_Year">Open Year: </label>
	{html_select_date prefix='Open_Date_' display_days=false display_months=false end_year="+1" }
	<div class="clear"></div>

	<br />
	{* Close Hour *}
	<label for="Close_Time_Hour">Close Hour: </label>
	{html_select_time prefix='Close_Time_' display_minutes=false display_seconds=false}
	<div class="clear"></div>
	
	<label for="Close_Date_Day">Close Day: </label>
	{html_select_date prefix='Close_Date_' display_months=false display_years=false }
	<div class="clear"></div>
	
	<label for="Close_Date_Month">Close Month: </label>
	{html_select_date prefix='Close_Date_' display_days=false display_years=false }
	<div class="clear"></div>
	
	<label for="Close_Date_Year">Close Year: </label>
	{html_select_date prefix='Close_Date_' display_days=false display_months=false end_year="+1" }
	<div class="clear"></div>
	
	{*<label for="active">Active: </label>
	<select name="active">
	  <option value="1">Yes</option>
	  <option value="0">No</option>
	</select>
	<div class="clear"></div>*}
	
	<button type="submit" name="submit">Create</button>
	<div class="clear"></div>
</form>
<div class="clear"></div>

</section>

{include file="footer.tpl"}
