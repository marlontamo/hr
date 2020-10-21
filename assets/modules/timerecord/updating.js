$(document).ready(function(){

	$('select.select2me').select2();
	$("#no_record").hide();
	$("#list-table-updating").hide();
	$("#loader").hide();
	$("#buttons").hide();

	if($('#user_id').val() > 0 && $("#pay_dates").val() > 0){
		$("#periods-div").show();


		var from = $('#pay_dates option:selected').attr('value-from');
		var to = $('#pay_dates option:selected').attr('value-to');
		var user_id = $('#user_id').val();
		get_period_list(user_id, from,to);
	}

	$("#pay_dates").live('change', function(){
		$('#pay_date_name').val($('option:selected', this).text());

		var from = $('option:selected', this).attr('value-from');
		var to = $('option:selected', this).attr('value-to');
		var user_id = $('#user_id').val();
		get_period_list(user_id, from,to);
		
	});

	$("#user_id").on("change", function(){

		if(!$(this).val()){
			$("#periods-div").hide();
			return;
		} 
		$("#pay_dates").trigger('change');
		$("#periods-div").show();
	});
		
});

function get_period_list(user_id, from, to){

	var request_data = {from: from, to: to, type: $('#type').val() , user_id : user_id };
	
	$.ajax({
	    url: base_url + module.get('route') + '/get_updating_period_list',
	    type: "POST",
	    async: false,
	    data: request_data,
	    dataType: "json",
	    beforeSend: function () {
	    	$("#loader").show();
	    },
	    success: function (response) {
	    	$("#loader").hide();
	    	$("#list-table-updating tbody tr").remove();
	    	$("#list-table-updating tbody").append(response.list);
	    	if($('#type').val() != "manage")
	    	{
	    		$("#list-table-updating tfoot tr").remove();
	    		$("#list-table-updating tfoot").append(response.approvers);
	    	}
	    	
	    	$("#list-table-updating").show();
	    	$("#buttons").show();
	    	$('select.select2me').select2();
	    	
	    	if(response.hide_btn == true || response.from == false){
	    		$('#buttons').hide();
	    	}
	    	if(response.for_approval == 1){
	    		$('#reassign').show();
	    		$('#forms_id').attr('form-status', response.forms_status);
	    	}else{
	    		$('#reassign').hide();
	    	}

	    	$('#forms_id').val(response.forms_id);
	    },
	    error: function(request, status, error){

	    	console.log("something went wrong. Sorry for that!");    	
	    }
	});
}

function save_timerecord_aux( forms, status , type, revision)
{
	if( type == 'manage' && revision == 1){
		if (!$("#approver_remarks").val()) {
            $("#approver_remarks").focus();
            return false;
        }
	}

    $.blockUI({ message: saving_message(),
        onBlock: function(){
        	$('input, select , textarea').attr("disabled", false); 
            forms.submit( function(e){ e.preventDefault(); } );
            var save_url = base_url + module.get('route') + '/save_timerecord_aux';
            var data = forms.find(":not('.dontserializeme')").serialize()

           $.ajax({
                url: save_url,
                type:"POST",
                data: data + "&status_id=" + status+ "&type="+type+"&revision="+revision,
                dataType: "json",
                async: false,
                beforeSend: function(){
                    
                },
                success: function ( response ) {
                    
                    if( typeof response.saved )
                    {
                        $('#pay_dates').val(response.period_id);
                        $('#pay_dates').trigger('change');

                        if(response.manage == 'manage')
                        {
                        	setTimeout(function(){window.location.replace(base_url + module.get('route') + '/updating/manage/'+ $('#forms_id').val() )},1000);
                        }
                    }

                    handle_ajax_message( response.message );
                }
            });
            
        },
        baseZ: 300000000
    });
    setTimeout(function(){$.unblockUI()},2000);
        // $.unblockUI();
}



function reassign_approver(approver_id){

	var forms_id = $('#forms_id').val();
	var forms_status = $('#forms_id').attr('form-status');
    var request_data = {approver_id: approver_id, forms_id: forms_id, 'forms_status': forms_status};  
    $.blockUI({ message: '<div>Loading...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
     onBlock: function(){
        $.ajax({
            url: base_url + module.get('route') + '/reassign_approver',
            type:"POST",
            async: false,
            data: request_data,
            dataType: "json",
            beforeSend: function(){
            },
            success: function ( response ) {
                if( typeof(response.edit_reassign_approver) != 'undefined' ){

                    $('#reassign_approver_modal').html(response.edit_reassign_approver);
                    $('#reassign_approver_modal').attr('data-width', '450');
                    $('#reassign_approver_modal').modal('show');

                    $('#new_approver').select2({
                        placeholder: "Select an option",
                        minimumInputLength: 1
                    });
                }
                handle_ajax_message( response.message );
            }            
        });
     }
    });
    $.unblockUI();   
}