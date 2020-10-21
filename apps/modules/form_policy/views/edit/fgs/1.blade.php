<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Policy Setup</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Class</label>
				<div class="col-md-7"><?php									                            		$db->select('class_id,class_code');
	                            			                            		$db->order_by('class_code', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('time_form_class'); 	                            $time_form_class_policy_class_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$time_form_class_policy_class_id_options[$option->class_id] = $option->class_code;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_form_class_policy[class_id]',$time_form_class_policy_class_id_options, $record['time_form_class_policy.class_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Value</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_form_class_policy[class_value]" id="time_form_class_policy-class_value" value="{{ $record['time_form_class_policy.class_value'] }}" placeholder="Enter Value" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Company</label>
				<div class="col-md-7"><?php                                                        		$db->select('company_id,company');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('users_company');
									$time_form_class_policy_company_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$time_form_class_policy_company_id_options[$option->company_id] = $option->company;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_form_class_policy[company_id][]',$time_form_class_policy_company_id_options, explode(',', $record['time_form_class_policy.company_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="time_form_class_policy-company_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Division</label>
				<div class="col-md-7"><?php                                                        		$db->select('division_id,division');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('users_division');
									$time_form_class_policy_division_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$time_form_class_policy_division_id_options[$option->division_id] = $option->division;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_form_class_policy[division_id][]',$time_form_class_policy_division_id_options, explode(',', $record['time_form_class_policy.division_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="time_form_class_policy-division_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Department</label>
				<div class="col-md-7"><?php                                                        		$db->select('department_id,department');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('users_department');
									$time_form_class_policy_department_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$time_form_class_policy_department_id_options[$option->department_id] = $option->department;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_form_class_policy[department_id][]',$time_form_class_policy_department_id_options, explode(',', $record['time_form_class_policy.department_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="time_form_class_policy-department_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Severity</label>
				<div class="col-md-7"><?php									                            		$db->select('severity,severity');
	                            			                            		$db->order_by('severity', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('time_form_class_policy'); 	                            $time_form_class_policy_severity_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$time_form_class_policy_severity_options[$option->severity] = $option->severity;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_form_class_policy[severity]',$time_form_class_policy_severity_options, $record['time_form_class_policy.severity'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>	</div>
</div>