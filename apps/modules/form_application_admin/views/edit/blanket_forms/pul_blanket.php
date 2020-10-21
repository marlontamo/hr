<input type="hidden" name="form_code" id="form_code" value="PUL">
	<div class="form-group">
		<label class="control-label col-md-4">From<span class="required">* </span></label>
		<div class="col-md-6">							
			<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
				<input type="text" class="form-control" name="time_forms[date_from]" id="time_forms-date_from" value="<?php echo $record['time_forms.date_from'] ?>" placeholder="">
				<span class="input-group-btn">
					<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
			</div> 				
		<div class="help-block small">
			Select Start Date
		</div>
		</div>	
	</div>
	<div class="form-group">
		<label class="control-label col-md-4">To<span class="required">* </span></label>
		<div class="col-md-6">							
			<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
				<input type="text" class="form-control" name="time_forms[date_to]" id="time_forms-date_to" value="<?php echo $record['time_forms.date_to'] ?>" placeholder="">
				<span class="input-group-btn">
					<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
			</div> 				
		<div class="help-block small">
			Select End Date
		</div>
		</div>	
	</div>			
	<div class="form-group">
		<label class="control-label col-md-4 text-danger small">Note: </label>
		<div class="col-md-6">
			<div class="help-block small">
				You have filed <span id="days" name="days"></span> day/s and you have an option to modify each.
			</div>
			<div class="btn-grp">
				<button id="goto_vl_co" class="btn blue btn-xs" type="button"><small>Change Options</small></button>
			</div>
		</div>
	</div>

<script>
	if (jQuery().datepicker) {
	    $('#time_forms-date_from').parent('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        autoclose: true
	    });
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}
	if (jQuery().datepicker) {
	    $('#time_forms-date_to').parent('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        autoclose: true
	    });
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}
	
   $('#goto_vl_co').click(function () {
    	$('#main_form').hide();
        $('.form-actions').hide();
    	$('#change_options').show();
    });

    $('#time_forms-date_from').change(function () {
        if($('#time_forms-date_to').val() != "" && $('#goto_vl_co').length > 0 ){
            get_selected_dates($('#record_id').val(), $('#form_status_id').val(), $('#time_forms-date_from').val(), $('#time_forms-date_to').val());
            $('#change_options_note').show();
        }
    })

    $('#time_forms-date_to').change(function () {
        if($('#time_forms-date_from').val() != "" && $('#goto_vl_co').length > 0 ){
            get_selected_dates($('#record_id').val(), $('#form_status_id').val(), $('#time_forms-date_from').val(), $('#time_forms-date_to').val());
            $('#change_options_note').show();
        }
    })

    if($("input[name='form_code']").val() == 'PUL') {
		$('#assignment_show').addClass('hide');
	}
</script>