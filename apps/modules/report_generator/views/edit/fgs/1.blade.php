<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Report Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="report_generator[report_code]" id="report_generator-report_code" value="{{ $record['report_generator.report_code'] }}" placeholder="Enter Report Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Report Title</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="report_generator[report_name]" id="report_generator-report_name" value="{{ $record['report_generator.report_name'] }}" placeholder="Enter Report Title" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="report_generator[description]" id="report_generator-description" placeholder="Enter Description" rows="4">{{ $record['report_generator.description'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Category</label>
				<div class="col-md-7"><?php									                            		$db->select('category_id,category');
	                            			                            		$db->order_by('category', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('report_generator_category'); 	                            $report_generator_category_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$report_generator_category_id_options[$option->category_id] = $option->category;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('report_generator[category_id]',$report_generator_category_id_options, $record['report_generator.category_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Accessed By</label>
				<div class="col-md-7"><?php                                                        		$db->select('role_id,role');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('roles');
									$report_generator_roles_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$report_generator_roles_options[$option->role_id] = $option->role;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('report_generator[roles][]',$report_generator_roles_options, explode(',', $record['report_generator.roles']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="report_generator-roles"') }}
	                        </div> 				</div>	
			</div>	</div>
</div>