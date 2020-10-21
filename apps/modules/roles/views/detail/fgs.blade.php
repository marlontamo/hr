<div class="portlet">
	<div class="portlet-title">
		<div class="caption"></div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('roles.role_name') }}</label>
				<div class="col-md-7">							<input type="text" disabled="disabled" class="form-control" name="roles[role]" id="roles-role" value="{{ $record['roles.role'] }}" placeholder="{{ lang('roles.p_role_name') }}"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('roles.profile_associated') }}</label>
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
	                            {{ form_multiselect('roles[profile_id][]',$roles_profile_id_options, explode(',', $record['roles.profile_id']), 'class="form-control select2me" disabled="disabled" id="roles-profile_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('roles.description') }}</label>
				<div class="col-md-7">							<input type="text" disabled="disabled" class="form-control" name="roles[description]" id="roles-description" value="{{ $record['roles.description'] }}" placeholder="{{ lang('roles.p_description') }}"/> 				</div>	
			</div>	</div>
</div>