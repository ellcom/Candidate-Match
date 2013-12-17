$(document).ready(function() {
	
	$('#tickbox_all').change(function() {
		if($(this).is(':checked')){
			$('table:first input[type="checkbox"]').prop('checked', true)
		}else {
			$('table:first input[type="checkbox"]').prop('checked', false)
		}
	})
	
	$('#tickbox_all_2').change(function() {
		if($(this).is(':checked')){
			$('table:not(:first) input[type="checkbox"]').prop('checked', true)
		}else {
			$('table:not(:first) input[type="checkbox"]').prop('checked', false)
		}
	})
	
	
	$('thead tr th:not(:first-child)').click(function() {
		var child = $(this).index()
		var sortBit = 1
		if($(this).hasClass('down')) sortBit = -1
		
		$('th.up, th.down').removeClass()
		
		var rows = $('tbody tr').get();
		
		rows.sort(function(a, b){
			var A = $(a).children('td').eq(child).text().toUpperCase()
			var B = $(b).children('td').eq(child).text().toUpperCase()
			
			if(A < B) return 0 - sortBit
			if(A > B) return 0 + sortBit
			
			return 0
		})
		
		$(this).addClass((sortBit == 1 ? "down" : "up"))
		
		$.each(rows, function(index, row) {
			$('table').children('tbody').append(row)
		})
		
		$(this).css('user-select', 'none')
	})
	
	
})