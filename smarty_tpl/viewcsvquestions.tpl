{include file="header.tpl" title="Confirm CSV Questions"}

<section id="main-matter">
<h1>CSV Confirmation</h1>

<p>Please check over the following questions before you add them to the election. If you're unhappy please go back to the <a href="./upload.php?eid={$election.id}">previous page</a>.</p>

<h2>Phased</h2>
<form method='post'>
<table>
	<thead>
		<tr>
			<th>Question Text
			<th>Category
	<tbody>
	{foreach $questions as $question}
		<tr>
			{foreach $question as $cell}
			<td>{$cell} <input type='hidden' value='{$cell}' name="{$question@iteration}[]"/>
			{/foreach}
	{/foreach}
</table>

<button name="cvstodatabase" type="submit">Add to Election</button>

</form>
</section>

{include file="footer.tpl"}
