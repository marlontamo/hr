$(document).ready(function(){

    if (jQuery().datepicker) {
        $('#recruitment_request-delivery_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }

    if (jQuery().datepicker) {
        $('#recruitment_request-created_on').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    if (jQuery().datepicker) {
        $('#recruitment_request-date_needed').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    $('#recruitment_request-department_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#recruitment_request-company_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });

    $(".pop-uri").fancybox(
    {
        autoSize: false,
        width: '80%',
        height: '100%',
    }
);
});