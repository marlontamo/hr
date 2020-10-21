<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('overtime_fixed_rates_amount.ot_rates_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('overtime_fixed_rates_amount.company') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="payroll_overtime_rates_amount[company_id]" id="payroll_overtime_rates_amount-company_id" value="{{ $record['payroll_overtime_rates_amount_company_id'] }}" placeholder="{{ lang('payroll_overtime_rates_amount.payroll_overtime_rates_amount_company_id') }}" /> 				
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('overtime_fixed_rates_amount.employment_type') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="payroll_overtime_rates_amount[employment_type_id]" id="payroll_overtime_rates_amount-employment_type_id" value="{{ $record['payroll_overtime_rates_amount_employment_type_id'] }}" placeholder="{{ lang('payroll_overtime_rates_amount.payroll_overtime_rates_amount_employment_type_id') }}" /> 				
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('overtime_fixed_rates_amount.location') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="payroll_overtime_rates_amount[overtime_location_id]" id="payroll_overtime_rates_amount-overtime_location_id" value="{{ $record['payroll_overtime_rates_amount_overtime_location_id'] }}" placeholder="{{ lang('payroll_overtime_rates_amount.payroll_overtime_rates_amount_overtime_location_id') }}" /> 				
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('overtime_fixed_rates_amount.ot') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="payroll_overtime_rates_amount[overtime_id]" id="payroll_overtime_rates_amount-overtime_id" value="{{ $record['payroll_overtime_rates_amount_overtime_id'] }}" placeholder="{{ lang('payroll_overtime_rates_amount.payroll_overtime_rates_amount_overtime_id') }}" /> 				
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('overtime_fixed_rates_amount.amount') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="payroll_overtime_rates_amount[overtime_amount]" id="payroll_overtime_rates_amount-overtime_amount" value="{{ $record['payroll_overtime_rates_amount_overtime_amount'] }}" placeholder="{{ lang('payroll_overtime_rates_amount.payroll_overtime_rates_amount_overtime_amount') }}" /> 				
			</div>	
		</div>											
	</div>
</div>