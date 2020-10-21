$(document).ready(function(){
$('#users_section-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#users_section-status_id').val('1');
	else
		$('#users_section-status_id').val('0');
});});