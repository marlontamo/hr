<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('annual_tax_rate.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('annual_tax_rate.salary_from') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_annual_tax[salary_from]" id="payroll_annual_tax-salary_from" value="{{ $record['payroll_annual_tax.salary_from'] }}" placeholder="{{ lang('annual_tax_rate.p_salary_from') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('annual_tax_rate.salary_to') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_annual_tax[salary_to]" id="payroll_annual_tax-salary_to" value="{{ $record['payroll_annual_tax.salary_to'] }}" placeholder="{{ lang('annual_tax_rate.p_salary_to') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('annual_tax_rate.fixed_amt') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_annual_tax[amount]" id="payroll_annual_tax-amount" value="{{ $record['payroll_annual_tax.amount'] }}" placeholder="{{ lang('annual_tax_rate.p_fixed_amt') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('annual_tax_rate.ex_rate') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_annual_tax[rate]" id="payroll_annual_tax-rate" value="{{ $record['payroll_annual_tax.rate'] }}" placeholder="{{ lang('annual_tax_rate.p_ex_rate') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				
			</div>	
		</div>	
	</div>
</div>