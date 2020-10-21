<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Processing Type</label>
				<div class="col-md-7"><?php									                            		$db->select('period_processing_type_id,period_processing_type');
	                            			                            		$db->order_by('period_processing_type', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_period_processing_type'); 	                            $payroll_current_transaction_processing_type_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_current_transaction_processing_type_id_options[$option->period_processing_type_id] = $option->period_processing_type;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_current_transaction[processing_type_id]',$payroll_current_transaction_processing_type_id_options, $record['payroll_current_transaction.processing_type_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Employee</label>
				<div class="col-md-7"><?php									                            		
								$qry_category = $mod->get_role_category();	
								$db->select('users.user_id,users.full_name');
								$db->from('users');
								$db->join('partners', 'users.user_id = partners.user_id');
								$db->join('users_profile', 'users_profile.user_id = partners.user_id');							
								$db->join('payroll_partners', 'payroll_partners.user_id = users.user_id', 'inner join');
								$db->order_by('users.full_name', '0');
						        if ($qry_category != ''){
						            $db->where($qry_category, '', false);
						        }							
						  		$db->where('users.deleted', '0');
	 					        $options = $db->get();	                            
	                            $payroll_current_transaction_employee_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_current_transaction_employee_id_options[$option->user_id] = $option->full_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_current_transaction[employee_id]',$payroll_current_transaction_employee_id_options, $record['payroll_current_transaction.employee_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Payroll Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="payroll_current_transaction[payroll_date]" id="payroll_current_transaction-payroll_date" value="{{ $record['payroll_current_transaction.payroll_date'] }}" placeholder="Enter Payroll Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Transaction</label>
				<div class="col-md-7"><?php									                            		$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.transaction_code, a.transaction_id, a.transaction_label, b.transaction_class
FROM {dbprefix}payroll_transaction a
LEFT JOIN {dbprefix}payroll_transaction_class b ON b.transaction_class_id =  a.transaction_class_id
WHERE a.deleted = 0")); 	                            $payroll_current_transaction_transaction_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_current_transaction_transaction_id_options[$option->transaction_class][$option->transaction_id] = $option->transaction_label;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_current_transaction[transaction_id]',$payroll_current_transaction_transaction_id_options, $record['payroll_current_transaction.transaction_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Quantity</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_current_transaction[quantity]" id="payroll_current_transaction-quantity" value="{{ $record['payroll_current_transaction.quantity'] }}" placeholder="Enter Quantity" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Unit Rate</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_current_transaction[unit_rate]" id="payroll_current_transaction-unit_rate" value="{{ $record['payroll_current_transaction.unit_rate'] }}" placeholder="Enter Unit Rate" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Amount</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_current_transaction[amount]" id="payroll_current_transaction-amount" value="{{ $record['payroll_current_transaction.amount'] }}" placeholder="Enter Amount" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">On Hold</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['payroll_current_transaction.on_hold'] ) checked="checked" @endif name="payroll_current_transaction[on_hold][temp]" id="payroll_current_transaction-on_hold-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="payroll_current_transaction[on_hold]" id="payroll_current_transaction-on_hold" value="@if( $record['payroll_current_transaction.on_hold'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Remarks</label>
				<div class="col-md-7">							<textarea class="form-control" name="payroll_current_transaction[remarks]" id="payroll_current_transaction-remarks" placeholder="Enter Remarks" rows="4">{{ $record['payroll_current_transaction.remarks'] }}</textarea> 				</div>	
			</div>	</div>
</div>