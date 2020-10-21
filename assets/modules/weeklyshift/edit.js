$(document).ready(function(){
    $('#shift_weekly-default-temp').change(function(){
        if( $(this).is(':checked') )
            $('#shift_weekly-default').val('1');
        else
            $('#shift_weekly-default').val('0');
    }); 
});