<input type="hidden" name="form_code" id="form_code" value="CWS">
<div class="form-group">
	<label class="control-label col-md-4"><?php echo lang('form_application.date') ?><span class="required">* </span></label>
	<div class="col-md-6">							
		<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
			<input type="text" class="form-control" name="time_forms[date_from]" id="time_forms-date_from" placeholder="Enter Date">
			<span class="input-group-btn">
				<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
			</span>
		</div> 				
		<div class="help-block small">
			<?php echo lang('form_application.select_date') ?>
		</div>
	</div>	
</div>
<!-- <div class="form-group">
	<label class="control-label col-md-4"><?php echo lang('form_application.current_sched') ?><span class="required">* </span></label>
	<div class="col-md-6">
		<?php	                        

		$shift_options = array();

		foreach($shifts as $index => $value){
			$shift_options[$value['shift_id']] = $value['shift'];
		}

		?>							
		<div class="input-group">
			<input type="hidden" size="16" class="form-control" readonly id="shift_id" name="shift_id"> 
			<span class="input-group-addon">
				<i class="fa fa-list-ul"></i>
			</span>
			<?php echo form_dropdown('shift_id_select',$shift_options, $shift_id['val'], 'id="shift_id_select" class="form-control select2me" data-placeholder="Select..." disabled') ?>
		</div> 				
	</div>	
</div> -->
<div class="form-group">
	<label class="control-label col-md-4"><?php echo lang('form_application.new_sched') ?><span class="required">* </span></label>
	<div class="col-md-6">
		<?php	                        

		$shift_options = array();

		foreach($shifts as $index => $value){

			$shift_options[$value['shift_id']] = $value['shift'];

		}


		?>							
		<div class="input-group">
			<span class="input-group-addon">
				<i class="fa fa-list-ul"></i>
			</span>
			<?php echo form_dropdown('shift_to',$shift_options, $shift_to['val'], 'id="shift_to" class="form-control select2me" data-placeholder="Select..."') ?>
		</div> 				
	</div>	
</div>
<script>
	$(document).ready(function(){
		if (jQuery().datepicker) {
		    $('#time_forms-date_from').parent('.date-picker').datepicker({
		        rtl: App.isRTL(),
		        autoclose: true
		    });
		    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
		}
	});
</script>