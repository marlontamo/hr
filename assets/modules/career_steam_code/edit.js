$(document).ready(function(){
$('#users_job_rank_code-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#users_job_rank_code-status_id').val('1');
	else
		$('#users_job_rank_code-status_id').val('0');
});});