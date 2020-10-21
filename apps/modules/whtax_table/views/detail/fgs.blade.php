<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('whtax_table.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('whtax_table.frequency') }} </label>
			<div class="col-md-7"><?php									                            		
									$db->select('payroll_schedule_id,payroll_schedule');
                            		$db->order_by('payroll_schedule', '0');
                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_schedule'); 	                            
                            		$payroll_whtax_table_payroll_schedule_id_options = array('' => 'Select...');
                    				foreach($options->result() as $option)
                    				{
                    			        $payroll_whtax_table_payroll_schedule_id_options[$option->payroll_schedule_id] = $option->payroll_schedule;
                    			    } ?>							
			    <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_whtax_table[payroll_schedule_id]',$payroll_whtax_table_payroll_schedule_id_options, $record['payroll_whtax_table.payroll_schedule_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                </div> 				
            </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('whtax_table.tax_code') }}</label>
			<div class="col-md-7"><?php									                            		
									$db->select('taxcode_id,taxcode');
                            		$db->order_by('taxcode', '0');
                            		$db->where('deleted', '0');
                            		$options = $db->get('taxcode'); 	                            
                            		$payroll_whtax_table_taxcode_id_options = array('' => 'Select...');
                    				foreach($options->result() as $option)
                    				{
                    			        $payroll_whtax_table_taxcode_id_options[$option->taxcode_id] = $option->taxcode;
                    			    } ?>							
			    <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_whtax_table[taxcode_id]',$payroll_whtax_table_taxcode_id_options, $record['payroll_whtax_table.taxcode_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                </div> 				
            </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('whtax_table.salary_from') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="payroll_whtax_table[salary_from]" id="payroll_whtax_table-salary_from" value="{{ $record['payroll_whtax_table.salary_from'] }}" placeholder="{{ lang('whtax_table.p_salary_from') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false'"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('whtax_table.salary_to') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="payroll_whtax_table[salary_to]" id="payroll_whtax_table-salary_to" value="{{ $record['payroll_whtax_table.salary_to'] }}" placeholder="{{ lang('whtax_table.p_salary_to') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false'"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('whtax_table.fixed_amt') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="payroll_whtax_table[fixed_amount]" id="payroll_whtax_table-fixed_amount" value="{{ $record['payroll_whtax_table.fixed_amount'] }}" placeholder="{{ lang('whtax_table.p_fixed_amt') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false'"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('whtax_table.ex_per') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="payroll_whtax_table[excess_percentage]" id="payroll_whtax_table-excess_percentage" value="{{ $record['payroll_whtax_table.excess_percentage'] }}" placeholder="{{ lang('whtax_table.p_ex_per') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false'"/> 				
			</div>	
		</div>	
	</div>
</div>