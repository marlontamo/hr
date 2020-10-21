<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Movement Details</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">	
		<div class="form-group">
			<label class="control-label col-md-2">
				<input type="hidden" name="field_count" id="field_count-<?php echo $count; ?>" value="0"/>
			</label>
			<div class="col-md-4">Current</div>
			<div class="col-md-6">To</div>
		</div>
		<?php foreach ($additional_allowance as $additional_allowance_field) {
		?>
			<div class="form-group">
				<label class="control-label col-md-2">
					<span class="required hidden">* </span>
					<?php echo $additional_allowance_field['transaction_label']; ?>
				</label>
				<div class="col-md-4">	 
						<input type="text" readonly class="form-control" name="partners_movement_action_transfer[from_name][]" 
						value="<?php echo $additional_allowance_field['from_allowance']; ?>" /> 
				</div>
				<div class="col-md-6">	
						<input type="text" readonly class="form-control trans_field" name="partners_movement_action_transfer[to_name][]" 
						value="<?php echo $additional_allowance_field['to_allowance']; ?>" placeholder="" /> 		
				</div>	
			</div>
		<?php 
		}
		?>
	</div>
</div>