$('#partners_employment_status-active-temp').change(function(){
	if( $(this).is(':checked') )
		$('#partners_employment_status-active').val('1');
	else
		$('#partners_employment_status-active').val('0');
});