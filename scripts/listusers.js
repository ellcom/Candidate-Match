$(document).ready(function() {

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
			url: './ajax_changeUsers.php',
			type: 'POST',
			data: {'ids': toVate, 'active' : active},
			dataType: 'text',
			timeout: 2000,
			success: function(data){
				if(data == "1"){
					$.each(toSay, function() {
						$(this).html((active == 1 ? "Yes":"No"))
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
	
	$('#delete_users').click(function() {
	
		var checked = $('tbody').find('input:checked')
	
		if(!checked.length) return
	
		var toDelete = [], toRemove = []
	
		checked.each(function() {
			toDelete.push(this.name.slice(5))
			toRemove.push($(this).parent().parent())
		})
	
		$.ajax({
			url: './ajax_changeUsers.php',
			type: 'POST',
			data: {'ids': toDelete, 'delete' : 1},
			dataType: 'text',
			timeout: 2000,
			success: function(data){
				if(data == "1"){
					$.each(toRemove, function() {
						$(this).remove()
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
	
	$('tbody tr td:not(:first-child)').click(function() {
		var user = $(this).parent().attr('id').slice(9)
		//var user = $(this).siblings().eq(1).html()
		window.location = './edituser.php?userid=' + user
	})

})