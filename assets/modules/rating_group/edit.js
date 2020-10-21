$(document).ready(function(){
$('#performance_setup_rating_group-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#performance_setup_rating_group-status_id').val('1');
	else
		$('#performance_setup_rating_group-status_id').val('0');
});

$('.score_stat').change(function(){
    if( $(this).is(':checked') ){
    	$(this).parent().next().val(1);
    }
    else{
    	$(this).parent().next().val(0);
    }
});

});