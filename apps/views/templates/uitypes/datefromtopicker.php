if (jQuery().datepicker) {
    $('#<?php echo $table?>-<?php echo $column?>_from').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}