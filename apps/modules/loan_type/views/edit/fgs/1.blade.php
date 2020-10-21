<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('loan_types.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('loan_types.loan_type') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_loan_type[loan_type]" id="payroll_loan_type-loan_type" value="{{ $record['payroll_loan_type.loan_type'] }}" placeholder="{{ lang('loan_types.p_loan_type') }}"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('loan_types.description') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="payroll_loan_type[description]" id="payroll_loan_type-description" placeholder="{{ lang('loan_types.p_description') }}" rows="4">{{ $record['payroll_loan_type.description'] }}</textarea> 				
			</div>	
		</div>	
	</div>
</div>