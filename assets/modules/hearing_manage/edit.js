$(document).ready(function(){
	$("#partners_incident_nte-hearing_date").datetimepicker({
	    isRTL: App.isRTL(),
	    format: "dd MM yyyy - hh:ii",
	    autoclose: true,
	    todayBtn: true,
	    pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
	    minuteStep: 1
	});

    $('#partners_incident-hearing_others-temp').select2({
        placeholder: "Select users",
        allowClear: true
    });	
});

function save_record( form, action, callback )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){

			var hasCKItem = form.find("textarea.ckeditor");

			if(hasCKItem && (typeof editor != 'undefined')){
				
				for ( instance in CKEDITOR.instances )
        			CKEDITOR.instances[instance].updateElement();
			}

			var data = form.find(":not('.dontserializeme')").serialize();
			data = data +'&incident_status_id='+ action;
			$.ajax({
				url: base_url + module.get('route') + '/save',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( response.saved )
					{
						if( response.action == 'insert' )
							$('#record_id').val( response.record_id );

						if (typeof(after_save) == typeof(Function)) after_save( response );
						if (typeof(callback) == typeof(Function)) callback( response );

						switch( action )
						{
							case 'new':
								document.location = base_url + module.get('route') + '/add';
								break;
							case 6:
							case 10:
								document.location = base_url + module.get('route');
								break;
						}
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}