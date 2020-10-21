<input type="hidden" name="form_code" id="form_code" value="ET">
	<div class="form-group">
		<label class="control-label col-md-4">Date<span class="required">* </span></label>
		<div class="col-md-6">							
			<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
				<input type="text" class="form-control" name="time_forms[date_from]" id="time_forms-date_from" value="<?php $record['time_forms.date_from'] ?>" placeholder="">
				<span class="input-group-btn">
					<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
			</div> 				
		<div class="help-block small">
			Select Date
		</div>
		</div>	
	</div>
	<div class="form-group">
		<label class="control-label col-md-4">Time <span class="required">*</span></label>
		<div class="col-md-6">
			<div class="input-group bootstrap-timepicker">                                       
				<input type="text" class="form-control timepicker-default" id="ut_time_in_out" name="ut_time_in_out" value="<?php echo $ut_time_in_out; ?>">
				<span class="input-group-btn">
				<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
				</span>
			</div>
			<!-- /input-group -->
			<div class="help-block small">
				Select Time
			</div>
		</div>
	</div> 
<script>
	if (jQuery().datepicker) {
	    $('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        autoclose: true
	    });
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}

	if (jQuery().timepicker) {
	    $('.timepicker-default').timepicker({
	        autoclose: true
	    });
	}

	if($("input[name='form_code']").val() == 'ET') {
		$('#assignment_show').addClass('hide');
	} 
	
</script>