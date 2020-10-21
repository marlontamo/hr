<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('phic_table.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('phic_table.salary_from') }}</label>
				<div class="col-md-7">							
					<input type="text" class="form-control" name="payroll_phic_table[from]" id="payroll_phic_table-from" value="{{ $record['payroll_phic_table.from'] }}" placeholder="{{ lang('phic_table.p_salary_from') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				
				</div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('phic_table.salary_to') }}</label>
				<div class="col-md-7">							
					<input type="text" class="form-control" name="payroll_phic_table[to]" id="payroll_phic_table-to" value="{{ $record['payroll_phic_table.to'] }}" placeholder="{{ lang('phic_table.p_salary_to') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				
				</div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('phic_table.emp_share') }}</label>
				<div class="col-md-7">							
					<input type="text" class="form-control" name="payroll_phic_table[eeshare]" id="payroll_phic_table-eeshare" value="{{ $record['payroll_phic_table.eeshare'] }}" placeholder="{{ lang('phic_table.p_emp_share') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				
				</div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('phic_table.empr_share') }}</label>
				<div class="col-md-7">							
					<input type="text" class="form-control" name="payroll_phic_table[ershare]" id="payroll_phic_table-ershare" value="{{ $record['payroll_phic_table.ershare'] }}" placeholder="{{ lang('phic_table.p_emp_share') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				
				</div>	
			</div>	
		</div>
</div>