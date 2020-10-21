<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Document No.</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_entry_recurring[document_no]" id="payroll_entry_recurring-document_no" value="{{ $record['payroll_entry_recurring.document_no'] }}" placeholder="Enter Document No." /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Transaction</label>
				<div class="col-md-7"><?php									                            		$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.*, b.transaction_class
FROM {dbprefix}payroll_transaction a
LEFT JOIN {dbprefix}payroll_transaction_class b on b.transaction_class_id = a.transaction_class_id
WHERE a.deleted = 0 and b.is_recurring = 1")); 	                            $payroll_entry_recurring_transaction_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_entry_recurring_transaction_id_options[$option->transaction_class][$option->transaction_id] = $option->transaction_label;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_entry_recurring[transaction_id]',$payroll_entry_recurring_transaction_id_options, $record['payroll_entry_recurring.transaction_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Date From - To</label>
				<div class="col-md-7">							<input type="hidden" name="payroll_entry_recurring[date]"/>
							<div class="input-group input-xlarge date-picker input-daterange" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="payroll_entry_recurring[date_from]" id="payroll_entry_recurring-date_from" value="{{ $record['payroll_entry_recurring.date_from'] }}" />
								<span class="input-group-addon">to</span>
								<input type="text" class="form-control" name="payroll_entry_recurring[date_to]" id="payroll_entry_recurring-date_to" value="{{ $record['payroll_entry_recurring.date_to'] }}" />
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Method</label>
				<div class="col-md-7"><?php									                            		$db->select('payroll_transaction_method_id,payroll_transaction_method');
	                            			                            		$db->order_by('payroll_transaction_method', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_transaction_method'); 	                            $payroll_entry_recurring_transaction_method_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_entry_recurring_transaction_method_id_options[$option->payroll_transaction_method_id] = $option->payroll_transaction_method;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_entry_recurring[transaction_method_id]',$payroll_entry_recurring_transaction_method_id_options, $record['payroll_entry_recurring.transaction_method_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Account Code</label>
				<div class="col-md-7"><?php									                            		$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.*, b.account_type
FROM {dbprefix}payroll_account a
LEFT JOIN {dbprefix}payroll_account_type b on b.account_type_id = a.account_type_id
WHERE a.deleted = 0 AND b.deleted = 0")); 	                            $payroll_entry_recurring_account_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_entry_recurring_account_id_options[$option->account_type][$option->account_id] = $option->account_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_entry_recurring[account_id]',$payroll_entry_recurring_account_id_options, $record['payroll_entry_recurring.account_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Apply Week/s</label>
				<div class="col-md-7"><?php                                                        		$db->select('week_id,week');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_week');
									$payroll_entry_recurring_week_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$payroll_entry_recurring_week_options[$option->week_id] = $option->week;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_entry_recurring[week][]',$payroll_entry_recurring_week_options, explode(',', $record['payroll_entry_recurring.week']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="payroll_entry_recurring-week"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Rate</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_entry_recurring[amount]" id="payroll_entry_recurring-amount" value="{{ $record['payroll_entry_recurring.amount'] }}" placeholder="Enter Rate" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Remarks</label>
				<div class="col-md-7">							<textarea class="form-control" name="payroll_entry_recurring[remarks]" id="payroll_entry_recurring-remarks" placeholder="Enter Remarks" rows="4">{{ $record['payroll_entry_recurring.remarks'] }}</textarea> 				</div>	
			</div>	</div>
</div>