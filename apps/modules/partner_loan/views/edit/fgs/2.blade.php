<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Amortization Setup</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Start Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="payroll_partners_loan[start_date]" id="payroll_partners_loan-start_date" value="{{ $record['payroll_partners_loan.start_date'] }}" placeholder="Enter Start Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Payment Mode</label>
				<div class="col-md-7"><?php									                            		$db->select('payment_mode_id,payment_mode');
	                            			                            		$db->order_by('payment_mode', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_payment_mode'); 	                            $payroll_partners_loan_payment_mode_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_loan_payment_mode_id_options[$option->payment_mode_id] = $option->payment_mode;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners_loan[payment_mode_id]',$payroll_partners_loan_payment_mode_id_options, $record['payroll_partners_loan.payment_mode_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Payments Remaining</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[no_payments_remaining]" id="payroll_partners_loan-no_payments_remaining" value="{{ $record['payroll_partners_loan.no_payments_remaining'] }}" placeholder="Enter Payments Remaining" data-inputmask="'alias': 'integer', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Amortization Credit </label>
				<div class="col-md-7"><?php									                            		$db->select('account_id,account_name');
	                            			                            		$db->order_by('account_name', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_account'); 	                            $payroll_partners_loan_amortization_credit_account_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_loan_amortization_credit_account_id_options[$option->account_id] = $option->account_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners_loan[amortization_credit_account_id]',$payroll_partners_loan_amortization_credit_account_id_options, $record['payroll_partners_loan.amortization_credit_account_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Interest Credit </label>
				<div class="col-md-7"><?php									                            		$db->select('account_id,account_name');
	                            			                            		$db->order_by('account_name', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_account'); 	                            $payroll_partners_loan_interest_credit_account_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_loan_interest_credit_account_id_options[$option->account_id] = $option->account_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners_loan[interest_credit_account_id]',$payroll_partners_loan_interest_credit_account_id_options, $record['payroll_partners_loan.interest_credit_account_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Running Balance</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[running_balance]" id="payroll_partners_loan-running_balance" value="{{ $record['payroll_partners_loan.running_balance'] }}" placeholder="Enter Running Balance" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">System Amortization</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[system_amortization]" id="payroll_partners_loan-system_amortization" value="{{ $record['payroll_partners_loan.system_amortization'] }}" placeholder="Enter System Amortization" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">System Interest</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[system_interest]" id="payroll_partners_loan-system_interest" value="{{ $record['payroll_partners_loan.system_interest'] }}" placeholder="Enter System Interest" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">User Amortization</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[user_amortization]" id="payroll_partners_loan-user_amortization" value="{{ $record['payroll_partners_loan.user_amortization'] }}" placeholder="Enter User Amortization" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">User Interest</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[user_interest]" id="payroll_partners_loan-user_interest" value="{{ $record['payroll_partners_loan.user_interest'] }}" placeholder="Enter User Interest" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>	</div>
</div>