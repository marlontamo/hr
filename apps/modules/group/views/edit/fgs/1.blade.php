<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('group.group_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('group.group') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_group[group]" id="users_group-group" value="{{ $record['users_group.group'] }}" placeholder="{{ lang('group.p_group') }}"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('group.group_code') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_group[group_code]" id="users_group-group_code" value="{{ $record['users_group.group_code'] }}" placeholder="{{ lang('group.p_group_code') }}"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('group.immediate_head') }}</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('user_id,display_name');
	                            			                            		$db->where('deleted', '0');
	                            		$options = $db->get('users');
										$users_group_immediate_id_options = array();
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$users_group_immediate_id_options[$option->user_id] = $option->display_name;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('users_group[immediate_id]',$users_group_immediate_id_options, $record['users_group.immediate_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('group.immediate_position') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_group[position]" id="users_group-position" value="{{ $record['users_group.position'] }}" placeholder="{{ lang('group.p_immediate_position') }}"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('group.active') }}</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;{{ lang('group.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('group.option_no') }}&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['users_group.status_id'] ) checked="checked" @endif name="users_group[status_id][temp]" id="users_group-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="users_group[status_id]" id="users_group-status_id" value="@if( $record['users_group.status_id'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>	</div>
</div>