{include file="header.tpl" title="Login"}

<section id="main-matter">
<form method="post" id="login">
	{if isset($message)}
	<span>{$message}</span>
	<div class="clear"></div>
	{/if}
	<label for="username">Username: </label>
	<input name="username" type="text" placeholder="Username" value="{$username|default:''}"/>
	<div class="clear"></div>
	<label for="password">Password: </label>
	<input name="password" type="password" placeholder="Password"/>
	<div class="clear"></div>
	<button type="submit">Login</button>
	<div class="clear"></div>
</form>
<div class="clear"></div>
</section>

{include file="footer.tpl"}