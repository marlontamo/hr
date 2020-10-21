$(document).ready(function(e) { 
	$('.list-filter').click(function(){
		$('.list-filter').removeClass('active');
		$('.list-filter').removeClass('label-success');
		$('.list-filter').addClass('label-default');
		$('.list-filter').children('i').addClass('fa-square-o');
		$(this).removeClass('label-default');
		$(this).addClass('label-success');
		$(this).addClass('active');
		$(this).children('i').removeClass('fa-square-o');
		$(this).children('i').addClass('fa-check-square-o');

		create_list();
	});	
});