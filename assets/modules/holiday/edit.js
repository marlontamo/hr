$(document).ready(function(){
// $('#time_holiday-locations').multiselect();

// $('#time_holiday_location-location_id').multiselect();

	$('#time_holiday-legal-temp').change(function(){
		if( $(this).is(':checked') )
			$('#time_holiday-legal').val('1');
		else
			$('#time_holiday-legal').val('0');
	});
	if (jQuery().datepicker) {
	    $('#time_holiday-holiday_date').parent('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        autoclose: true
	    });
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}
});

function populate()
{
	var record_id = $('#record_id').val();
	$.ajax({
	    url: base_url + module.get('route') + '/populate_holiday_form',
	    type: "POST",
	    async: false,
	    data: 'record_id='+record_id,
	    dataType: "json",
	    beforeSend: function () {
	        $.blockUI({
	        	message: '<img src="'+ base_url +'assets/img/ajax-modal-loading.gif"><br />Loading discussion, please wait...',
	        	css: {
					background: 'none',
					border: 'none',		
			    	'z-index':'99999'		    	
				},
				baseZ: 20000,
	        });
	    },
	    success: function (response) {
	        $.unblockUI();

	        if (typeof (response.year_holiday) != 'undefined') {
	        	$('.modal-container').html(response.year_holiday);
				$('.modal-container').modal();      
	        }
	        handle_ajax_message( response.message );
	    }
	});
}

function populate_save( form )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){

			var hasCKItem = form.find("textarea.ckeditor");

			if(hasCKItem && (typeof editor != 'undefined')){
				
				for ( instance in CKEDITOR.instances )
        			CKEDITOR.instances[instance].updateElement();
			}

			var data = form.find(":not('.dontserializeme')").serialize();
			// console.log(data);
			$.ajax({
				url: base_url + module.get('route') + '/save_populated_holiday',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( response.saved )
					{
						document.location = base_url + module.get('route');

						$('.modal-container').modal('hide');
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}