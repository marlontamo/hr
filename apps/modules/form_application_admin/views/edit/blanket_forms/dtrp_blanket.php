<input type="hidden" name="form_code" id="form_code" value="DTRP">
<div class="form-group">
	<label class="control-label col-md-4"><?php echo lang('form_application.type') ?><span class="required">* </span></label>
	<div class="col-md-6">
		<?php	                        

		$dtrp_type_options = array();
		$dtrp_type_options[1] = 'Time In';
		$dtrp_type_options[2] = 'Time Out';
		$dtrp_type_options[3] = 'Time In and Time Out';

		?>							
		<div class="input-group">
			<span class="input-group-addon">
				<i class="fa fa-list-ul"></i>
			</span>
			<?php echo form_dropdown('dtrp_type',$dtrp_type_options, $dtrp_type, 'id="dtrp_type" class="form-control select2me" data-placeholder="Select..."') ?>
		</div> 				
	</div>	
</div>
<div class="form-group">
	<label class="control-label col-md-4"><?php echo lang('form_application.dtrp_date') ?><span class="required">* </span></label>
	<div class="col-md-6">							
		<div class="input-group date date-picker" data-date-format="MM dd, yyyy">                                       
				<input type="text" size="16" class="form-control" name="time_forms[focus_date]" id="time_forms-focus_date" value="" />
				<span class="input-group-btn">
					<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
				</span>
		</div> 				
	</div>	
</div>
<div class="form-group">
	<label class="control-label col-md-4"><?php echo lang('form_application.from') ?><span class="required">* </span></label>
	<div class="col-md-6">							
		<div class="input-group date form_datetime" data-date-format="MM dd, yyyy - HH:ii p">                                       
			<input type="text" size="16" class="form-control" name="time_forms[date_from]" id="time_forms-datetime_from" />
			<span class="input-group-btn">
				<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
			</span>
		</div> 				
	</div>	
</div>	
<div class="form-group">
	<label class="control-label col-md-4"><?php echo lang('form_application.to') ?><span class="required">* </span></label>
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
$(document).ready(function(){

	check_dtrp_type($('#dtrp_type').val(), 0)

	//disabled datepicker
	if($('#form_status_id').val()>2){
		$('.form_datetime').removeClass('form_datetime');
	}

  	$("#time_forms-datetime_from").change(function(){ 
  		if($("#dtrp_type").val() != 3){
	  		if($(this).val() != "" && $("#time_forms-datetime_to").val() != ""){
  				get_shift_details($(this).val(), $(this).val(), 11, $('#dtrp_type').val());
  			}
  		}
  	});

  	$("#time_forms-datetime_to").change(function(){ 
  		if($("#dtrp_type").val() != 3){
	  		if($(this).val() != "" && $("#time_forms-datetime_from").val() != ""){
  				get_shift_details($(this).val(), $(this).val(), 11, $('#dtrp_type').val());
  			}
  		}
  	});


	$("#dtrp_type").change(function(){ 
		check_dtrp_type($(this).val(), 1)
	});

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

    $("#time_forms-focus_date").datepicker({
        format: "MM dd, yyyy",
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
});


function check_dtrp_type(dtrp_type, load_shift){
	if(dtrp_type == 1){
		$('#time_forms-focus_date').val('');
		$('#time_forms-datetime_to').parent().parent().parent().hide();
		$('#time_forms-datetime_from').parent().parent().parent().show();
		$('#time_forms-focus_date').parent().parent().parent().hide();
	}else if (dtrp_type == 2){
		$('#time_forms-datetime_from').parent().parent().parent().hide();
		$('#time_forms-datetime_to').parent().parent().parent().show();
		$('#time_forms-focus_date').parent().parent().parent().show();
	}else{
		$('#time_forms-focus_date').val('');
		$('#time_forms-datetime_from').parent().parent().parent().show();
		$('#time_forms-datetime_to').parent().parent().parent().show();
		$('#time_forms-focus_date').parent().parent().parent().hide();
	}

	if(load_shift == 1){
		if($("#time_forms-datetime_to").val() != "" && $("#time_forms-datetime_from").val() != ""){
			get_shift_details($("#time_forms-datetime_from").val(), $("#time_forms-datetime_to").val(), 11, $('#dtrp_type').val());
		}
	}else{
		if(dtrp_type == 1){
			$('#time_forms-datetime_to').val($('#time_forms-datetime_from').val());
		}else if(dtrp_type == 2){
			$('#time_forms-datetime_from').val($('#time_forms-datetime_to').val());
		}
	}
}
</script>