$(document).ready(function(){
	$('input[name="temprequisition_items[quantity][]"]').change(function(){
		var target_f = $(this).parent().parent().find('input[name="requisition_items[quantity][]"]');
		if( $(this).is(':checked') )
			target_f.val('1');
		else
			target_f.val('0');
	
		calc_grand_total();
	});	
});
