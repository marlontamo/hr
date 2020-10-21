<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('sub_account_charts.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('sub_account_charts.sub_acc_code') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_account_sub[account_sub_code]" id="payroll_account_sub-account_sub_code" value="{{ $record['payroll_account_sub.account_sub_code'] }}" placeholder="{{ lang('sub_account_charts.p_sub_acc_code') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('sub_account_charts.sub_acc_name') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_account_sub[account_sub]" id="payroll_account_sub-account_sub" value="{{ $record['payroll_account_sub.account_sub'] }}" placeholder="{{ lang('sub_account_charts.p_sub_acc_name') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('sub_account_charts.acc_name') }}</label>
			<div class="col-md-7"><?php									                            		
									$db->select('account_id,account_name');
                            		$db->order_by('account_name', '0');
                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_account'); 	                            
                            		$payroll_account_sub_account_id_options = array('' => 'Select...');
                    				foreach($options->result() as $option)
                    				{
                    			        $payroll_account_sub_account_id_options[$option->account_id] = $option->account_name;
                    			    } ?>							
			    <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_account_sub[account_id]',$payroll_account_sub_account_id_options, $record['payroll_account_sub.account_id'], 'class="form-control select2me" data-placeholder="Select..." id="payroll_account_sub-account_id"') }}
                </div> 				
            </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('sub_account_charts.category') }}</label>
			<div class="col-md-7"><?php									                            		
									$db->select('category_id,category');
                            		$db->order_by('category', '0');
                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_account_category'); 	                            
                            		$payroll_account_sub_category_id_options = array('' => 'Select...');
                    				foreach($options->result() as $option)
                    				{
                    			        $payroll_account_sub_category_id_options[$option->category_id] = $option->category;
                    			    } ?>							
			    <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_account_sub[category_id]',$payroll_account_sub_category_id_options, $record['payroll_account_sub.category_id'], 'class="form-control select2me" data-placeholder="Select..." id="payroll_account_sub-category_id"') }}
                </div> 				
            </div>	
		</div>	
	</div>
</div>