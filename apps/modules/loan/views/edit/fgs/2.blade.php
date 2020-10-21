<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('loans.int_set_up') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('loans.int_trans') }}</label>
			<div class="col-md-7"><?php									                            		
									$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.transaction_code, a.transaction_id, a.transaction_label, b.transaction_class
									FROM {dbprefix}payroll_transaction a
									LEFT JOIN {dbprefix}payroll_transaction_class b ON b.transaction_class_id =  a.transaction_class_id
									WHERE a.deleted = 0 AND b.transaction_class_code = 'LOAN_INTEREST'")); 	                            
									$payroll_loan_interest_transid_options = array('' => 'Select...');
                    				foreach($options->result() as $option)
                    				{
                    			        $payroll_loan_interest_transid_options[$option->transaction_class][$option->transaction_id] = $option->transaction_label;
                    			    } ?>							
			    <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_loan[interest_transid]',$payroll_loan_interest_transid_options, $record['payroll_loan.interest_transid'], 'class="form-control select2me" data-placeholder="Select..."') }}
                </div> 				
            </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('loans.int_mode') }}</label>
			<div class="col-md-7"><?php									                            		
									$db->select('interest_type_id,interest_type');
                            		$db->order_by('interest_type', '0');
                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_loan_interest_type'); 	                            
                            		$payroll_loan_interest_type_id_options = array('' => 'Select...');
                    				foreach($options->result() as $option)
                    				{
                    			        $payroll_loan_interest_type_id_options[$option->interest_type_id] = $option->interest_type;
                    			    } ?>							
			    <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_loan[interest_type_id]',$payroll_loan_interest_type_id_options, $record['payroll_loan.interest_type_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                </div> 				
            </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('loans.debit') }}</label>
			<div class="col-md-7"><?php									                            		
									$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.*, b.account_type
									FROM {dbprefix}payroll_account a
									LEFT JOIN {dbprefix}payroll_account_type b on b.account_type_id = a.account_type_id
									WHERE a.deleted = 0 AND b.deleted = 0")); 	                            
									$payroll_loan_debit_options = array('' => 'Select...');
                    				foreach($options->result() as $option)
                    				{
                    			        $payroll_loan_debit_options[$option->account_type][$option->account_id] = $option->account_name;
                    			    } ?>							
			    <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_loan[debit]',$payroll_loan_debit_options, $record['payroll_loan.debit'], 'class="form-control select2me" data-placeholder="Select..."') }}
                </div> 				
            </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('loans.credit') }}</label>
			<div class="col-md-7"><?php									                            		
									$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.*, b.account_type
									FROM {dbprefix}payroll_account a
									LEFT JOIN {dbprefix}payroll_account_type b on b.account_type_id = a.account_type_id
									WHERE a.deleted = 0 AND b.deleted = 0")); 	                            
									$payroll_loan_credit_options = array('' => 'Select...');
                    				foreach($options->result() as $option)
                    				{
                    			        $payroll_loan_credit_options[$option->account_type][$option->account_id] = $option->account_name;
                    			    } ?>							
			    <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_loan[credit]',$payroll_loan_credit_options, $record['payroll_loan.credit'], 'class="form-control select2me" data-placeholder="Select..."') }}
                </div> 				
            </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('loans.monthly_int') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_loan[interest]" id="payroll_loan-interest" value="{{ $record['payroll_loan.interest'] }}" placeholder="{{ lang('loans.p_monthly_int') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"'/> 				
			</div>	
		</div>	
	</div>
</div>