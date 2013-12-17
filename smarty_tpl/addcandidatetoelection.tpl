{include file="header.tpl" title="Create A New Candidate"}

<section id="main-matter">
<h1>Create Candidate for {$election.name}</h1>

<form method="post" id="login">
	{if isset($message)}
	<span>{$message}</span>
	<div class="clear"></div>
	{/if}
	
	<label for="username">Username:</label>
	<select name="username">
	{foreach $usernames as $user}
	  <option value="{$user.id}">{$user.username}</option>
	{/foreach}
	</select>
	<div class="clear"></div>
	
	<label for="course">Course: </label>
	<input name="course" type="text" value=""/>
	<div class="clear"></div>
	
	<label for="age">Age: </label>
	<select name="age">
	{foreach range(15,80) as $age}
	  <option value="{$age}">{$age}</option>
	{/foreach}
	</select>
	<div class="clear"></div>
	
	<label for="gender">Gender: </label>
	<select name="gender">
	  <option value="M">Male</option>
	  <option value="F">Female</option>
	</select>
	<div class="clear"></div>
	
	
	<label for="link">Manifesto Link: </label>
	<input name="link" type="text" value="" placeholder="http://site.com/me.html"/>
	<div class="clear"></div>
	
	<button type="submit" name="submit">Create</button>
	<div class="clear"></div>
</form>
<div class="clear"></div>

</section>

{include file="footer.tpl"}
