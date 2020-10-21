<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('overtime_rates.ot_rates_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">		
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('overtime_rates.company') }}</label>
			<div class="col-md-7"><?php									                            		
									$db->select('company_id,company');
                            		$db->order_by('company', '0');
                            		$db->where('deleted', '0');
                            		$options = $db->get('users_company'); 	                            
                            		$payroll_overtime_rates_company_id_options = array('' => 'Select...');
                    				foreach($options->result() as $option)
                    				{
                    			        $payroll_overtime_rates_company_id_options[$option->company_id] = $option->company;
                    			    } ?>							
			    <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_overtime_rates[company_id]',$payroll_overtime_rates_company_id_options, $record['payroll_overtime_rates.company_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                </div> 				
            </div>	
		</div>		
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('overtime_rates.ot') }}</label>
			<div class="col-md-7"><?php									                            		
									$db->select('overtime_id,overtime');
                            		$db->order_by('overtime', '0');
                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_overtime'); 	                            
                            		$payroll_overtime_rates_overtime_id_options = array('' => 'Select...');
                    				foreach($options->result() as $option)
                    				{
                    			        $payroll_overtime_rates_overtime_id_options[$option->overtime_id] = $option->overtime;
                    			    } ?>							
			    <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_overtime_rates[overtime_id]',$payroll_overtime_rates_overtime_id_options, $record['payroll_overtime_rates.overtime_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                </div> 				
            </div>	
		</div>		
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('overtime_rates.rate') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_overtime_rates[overtime_rate]" id="payroll_overtime_rates-overtime_rate" value="{{ $record['payroll_overtime_rates.overtime_rate'] }}" placeholder="{{ lang('overtime_rates.p_rate') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				
			</div>	
		</div>	
	</div>
</div>