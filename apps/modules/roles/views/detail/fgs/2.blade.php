<div class="portlet">
	<div class="portlet-title">
		<div class="caption"></div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Role Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="roles[role]" id="roles-role" value="{{ $record['roles.role'] }}" placeholder="Enter Role Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Profile Associated</label>
				<div class="col-md-7"><?php                                                        		$db->select('profile_id,profile');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('profiles');
									$roles_profile_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$roles_profile_id_options[$option->profile_id] = $option->profile;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('roles[profile_id][]',$roles_profile_id_options, $record['roles.profile_id'], 'class="form-control select2me" data-placeholder="Select..." multiple="multiple" id="roles-profile_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="roles[description]" id="roles-description" value="{{ $record['roles.description'] }}" placeholder="Enter Description"/> 				</div>	
			</div>	</div>
</div>