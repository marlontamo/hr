<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Compensation Adjustment</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<p>Compensation Adjustment</p>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span>Current Salary
			</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="partners_movement_action_compensation[current_salary]" id="partners_movement_action_compensation-current_salary" value="{{ $record['partners_movement_action_compensation.current_salary'] }}" placeholder="Enter Current Salary" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span>New Salary
			</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="partners_movement_action_compensation[to_salary]" id="partners_movement_action_compensation-to_salary" value="{{ $record['partners_movement_action_compensation.to_salary'] }}" placeholder="Enter New Salary" /> 				
			</div>	
		</div>	
	</div>
</div>