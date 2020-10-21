$(document).ready(function(){
    if ($('select[name="payroll_partners[sss_mode]"]').val() != 3){
        $('#payroll_partners-sss_amount').parent().parent().hide();
    }

    if ($('select[name="payroll_partners[hdmf_mode]"]').val() != 3){
        $('#payroll_partners-hdmf_amount').parent().parent().hide();
    }

    if ($('select[name="payroll_partners[phic_mode]"]').val() != 3){
        $('#payroll_partners-phic_amount').parent().parent().hide();
    }

    if ($('select[name="payroll_partners[tax_mode]"]').val() != 3){
        $('#payroll_partners-tax_amount').parent().parent().hide();
    }

    $('#payroll_partners-attendance_base-temp').change(function(){
    	if( $(this).is(':checked') )
    		$('#payroll_partners-attendance_base').val('1');
    	else
    		$('#payroll_partners-attendance_base').val('0');
    });

    $('#payroll_partners-whole_half-temp').change(function(){
        if( $(this).is(':checked') )
            $('#payroll_partners-whole_half').val('0');
        else
            $('#payroll_partners-whole_half').val('1');
    });

    $('#payroll_partners-payout_schedule-temp').change(function(){
        if( $(this).is(':checked') )
            $('#payroll_partners-payout_schedule').val('0');
        else
            $('#payroll_partners-payout_schedule').val('1');
    });
            
    $('#payroll_partners-user_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_partners-company_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $(":input").inputmask();
    $('#payroll_partners-payroll_rate_type_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_partners-payroll_schedule_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_partners-taxcode_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_partners-payment_type_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_partners-location_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_partners-fixed_rate-temp').change(function(){
    	if( $(this).is(':checked') )
    		$('#payroll_partners-fixed_rate').val('1');
    	else
    		$('#payroll_partners-fixed_rate').val('0');
    });
    $('#payroll_partners-non_swipe-temp').change(function(){
        if( $(this).is(':checked') )
            $('#payroll_partners-non_swipe').val('1');
        else
            $('#payroll_partners-non_swipe').val('0');
    });
    $('#payroll_partners-sensitivity').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_partners-on_hold-temp').change(function(){
    	if( $(this).is(':checked') )
    		$('#payroll_partners-on_hold').val('1');
    	else
    		$('#payroll_partners-on_hold').val('0');
    });
    if (jQuery().datepicker) {
        $('#partners-resigned_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    $('#payroll_partners-sss_mode').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_partners-sss_week').multiselect();

    $('#payroll_partners-hdmf_mode').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_partners-hdmf_week').multiselect();

    $('#payroll_partners-phic_mode').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_partners-phic_week').multiselect();

    $('#payroll_partners-tax_mode').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_partners-tax_week').multiselect();

    $('#payroll_partners-ecola_week').multiselect();

    $('select[name="payroll_partners[sss_mode]"]').change(function(){
        if($(this).val() == 3){
            $('#payroll_partners-sss_amount').parent().parent().show();
        } else {
            $('#payroll_partners-sss_amount').parent().parent().hide();
        }
    });

    $('select[name="payroll_partners[hdmf_mode]"]').change(function(){
        if($(this).val() == 3){
            $('#payroll_partners-hdmf_amount').parent().parent().show();
        } else {
            $('#payroll_partners-hdmf_amount').parent().parent().hide();
        }
    });

    $('select[name="payroll_partners[phic_mode]"]').change(function(){
        if($(this).val() == 3){
            $('#payroll_partners-phic_amount').parent().parent().show();
        } else {
            $('#payroll_partners-phic_amount').parent().parent().hide();
        }
    });

    $('select[name="payroll_partners[tax_mode]"]').change(function(){
        if($(this).val() == 3){
            $('#payroll_partners-tax_amount').parent().parent().show();
        } else {
            $('#payroll_partners-tax_amount').parent().parent().hide();
        }
    });

    $('select[name="payroll_partners[account_type_id]"]').change(function(){
        if($(this).val() == 1){

            var user_id = $('#record_id').val();
            get_bank_account(user_id, 1);
        } 
        if($(this).val() == 2) {

            var user_id = $('#record_id').val();
            get_bank_account(user_id, 2);
        }
    });

    $('#payroll_partners-salary').change(function(){
        var salary = 0;
        var min_takehome = 0;
        salary = $('#payroll_partners-salary').val();
        min_takehome = parseFloat(remove_commas(salary)) * 0.3
        $('#payroll_partners-minimum_takehome').val("'"+min_takehome+"'");
    });
});

function get_bank_account(user_id, account_type_id){

    if((user_id != null) && (user_id != '')){

        $.ajax({
            url: base_url + module.get('route') + '/get_bank_account',
            type:"POST",
            async: false,
            data: {user_id:user_id, account_type_id:account_type_id},
            dataType: "json",
            beforeSend: function(){
                // $('body').modalmanager('loading');
            },
            success: function ( response ) {
                
                $('#payroll_partners-bank_account').val(response.bank_account);
            }
        }); 
    }
    else{

        $('#payroll_partners-bank_account').val('');
    }
}