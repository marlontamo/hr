$('#users_project-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#users_project-status_id').val('1');
	else
		$('#users_project-status_id').val('0');
});