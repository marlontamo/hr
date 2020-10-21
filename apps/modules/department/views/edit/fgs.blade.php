<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('department.department_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('department.department') }}</label>				
			<div class="col-md-7">							
				<input type="text" class="form-control" name="users_department[department]" id="users_department-department" value="{{ $record['users_department.department'] }}" placeholder="Enter Department"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('department.department_code') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="users_department[department_code]" id="users_department-department_code" value="{{ $record['users_department.department_code'] }}" placeholder="Enter Department Code"/> 				
			</div>				
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('department.division') }}</label>
			<div class="col-md-7"><?php	                            	                            		$db->select('division_id,division');
                            			                            		$db->where('deleted', '0');
                            		$options = $db->get('users_division');
									$users_department_division_id_options = array('' => lang('users.select'));                            		
									foreach($options->result() as $option)
                            		{
                            				                            				$users_department_division_id_options[$option->division_id] = $option->division;
                            				                            		} ?>							
       			<div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('users_department[division_id]',$users_department_division_id_options, $record['users_department.division_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                </div> 				
            </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('department.immediate_head') }}</label>
			<div class="col-md-7"><?php 
										$db->select('user_id,display_name');
	                            		$db->where('deleted', '0');
	                            		$db->where('active', '1');
	                            		$options = $db->get('users');
										$users_department_immediate_id_options = array('' => lang('users.select'));	                            		
										foreach($options->result() as $option)
	                            		{
	                            				                            				$users_department_immediate_id_options[$option->user_id] = $option->display_name;
	                            				                            		} ?>							
				<div class="input-group">
					<span class="input-group-addon">
	                <i class="fa fa-list-ul"></i>
	                </span>

	                {{ form_dropdown('users_department[immediate_id]',$users_department_immediate_id_options, $record['users_department.immediate_id'], 'class="form-control select2me" id="department-immediate_id" data-placeholder="Select..."') }}
	            </div> 				
            </div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('department.immediate_position') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="users_department[immediate_position]" id="users_department-immediate_position" value="{{ $record['users_department.immediate_position'] }}" placeholder="{{ lang('department.p_immediate_position') }}" readonly/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('department.active') }}</label>
			<div class="col-md-7">							
				<div class="make-switch" data-on-label="&nbsp;{{ lang('department.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('department.option_no') }}&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['users_department.status_id'] ) checked="checked" @endif name="users_department[status_id][temp]" id="users_department-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="users_department[status_id]" id="users_department-status_id" value="@if( $record['users_department.status_id'] ) 1 else 0 @endif"/>
				</div> 				
			</div>	
		</div>	
	</div>
</div>