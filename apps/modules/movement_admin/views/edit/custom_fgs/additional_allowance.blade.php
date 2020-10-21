<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Movement Details</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">	
		<?php foreach ($additional_allowance as $additional_allowance_field) {
		?>
			<div class="form-group">
				<label class="control-label col-md-3">
					<span class="required hidden">* </span>
					<?php echo $additional_allowance_field['transaction_label']; ?>
					<input type="hidden" name="partners_movement_action_additional_allowance[transaction_id][]"
					id="partners_movement_action_additional_allowance-transaction_id" value="<?php echo $additional_allowance_field['transaction_id']; ?>">
					<input type="hidden" name="partners_movement_action_additional_allowance[transaction_label][]"
					id="partners_movement_action_additional_allowance-transaction_label" value="<?php echo $additional_allowance_field['transaction_label']; ?>">
				</label>
				<div class="col-md-4">	
					<input type="text" readonly class="form-control" name="partners_movement_action_additional_allowance[from_allowance][]" 
					id="partners_movement_action_additional_allowance-from_allowance-<?php echo $additional_allowance_field['transaction_id']?>" value="<?php echo $additional_allowance_field['from_allowance']; ?>" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 
				</div>
				<div class="col-md-5">	
					<input type="text" class="form-control trans_field" name="partners_movement_action_additional_allowance[to_allowance][]" 
					id="partners_movement_action_additional_allowance-to_allowance-<?php echo $additional_allowance_field['transaction_id']?>" 
					value="<?php echo $additional_allowance_field['to_allowance']; ?>" placeholder="Enter New <?php echo $additional_allowance_field['transaction_label']; ?>" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 
				</div>	
			</div>
		<?php 
		}
		?>
	</div>
</div>