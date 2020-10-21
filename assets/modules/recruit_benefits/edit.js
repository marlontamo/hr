$(document).ready(function(){
$('#recruitment_benefit_package-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#recruitment_benefit_package-status_id').val('1');
	else
		$('#recruitment_benefit_package-status_id').val('0');
});
$('#recruitment_benefit_package-rank_id').select2({
    placeholder: "Select an option",
    allowClear: true
});

$('.benefit_stat').change(function(){
    if( $(this).is(':checked') ){
    	$(this).parent().next().val(1);
    }
    else{
    	$(this).parent().next().val(0);
    }
});
});