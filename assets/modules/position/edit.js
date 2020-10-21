$('#users_position-employee_type_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#users_position-immediate_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#users_position-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#users_position-status_id').val('1');
	else
		$('#users_position-status_id').val('0');
});