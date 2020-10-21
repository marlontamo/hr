<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Movement Details</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">	
		<?php if($type_id == 12): ?>
			<div class="form-group">
				<label class="control-label col-md-3">
					<span class="required">* </span>End Date of Temporary Assignment
				</label>
				<div class="col-md-7">							
					<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
						<input type="text" class="form-control" name="partners_movement_action_transfer[end_date]" 
						id="partners_movement_action_transfer-end_date" value="<?php echo $end_date; ?>" placeholder="Enter End Date of Temporary Assignment" readonly>
						<span class="input-group-btn">
							<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
						</span>
					</div>
				</div>	
			</div>
		<?php endif; ?>
		<div class="form-group">
			<label class="control-label col-md-2">
				<input type="hidden" name="field_count" id="field_count-<?php echo $count; ?>" value="0"/>
			</label>
			<div class="col-md-4">Current</div>
			<div class="col-md-6">To</div>
		</div>
		<?php foreach ($transfer_fields as $transfer_field) {
		?>
			<div class="form-group">
				<label class="control-label col-md-2">
					<span class="required hidden">* </span>
					<?php echo $transfer_field['field_label']; ?>
				</label>
				<div class="col-md-4">	 
						<input type="text" readonly class="form-control" name="partners_movement_action_transfer[from_name][]" 
						id="<?php echo $transfer_field['field_name']?>-from_name" value="<?php echo $transfer_field['from_name']; ?>" /> 
				</div>
				<div class="col-md-6">	
						<input type="text" readonly class="form-control trans_field" name="partners_movement_action_transfer[to_name][]" 
						id="partners_movement_action_transfer-to_name-<?php echo $transfer_field['field_id']?>" 
						value="<?php echo $transfer_field['to_name']; ?>" placeholder="" /> 		
				</div>	
			</div>
		<?php 
		}
		?>
	</div>
</div>