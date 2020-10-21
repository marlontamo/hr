$(document).ready(function(){
	
	if (jQuery().datepicker) {
	    $('#time_forms_ot_leave-expiration_date').parent('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        autoclose: true
	    });
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}

});