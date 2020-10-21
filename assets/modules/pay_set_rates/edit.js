$(document).ready(function(){
$('#users_pay_set_rates-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#users_pay_set_rates-status_id').val('1');
	else
		$('#users_pay_set_rates-status_id').val('0');
});});