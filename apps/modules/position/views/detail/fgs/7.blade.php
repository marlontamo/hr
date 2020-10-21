<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('position.position_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('position.position') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_position[position]" id="users_position-position" value="{{ $record['users_position.position'] }}" placeholder="{{ lang('position.p_position') }}"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('position.position_code') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_position[position_code]" id="users_position-position_code" value="{{ $record['users_position.position_code'] }}" placeholder="{{ lang('position.p_position_code') }}"/> 				
			</div>	
		</div>			
		<div class="form-group">
				<label class="control-label col-md-3">{{ lang('position.employee_type') }}</label>
				<div class="col-md-7"><?php	                            	                            		
										$db->select('employment_type_id,employment_type');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_employment_type');
										$users_position_employee_type_id_options = array('' => lang('users.select'));
	                            		foreach($options->result() as $option)
	                            		{
	                            			$users_position_employee_type_id_options[$option->employment_type_id] = $option->employment_type;
	                            		} ?>							
            		<div class="input-group">
						<span class="input-group-addon">
	                    <i class="fa fa-list-ul"></i>
	                    </span>
	                    {{ form_dropdown('users_position[employee_type_id]',$users_position_employee_type_id_options, $record['users_position.employee_type_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
	                </div> 				
                </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('position.immediate_head') }}</label>
			<div class="col-md-7"><?php	                            	                            		
									$db->select('user_id,display_name');
                            		$db->where('deleted', '0');
                            		$options = $db->get('users');
									$users_position_immediate_id_options = array('' => lang('users.select'));
                            		foreach($options->result() as $option)
                            		{
                            			$users_position_immediate_id_options[$option->user_id] = $option->display_name;
                            		} ?>							
        		<div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('users_position[immediate_id]',$users_position_immediate_id_options, $record['users_position.immediate_id'], 'id="users_position-immediate_id" disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                </div> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('position.immediate_position') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_position[immediate_position]" id="users_position-immediate_position" value="{{ $record['users_position.immediate_position'] }}" placeholder="{{ lang('position.p_immediate_position') }}" readonly/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('position.active') }}</label>
			<div class="col-md-7">							
				<div class="make-switch" data-on-label="&nbsp;{{ lang('position.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('position.option_no') }}&nbsp;">
			    	<input type="checkbox" disabled="disabled" value="1" @if( $record['users_position.status_id'] ) checked="checked" @endif name="users_position[status_id][temp]" id="users_position-status_id-temp" class="dontserializeme toggle"/>
			    	<input type="hidden" name="users_position[status_id]" id="users_position-status_id" value="@if( $record['users_position.status_id'] ) 1 else 0 @endif"/>
				</div> 				
			</div>	
		</div>	
	</div>
</div>