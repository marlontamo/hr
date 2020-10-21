
$(document).ready(function(){
    $('select[name="payroll_leave_conversion_period[apply_to_id]"]').change(function(){
        if( $(this).val() != '' ) {
            $.ajax({
                url: base_url + module.get('route') + '/get_applied_to_options',
                type:"POST",
                data: { apply_to: $('select[name="payroll_leave_conversion_period[apply_to_id]"]').val()},
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );

                    $('#payroll_leave_conversion_period-applied_to').html( response.options );
                    $('#payroll_leave_conversion_period-applied_to').select2();
                }
            });
        } else {
            $('#payroll_leave_conversion_period-applied_to').empty();
        }
    });
});