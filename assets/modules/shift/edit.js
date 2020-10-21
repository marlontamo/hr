if (jQuery().timepicker) {
    $('#time_shift-time_start').timepicker({
        autoclose: true,
        minuteStep: 1,
        secondStep: 1,
        defaultTime: false
    });
}
if (jQuery().timepicker) {
    $('#time_shift-time_end').timepicker({
        autoclose: true,
        minuteStep: 1,
        secondStep: 1,
        defaultTime: false
    });
}


$('#time_shift-use_tag-temp').change(function(){
    if( $(this).is(':checked') )
        $('#time_shift-use_tag').val('1');
    else
        $('#time_shift-use_tag').val('0');
});