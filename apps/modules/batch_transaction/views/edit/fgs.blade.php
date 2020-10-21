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
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Employees</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>This section manage to add company, department, branch, position, employee type and location.</p>
			<div class="form-group">
            	<label class="control-label col-md-4">Add</label>
                <div class="col-md-5">
                    <div class="input-group">
                        <select  class="form-control select2me input-sm" data-placeholder="Select..." name="default[add-group]">
                        	<option value="company">Company</option>
                            <option value="department">Department</option>
                            <option value="branch">Branch</option>                            
                            <option value="position">Position</option>
                            <option value="employee_type">Employee Type</option>
                            <option value="location">Location</option>
                        </select>
                    
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-default" onclick="add_group()"><i class="fa fa-plus"></i></button>
                        </span>
                    </div>
                    <div class="help-block small">
                    	Select category then click add button to modify.
                	</div>
                    <!-- /input-group -->
                </div>
            </div>
            <div class="portlet margin-top-25">
				<h5 class="form-section margin-bottom-10"><b>List of Employee</b>
					<span class="pull-right"><div class="btn-group">
                            <a class="btn btn-xs text-muted" href="javascript:mass_delete_employee()"><i class="fa fa-trash-o"></i> Delete</a>
                        </div>
                    </span>
                </h5>

                <div class="portlet-body" >
                	<table class="table table-condensed table-striped table-hover" >
                        <thead>
                            <tr>
                            	<th width="1%" class="padding-top-bottom-10"><input type="checkbox" class="group-checkable" data-set=".added-employee" /></th>
                            	<th width="20%" class="padding-top-bottom-10" >Employee</th>
                            	<th width="21%" class="padding-top-bottom-10 hidden-xs" >Quantity</th>
                                <th width="21%" class="padding-top-bottom-10">Unit Rate</th>
                                <th width="22%" class="padding-top-bottom-10">Total Amount</th>
                                <th width="15%" class="padding-top-bottom-10" >Action</th>
                            </tr> 
                        </thead>
                        <tbody id="employee-table">
                        	{{ $employee_table }}
                        </tbody>
                    </table>
                </div>
            </div>
</div>