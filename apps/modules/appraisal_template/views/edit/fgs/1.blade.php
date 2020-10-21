<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Template </div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Template Title</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="performance_template[template]" id="performance_template-template" value="{{ $record['performance_template.template'] }}" placeholder="Enter Template Title" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Template Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="performance_template[template_code]" id="performance_template-template_code" value="{{ $record['performance_template.template_code'] }}" placeholder="Enter Template Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Applicable for</label>
				<div class="col-md-7"><?php									                            		$db->select('applicable_to_id,applicable_to');
	                            			                            		$db->order_by('applicable_to', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('performance_template_applicable'); 	                            $performance_template_applicable_to_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$performance_template_applicable_to_id_options[$option->applicable_to_id] = $option->applicable_to;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('performance_template[applicable_to_id]',$performance_template_applicable_to_id_options, $record['performance_template.applicable_to_id'], 'class="form-control select2me" data-placeholder="Select..." id="performance_template-applicable_to_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Applicable to</label>
				<div class="col-md-7"><?php                                                        		$db->select('applicable_to_id,applicable_to');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('performance_template_applicable');
									$performance_template_applicable_to_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$performance_template_applicable_to_options[$option->applicable_to_id] = $option->applicable_to;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('performance_template[applicable_to][]',$performance_template_applicable_to_options, explode(',', $record['performance_template.applicable_to']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="performance_template-applicable_to"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="performance_template[description]" id="performance_template-description" placeholder="Enter Description" rows="4">{{ $record['performance_template.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>