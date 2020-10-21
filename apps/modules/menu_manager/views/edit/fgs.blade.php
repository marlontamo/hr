<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('menu_manager.menu_basic') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('menu_manager.label') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="menu[label]" id="menu-label" value="{{ $record['menu.label'] }}" placeholder="{{ lang('menu_manager.label') }}"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('menu_manager.icon') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="menu[icon]" id="menu-icon" value="{{ $record['menu.icon'] }}" placeholder="{{ lang('menu_manager.p_icon') }}"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('menu_manager.parent_menu') }}</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('menu_item_id,label');
	                            			                            		$db->where('deleted', '0'); $db->order_by('label');
	                            		$options = $db->get('menu');
										$menu_parent_menu_item_id_options = array('' => 'Select...');
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$menu_parent_menu_item_id_options[$option->menu_item_id] = $option->label;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('menu[parent_menu_item_id]',$menu_parent_menu_item_id_options, $record['menu.parent_menu_item_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('menu_manager.menu_type') }}</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('menu_item_type_id,menu_item_type');
	                            			                            		$db->where('deleted', '0');
	                            		$options = $db->get('menu_item_type');
										$menu_menu_item_type_id_options = array();
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$menu_menu_item_type_id_options[$option->menu_item_type_id] = $option->menu_item_type;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('menu[menu_item_type_id]',$menu_menu_item_type_id_options, $record['menu.menu_item_type_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('menu_manager.module') }}</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('mod_id,short_name,mod_code');
	                            			                            		$db->where('deleted', '0');  $db->order_by('short_name');
	                            		$options = $db->get('modules');
										$menu_mod_id_options = array();
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$menu_mod_id_options[$option->mod_id] = $option->short_name.' : '.$option->mod_code;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('menu[mod_id]',$menu_mod_id_options, $record['menu.mod_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('menu_manager.method') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="menu[method]" id="menu-method" value="{{ $record['menu.method'] }}" placeholder="{{ lang('menu_manager.p_method') }}"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('menu_manager.url') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="menu[uri]" id="menu-uri" value="{{ $record['menu.uri'] }}" placeholder="{{ lang('menu_manager.p_url') }}"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('menu_manager.description') }}</label>
				<div class="col-md-7">							<textarea class="form-control" name="menu[description]" id="menu-description" placeholder="{{ lang('menu_manager.p_description') }}" rows="4">{{ $record['menu.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>