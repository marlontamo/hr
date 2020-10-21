<div class="portlet">
	<div class="portlet-title">
		<div class="caption"> {{ lang('users.employee_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('users.user_login') }}</label>
			<div class="col-md-7">
				<input type="text" class="form-control" name="users[login]" id="users-login" value="{{ $record['users.login'] }}" placeholder="{{ lang('users.p_user_login') }}" /> 	
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('users.password') }}</label>
			<div class="col-md-7">
				@if( $record_id )
					<button class="btn btn-info btn-sm" type="button" onclick="show_pass_field('users-hash', $(this))">{{ lang('users.change_password') }}</button>
                    <small class="help-block">{{ lang('users.to_change_password') }}</small>
				@endif
				<div class="input-group margin-bottom-15 @if( $record_id ) hidden @endif">
					<span class="input-group-addon"><i class="fa fa-key"></i></span>
					<input type="password" class="form-control @if( $record_id ) dontserializeme @endif" name="users[hash]" id="users-hash" value="" placeholder="{{ lang('users.p_password') }}"/>
				</div>
				<div class="input-group @if( $record_id ) hidden @endif">
					<span class="input-group-addon"><i class="fa fa-key"></i></span>
					<input type="password" class="form-control @if( $record_id ) dontserializeme @endif" name="users[hash-confirm]" id="users-hash-confirm" value="" placeholder="{{ lang('users.p_confirm_password') }}"/>
				</div>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('users.company') }}</label>
			<div class="col-md-7"><?php	$db->select('company_id,company');
	                            		$db->order_by('company', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users_company');
	                            		$users_profile_company_id_options = array('' => lang('users.select'));
                        		foreach($options->result() as $option)
                        		{	
                        			$users_profile_company_id_options[$option->company_id] = $option->company;
                        		} ?>
                <div class="input-group">
                	<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
	                {{ form_dropdown('users_profile[company_id]',$users_profile_company_id_options, $record['users_profile.company_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	            </div>
	        </div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span><?php echo lang('users.role'); ?></label>
			<div class="col-md-7"><?php	$db->select('role_id,role');
	                            		$db->order_by('role', '0');
	                            		if( $current_user->role_id != 1 ){
	                            			$db->where('role_id != 1');
	                            		}
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('roles');
	                            		$users_role_id_options = array('' => lang('users.select'));
                        		foreach($options->result() as $option)
                        		{
                        			$users_role_id_options[$option->role_id] = $option->role;
                        		} ?>
                <div class="input-group">
					<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
	                    {{ form_dropdown('users[role_id]',$users_role_id_options, $record['users.role_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	            </div>
	        </div>	
		</div>
			@if( $current_user->role_id == 1 )
				<div class="form-group">
					<label class="control-label col-md-3"><span class="required">* </span>{{ lang('users.business_level') }}</label>
					<div class="col-md-7"><?php	$db->select('level_id,level');
		                            			$db->order_by('level', '0');
		                            			$db->where('deleted', '0');
		                            			$options = $db->get('business_level');
		                            			$users_level_id_options = array('' => lang('users.select'));
	                        		foreach($options->result() as $option)
	                        		{
	                        			$users_level_id_options[$option->level_id] = $option->level;
	                        		} ?>
	                    <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
		                    {{ form_dropdown('users_profile[business_level_id]',$users_level_id_options, $record['users_profile.level_id'], 'class="form-control select2me" data-placeholder= '.lang('users.select')) }}
		                </div>
		            </div>	
				</div>
			@endif

			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('users.active') }}</label>
				<div class="col-md-7">
					<div class="make-switch" data-on-label="&nbsp;{{ lang('users.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('users.option_no') }}&nbsp;">
						<input type="checkbox" value="1" @if( $record['users.active'] ) checked="checked" @endif name="users[active][temp]" id="users-active-temp" class="dontserializeme toggle"/>
						<input type="hidden" name="users[active]" id="users-active" value="@if( $record['users.active'] ) 1 else 0 @endif"/>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption"> {{ lang('users.personal_information') }}</div>
			<div class="tools"><a class="collapse" href="javascript:;"></a></div>
		</div>
		<div class="portlet-body form">
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('users.firstname') }}</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="users_profile[firstname]" id="users_profile-firstname" value="{{ $record['users_profile.firstname'] }}" placeholder="{{ lang('users.p_firstname') }}" />
				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('users.lastname') }}</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="users_profile[lastname]" id="users_profile-lastname" value="{{ $record['users_profile.lastname'] }}" placeholder="{{ lang('users.p_lastname') }}" />
				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('users.middlename') }}</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="users_profile[middlename]" id="users_profile-middlename" value="{{ $record['users_profile.middlename'] }}" placeholder="{{ lang('users.p_middlename') }}" /> 				
				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('users.suffix') }}</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="users_profile[suffix]" id="users_profile-suffix" value="{{ $record['users_profile.suffix'] }}" placeholder="{{ lang('users.p_suffix') }}" /> 				
				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('users.nickname') }}</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="users_profile[nickname]" id="users_profile-nickname" value="{{ $record['users_profile.nickname'] }}" placeholder="{{ lang('users.p_nickname') }}" /> 				
				</div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('users.birth_date') }}</label>
				<div class="col-md-7">
					<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
						<input type="text" class="form-control" name="users_profile[birth_date]" id="users_profile-birth_date" value="{{ $record['users_profile.birth_date'] }}" placeholder="{{ lang('users.p_birth_date') }}" readonly>
						<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
					</div>
				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('users.photo') }}</label>
				<div class="col-md-7">
					<div data-provides="fileupload" class="fileupload fileupload-new" id="users_profile-photo-container">
						@if( !empty($record['users_profile.photo']) )
							<?php 
								$file = FCPATH . urldecode( $record['users_profile.photo'] );
								if( file_exists( $file ) )
								{
									$f_info = get_file_info( $file );
								}
							?>								@endif
						<input type="hidden" name="users_profile[photo]" id="users_profile-photo" value="{{ $record['users_profile.photo'] }}"/>
						<div class="input-group">
							<span class="input-group-btn">
								<span class="uneditable-input">
									<i class="fa fa-file fileupload-exists"></i> 
									<span class="fileupload-preview">@if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif</span>
								</span>
							</span>
							<span class="btn default btn-file">
								<span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('users.select_file') }}</span>
								<span class="fileupload-exists"><i class="fa fa-undo"></i> {{ lang('users.change') }}</span>
								<input type="file" id="users_profile-photo-fileupload" type="file" name="files[]">
							</span>
							<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> {{ lang('users.remove') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption"> {{ lang('users.contact_information') }}</div>
			<div class="tools"><a class="collapse" href="javascript:;"></a></div>
		</div>
		<div class="portlet-body form">
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('users.email') }}</label>
				<div class="col-md-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope"></i></span>	
						<input type="text" class="form-control" name="users[email]" id="users-email" value="{{ $record['users.email'] }}" placeholder="{{ lang('users.p_email') }}" /> 	
					</div>	
				</div>	
			</div>
		</div>
	</div>