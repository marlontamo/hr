$('#users_division-immediate_id').select2({
    placeholder: "Select an option",
    allowClear: true
});

$('#division-immediate_id').select2({
		placeholder: "Select an option",
		allowClear: true
	});

$('#users_division-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#users_division-status_id').val('1');
	else
		$('#users_division-status_id').val('0');
});