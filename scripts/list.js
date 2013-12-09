$(document).ready(function() {
	
	$('#tickbox_all').change(function() {
		if($(this).is(':checked')){
			$('input[type="checkbox"]').prop('checked', true);
		}else {
			$('input[type="checkbox"]').prop('checked', false);
		}
	})
	
	$('#deactivate_users, #activate_users').click(function() {
		
		var checked = $('tbody').find('input:checked')
		
		if(!checked.length) return
		
		var toVate = [], toSay = []
		var active = (this.id == 'activate_users' ? '1':'0')
		
		checked.each(function() {
			toVate.push(this.name.slice(5))
			toSay.push($(this).parent().siblings("td:last-child"))
		})
		
		$.ajax({
			url: '/ajax_changeUsers.php',
			type: 'POST',
			data: {'ids': toVate, 'active' : active},
			dataType: 'text',
			timeout: 2000,
			success: function(data){
				if(data == "1"){
					$.each(toSay, function() {
						$(this).html((active == 1 ? "Yes":"No"));
					})
					
				}else {
					location.reload()
				}
			},
			error: function(request, status, error) {
				alert(request.responseText)
			}
		})
	})

})