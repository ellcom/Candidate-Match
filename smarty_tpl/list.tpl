{include file="header.tpl" title="List Users"}

<section id="main-matter">
<h1>List Users</h1>

<table>
	<thead>
		<tr>
			<th><input type="checkbox" name="all" id="tickbox_all">
			<th>id
			<th>Username
			<th>Name
			<th>Email
			<th>Type
			<th>Active
	<tbody>
		{foreach $users as $row}
		<tr>
			<td><input type="checkbox" name="user_{$row.id}" id="tickbox_user_{$row.id}">
			<td>{$row.id}
			<td>{$row.username}
			<td>{$row.name|capitalize}
			<td>{$row.email}
			<td>{$row.type|capitalize}
			<td>{if $row.active}Yes{else}No{/if}
		{/foreach}
</table>

<button id="delete_users" name="delete_users">Delete User(s)</button>
<button id="deactivate_users" name="deactivate_users">Deactivate User(s)</button>
<button id="activate_users" name="activate_users">Activate User(s)</button>
</section>
<script src="/scripts/list.js" type="text/javascript">
{include file="footer.tpl"}
