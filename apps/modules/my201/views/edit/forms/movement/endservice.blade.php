<div class="form-group">
	<label class="control-label col-md-3">
		End Date
	</label>
    <input type="hidden" name="partners_movement_action_moving[id]" id="partners_movement_action_moving-id" 
    value="<?php echo $record['partners_movement_action_moving.id']; ?>" />	
	<div class="col-md-7">							
		<div class="input-group input-medium " data-date-format="MM dd, yyyy">
			<input disabled type="text" class="form-control" name="partners_movement_action_moving[end_date]" 
			id="partners_movement_action_moving-end_date" value="<?php echo $record['partners_movement_action_moving.end_date']; ?>" placeholder="Enter End Date" readonly>
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
			<input type="hidden" name="partners_movement_action_moving[blacklisted]" id="partners_movement_action_moving-blacklisted" 
			value="<?php ( $record['partners_movement_action_moving.blacklisted'] ) ? 1 : 0 ?>"/>
		</div> 				
	</div>	
</div>	
<div class="form-group">
	<label class="control-label col-md-3">
		Reason
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
			<select disabled name="partners_movement_action_moving[reason_id]" id="partners_movement_action_moving-reason_id"
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
		<textarea disabled class="form-control" name="partners_movement_action_moving[further_reason]" id="partners_movement_action_moving-further_reason" placeholder="Enter Further Reason" rows="4"><?php echo $record['partners_movement_action_moving.further_reason']; ?></textarea> 				
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
        $('#partners_movement_action_moving-end_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
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