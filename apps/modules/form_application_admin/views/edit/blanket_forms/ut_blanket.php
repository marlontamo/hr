<input type="hidden" name="form_code" id="form_code" value="UT">
	<div class="form-group">
		<label class="control-label col-md-4"><?=lang('form_application.type')?><span class="required">*</span></label>
		<div class="col-md-6">
			<div class="make-switch" data-on-label="&nbsp;In&nbsp;" data-off-label="&nbsp;Out&nbsp;">
				<input type="checkbox" value="0" class="toggle" id="ut_type-temp" name="ut_type-temp" class="dontserializeme toggle" />
				<input type="hidden" value="" checked class="toggle" id="ut_type" name="ut_type"/>
			</div>
			<div class="help-block small">
				<?=lang('form_application.select_inout')?>
			</div>
		</div>
	</div>  
	<div class="form-group">
		<label class="control-label col-md-4"><?php echo lang('form_application_admin.ut_date') ?><span class="required">* </span></label>
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
		<label class="control-label col-md-4"><?php echo lang('form_application_admin.date_time') ?><span class="required">* </span></label>
		<div class="col-md-6">							
			<div class="input-group date form_datetime" data-date-format="MM dd, yyyy - HH:ii p">
				<input type="text" class="form-control" name="ut_time_in_out" id="ut_time_in_out" value="<?php $ut_time_in_out ?>" placeholder="">
				<span class="input-group-btn">
					<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
			</div> 				
		<div class="help-block small">
			Select Date and Time
		</div>
		</div>	
	</div>
<script>
	$(document).ready(function(){
		$('#ut_type-temp').change(function(){
			if( $(this).is(':checked') ){
				$('#ut_type').val('1');
				check_ut_type(1);
			}else{
				$('#ut_type').val('0');
				check_ut_type(0);
			}
		});		
	});

	function check_ut_type(ut_type){
		$('#time_forms-date_from').parent().parent().parent().hide();
		$('#time_forms-date_to').parent().parent().parent().show();
		$('#time_forms-date_from').val($('#date_to').val());

  	}

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

	if($("input[name='form_code']").val() == 'UT') {
		$('#assignment_show').addClass('hide');
	}
	
</script>