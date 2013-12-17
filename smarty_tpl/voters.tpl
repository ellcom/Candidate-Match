{include file="header.tpl" title="Voters"}

<section id="main-matter">
	<h1>Voter's Page</h1>
	<h2>Select an Election</h2>
	<dl>
		{foreach $elections as $row}
		<dt><a href="./votersquestionnaire.php?election={$row.id}">Election {$row.id} - {$row.name}</a></dt>
			<dd>{$row.description}</dd>
		{/foreach}
	</dl>
</section>

{include file="footer.tpl"}