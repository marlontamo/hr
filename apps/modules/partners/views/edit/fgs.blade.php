<div class="portlet">
	<div class="portlet-title">
		<div class="caption">General Informationssss</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Last Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[lastname]" id="users_profile-lastname" value="{{ $record['users_profile.lastname'] }}" placeholder="Enter Last Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">First Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[firstname]" id="users_profile-firstname" value="{{ $record['users_profile.firstname'] }}" placeholder="Enter First Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Middle Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[middlename]" id="users_profile-middlename" value="{{ $record['users_profile.middlename'] }}" placeholder="Enter Middle Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Maiden Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[maidenname]" id="users_profile-maidenname" value="{{ $record['users_profile.maidenname'] }}" placeholder="Enter Maiden Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Nick Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[nickname]" id="users_profile-nickname" value="{{ $record['users_profile.nickname'] }}" placeholder="Enter Nick Name"/> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Company Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Company</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('company_id,company');
	                            			                            		$db->where('deleted', '0');
	                            		$options = $db->get('users_company');
										$users_profile_company_options = array('' => 'Select...');
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$users_profile_company_options[$option->company_id] = $option->company;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('users_profile[company]',$users_profile_company_options, $record['users_profile.company'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Location</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('location_id,location');
	                            			                            		$db->where('deleted', '0');
	                            		$options = $db->get('users_location');
										$users_profile_location_id_options = array('' => 'Select...');
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$users_profile_location_id_options[$option->location_id] = $option->location;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('users_profile[location_id]',$users_profile_location_id_options, $record['users_profile.location_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Position Title</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('position_id,position');
	                            			                            		$db->where('deleted', '0');
	                            		$options = $db->get('users_position');
										$users_profile_position_id_options = array('' => 'Select...');
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$users_profile_position_id_options[$option->position_id] = $option->position;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('users_profile[position_id]',$users_profile_position_id_options, $record['users_profile.position_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Role</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('role_id,role');
	                            			                            		$db->where('deleted', '0');
	                            		$options = $db->get('roles');
										$users_role_id_options = array('' => 'Select...');
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$users_role_id_options[$option->role_id] = $option->role;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('users[role_id]',$users_role_id_options, $record['users.role_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">ID Number</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners[id_number]" id="partners-id_number" value="{{ $record['partners.id_number'] }}" placeholder="Enter ID Number"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Biometric Number</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners[biometric]" id="partners-biometric" value="{{ $record['partners.biometric'] }}" placeholder="Enter Biometric Number"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Work Schedule</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('shift_id,shift');
	                            			                            		$db->where('deleted', '0');
	                            		$options = $db->get('time_shift');
										$partners_shift_id_options = array('' => 'Select...');
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$partners_shift_id_options[$option->shift_id] = $option->shift;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners[shift_id]',$partners_shift_id_options, $record['partners.shift_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Employment Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Employee Status</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('employment_status_id,employment_status');
	                            			                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_employment_status');
										$partners_status_id_options = array('' => 'Select...');
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$partners_status_id_options[$option->employment_status_id] = $option->employment_status;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners[status_id]',$partners_status_id_options, $record['partners.status_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Date Hired</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners[effectivity_date]" id="partners-effectivity_date" value="{{ $record['partners.effectivity_date'] }}" placeholder="Enter Date Hired" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Personal Contact</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Email Address</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users[email]" id="users-email" value="{{ $record['users.email'] }}" placeholder="Enter Email Address"/> 				</div>	
			</div>	</div>
</div><div class="portlet">
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
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Emergency Contact</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Personal Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Birthday</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="users_profile[birth_date]" id="users_profile-birth_date" value="{{ $record['users_profile.birth_date'] }}" placeholder="Enter Birthday" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Other Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">	</div>
</div>