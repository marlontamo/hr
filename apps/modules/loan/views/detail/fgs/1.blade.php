<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Loan Set Up</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Loan Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_loan[loan_code]" id="payroll_loan-loan_code" value="{{ $record['payroll_loan.loan_code'] }}" placeholder="Enter Loan Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Loan Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_loan[loan]" id="payroll_loan-loan" value="{{ $record['payroll_loan.loan'] }}" placeholder="Enter Loan Name" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Loan Type</label>
				<div class="col-md-7"><?php									                            		$db->select('loan_type_id,loan_type');
	                            			                            		$db->order_by('loan_type', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_loan_type'); 	                            $payroll_loan_loan_type_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_loan_loan_type_id_options[$option->loan_type_id] = $option->loan_type;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_loan[loan_type_id]',$payroll_loan_loan_type_id_options, $record['payroll_loan.loan_type_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Loan Mode</label>
				<div class="col-md-7"><?php									                            		$db->select('loan_mode_id,loan_mode');
	                            			                            		$db->order_by('loan_mode', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_loan_mode'); 	                            $payroll_loan_loan_mode_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_loan_loan_mode_id_options[$option->loan_mode_id] = $option->loan_mode;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_loan[loan_mode_id]',$payroll_loan_loan_mode_id_options, $record['payroll_loan.loan_mode_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Principal Transaction</label>
				<div class="col-md-7"><?php									                            		$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.transaction_code, a.transaction_id, a.transaction_label, b.transaction_class
FROM {dbprefix}payroll_transaction a
LEFT JOIN {dbprefix}payroll_transaction_class b ON b.transaction_class_id =  a.transaction_class_id
WHERE a.deleted = 0 AND b.transaction_class_code = 'LNEMPL'")); 	                            $payroll_loan_principal_transid_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_loan_principal_transid_options[$option->transaction_class][$option->transaction_id] = $option->transaction_label;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_loan[principal_transid]',$payroll_loan_principal_transid_options, $record['payroll_loan.principal_transid'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Amortization Transaction</label>
				<div class="col-md-7"><?php									                            		$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.transaction_code, a.transaction_id, a.transaction_label, b.transaction_class
FROM {dbprefix}payroll_transaction a
LEFT JOIN {dbprefix}payroll_transaction_class b ON b.transaction_class_id =  a.transaction_class_id
WHERE a.deleted = 0 AND b.transaction_class_code = 'LOAN_AMORTIZATION'")); 	                            $payroll_loan_amortization_transid_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_loan_amortization_transid_options[$option->transaction_class][$option->transaction_id] = $option->transaction_label;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_loan[amortization_transid]',$payroll_loan_amortization_transid_options, $record['payroll_loan.amortization_transid'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Amount Limit</label>
				<div class="col-md-7">							<input type="text" class="form-control text-right" name="payroll_loan[amount_limit]" id="payroll_loan-amount_limit" value="{{ $record['payroll_loan.amount_limit'] }}" placeholder="Enter Amount Limit" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>	</div>
</div>