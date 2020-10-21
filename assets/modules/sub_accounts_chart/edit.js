$(document).ready(function(){
	$('select[name="payroll_account_sub[category_id]"]').change(function(){
        if( $(this).val() != '' ) {
            $.ajax({
                url: base_url + module.get('route') + '/get_applied_to_options',
                type:"POST",
                data: { category_id: $('select[name="payroll_account_sub[category_id]"]').val()},
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );
                    $('#payroll_account_sub-category_val_id').html( response.options );
                    $('#payroll_account_sub-category_val_id').select2();
                }
            });
        } else {
            $('#payroll_account_sub-category_val_id').empty();
        }
        
    });

	$('#payroll_account_sub-category_id').select2({
	    placeholder: "Select an option",
	    allowClear: true
	});
	$('#payroll_account_sub-account_id').select2({
	    placeholder: "Select an option",
	    allowClear: true
	});
});