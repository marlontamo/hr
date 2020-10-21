$(document).ready(function(){
$('#users_profile-department_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#users_profile-group_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#users_profile-division_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#users_department-immediate_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
if (jQuery().datepicker) {
    $('#users_profile-birth_date').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
if (jQuery().datepicker) {
    $('#partners-effectivity_date').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
$('#partners-status_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#users_profile-location_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#users_profile-company').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#users_profile-position_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#partners-shift_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#users-role_id').select2({
    placeholder: "Select an option",
    allowClear: true
});});