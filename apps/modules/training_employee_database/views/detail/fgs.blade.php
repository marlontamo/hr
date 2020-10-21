<div class="portlet">

	<div class="portlet-title">
		<div class="caption">Employee Details</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>

	<div class="portlet-body form">	
			
		<div class="form-group">
			<label class="control-label col-md-3">Employee</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="employee" id="employee" disabled="disabled" value="{{ $record['employee'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Position</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="position" id="position" disabled="disabled" value="{{ $record['position'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Division</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="division" id="division" disabled="disabled" value="{{ $record['division'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Department</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="department" id="department" disabled="disabled" value="{{ $record['department'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Project</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="project" id="project" disabled="disabled" value="{{ $record['project'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Rank</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="rank" id="rank" disabled="disabled" value="{{ $record['rank'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Employment Status</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="employment_status" id="employment_status" disabled="disabled" value="{{ $record['employment_status'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Daily Training Cost</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="daily_training_cost" id="daily_training_cost" disabled="disabled" value="{{ $record['daily_training_cost'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Training Balance</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="training_balance" id="training_balance" disabled="disabled" value="{{ $record['training_balance'] }}" placeholder="" /> 				
			</div>	
		</div>

	</div>
	
</div>


<?php 
	if( $employee_training_total > 0 ){
		foreach( $employee_training as $employee_training_info ){
?>
<div class="portlet">

	<div class="portlet-title">
		<div class="caption">Training Details</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>

	<div class="portlet-body form">	
			
		<div class="form-group">
			<label class="control-label col-md-3">Training</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="course" id="course" disabled="disabled" value="{{ $employee_training_info['course'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Provider</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="provider" id="provider" disabled="disabled" value="{{ $employee_training_info['provider'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Venue</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="venue" id="venue" disabled="disabled" value="{{ $employee_training_info['venue'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Start Date</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="start_date" id="start_date" disabled="disabled" value="{{ $employee_training_info['start_date'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">End Date</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="end_date" id="end_date" disabled="disabled" value="{{ $employee_training_info['end_date'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Direct Cost</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="cost_per_pax" id="cost_per_pax" disabled="disabled" value="{{ $employee_training_info['cost_per_pax'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Schedule</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="schedule" id="schedule" disabled="disabled" value="" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Training Cost</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="cost_per_pax" id="cost_per_pax" disabled="disabled" value="{{ $employee_training_info['cost_per_pax'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Bond Start Date</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="bond_start_date" id="bond_start_date" disabled="disabled" value="{{ $employee_training_info['bond_start_date'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Bond End Date</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="bond_end_date" id="bond_end_date" disabled="disabled" value="{{ $employee_training_info['bond_end_date'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">No. of Bond Days</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="no_bond_days" id="no_bond_days" disabled="disabled" value="{{ $employee_training_info['no_bond_days'] }}" placeholder="" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Bond Status</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="bond_status" id="bond_status" disabled="disabled" value="{{ $employee_training_info['bond_status'] }}" placeholder="" /> 				
			</div>	
		</div>

	</div>
	
</div>

<?php 
		}
	}
?>