<div class="portlet">
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
</div>