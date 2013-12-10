{include file="header.tpl" title="Create A New User"}

<section id="main-matter">
<h1>Create a New User</h1>

<form method="post" id="login">
	{if isset($message)}
	<span>{$message}</span>
	<div class="clear"></div>
	{/if}
	
	<label for="username">Username:</label>
	<input name="username" type="text" value="{$user.username|default:""}"/>
	<div class="clear"></div>
	
	<label for="name">Name: </label>
	<input name="name" type="text" value="{$user.name|default:""}"/>
	<div class="clear"></div>

	<label for="email">Email: </label>
	<input name="email" type="text" value="{$user.email|default:""}"/>
	<div class="clear"></div>
	
	<label for="type">Type: </label>
	<select name="type">
	{foreach $userTypes as $type}
	  <option value="{$type}" {if isset($user) && $type == $user.type}selected{/if}>{$type}</option>
	{/foreach}
	</select>
	<div class="clear"></div>
	
	<label for="active">Active: </label>
	<select name="active">
	  <option value="1" {if isset($user) && $user.active}selected{/if}>Yes</option>
	  <option value="0" {if isset($user) && !$user.active}selected{/if}>No</option>
	</select>
	<div class="clear"></div>
	
	<label for="password">Password: </label>
	<input name="password" type="password"/>
	<div class="clear"></div>
	
	<button type="submit" name="submit">Save Changes</button>
	<div class="clear"></div>
</form>
<div class="clear"></div>

</section>

{include file="footer.tpl"}
