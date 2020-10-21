$("#<?php echo $table?>-<?php echo $column?>").datetimepicker({
    isRTL: App.isRTL(),
    format: "dd MM yyyy - hh:ii",
    autoclose: true,
    todayBtn: true,
    pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
    minuteStep: 1
});