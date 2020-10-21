<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Employee</label>
				<div class="col-md-7"><?php									                            		$db->select('user_id,full_name');
	                            			                            		$db->order_by('full_name', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users'); 	                            $payroll_closed_transaction_employee_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_closed_transaction_employee_id_options[$option->user_id] = $option->full_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_closed_transaction[employee_id]',$payroll_closed_transaction_employee_id_options, $record['payroll_closed_transaction.employee_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Payroll Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="payroll_closed_transaction[payroll_date]" id="payroll_closed_transaction-payroll_date" value="{{ $record['payroll_closed_transaction.payroll_date'] }}" placeholder="Enter Payroll Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Transaction</label>
				<div class="col-md-7"><?php									                            		$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.transaction_code, a.transaction_id, a.transaction_label, b.transaction_class
FROM {dbprefix}payroll_transaction a
LEFT JOIN {dbprefix}payroll_transaction_class b ON b.transaction_class_id =  a.transaction_class_id
WHERE a.deleted = 0")); 	                            $payroll_closed_transaction_transaction_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_closed_transaction_transaction_id_options[$option->transaction_class][$option->transaction_id] = $option->transaction_label;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_closed_transaction[transaction_id]',$payroll_closed_transaction_transaction_id_options, $record['payroll_closed_transaction.transaction_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Quantity</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_closed_transaction[quantity]" id="payroll_closed_transaction-quantity" value="{{ $record['payroll_closed_transaction.quantity'] }}" placeholder="Enter Quantity" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Unit Rate</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_closed_transaction[unit_rate]" id="payroll_closed_transaction-unit_rate" value="{{ $record['payroll_closed_transaction.unit_rate'] }}" placeholder="Enter Unit Rate" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Amount</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_closed_transaction[amount]" id="payroll_closed_transaction-amount" value="{{ $record['payroll_closed_transaction.amount'] }}" placeholder="Enter Amount" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Remarks</label>
				<div class="col-md-7">							<textarea class="form-control" name="payroll_closed_transaction[remarks]" id="payroll_closed_transaction-remarks" placeholder="Enter Remarks" rows="4">{{ $record['payroll_closed_transaction.remarks'] }}</textarea> 				</div>	
			</div>	</div>
</div>