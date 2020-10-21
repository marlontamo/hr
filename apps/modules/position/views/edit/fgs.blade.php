<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('position.position_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('position.position') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="users_position[position]" id="users_position-position" value="{{ $record['users_position.position'] }}" placeholder="Enter Position"/> 				
			</div>
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('position.position_code') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="users_position[position_code]" id="users_position-position_code" value="{{ $record['users_position.position_code'] }}" placeholder="Enter Position Code"/> 				
			</div>
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('position.employee_type') }}</label>				
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
                    {{ form_dropdown('users_position[employee_type_id]',$users_position_employee_type_id_options, $record['users_position.employee_type_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
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
                            {{ form_dropdown('users_position[immediate_id]',$users_position_immediate_id_options, $record['users_position.immediate_id'], 'id="users_position-immediate_id" class="form-control select2me" data-placeholder="Select..."') }}
    	 		</div> 				
    	 	</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('position.immediate_position') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="users_position[immediate_position]" id="users_position-immediate_position" value="{{ $record['users_position.immediate_position'] }}" placeholder="{{ lang('position.p_immediate_position') }}" readonly/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('position.active') }}</label>
			<div class="col-md-7">							
				<div class="make-switch" data-on-label="&nbsp;{{ lang('position.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('position.option_no') }}&nbsp;">
			    	<input type="checkbox" value="1" @if( $record['users_position.status_id'] ) checked="checked" @endif name="users_position[status_id][temp]" id="users_position-status_id-temp" class="dontserializeme toggle"/>
			    	<input type="hidden" name="users_position[status_id]" id="users_position-status_id" value="@if( $record['users_position.status_id'] ) 1 else 0 @endif"/>
				</div> 				
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('position.job_description') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="users_position[job_description]" id="users_position-job_description" placeholder="Enter Job Description" rows="4">{{ $record['users_position.job_description'] }}</textarea> 				
			</div>	
		</div>		
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('position.attachment') }}</label>
			<div class="col-md-7">
				<div data-provides="fileupload" class="fileupload fileupload-new" id="users_position-photo-container">
                    <?php 
                    	$filename = urldecode(basename($record['users_position.attachment'])); 
                    	if(strtolower($filename) == 'avatar.png'){
                    		$record['users_position.attachment'] = '';
                    		$filename = '';
                    	}
                    ?>											
					<input type="hidden" name="users_position[attachment]" id="users_position-photo" value="<?php echo $record['users_position.attachment'] ?>"/>
					<div class="input-group">
						<span class="input-group-btn">
							<span class="uneditable-input">
								<i class="fa fa-file fileupload-exists"></i> 
								<span class="fileupload-preview"><?php echo $filename ?></span>
							</span>
						</span>		
						<div id="photo-container">										
							<span class="btn default btn-file">
								<span class="fileupload-new"><i class="fa fa-paper-clip"></i>Select File </span>
								<span class="fileupload-exists"><i class="fa fa-undo"></i> Modify</span>
								<input type="file" id="users_position-photo-fileupload" type="file" name="files[]">
							</span>
							<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
						</div>
					</div>
				</div>
			</div>
		</div>				
	</div>
</div>