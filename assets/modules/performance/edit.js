$(document).ready(function(){
$('#performance_setup_performance-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#performance_setup_performance-status_id').val('1');
	else
		$('#performance_setup_performance-status_id').val('0');
});

$('#performance_setup_performance-send_feeds-temp').change(function(){
	if( $(this).is(':checked') )
		$('#performance_setup_performance-send_feeds').val('1');
	else
		$('#performance_setup_performance-send_feeds').val('0');
});

$('#performance_setup_performance-send_email-temp').change(function(){
	if( $(this).is(':checked') )
		$('#performance_setup_performance-send_email').val('1');
	else
		$('#performance_setup_performance-send_email').val('0');
});

$('#performance_setup_performance-send_sms-temp').change(function(){
	if( $(this).is(':checked') )
		$('#performance_setup_performance-send_sms').val('1');
	else
		$('#performance_setup_performance-send_sms').val('0');
});


});