{include file="header.tpl" title="List Elections"}

<section id="main-matter">
<h1>List Elections</h1>

<table>
	<thead>
		<tr>
			<th><input type="checkbox" name="all" id="tickbox_all">
			<th id="th_id">id
			<th id="th_name">Name
			<th id="th_start">Start Time
			<th id="th_end">End Time
			<th id="th_active">Live
	<tbody>
		{foreach $list as $row}<tr id="election_row_{$row.id}">
			<td><input type="checkbox" name="election_{$row.id}" id="tickbox_user_{$row.id}">
			<td>{$row.id}
			<td>{$row.name}
			<td>{$row.timestamp|date_format}
			<td>{$row.end_timestamp|date_format}
			<td>{if $row.timestamp lte $smarty.now and $row.end_timestamp gt $smarty.now}Yes{else}No{/if}
			
		{/foreach}
</table>

</section>
<script src="./scripts/list.js" type="text/javascript"></script>
<script src="./scripts/listelections.js" type="text/javascript"></script>

{include file="footer.tpl"}
