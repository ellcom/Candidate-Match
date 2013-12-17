$(document).ready(function() {

	$('#removeCandidateFromElection').click(function() {
		var checked = $('table:first tbody').find('input:checked')
	
		if(!checked.length) return
	
		var toDelete = [], toRemove = []
	
		checked.each(function() {
			toDelete.push(this.name.slice(14))
			toRemove.push($(this).parent().parent())
		})
		
		$.ajax({
			url: './ajax_changeElection.php',
			type: 'POST',
			data: {'ids': toDelete, 'removeCandidatesFromElection' : $('#electionId').html()},
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
	
	$('#addCandidateToElection').click(function(){
		location = "./addcandidatetoelection.php?eid=" + $("#electionId").text()
	})
	
	
	
	
	$('#addQuestion').click(function(){
		location = "./addquestion.php?id=" + $("#electionId").text()
	})
	
	$('#removeQuestion').click(function(){
		var checked = $('table:not(:first) tbody').find('input:checked')
		
		if(!checked.length) return
	
		var toDelete = [], toRemove = []
		
		checked.each(function() {
			toDelete.push(this.name.slice(18))
			toRemove.push($(this).parent().parent())
		})
		
		$.ajax({
			url: './ajax_changeElection.php',
			type: 'POST',
			data: {'ids': toDelete, 'removeQuestionsFromElection' : $('#electionId').html()},
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
})