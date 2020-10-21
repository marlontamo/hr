function check_passwords( record_id, payroll_date )
{
    
    $.blockUI({ message: loading_message(), 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/check_password',
                type:"POST",
                dataType: "json",
                data: {record_id: record_id, payroll_date: payroll_date},
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );
                    if( typeof(response.my_payslip_password) != 'undefined' )
                    {
                        $('.modal-container').html(response.my_payslip_password);
                        $('.modal-container').modal();

                        $('input[type="password"]').keypress(function (e) {

                            kc = e.keyCode?e.keyCode:e.which;
                            sk = e.shiftKey?e.shiftKey:((kc == 16)?true:false);
                            if(((kc >= 65 && kc <= 90) && !sk)||((kc >= 97 && kc <= 122) && sk)){
                                $('#caps-lock').show();
                            }else{
                                $('#caps-lock').hide();
                            }

                        });

                        $('input[type="password"]').keypress(function(e) {
                            if(e.which == 13) {
                                e.preventDefault();
                                ajax_export_custom();
                            }
                        });

                    }
                }
            });
        }
    });
    $.unblockUI();  
}

function check_details( record_id, payroll_date )
{
    
    $.blockUI({ message: loading_message(), 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/check_details',
                type:"POST",
                dataType: "json",
                data: {record_id: record_id, payroll_date: payroll_date},
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );
                    if( typeof(response.my_payslip_password) != 'undefined' )
                    {
                        $('.modal-container').html(response.my_payslip_password);
                        $('.modal-container').modal();
                        init_checkpass_form();
                    }
                }
            });
        }
    });
    $.unblockUI();  
}

function ajax_export_custom() {
    $.blockUI({ message: '<div>'+lang.common.processing+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/validate_password',
                type:"POST",
                dataType: "json",
                data: $('form#check-password').serialize(),
                async: false,
                success: function ( response ) {
                    if( response.filename != undefined )
                    {
                        window.open( root_url + response.filename );
                    }
                    handle_ajax_message( response.message );
                }
            });
        },
        baseZ: 300000000
    });
    $.unblockUI();  
}

function init_checkpass_form()
{
    $('form#check-password').submit(function(event){
        event.preventDefault();
        ajax_export_custom();
    });  
}