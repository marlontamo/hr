<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Credit Setup</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">		
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Company</label>
				<div class="col-md-7">
						<?php	
							$db->select('*');
                    		$db->order_by('company', '0');
                    		$db->where('deleted', '0');
                    		$options = $db->get('users_company'); 	                            
                    		$time_form_balance_setup_policy_balance_setup_id_options = array('' => 'Select...');
	            		foreach($options->result() as $option)
	            		{
	            			$time_form_balance_setup_policy_balance_setup_id_options[$option->company_id] = $option->company;
	            		} ?>
	            	<div class="input-group">
						<span class="input-group-addon">
	                    <i class="fa fa-list-ul"></i>
	                    </span>
	                    {{ form_dropdown('time_form_balance_setup_policy[company_id]',$time_form_balance_setup_policy_balance_setup_id_options, $record['time_form_balance_setup_policy.company_id'], 'class="form-control select2me" data-placeholder="Select..." id="time_form_balance_setup_policy-company_id"') }}
	                </div>
	            </div>	
			</div>						
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Balance Setup</label>
				<div class="col-md-7">
						<?php	
							$db->select('balance_setup_id,employment_type,employment_status');
                    		$db->order_by('employment_type', '0');
                    		$db->where('deleted', '0');
                    		$options = $db->get('time_form_balance_setup'); 	                            
                    		$time_form_balance_setup_policy_balance_setup_id_options = array('' => 'Select...');
	            		foreach($options->result() as $option)
	            		{
	            			$time_form_balance_setup_policy_balance_setup_id_options[$option->balance_setup_id] = $option->employment_type .' - '. $option->employment_status;
	            		} ?>
	            	<div class="input-group">
						<span class="input-group-addon">
	                    <i class="fa fa-list-ul"></i>
	                    </span>
	                    {{ form_dropdown('time_form_balance_setup_policy[balance_setup_id]',$time_form_balance_setup_policy_balance_setup_id_options, $record['time_form_balance_setup_policy.balance_setup_id'], 'class="form-control select2me" data-placeholder="Select..." id="time_form_balance_setup_policy-balance_setup_id"') }}
	                </div>
	            </div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Leave Type</label>
				<div class="col-md-7">
					<?php	
						$db->select('form_id,form');
						$db->order_by('form', '0');
						$db->where('deleted', '0');
						$db->where('is_leave', '1');
						$options = $db->get('time_form');
						$time_form_balance_setup_policy_form_id_options = array('' => 'Select...');
                        foreach($options->result() as $option)
                        {   
                        	$time_form_balance_setup_policy_form_id_options[$option->form_id] = $option->form;
                        } ?>
                    <div class="input-group">
						<span class="input-group-addon">
                        	<i class="fa fa-list-ul"></i>
                        </span>
	                    {{ form_dropdown('time_form_balance_setup_policy[form_id]',$time_form_balance_setup_policy_form_id_options, $record['time_form_balance_setup_policy.form_id'], 'class="form-control select2me" data-placeholder="Select..." id="time_form_balance_setup_policy-form_id"') }}
	                </div>
	            </div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Starting</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="time_form_balance_setup_policy[starting_credit]" id="time_form_balance_setup_policy-starting_credit" value="{{ $record['time_form_balance_setup_policy.starting_credit'] }}" placeholder="Enter Starting" />
				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">Maximum</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="time_form_balance_setup_policy[max_credit]" id="time_form_balance_setup_policy-max_credit" value="{{ $record['time_form_balance_setup_policy.max_credit'] }}" placeholder="Enter Maximum" />
				</div>	
			</div>
		</div>
</div>