<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('account_charts.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('account_charts.acc_code') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_account[account_code]" id="payroll_account-account_code" value="{{ $record['payroll_account.account_code'] }}" placeholder="{{ lang('account_charts.p_acc_code') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('account_charts.acc_name') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_account[account_name]" id="payroll_account-account_name" value="{{ $record['payroll_account.account_name'] }}" placeholder="{{ lang('account_charts.p_acc_name') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('account_charts.acc_type') }}</label>
			<div class="col-md-7"><?php									                            		
									$db->select('account_type_id,account_type');
                            		$db->order_by('account_type', '0');
                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_account_type'); 	                            
                            		$payroll_account_account_type_id_options = array('' => 'Select...');
                    				foreach($options->result() as $option)
                    				{
                    			        $payroll_account_account_type_id_options[$option->account_type_id] = $option->account_type;
                    			    } ?>							
			    <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_account[account_type_id]',$payroll_account_account_type_id_options, $record['payroll_account.account_type_id'], 'class="form-control select2me" data-placeholder="Select..." id="payroll_account-account_type_id"') }}
                </div> 				
            </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('account_charts.description') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="payroll_account[description]" id="payroll_account-description" placeholder="{{ lang('account_charts.p_description') }}" rows="4">{{ $record['payroll_account.description'] }}</textarea> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('account_charts.order') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="payroll_account[arrangement]" id="payroll_account-arrangement" placeholder="{{ lang('account_charts.p_order') }}" rows="4">{{ $record['payroll_account.arrangement'] }}</textarea> 				
			</div>	
		</div>	
	</div>
</div>