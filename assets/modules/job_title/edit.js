$('#users_job_title-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#users_job_title-status_id').val('1');
	else
		$('#users_job_title-status_id').val('0');
});