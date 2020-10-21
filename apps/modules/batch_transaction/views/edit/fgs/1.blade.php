<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Document No.</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_entry_batch[document_no]" id="payroll_entry_batch-document_no" value="{{ $record['payroll_entry_batch.document_no'] }}" placeholder="Enter Document No." /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Transaction</label>
				<div class="col-md-7"><?php									                            		$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.*, b.transaction_class
FROM {dbprefix}payroll_transaction a
LEFT JOIN {dbprefix}payroll_transaction_class b on b.transaction_class_id = a.transaction_class_id
WHERE a.deleted = 0 and b.is_irregular = 1")); 	                            $payroll_entry_batch_transaction_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_entry_batch_transaction_id_options[$option->transaction_class][$option->transaction_id] = $option->transaction_label;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_entry_batch[transaction_id]',$payroll_entry_batch_transaction_id_options, $record['payroll_entry_batch.transaction_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Payroll Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="payroll_entry_batch[payroll_date]" id="payroll_entry_batch-payroll_date" value="{{ $record['payroll_entry_batch.payroll_date'] }}" placeholder="Enter Payroll Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Unit Rate</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_entry_batch[unit_rate_main]" id="payroll_entry_batch-unit_rate_main" value="{{ $record['payroll_entry_batch.unit_rate_main'] }}" placeholder="Enter Unit Rate" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Remarks</label>
				<div class="col-md-7">							<textarea class="form-control" name="payroll_entry_batch[remarks]" id="payroll_entry_batch-remarks" placeholder="Enter Remarks" rows="4">{{ $record['payroll_entry_batch.remarks'] }}</textarea> 				</div>	
			</div>	</div>
</div>