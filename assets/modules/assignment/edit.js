$(document).ready(function(){
$('#users_assignment-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#users_assignment-status_id').val('1');
	else
		$('#users_assignment-status_id').val('0');
});});