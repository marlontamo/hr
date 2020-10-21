<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Competency Values</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Competency Values</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Category</label>
				<div class="col-md-7"><?php									                            		$db->select('competency_category_id,competency_category');
	                            			                            		$db->order_by('competency_category', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('performance_competency_category'); 	                            $performance_competency_values_competency_category_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$performance_competency_values_competency_category_id_options[$option->competency_category_id] = $option->competency_category;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('performance_competency_values[competency_category_id]',$performance_competency_values_competency_category_id_options, $record['performance_competency_values.competency_category_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Competency Value</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="performance_competency_values[competency_values]" id="performance_competency_values-competency_values" value="{{ $record['performance_competency_values.competency_values'] }}" placeholder="Enter Competency Value" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Description</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="performance_competency_values[description]" id="performance_competency_values-description" value="{{ $record['performance_competency_values.description'] }}" placeholder="Enter Description" /> 				</div>	
			</div>	</div>
</div>