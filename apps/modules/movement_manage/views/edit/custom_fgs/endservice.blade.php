<div class="form-group">
	<input type="hidden" class="form-control" name="partners_movement_action_moving[end_date]" value="" />
	<label class="control-label col-md-3">
		End Date
	</label>
    <input type="hidden" name="partners_movement_action_moving[id]" id="partners_movement_action_moving-id" 
    value="<?php echo $record['partners_movement_action_moving.id']; ?>" />	
	<div class="col-md-7">							
		<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
			<input disabled type="text" class="form-control" name="partners_movement_action_moving[end_date]" 
			id="partners_movement_action_moving-end_date" value="<?php echo ($record['partners_movement_action_moving.end_date'] && $record['partners_movement_action_moving.end_date'] != '0000-00-00' && $record['partners_movement_action_moving.end_date'] != 'November 30, -0001' && $record['partners_movement_action_moving.end_date'] != 'January 01, 1970' && $record['partners_movement_action_moving.end_date'] != '1970-01-01') ? $record['partners_movement_action_moving.end_date'] : '' ?>" placeholder="Enter End Date" readonly>
			<span class="input-group-btn">
				<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
			</span>
		</div> 				
	</div>	
</div>			
<div class="form-group">
	<label class="control-label col-md-3">Blacklisted
	</label>
	<div class="col-md-7">							
		<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
			<input disabled type="checkbox" value="1" <?php if ( $record['partners_movement_action_moving.blacklisted'] ){ echo "checked='checked'"; } ?> 
			name="partners_movement_action_moving[blacklisted][temp]" id="partners_movement_action_moving-blacklisted-temp" class="dontserializeme toggle"/>
			<input disabled type="hidden" name="partners_movement_action_moving[blacklisted]" id="partners_movement_action_moving-blacklisted" 
			value="<?php ( $record['partners_movement_action_moving.blacklisted'] ) ? 1 : 0 ?>"/>
		</div> 				
	</div>	
</div>	
<div class="form-group">
	<label class="control-label col-md-3">
		<span class="required">* </span>Reason
	</label>
	<div class="col-md-7">
		<?php	
		$db->select('reason_id,reason');
		$db->order_by('reason', '0');
		$db->where('deleted', '0');
		$options = $db->get('partners_movement_reason'); 	                            
		$partners_movement_action_moving_reason_id_options = array('' => 'Select...');
		?>							
		<div class="input-group">
			<span class="input-group-addon">
				<i class="fa fa-list-ul"></i>
			</span>
			<select name="partners_movement_action_moving[reason_id]" id="partners_movement_action_moving-reason_id"
			class="form-control form-select" data-placeholder="Select...">
			<option value="">Select...</option>
			<?php
			foreach($options->result() as $option)
			{
				$selected = ($option->reason_id == $record['partners_movement_action_moving.reason_id']) ? "selected" : "";
			?>
				<option <?php echo $selected; ?> value="<?php echo $option->reason_id;?>"><?php echo $option->reason;?></option>
			<?php
			}
			?>
			</select>
		</div> 				
	</div>	
</div>		
<div class="form-group">
	<label class="control-label col-md-3">Further Reason
	</label>
	<div class="col-md-7">							
		<textarea class="form-control" name="partners_movement_action_moving[further_reason]" id="partners_movement_action_moving-further_reason" placeholder="Enter Further Reason" rows="4"><?php echo $record['partners_movement_action_moving.further_reason']; ?></textarea> 				
	</div>	
</div>

<script language="javascript">
$(document).ready(function(){
        
    if (jQuery().select2) {
	    $("#partners_movement_action_moving-reason_id").select2({
			placeholder: "Select a reason",
			allowClear: true
		});
		$('body').removeClass("modal-open"); 
	}

    if (jQuery().datepicker) {
    	$("#partners_movement_action_moving-end_date").datepicker().datepicker('disable');
/*        $('#partners_movement_action_moving-end_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });*/
        $('body').removeClass("modal-open"); 
    }
	
	$(".make-switch").bootstrapSwitch();
  
	$('#partners_movement_action_moving-blacklisted-temp').change(function(){
		if( $(this).is(':checked') )
			$('#partners_movement_action_moving-blacklisted').val('1');
		else
			$('#partners_movement_action_moving-blacklisted').val('0');
	});

});
</script>