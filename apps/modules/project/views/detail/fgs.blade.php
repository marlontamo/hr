<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Project Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3">Project</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="" id="" value="{{ $record['users_project_project'] }}" placeholder="{{ lang('weeklyshift.mon') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">Project Code</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="" id="" value="{{ $record['users_project_project_code'] }}" placeholder="{{ lang('weeklyshift.tue') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">Active</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="" id="" value="{{ $record['users_project_status_id'] }}" placeholder="{{ lang('weeklyshift.wed') }}" /> 				
			</div>	
		</div>							
	</div>
</div>