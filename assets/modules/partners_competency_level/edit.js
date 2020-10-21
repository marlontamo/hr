$(document).ready(function(){
$('#users_competency_level-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#users_competency_level-status_id').val('1');
	else
		$('#users_competency_level-status_id').val('0');
});});