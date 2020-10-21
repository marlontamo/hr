$(document).ready(function() {
	$('.make-switch').not(".has-switch")['bootstrapSwitch']();
	$('label[for="partners_personal_history-family-dependent-temp"]').css('margin-top', '0');
	$('.dependent').change(function(){
	    if( $(this).is(':checked') ){
	    	$(this).parent().next().val(1);
	    }
	    else{
	    	$(this).parent().next().val(0);
	    }
	});
	
	if (jQuery().datepicker) {
	    $('#users_profile-birth_date').parent('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        autoclose: true
	    });
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}
});

function view_personal_details(modal_form, key_class, sequence){	
	$.ajax({
		url: base_url + module.get('route') + '/view_personal_details',
		type:"POST",
		async: false,
		data: 'modal_form='+modal_form+'&key_class='+key_class+'&sequence='+sequence,
		dataType: "json",
		beforeSend: function(){
			// $('body').modalmanager('loading');
		},
		success: function ( response ) {

			handle_ajax_message( response.message );

			if( typeof(response.view_details) != 'undefined' )
			{	
				$('.modal-container-partners').html(response.view_details).modal();		
			}

		}
	});	
}
function save_partner( partner )
{
	partner.submit( function(e){ e.preventDefault(); } );
	var user_id = $('#record_id').val();
	var partner_id = partner.attr('partner_id');
	//$('input[type="text"],input[type="radio"], textarea, select').attr("disabled", false);		
	$.blockUI({ message: saving_message(), 
		onBlock: function(){
			partner.submit( function(e){ e.preventDefault(); } );
			var partner_id = partner.attr('partner_id');
			var data = partner.find(":not('.dontserializeme')").serialize();
			data = data + '&record_id=' + $('#record_id').val()+ '&fgs_number=' + partner_id;
			


			$.ajax({
				url: base_url + module.get('route') + '/save',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );
					//$('input[type="text"],input[type="radio"], textarea, select').attr("disabled", true);		
					
				}
			});
		}
	});
	$.unblockUI();	

    // location.reload();
}


	//remove phone
function remove_form(div_form, mode, tab){
	if(tab == 'history'){
		$('#'+div_form).parent().parent().parent().remove();
		var count = ($('#'+mode+'_count').val() - 1);
		$('#'+mode+'_count').val(count);
	}else{
		$('#'+div_form).parent().parent().remove();
		var count = ($('#'+mode+'_count').val() - 1);
		var counting = $('#'+mode+'_counting').val();
		if( count == 1 ){
			$('.action_'+mode).remove();
			var span_delete_add = '<a class="btn btn-default action_'+mode+' add_'+mode+'" id="add_'+mode+'" onclick="add_form(\'contact_'+mode+'\', \''+mode+'\')" ><i class="fa fa-plus"></i></a>';
			$('.add_delete_'+mode).append(span_delete_add);
		}else{
			$( "#personal_"+mode+" div.form-group:last-child span.add_delete_"+mode+":last-child a.add_"+mode ).remove();
			var span_delete_add = '<a class="btn btn-default action_'+mode+' add_'+mode+'" id="add_'+mode+'" onclick="add_form(\'contact_'+mode+'\', \''+mode+'\')" ><i class="fa fa-plus"></i></a>';			
			$( "#personal_"+mode+" div.form-group:last-child span.add_delete_"+mode+":last-child" ).append(span_delete_add);	
		}
		$('#'+mode+'_count').val(count);	
		var count_val = 1;
		var num = 1;
		while(counting >= num){
			if( $('#'+mode+'_display_count-'+num).length ) {
				if(count_val == 1){
					$('#'+mode+'_display_count-'+num).text('');
				}else{
					$('#'+mode+'_display_count-'+num).text(count_val);
				}
				count_val++;
			}
			num++;
		}
	}
}

//add phone 
function add_form(add_form, mode, sequence){
	var count = $('#'+mode+'_count').val();
	var counting = $('#'+mode+'_counting').val();
	var form_category = ( $('#'+mode+'_category').length ) ? $('#'+mode+'_category').val() : '';
	if( count == 1 ){
		$('.action_'+mode).remove();
		var span_delete_add = '<a class="btn btn-default action_"'+mode+' id="delete_'+mode+'-'+counting+'" onclick="remove_form(this.id, \''+mode+'\')" ><i class="fa fa-trash-o"></i></a>';
		$('.add_delete_'+mode).append(span_delete_add);
	}
	$.ajax({
		url: base_url + module.get('route') + '/add_form',
		type:"POST",
		async: false,
		data: 'add_form='+add_form+'&count='+count+'&category='+form_category+'&counting='+counting,
		dataType: "json",
		beforeSend: function(){
		},
		success: function ( response ) {

			for( var i in response.message )
			{
				if(response.message[i].message != "")
				{
					var message_type = response.message[i].type;
					notify(response.message[i].type, response.message[i].message);
				}
			}
			if( typeof(response.add_form) != 'undefined' )
			{	
				$('#add_'+mode).remove();
				$('#'+mode+'_count').val(response.count);
				$('#'+mode+'_counting').val(response.counting);
				$('#personal_'+mode).append(response.add_form);
				// handleSelect2();
				FormComponents.init();
			}

		}
	});	
}

function _calculateAge(birthday, count) { // birthday is a date
	dateString = birthday.value;

	var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
	$( "#partners_personal_history-family-age"+count ).val(age);
}