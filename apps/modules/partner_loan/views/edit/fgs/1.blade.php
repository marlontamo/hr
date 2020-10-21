<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Employee Loans</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Employee Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[user_id]" id="payroll_partners_loan-user_id" value="{{ $record['payroll_partners_loan.user_id'] }}" placeholder="Enter Employee Name" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Loan Type</label>
				<div class="col-md-7"><?php									                            		$db->select('loan_id,loan');
	                            			                            		$db->order_by('loan', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_loan'); 	                            $payroll_partners_loan_loan_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_loan_loan_id_options[$option->loan_id] = $option->loan;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners_loan[loan_id]',$payroll_partners_loan_loan_id_options, $record['payroll_partners_loan.loan_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Loan Status</label>
				<div class="col-md-7"><?php									                            		$db->select('loan_status_id,loan_status');
	                            			                            		$db->order_by('loan_status', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_loan_status'); 	                            $payroll_partners_loan_loan_status_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_loan_loan_status_id_options[$option->loan_status_id] = $option->loan_status;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners_loan[loan_status_id]',$payroll_partners_loan_loan_status_id_options, $record['payroll_partners_loan.loan_status_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Entry Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="payroll_partners_loan[entry_date]" id="payroll_partners_loan-entry_date" value="{{ $record['payroll_partners_loan.entry_date'] }}" placeholder="Enter Entry Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>No. of payments</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[no_payments]" id="payroll_partners_loan-no_payments" value="{{ $record['payroll_partners_loan.no_payments'] }}" placeholder="Enter No. of payments" data-inputmask="'alias': 'integer', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Releasing Debit Account</label>
				<div class="col-md-7"><?php									                            		$db->select('account_id,account_name');
	                            			                            		$db->order_by('account_name', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_account'); 	                            $payroll_partners_loan_releasing_debit_account_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_loan_releasing_debit_account_id_options[$option->account_id] = $option->account_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners_loan[releasing_debit_account_id]',$payroll_partners_loan_releasing_debit_account_id_options, $record['payroll_partners_loan.releasing_debit_account_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Releasing Credit Account</label>
				<div class="col-md-7"><?php									                            		$db->select('account_id,account_name');
	                            			                            		$db->order_by('account_name', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_account'); 	                            $payroll_partners_loan_releasing_credit_account_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_loan_releasing_credit_account_id_options[$option->account_id] = $option->account_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners_loan[releasing_credit_account_id]',$payroll_partners_loan_releasing_credit_account_id_options, $record['payroll_partners_loan.releasing_credit_account_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Loan Principal</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[loan_principal]" id="payroll_partners_loan-loan_principal" value="{{ $record['payroll_partners_loan.loan_principal'] }}" placeholder="Enter Loan Principal" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Amount</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[amount]" id="payroll_partners_loan-amount" value="{{ $record['payroll_partners_loan.amount'] }}" placeholder="Enter Amount" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Interest</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[interest]" id="payroll_partners_loan-interest" value="{{ $record['payroll_partners_loan.interest'] }}" placeholder="Enter Interest" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Beginning Balance</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[beginning_balance]" id="payroll_partners_loan-beginning_balance" value="{{ $record['payroll_partners_loan.beginning_balance'] }}" placeholder="Enter Beginning Balance" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="payroll_partners_loan[description]" id="payroll_partners_loan-description" placeholder="Enter Description" rows="4">{{ $record['payroll_partners_loan.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>