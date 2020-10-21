<div class="portlet">
	<div class="portlet-title">
		<div class="caption"> Employee Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">User Login</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users[login]" id="users-login" value="{{ $record['users.login'] }}" placeholder="Enter User Login" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Password</label>
				<div class="col-md-7">							@if( $record_id )
								<button class="btn btn-info btn-sm" type="button" onclick="show_pass_field('users-hash', $(this))">Change Password?</button>
                                <small class="help-block">Click button to change password.</small>
							@endif
							<div class="input-group margin-bottom-15 @if( $record_id ) hidden @endif">
								<span class="input-group-addon"><i class="fa fa-key"></i></span>
								<input type="password" class="form-control @if( $record_id ) dontserializeme @endif" name="users[hash]" id="users-hash" value="" placeholder="Enter Password"/>
							</div>
														<div class="input-group @if( $record_id ) hidden @endif">
								<span class="input-group-addon"><i class="fa fa-key"></i></span>
								<input type="password" class="form-control @if( $record_id ) dontserializeme @endif" name="users[hash-confirm]" id="users-hash-confirm" value="" placeholder="Confirm Password"/>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Company</label>
				<div class="col-md-7"><?php									                            		$db->select('company_id,company');
	                            			                            		$db->order_by('company', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users_company'); 	                            $users_profile_company_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$users_profile_company_id_options[$option->company_id] = $option->company;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('users_profile[company_id]',$users_profile_company_id_options, $record['users_profile.company_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Role</label>
				<div class="col-md-7"><?php									                            		$db->select('role_id,role');
	                            			                            		$db->order_by('role', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('roles'); 	                            $users_role_id_options = array('' => 'Select...');
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
				<label class="control-label col-md-3">Active</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['users.active'] ) checked="checked" @endif name="users[active][temp]" id="users-active-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="users[active]" id="users-active" value="@if( $record['users.active'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>	</div>
</div>