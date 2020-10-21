function back_to_leavebalance(cancel){
    if(cancel==1){
        get_selected_dates($('#record_id').val(), $('#form_status_id').val(), $('#time_forms-date_from').val(), $('#time_forms-date_to').val());    
    }
    $('#change_options').hide();
    $('#main_form').show();
    $('.form-actions').show();
}