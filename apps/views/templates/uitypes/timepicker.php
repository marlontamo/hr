if (jQuery().timepicker) {
    $('#<?php echo $table?>-<?php echo $column?>').timepicker({
        autoclose: true,
        showSeconds: true,
        minuteStep: 1,
        secondStep: 1
    });
}