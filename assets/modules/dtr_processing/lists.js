$(document).ready(function(){
	$('#list-search').addClass('hidden');

	$('.event-block').click(function(){
		$('.event-block').removeClass('label-success');
		$('.event-block').not('.event-block-year').addClass('label-default');
		$(this).removeClass('label-default');
		$(this).addClass('label-success');
		
		$('input[name="list-search"]').val( $(this).attr('search') );
		$('#record-list').infiniteScroll( 'search' );
	});

	$('input[name="mobile-filter"]').click(function(){
		$('.event-block[search="'+$(this).val()+'"]').trigger('click');
	});

    $("#time_period-cutoff").parent().datepicker('setStartDate', $("#time_period-date_to").val());

    $('#time_period-project_id').live('change', function () {
        get_previous_cutoff();                        
    });

    $('#time_period-company_id').live('change', function () {
        get_previous_cutoff();                        
    });    

    $('select[name="time_period[apply_to_id]"]').live('change',function(){
        if( $(this).val() != '' ) {
            $.ajax({
                url: base_url + module.get('route') + '/get_applied_to_options',
                type:"POST",
                data: { apply_to: $('select[name="time_period[apply_to_id]"]').val()},
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );
                    $('#time_period-applied_to').html( response.options );
                    $('#time_period-applied_to').select2();
                }
            });
        } else {
            $('#time_period-applied_to').empty();
        }
        
    });    
});

function process_form( record_id )
{
	$.ajax({
		url: base_url + module.get('route') + '/process_form',
		type:"POST",
		async: false,
		data: 'record_id='+record_id,
		dataType: "json",
		beforeSend: function(){
			$('body').modalmanager('loading');
		},
		success: function ( response ) {
			$('.modal-container').attr('data-width', '780');
			$('.modal-container').html(response.process_form);
			$('.modal-container').modal();
		}
	});
}

function process_period( record_id )
{
	var puser_id = $('input[name="user_id"]').val();
	if( puser_id == "" ) puser_id = 0;
	$.ajax({
		url: base_url + module.get('route') + '/process',
		type:"POST",
		data: {record_id: record_id, user_id:puser_id},
		dataType: "json",
		async: false,
		beforeSend: function(){
			$('.fa-spin').addClass('fa-spinner');
		},
		success: function ( response ) {
			handle_ajax_message( response.message );	
			$('.fa-spin').removeClass('fa-spinner');
		}
	});
}

function quick_edit( record_id )
{
    $.blockUI({ message: loading_message(), 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/quick_edit',
                type:"POST",
                async: false,
                data: 'record_id='+record_id,
                dataType: "json",
                beforeSend: function(){
                },
                success: function ( response ) {
                    handle_ajax_message( response.message );

                    if( typeof(response.quick_edit_form) != 'undefined' )
                    {
                        $('.modal-container').attr('data-width', '800');
                        $('.modal-container').html(response.quick_edit_form);
                        $('.modal-container').modal();                     

                    }
                    $("#time_period-cutoff").parent().datepicker('setStartDate', $("#time_period-date_to").val())

                    $("#time_period-date_to").live('change', function () {
                        $("#time_period-cutoff").parent().datepicker('setStartDate', $(this).val())
                    })

                }
            });
        }
    });
    $.unblockUI();  
}

function quick_add()
{
    $.blockUI({ message: loading_message(), 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/quick_add', 
                type:"POST",
                dataType: "json",
                async: false,
                beforeSend: function(){
                },
                success: function ( response ) {
                    handle_ajax_message( response.message );

                    if( typeof(response.quick_edit_form) != 'undefined' )
                    {
                        $('.modal-container').attr('data-width', '800');
                        $('.modal-container').html(response.quick_edit_form);
                        $('.modal-container').modal();
                    }
                    
                    $("#time_period-date_to").live('change', function () {
                        $("#time_period-cutoff").parent().datepicker('setStartDate', $(this).val())
                    });

                    
                }
            });
        }
    });
    $.unblockUI();  
}


function get_previous_cutoff() 
{
    $.ajax({
        url: base_url + module.get('route') + '/get_previous_cutoff', 
        type:"POST",
        dataType: "json",
        data: 'company_id='+$('#time_period-company_id').val() + '&project_id='+$('#time_period-project_id').val() + '&payroll_date='+$("#time_period-payroll_date").val(),
        async: false,
        beforeSend: function(){
        },
        success: function ( response ) {            

            $("#time_period-previous_cutoff").parent().datepicker('setDate', new Date(response.previous_cutoff) );
            
            $("#time_period-previous_cutoff").parent().datepicker({
                autoclose: true,
                format : "MM dd, yyyy"
            });
        }
    });
}

function closed_record( record_id )
{
    bootbox.confirm("Are you sure you want to close this period?", function(confirm) {
        if( confirm )
        {
            $.blockUI({ message: lang.common.closing, 
                onBlock: function(){
                    $.ajax({
                        url: base_url + module.get('route') + '/closed_record',
                        type:"POST",
                        data: 'record_id='+record_id,
                        dataType: "json",
                        async: false,
                        beforeSend: function(){
                            
                        },
                        success: function ( response ) {
                            handle_ajax_message( response.message );    
                            $('.modal-container').modal('hide');
                            $.unblockUI();
                            self.location.reload();
                        }
                    });
                }
            });
        }
    });
}