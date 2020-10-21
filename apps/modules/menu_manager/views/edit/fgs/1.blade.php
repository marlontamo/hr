<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Menu Basic Info</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Label</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="menu[label]" id="menu-label" value="{{ $record['menu.label'] }}" placeholder="Enter Label"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Icon</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="menu[icon]" id="menu-icon" value="{{ $record['menu.icon'] }}" placeholder="Enter Icon"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Parent Menu</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('menu_item_id,label');
	                            			                            		$db->where('deleted', '0');
	                            		$options = $db->get('menu');
										$menu_parent_menu_item_id_options = array();
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
				<label class="control-label col-md-3"><span class="required">* </span>Menu Type</label>
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
				<label class="control-label col-md-3">Module</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('mod_id,short_name');
	                            			                            		$db->where('deleted', '0');
	                            		$options = $db->get('modules');
										$menu_mod_id_options = array();
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$menu_mod_id_options[$option->mod_id] = $option->short_name;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('menu[mod_id]',$menu_mod_id_options, $record['menu.mod_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Method</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="menu[method]" id="menu-method" value="{{ $record['menu.method'] }}" placeholder="Enter Method"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">URL</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="menu[uri]" id="menu-uri" value="{{ $record['menu.uri'] }}" placeholder="Enter URL"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="menu[description]" id="menu-description" placeholder="Enter Description" rows="4">{{ $record['menu.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>