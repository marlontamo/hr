$(document).ready(function(){
    init_table_inputs();
});

function add_group()
{
    var rate = $('input[name="payroll_entry_recurring[amount]"]').val();
    var group = $('select[name="default[add-group]"]').val();
    $.blockUI({ message: loading_message(), 
        onBlock: function(){
            var employee_id = new Array();
            var ctr = 0;
            $('#employee-table tr').each(function(){
                employee_id[ctr] = $(this).attr('employee_id');
                ctr++;
            });

            $.ajax({
                url: base_url + module.get('route') + '/get_add_employee_form',
                type:"POST",
                data: {group: group, employee_id: employee_id, rate: rate},
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );

                    if( typeof(response.add_employee_form) != 'undefined' )
                    {
                        $('.modal-container').attr('data-width', '800');
                        $('.modal-container').html(response.add_employee_form);
                        $('.modal-container').modal();
                    }  
                }
            });
        }
    });
    $.unblockUI();
}

function init_table_inputs()
{
    $('input[name="payroll_entry_recurring_employee[quantity][]"], input[name="payroll_entry_recurring_employee[amount][]"]').die().keyup(function(){
        var parent = $(this).closest('tr');
        var employee_id = parent.attr('employee_id')
        update_total( employee_id );
    });
}

function update_total( employee_id )
{
    var amount = $('tr[employee_id="'+employee_id+'"] input[name="payroll_entry_recurring_employee[amount][]"]').val();
    var quantity = $('tr[employee_id="'+employee_id+'"] input[name="payroll_entry_recurring_employee[quantity][]"]').val();

    var total = 0;
    if( amount != "" && quantity != "" )
    {
        amount = remove_commas( amount );
        quantity = remove_commas( quantity );
        total = parseFloat( amount ).toFixed(2) * parseInt( quantity );
    }

    $('tr[employee_id="'+employee_id+'"] input[name="payroll_entry_recurring_employee[total][]"]').attr('disabled', false);
    $('tr[employee_id="'+employee_id+'"] input[name="payroll_entry_recurring_employee[total][]"]').val( parseFloat( total ).toFixed(2) );
    $('tr[employee_id="'+employee_id+'"] input[name="payroll_entry_recurring_employee[total][]"]').attr('disabled', true);
}

function delete_employee( employee_id )
{
    bootbox.confirm("Are you sure you want to remove selected employee?", function(confirm) {
        if( confirm )
        {
            $('tr[employee_id="'+employee_id+'"]').remove();
        }
    });
}

function mass_delete_employee()
{
    bootbox.confirm("Are you sure you want to remove selected employees?", function(confirm) {
        if( confirm )
        {
            $('#employee-table .added-employee:checked').each(function(){
                var employee_id = $(this).val();
                $('tr[employee_id="'+employee_id+'"]').remove();
            });
        }
    });
}

function toggle_item( id )
{
    var checkbox = $('.list-group input[value="'+id+'"]');
    if( checkbox.is(':checked') )
    {
        checkbox.prop('checked',false);
    }
    else{
        checkbox.prop('checked',true);
    }

    update_employee_lists();
}

function toggle_checkbox( id )
{
    var checkbox = $('.list-group input[value="'+id+'"]');
    if( checkbox.is(':checked') )
    {
        checkbox.prop('checked',false);
    }
    else{
        checkbox.prop('checked',true);
    }
}

function update_employee_lists()
{
    var data = $('form[name="add-employee-form"]').serialize();
    $('tbody#employee-lists').block({ message: '<img src="'+root_url+'assets/img/ajax-loading.gif" />',
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/get_employees',
                type:"POST",
                data: data,
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );
                    $('tbody#employee-lists').html(response.employees);
                    App.initUniform('.employee-checker');
                }
            });     
        }
    });
    $('tbody#employee-lists').unblock();
    $('div.blockElement').remove();
}

function add_employees()
{
    var rate = $('input[name="payroll_entry_recurring[amount]"]').val();
    $('tbody#employee-lists').block({ message: '<img src="'+root_url+'assets/img/ajax-loading.gif" />',
        onBlock: function(){
            var data = new Array();
            var ctr = 0;
            $('input[name="add_employee[]"]').each(function(){
                if( $(this).is(':checked') )
                {
                    data[ctr] = $(this).val();
                    ctr++;
                }
            });
            $.ajax({
                url: base_url + module.get('route') + '/add_employees',
                type:"POST",
                data: {employees: data, rate: rate},
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );
                    $('.modal-container').modal('hide');
                    $('#employee-table').append(response.employees);
                    App.initUniform('.added-employee');
                    $(":input").inputmask();
                    init_table_inputs();
                }
            });     
        }
    });
    $ 
}