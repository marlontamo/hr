<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Bonus Type</label>
				<div class="col-md-7"><?php									                            		$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.transaction_id, a.transaction_label, b.transaction_class
FROM {dbprefix}payroll_transaction a
LEFT JOIN {dbprefix}payroll_transaction_class b ON b.transaction_class_id =  a.transaction_class_id
WHERE a.deleted = 0 AND b.is_bonus = 1")); 	                            $payroll_bonus_bonus_transaction_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_bonus_bonus_transaction_id_options[$option->transaction_class][$option->transaction_id] = $option->transaction_label;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_bonus[bonus_transaction_id]',$payroll_bonus_bonus_transaction_id_options, $record['payroll_bonus.bonus_transaction_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Payroll Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="payroll_bonus[payroll_date]" id="payroll_bonus-payroll_date" value="{{ $record['payroll_bonus.payroll_date'] }}" placeholder="Enter Payroll Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Period</label>
				<div class="col-md-7">							<input type="hidden" name="payroll_bonus[date]"/>
							<div class="input-group input-xlarge date-picker input-daterange" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="payroll_bonus[date_from]" id="payroll_bonus-date_from" value="{{ $record['payroll_bonus.date_from'] }}" />
								<span class="input-group-addon">to</span>
								<input type="text" class="form-control" name="payroll_bonus[date_to]" id="payroll_bonus-date_to" value="{{ $record['payroll_bonus.date_to'] }}" />
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>No. of Periods</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_bonus[period]" id="payroll_bonus-period" value="{{ $record['payroll_bonus.period'] }}" placeholder="Enter No. of Periods" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Apply Week/s</label>
				<div class="col-md-7"><?php                                                        		$db->select('week_id,week');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_week');
									$payroll_bonus_week_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$payroll_bonus_week_options[$option->week_id] = $option->week;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_bonus[week][]',$payroll_bonus_week_options, explode(',', $record['payroll_bonus.week']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="payroll_bonus-week"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Method</label>
				<div class="col-md-7"><?php									                            		$db->select('payroll_transaction_method_bonus_id,payroll_transaction_method_bonus');
	                            			                            		$db->order_by('payroll_transaction_method_bonus', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_transaction_method_bonus'); 	                            $payroll_bonus_transaction_method_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_bonus_transaction_method_id_options[$option->payroll_transaction_method_bonus_id] = $option->payroll_transaction_method_bonus;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_bonus[transaction_method_id]',$payroll_bonus_transaction_method_id_options, $record['payroll_bonus.transaction_method_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Account</label>
				<div class="col-md-7"><?php									                            		$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.*, b.account_type
FROM {dbprefix}payroll_account a
LEFT JOIN {dbprefix}payroll_account_type b on b.account_type_id = a.account_type_id
WHERE a.deleted = 0 AND b.deleted = 0")); 	                            $payroll_bonus_account_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_bonus_account_id_options[$option->account_type][$option->account_id] = $option->account_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_bonus[account_id]',$payroll_bonus_account_id_options, $record['payroll_bonus.account_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="payroll_bonus[description]" id="payroll_bonus-description" placeholder="Enter Description" rows="4">{{ $record['payroll_bonus.description'] }}</textarea> 				</div>	
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
                            	<th width="54%" class="padding-top-bottom-10" >Employee</th>
                            	<th width="40%" class="padding-top-bottom-10">Amount</th>
                                <th width="5%" class="padding-top-bottom-10" >Action</th>
                            </tr> 
                        </thead>
                        <tbody id="employee-table">
                        	{{ $employee_table }}
                        </tbody>
                    </table>
                </div>
            </div>
</div>