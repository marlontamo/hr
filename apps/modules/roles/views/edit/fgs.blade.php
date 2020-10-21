<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Profile Description</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('roles.role_name') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="roles[role]" id="roles-role" value="{{ $record['roles.role'] }}" placeholder="{{ lang('roles.p_role_name') }}"/> 				</div>	
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
	                            {{ form_multiselect('roles[profile_id][]',$roles_profile_id_options, explode(',', $record['roles.profile_id']), 'class="form-control select2me" id="roles-profile_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('roles.description') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="roles[description]" id="roles-description" value="{{ $record['roles.description'] }}" placeholder="{{ lang('roles.p_description') }}"/> 				</div>	
			</div>	</div>
</div>

<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Role Setup for Subordinates Access Limitation</div>
		<div class="tools"><a class="expand" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form category_container" style="display: none;">	
		<div style="display:none;" id="category_container">
			<?php
				$category_id_selected = explode(',', $record['roles.category_id']); 
				foreach ($category_id_selected as $key => $value) {
					if ($value != '' && $value != 0){
			?>
						<input type="text" class="form-control" name="roles[category_selected][]" id="cat<?php echo $value ?>" value="<?php echo $value ?>"/>
			<?php
					}
				}
			?>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required"></span>{{ lang('roles.category') }}
			</label>
			<div class="col-md-7">
                <div class="input-group">
					<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                    <select name="roles[category_id]" id="category_id" class="select2me form-control">
                    <?php
						$db->select('*,category as label, category_id as value');
						$db->order_by('category');
						$category = $db->get_where('category',array('deleted' => 0)); 
						$category_id_selected = explode(',', $record['roles.category_id']); 
	                    if ($category && $category->num_rows() > 0){
	                    	foreach ($category->result() as $row) {
	                    		if ($db->table_exists($row->table_name) && (!in_array($row->value, $category_id_selected))){
									print '<option value="'. $row->value .'" '.($record['roles.category_id'] == $row->category_id ? 'selected="selected"' : '').'>'.$row->label.'</option>';
								}
	                    	}
	                    }
                    ?>
                    </select>
					<span class="input-group-btn">
						<button type="button" class="btn btn-default" onclick="add_category()"><i class="fa fa-plus"></i></button>
					</span>                    
                </div>
            </div>	
		</div>
		<?php
			$db->where('role_id',$record['record_id']);
			$role_category = $db->get('roles_category');
			if ($role_category && $role_category->num_rows() > 0){
				foreach ($role_category->result() as $row) {
					$category_master = $db->get_where('category',array('primary_key' => $row->category_field));

					if ($category_master && $category_master->num_rows() > 0){
						$category_master_record = $category_master->row();
					}

					$category_id_selected = explode(',', $row->category_val); 
		?>
					<div class="form-group">
						<label class="control-label col-md-3">
							<span class="required"></span><?php echo $category_master_record->category ?>
						</label>
						<div class="col-md-7">
					        <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
					            <select name="roles[category][<?php echo $category_master_record->primary_key ?>][]" class="select2me form-control" id="<?php echo $category_master_record->primary_key ?>" multiple>
					            <?php
									$db->select("{$category_master_record->field_label} as label, {$category_master_record->primary_key} as value");
									$result = $db->get_where($category_master_record->table_name,array('deleted' => 0));   
					                if ($result && $result->num_rows() > 0){
					                	foreach ($result->result() as $row_cat_table) {
											print '<option value="'. $row_cat_table->value .'" '.(in_array($row_cat_table->value, $category_id_selected) ? 'selected="selected"' : '').'>'.$row_cat_table->label.'</option>';
					                	}
					                }
					            ?>
					            </select>
								<span class="input-group-btn">
									<button type="button" class="btn btn-default" onclick="remove_category('<?php echo $category_master_record->primary_key ?>',<?php echo $category_master_record->category_id ?>,'<?php echo $category_master_record->category ?>')"><i class="fa fa-minus"></i></button>
								</span>                     
					        </div>
					    </div>	
					</div>		
		<?php
				}
			}
		?>	
	</div>		
</div>