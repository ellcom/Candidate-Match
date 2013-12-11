$(document).ready(function() {
	
	$('tbody tr td:not(:first-child)').click(function() {
		var id = $(this).parent().attr('id').slice(13)

		window.location = './electionprofiler.php?id=' + id
	})
	
})