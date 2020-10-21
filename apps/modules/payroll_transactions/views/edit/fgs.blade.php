<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('payroll_transactions.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('payroll_transactions.trans_code') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_transaction[transaction_code]" id="payroll_transaction-transaction_code" value="{{ $record['payroll_transaction.transaction_code'] }}" placeholder="{{ lang('payroll_transactions.p_trans_code') }}"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('payroll_transactions.trans_label') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_transaction[transaction_label]" id="payroll_transaction-transaction_label" value="{{ $record['payroll_transaction.transaction_label'] }}" placeholder="{{ lang('payroll_transactions.p_trans_label') }}"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('payroll_transactions.trans_class') }}</label>
			<div class="col-md-7"><?php	                            	                            		
									$db->select('transaction_class_id,transaction_class');
                            		$db->order_by('transaction_class', '0');
                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_transaction_class');
									$payroll_transaction_transaction_class_id_options = array('' => 'Select...');
                            		foreach($options->result() as $option)
                            		{
                            				$payroll_transaction_transaction_class_id_options[$option->transaction_class_id] = $option->transaction_class;
                            		} ?>							
                <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_transaction[transaction_class_id]',$payroll_transaction_transaction_class_id_options, $record['payroll_transaction.transaction_class_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                </div> 				
            </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('payroll_transactions.trans_type') }}</label>
			<div class="col-md-7"><?php	                            	                            		
									$db->select('transaction_type_id,transaction_type');
                            		$db->order_by('transaction_type', '0');
                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_transaction_type');
									$payroll_transaction_transaction_type_id_options = array('' => 'Select...');
                            		foreach($options->result() as $option)
                            		{
                            			$payroll_transaction_transaction_type_id_options[$option->transaction_type_id] = $option->transaction_type;
                            		} ?>							
        		<div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_transaction[transaction_type_id]',$payroll_transaction_transaction_type_id_options, $record['payroll_transaction.transaction_type_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                </div> 				
            </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('payroll_transactions.debit_acct_code') }}</label>
			<div class="col-md-7"><?php	                            	                            		
									$db->select('account_id,account_name');
	                        		$db->order_by('account_name', '0');
	                        		$db->where('deleted', '0');
	                        		$options = $db->get('payroll_account');
									$payroll_transaction_debit_account_id_options = array('' => 'Select...');
	                        		foreach($options->result() as $option)
	                        		{
	                        			$payroll_transaction_debit_account_id_options[$option->account_id] = $option->account_name;
	                        		} ?>							
	            <div class="input-group">
					<span class="input-group-addon">
	                <i class="fa fa-list-ul"></i>
	                </span>
	                {{ form_dropdown('payroll_transaction[debit_account_id]',$payroll_transaction_debit_account_id_options, $record['payroll_transaction.debit_account_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	            </div> 				
	        </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('payroll_transactions.credit_acct_code') }}</label>
			<div class="col-md-7"><?php	                            	                            		
									$db->select('account_id,account_name');
                            		$db->order_by('account_name', '0');
                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_account');
									$payroll_transaction_credit_account_id_options = array('' => 'Select...');
                            		foreach($options->result() as $option)
                            		{
                            			$payroll_transaction_credit_account_id_options[$option->account_id] = $option->account_name;
                            		} ?>							
        		<div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_transaction[credit_account_id]',$payroll_transaction_credit_account_id_options, $record['payroll_transaction.credit_account_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                </div> 				
            </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('payroll_transactions.priority') }}</label>
			<div class="col-md-7"><?php	                            	                            		
									$db->select('priority_id,priority');
                            		$db->order_by('priority', '0');
                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_transaction_priority');
									$payroll_transaction_priority_id_options = array('' => 'Select...');
                            		foreach($options->result() as $option)
                            		{
                            			$payroll_transaction_priority_id_options[$option->priority_id] = $option->priority;
                            		} ?>							
        		<div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_transaction[priority_id]',$payroll_transaction_priority_id_options, $record['payroll_transaction.priority_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                </div> 				
            </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('payroll_transactions.is_bonus') }}</label>
			<div class="col-md-7">							
				<div class="make-switch" data-on-label="&nbsp;{{ lang('payroll_transactions.option_no') }}&nbsp;" data-off-label="&nbsp;{{ lang('payroll_transactions.option_yes') }}&nbsp;">
			    	<input type="checkbox" value="1" @if( $record['payroll_transaction.is_bonus'] ) checked="checked" @endif name="payroll_transaction[is_bonus][temp]" id="payroll_transaction-is_bonus-temp" class="dontserializeme toggle"/>
			    	<input type="hidden" name="payroll_transaction[is_bonus]" id="payroll_transaction-is_bonus" value="@if( $record['payroll_transaction.is_bonus'] ) 1 else 0 @endif"/>
				</div> 				
			</div>	
		</div>			
	</div>
</div>