$(document).ready(function() {
	
	$('input[type="submit"]').attr('disabled','disabled');
	
	var names = {};
	$('input:radio').each(function() {
		  names[$(this).attr('name')] = true;
	});
	
	$('input:radio').change(function() {
		var count = 0;
		$.each(names, function() {
			  count++;
		});
		
		if($('input:radio:checked').length == count) {
			$('input[type="submit"]').removeAttr('disabled');
		}
	})
})