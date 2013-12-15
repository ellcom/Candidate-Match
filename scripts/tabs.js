$(function(){
	$('div.tabs a:first').addClass('active');
	$('.tabContent div').hide();
	$('.tabContent div:first').show();
	$('div.tabs a').on('click',function(){
		$('div.tabs a').removeClass('active');
		$(this).addClass('active')
		$('.tabContent div').hide();
		var activeTab = $(this).attr('href');
		$(activeTab).show();
		return false;
	});
})