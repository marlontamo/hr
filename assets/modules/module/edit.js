$(document).ready(function(){
$('#modules-disabled-temp').change(function(){
	if( $(this).is(':checked') )
		$('#modules-disabled').val('1');
	else
		$('#modules-disabled').val('0');
});
$('#modules-enable_mass_action-temp').change(function(){
	if( $(this).is(':checked') )
		$('#modules-enable_mass_action').val('1');
	else
		$('#modules-enable_mass_action').val('0');
});
$('#modules-wizard_on_new-temp').change(function(){
	if( $(this).is(':checked') )
		$('#modules-wizard_on_new').val('1');
	else
		$('#modules-wizard_on_new').val('0');
});});