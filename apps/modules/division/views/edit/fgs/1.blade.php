<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('division.division_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('division.division') }}</label>				
			<div class="col-md-7">							
				<input type="text" class="form-control" name="users_division[division]" id="users_division-division" value="{{ $record['users_division.division'] }}" placeholder="{{ lang('division.p_division') }}"/> 				
			</div>
		</div>			

		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('division.division_code') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="users_division[division_code]" id="users_division-division_code" value="{{ $record['users_division.division_code'] }}" placeholder="{{ lang('division.p_division_code') }}"/> 				
			</div>				
		</div>			
		<div class="form-group">
				<label class="control-label col-md-3">{{ lang('division.immediate_head') }}</label>
				<div class="col-md-7"><?php	                            	                            		
										$db->select('user_id,display_name');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users');
										$users_division_immediate_id_options = array('' => lang('users.select'));
	                            		foreach($options->result() as $option)
	                            		{
	                            			$users_division_immediate_id_options[$option->user_id] = $option->display_name;
	                            		} ?>							
	                 <div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>

	                            {{ form_dropdown('users_division[immediate_id]',$users_division_immediate_id_options, $record['users_division.immediate_id'], 'class="form-control select2me" id="division-immediate_id" data-placeholder="Select..."') }}
	                 </div> 				
				</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('division.immediate_position') }}</label>
			<div class="col-md-7">							
				<input type="text" readonly class="form-control" name="users_division[position]" id="users_division-position" value="{{ $record['users_division.position'] }}" placeholder="{{ lang('division.p_immediate_position') }}"/> 				
			</div>				
		</div>			

		<div class="form-group">
				<label class="control-label col-md-3">{{ lang('division.active') }}</label>
				<div class="col-md-7">							
					<div class="make-switch" data-on-label="&nbsp;{{ lang('division.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('division.option_no') }}&nbsp;">
				    	<input type="checkbox" value="1" @if( $record['users_division.status_id'] ) checked="checked" @endif name="users_division[status_id][temp]" id="users_division-status_id-temp" class="dontserializeme toggle"/>
				    	<input type="hidden" name="users_division[status_id]" id="users_division-status_id" value="@if( $record['users_division.status_id'] ) 1 else 0 @endif"/>
					</div> 				
				</div>	
			</div>
	</div>
</div>