{include file="header.tpl" title="Admin"}

<section id="main-matter">
<h1>Hello {$session.name|default:"John Doe"}</h1>

<h2>Profile</h2>
<ul>
	<li><a href="/password.php">Change My Password</a></li>
</ul>	
	

{if $session.type eq 'admin'}{include file="admin.tpl"}{elseif $session.type eq 'candidate'}{include file="candidate.tpl"}{/if}
</section>

{include file="footer.tpl"}
