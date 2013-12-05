{include file="header.tpl" title="Admin"}

<section id="main-matter">
<h1>Helloo {$session.name|default:"John Doe"} - <a href='dashboard.php'>Dashboard Page</a></h1>

{if $session.type eq 'admin'}{include file="admin.tpl"}{/if}
</section>

{include file="footer.tpl"}
