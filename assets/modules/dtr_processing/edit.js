
if (jQuery().datepicker) {
    $('#time_period-payroll_date').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
if (jQuery().datepicker) {
    $('#time_period-date_from').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
if (jQuery().datepicker) {
    $('#time_period-cutoff').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
if (jQuery().datepicker) {
    $('#time_period-previous_cutoff').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
$(document).ready(function(){
// $('#time_period-project_id').multiselect();
    // $('#performance_planning-template_id').multiselect();
    $('#time_period-project_id').select2({
        placeholder: "Select project",
        allowClear: true
    });
    $('#time_period-company_id').select2({
        placeholder: "Select company",
        allowClear: true
    });    

    $('#time_period-apply_to_id').select2({
        placeholder: "Select",
        allowClear: true
    });    

    $('#time_period-applied_to').select2({
        placeholder: "Select",
        allowClear: true
    });            
});