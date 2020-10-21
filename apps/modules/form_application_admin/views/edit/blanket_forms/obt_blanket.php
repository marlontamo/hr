<input type="hidden" name="form_code" id="form_code" value="OBT">
<div class="form-group">
	<label class="control-label col-md-4">Type<span class="required">* </span></label>
	<div class="col-md-6">
		<?php	                        

		$business_trip_type_options = array();
		$business_trip_type_options[1] = 'Standard';
		$business_trip_type_options[2] = 'Date Range';

		?>							
		<div class="input-group">
			<span class="input-group-addon">
				<i class="fa fa-list-ul"></i>
			</span>
			<?php echo form_dropdown('time_forms[bt_type]',$business_trip_type_options, $bt_type, ' id="obt_select" class="form-control select2me" data-placeholder="Select..."') ?>
		</div> 				
	</div>	
</div>

<div class="form-group">
	<label class="control-label col-md-4">Location</label>
	<div class="col-md-6">							
		<input type="text" class="form-control" name="time_forms_obt[location]" id="time_forms_obt-location" value="" placeholder=""/> 				
	</div>	
</div>

<div class="form-group">
	<label class="control-label col-md-4">From<span class="required">* </span></label>
	<div class="col-md-6">							
		<div class="input-group date " data-date-format="MM dd, yyyy - HH:ii p">                                       
			<input type="text" size="16" class="form-control" name="time_forms[date_from]" id="time_forms-datetime_from" value="" />
			<span class="input-group-btn">
				<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
			</span>
		</div> 				
	</div>	
</div>	
<div class="form-group">
	<label class="control-label col-md-4">To<span class="required">* </span></label>
	<div class="col-md-6">							
		<div class="input-group date form_datetime">                                       
			<input type="text" size="16" class="form-control" name="time_forms[date_to]" id="time_forms-datetime_to" value="" />
			<span class="input-group-btn">
				<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
			</span>
		</div> 				
	</div>	
</div>

<script>
    $("#time_forms-datetime_from").datetimepicker({
        format: "MM dd, yyyy - HH:ii p",
        autoclose: true,
        todayBtn: false,
        pickerPosition: "bottom-left",
        minuteStep: 1
    });

    $("#time_forms-datetime_to").datetimepicker({
        format: "MM dd, yyyy - HH:ii p",
        autoclose: true,
        todayBtn: false,
        pickerPosition: "bottom-left",
        minuteStep: 1
    });

    if (jQuery().timepicker) {
        $('.timepicker-default').timepicker({
            autoclose: true
        });
    }
</script>