<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('sss_table.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('sss_table.salary_from') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_sss_table[from]" id="payroll_sss_table-from" value="{{ $record['payroll_sss_table.from'] }}" placeholder="{{ lang('sss_table.p_salary_from') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('sss_table.salary_to') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_sss_table[to]" id="payroll_sss_table-to" value="{{ $record['payroll_sss_table.to'] }}" placeholder="{{ lang('sss_table.p_salary_to') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('sss_table.emp_share') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_sss_table[eeshare]" id="payroll_sss_table-eeshare" value="{{ $record['payroll_sss_table.eeshare'] }}" placeholder="{{ lang('sss_table.p_emp_share') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('sss_table.empr_share') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_sss_table[ershare]" id="payroll_sss_table-ershare" value="{{ $record['payroll_sss_table.ershare'] }}" placeholder="{{ lang('sss_table.empr_share') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('sss_table.ec') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_sss_table[ec]" id="payroll_sss_table-ec" value="{{ $record['payroll_sss_table.ec'] }}" placeholder="{{ lang('sss_table.p_ec') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				
			</div>	
		</div>	
	</div>
</div>