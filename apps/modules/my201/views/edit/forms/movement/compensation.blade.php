<div class="form-group">
	<label class="control-label col-md-3">
		Current Salary
	</label>
	<div class="col-md-7">
	    <input type="hidden" name="partners_movement_action_compensation[id]" id="partners_movement_action_compensation-id" 
	    value="<?php echo $record['partners_movement_action_compensation.id']; ?>" />						
		<input type="text" disabled readonly class="form-control" name="partners_movement_action_compensation[current_salary]" id="partners_movement_action_compensation-current_salary" value="<?php echo $record['partners_movement_action_compensation.current_salary'] ?>" placeholder="Enter Current Salary" /> 				
	</div>	
</div>			
<div class="form-group">
	<label class="control-label col-md-3">
		New Salary
	</label>
	<div class="col-md-7">							
		<input type="text" disabled class="form-control" name="partners_movement_action_compensation[to_salary]" id="partners_movement_action_compensation-to_salary" value="<?php echo $record['partners_movement_action_compensation.to_salary'] ?>" placeholder="Enter New Salary" /> 				
	</div>	
</div>	