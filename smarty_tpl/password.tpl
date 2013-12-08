{include file="header.tpl" title="Change My Password"}

<section id="main-matter">
<h1>Hello {$session.name|default:"John Doe"}</h1>

<h2>Change My Password</h2>

<form method="post" id="login">
	{if isset($message)}
	<span>{$message}</span>
	<div class="clear"></div>
	{/if}
	<label for="password0">Password:</label>
	<input name="password0" type="password" placeholder="Current Password"/>
	<div class="clear"></div>
	<label for="password1">New Password:</label>
	<input name="password1" type="password" placeholder="New Password"/>
	<div class="clear"></div>
	<label for="password2">Again: </label>
	<input name="password2" type="password" placeholder="New Password"/>
	<div class="clear"></div>
	<button type="submit">Change</button>
	<div class="clear"></div>
</form>
</section>

{include file="footer.tpl"}
