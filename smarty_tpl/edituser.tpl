{include file="header.tpl" title="Edit User"}

<section id="main-matter">
<h1>Edit User</h1>

<form id="login">
	{if isset($message)}
	<span>{$message}</span>
	<div class="clear"></div>
	{/if}
	
	<label for="id" class="locked">Id:</label>
	<input name="id" type="text" disabled="true" value="{$user.id}"/>
	<div class="clear"></div>
	
	<label for="username">Username:</label>
	<input name="username" type="text" value="{$user.username}"/>
	<div class="clear"></div>
	
	<label for="name">Name: </label>
	<input name="name" type="text" value="{$user.name}"/>
	<div class="clear"></div>

	<label for="email">Email: </label>
	<input name="email" type="text" value="{$user.email}"/>
	<div class="clear"></div>
	
	<label for="type">Type: </label>
	<select name="type">
	{foreach $userTypes as $type}
	  <option value="{$type}" {if $type == $user.type}selected{/if}>{$type}</option>
	{/foreach}
	</select>
	<div class="clear"></div>
</form>

<button id="save_changes" name="save_changes">Save Changes</button>

<button id="active_state" name="active_state">Deactivate Account</button>

<button id="change_password" name="change_password">Change Password</button>

<div class="clear"></div>


</section>

{include file="footer.tpl"}
