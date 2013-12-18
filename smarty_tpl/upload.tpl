{include file="header.tpl" title="Upload CSV Questions"}

<section id="main-matter">
<h1>Upload New Questions via CSV</h1>

<p>Download a sample CSV file from <a href="test.csv" target="_blank">here</a> to see how you should lay out your spreadsheet.</p>
<form method="post" id="login" enctype="multipart/form-data">
	{if isset($message)}
	<span>{$message}</span>
	<div class="clear"></div>
	{/if}
	
	<label for="file">CSV File:</label>
	<input name="file" type="file" id="file"/>
	<div class="clear"></div>
	
	<br />
	<input type="hidden" name="electionID" value="{$election.id}"/>
	
	<button type="submit" name="submit">Upload</button>
	<div class="clear"></div>
</form>
<div class="clear"></div>

</section>

{include file="footer.tpl"}
