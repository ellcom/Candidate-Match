{include file="header.tpl" title="Election Profiler"}

<section id="main-matter">
<h1>Election Profiler</h1>

<h2>{$election.name}</h2>

<ul>
	<li><b>ID:</b> <span id="electionId">{$election.id}</span></li>
	<li><b>Created:</b> {$election.timestamp|date_format} {$election.timestamp|date_format:'%I:%M %p'}</li>
	<li><b>End Time:</b> {$election.end_timestamp|date_format} {$election.end_timestamp|date_format:'%I:%M %p'}</li>
	<li><b>Active:</b> {if $election.active}Yes{else}No{/if}</li>
	<li><a href="./editelection.php">Edit</a></li>
</ul>

<table>
	<thead>
		<tr>
			<th><input type="checkbox" name="all" id="tickbox_all">
			<th id="th_cid">Candidate ID
			<th id="th_uid">User ID
			<th id="th_name">Name
			<th id="th_age">Age
			<th id="th_gender">Gender
			<th id="th_course">Course
			<th id="th_link">Link
	<tbody>
		{foreach $candidates as $row}<tr id="candidate_row_{$row.cid}">
			<td><input type="checkbox" name="election_user_{$row.cid}" id="tickbox_user_{$row.cid}">
			<td>{$row.cid}
			<td>{$row.uid}
			<td>{$row.name}
			<td>{$row.age}
			<td>{$row.gender}
			<td>{$row.course}
			<td>{$row.link}
			
		{/foreach}
</table>

<button id="addCandidateToElection">Add Candidate(s)</button>
<button id="removeCandidateFromElection" class="red">Remove Candidate(s)</button>

</section>

<script src="./scripts/list.js" type="text/javascript"></script>
<script src="./scripts/electionprofiler.js" type="text/javascript"></script>

{include file="footer.tpl"}