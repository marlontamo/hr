$(document).ready(function(){
	$('#partners_employment_type-active-temp').change(function(){
	if( $(this).is(':checked') )
		$('#partners_employment_type-active').val('1');
	else
		$('#partners_employment_type-active').val('0');
});
});