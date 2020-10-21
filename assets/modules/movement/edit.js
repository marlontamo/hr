$(document).ready(function(){
	$('#partners_movement_action-type_id').select2({
	    placeholder: "Select an option",
	    allowClear: true
	});
	$('#partners_movement-due_to_id').select2({
	    placeholder: "Select an option",
	    allowClear: true
	});

	$('#type_id').live('change',function(){
		var val = $(this).val();
		if (val == 8){
			$('.cat_type').show();
		}
		else{
			$('.cat_type').hide();			
		}
	});
});