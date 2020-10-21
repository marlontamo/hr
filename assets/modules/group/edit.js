$('#users_group-immediate_id').select2({
    placeholder: "Select an option",
    allowClear: true
});

$('#group-immediate_id').select2({
		placeholder: "Select an option"
		// allowClear: true
});

$('#users_group-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#users_group-status_id').val('1');
	else
		$('#users_group-status_id').val('0');
});