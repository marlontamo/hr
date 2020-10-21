$(document).ready(function(){
$('#users_specialization-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#users_specialization-status_id').val('1');
	else
		$('#users_specialization-status_id').val('0');
});});