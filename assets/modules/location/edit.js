$(document).ready(function(){
$('#users_location-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#users_location-status_id').val('1');
	else
		$('#users_location-status_id').val('0');
});});