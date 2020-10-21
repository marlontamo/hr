<input type="hidden" name="form_code" id="form_code" value="MS">
	<div class="form-group">
		<label class="control-label col-md-4">Date<span class="required">* </span></label>
		<div class="col-md-6">							
			<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
				<input type="text" class="form-control" name="time_forms[form_date]" id="time_forms-form_date" value="<?php $record['time_forms.form_date'] ?>" placeholder="">
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
        <label class="control-label col-md-4">Work Schedule <span class="required">*</span></label>
        <div class="col-md-6">
            <?php
                // $option = $this->db->get_where('time_shift', array('shift_id' => 42,'deleted' => 0));
                // $options = array('' => 'Select...');
                // foreach ($option->result() as $opt) {
                //     $options[$opt->shift_id] = $opt->shift;
                // }
                // echo form_dropdown('work_schedule',$options, $work_schedule, 'class="form-control select2me" data-placeholder="Select..."');
                $shift = $this->db->get_where('time_shift', array('shift_id' => 42,'deleted' => 0));
                $result = array();
                if($shift->num_rows() > 0) {
                	$result = $shift->row_array(); 
                }
            ?> 
            <input type="text" class="form-control" name="shift_name" id="shift_name" value="<?php echo $result['shift'] ?>" placeholder="" disabled/>
            <input type="text" class="form-control hidden" name="work_schedule" id="work_schedule" value="<?php echo $result['shift_id'] ?>" placeholder=""/>
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

	if($("input[name='form_code']").val() == 'MS') {
		$('#assignment_show').removeClass('hide');
	} 
	
</script>