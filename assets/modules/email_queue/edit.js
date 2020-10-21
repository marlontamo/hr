$(document).ready(function() {
	if ($('.wysihtml5').size() > 0) {
        $('.wysihtml5').wysihtml5({
            "stylesheets": ["assets/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
        });
    
        $('input[name="_wysihtml5_mode"]').addClass('dontserializeme');
         $('.wysihtml5-sandbox').attr('disabled', true);
    }
    
    $(".form_datetime").datetimepicker({
        autoclose: true,
        todayBtn: false,
        pickerPosition: "bottom-left",
        minuteStep: 1
    });
    if (jQuery().select2) {
	    $('#system_email_queue-to').select2({
	        placeholder: "Select an option",
	        allowClear: true
	    });
	}

});