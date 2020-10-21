<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('late_exemption.late_exemption_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('late_exemption.company') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="payroll_late_exemption[company_id]" id="payroll_late_exemption-company_id" value="{{ $record['payroll_late_exemption_company_id'] }}" placeholder="{{ lang('payroll_late_exemption.payroll_late_exemption_company_id') }}" /> 				
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('late_exemption.e_type') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="payroll_late_exemption[employment_type_id]" id="payroll_late_exemption-employment_type_id" value="{{ $record['payroll_late_exemption_employment_type_id'] }}" placeholder="{{ lang('payroll_late_exemption.payroll_late_exemption_employment_type_id') }}" /> 				
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('late_exemption.late_exemption') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="payroll_late_exemption[late_exemption]" id="payroll_late_exemption-late_exemption" value="{{ $record['payroll_late_exemption_lates_exemption'] }}" placeholder="{{ lang('payroll_late_exemption.payroll_late_exemption_overtime_amount') }}" /> 				
			</div>	
		</div>											
	</div>
</div>