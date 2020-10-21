<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Work Assignment</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Reports To</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('user_id,display_name');
	                            			                            		$db->where('deleted', '0');
	                            			                            		$db->where('active', '1');
	                            		$options = $db->get('users');
										$users_department_immediate_id_options = array('' => 'Select...');
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$users_department_immediate_id_options[$option->user_id] = $option->display_name;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('users_department[immediate_id]',$users_department_immediate_id_options, $record['users_department.immediate_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Division</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('division_id,division');
	                            			                            		$db->where('deleted', '0');
	                            		$options = $db->get('users_division');
										$users_profile_division_id_options = array('' => 'Select...');
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$users_profile_division_id_options[$option->division_id] = $option->division;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('users_profile[division_id]',$users_profile_division_id_options, $record['users_profile.division_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Group</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('group_id,group');
	                            			                            		$db->where('deleted', '0');
	                            		$options = $db->get('users_group');
										$users_profile_group_id_options = array('' => 'Select...');
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$users_profile_group_id_options[$option->group_id] = $option->group;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('users_profile[group_id]',$users_profile_group_id_options, $record['users_profile.group_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Department</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('department_id,department');
	                            			                            		$db->where('deleted', '0');
	                            		$options = $db->get('users_department');
										$users_profile_department_id_options = array('' => 'Select...');
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$users_profile_department_id_options[$option->department_id] = $option->department;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('users_profile[department_id]',$users_profile_department_id_options, $record['users_profile.department_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>	</div>
</div>