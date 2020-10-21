$(document).ready(function(){
$('#users_branch-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#users_branch-status_id').val('1');
	else
		$('#users_branch-status_id').val('0');
});});