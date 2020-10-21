<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Policy Setup</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Class</label>
				<div class="col-md-7"><?php									                            		
								$db->select('class_id,class_code');
								$db->order_by('class_code', '0');
                        		$db->where('deleted', '0');
                        		$options = $db->get('time_form_class'); 	                            
                        		$time_form_class_policy_class_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$time_form_class_policy_class_id_options[$option->class_id] = $option->class_code;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_form_class_policy[class_id]',$time_form_class_policy_class_id_options, $record['time_form_class_policy.class_id'], 'class="form-control select2me" id="time_form_class_policy-class_id" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Value</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_form_class_policy[class_value]" id="time_form_class_policy-class_value" value="{{ $record['time_form_class_policy.class_value'] }}" placeholder="Enter Value" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="time_form_class_policy[description]" id="time_form_class_policy-description" placeholder="Enter Description" rows="4">{{ $record['time_form_class_policy.description'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Severity</label>
				<div class="col-md-7"><?php	
										$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT 'Warning' AS source
													UNION ALL 
													SELECT 'Strict Compliance' AS source")); 	                            
										$time_form_class_policy_severity_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$time_form_class_policy_severity_options[$option->source] = $option->source;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_form_class_policy[severity]',$time_form_class_policy_severity_options, $record['time_form_class_policy.severity'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Company</label>
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
	                        </div>
	                        <br /><p class="small text-muted margin-bottom-20 margin-top-10"> Note: The following fields will default to 'all selected' when none of the categories listed is chosen</p>
	            </div>	
			</div>			

			<div class="form-group">
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
				<label class="control-label col-md-3">Group</label>
				<div class="col-md-7"><?php                                                        		$db->select('group_id,group');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('users_group');
									$time_form_class_policy_group_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$time_form_class_policy_group_id_options[$option->group_id] = $option->group;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_form_class_policy[group_id][]',$time_form_class_policy_group_id_options, explode(',', $record['time_form_class_policy.group_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="time_form_class_policy-group_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Employment Status</label>
				<div class="col-md-7"><?php                                                        		$db->select('employment_status_id,employment_status');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('partners_employment_status');
									$time_form_class_policy_employment_status_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$time_form_class_policy_employment_status_id_options[$option->employment_status_id] = $option->employment_status;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_form_class_policy[employment_status_id][]',$time_form_class_policy_employment_status_id_options, explode(',', $record['time_form_class_policy.employment_status_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="time_form_class_policy-employment_status_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Employment Type</label>
				<div class="col-md-7"><?php                                                        		$db->select('employment_type_id,employment_type');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('partners_employment_type');
									$time_form_class_policy_employment_type_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$time_form_class_policy_employment_type_id_options[$option->employment_type_id] = $option->employment_type;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_form_class_policy[employment_type_id][]',$time_form_class_policy_employment_type_id_options, explode(',', $record['time_form_class_policy.employment_type_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="time_form_class_policy-employment_type_id"') }}
	                        </div> 				</div>	
			</div>		
        	</div>
</div>