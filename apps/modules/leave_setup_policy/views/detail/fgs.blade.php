<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('leave_setup_policy.title') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('leave_setup_policy.company') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="leave_setup_policy[job_level]" id="leave_setup_policy-job_level" value="{{ $record['time_form_balance_setup_policy.company'] }}" placeholder="{{ lang('leave_setup_policy.company') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('leave_setup_policy.balance_setup') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="leave_setup_policy[job_grade_code]" id="leave_setup_policy-job_grade_code" value="{{ $record['time_form_balance_setup_policy.employment_type'] }}" placeholder="{{ lang('leave_setup_policy.balance_setup') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('leave_setup_policy.leave_type') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="leave_setup_policy[job_grade_code]" id="leave_setup_policy-job_grade_code" value="{{ $record['time_form_balance_setup_policy.form'] }}" placeholder="{{ lang('leave_setup_policy.leave_type') }}" /> 				
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('leave_setup_policy.starting') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="leave_setup_policy[job_grade_code]" id="leave_setup_policy-job_grade_code" value="{{ $record['time_form_balance_setup_policy.starting_credit'] }}" placeholder="{{ lang('leave_setup_policy.starting') }}" /> 				
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('leave_setup_policy.maximum') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="leave_setup_policy[job_grade_code]" id="leave_setup_policy-job_grade_code" value="{{ $record['time_form_balance_setup_policy.max_credit'] }}" placeholder="{{ lang('leave_setup_policy.maximum') }}" /> 				
			</div>	
		</div>				
	</div>
</div>