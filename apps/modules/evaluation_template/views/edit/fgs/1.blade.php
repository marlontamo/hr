<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Template Evaluation</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Evaluation Title</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_evaluation_template[title]" id="training_evaluation_template-title" value="{{ $record['training_evaluation_template.title'] }}" placeholder="Enter Evaluation Title" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Applicable For</label>
				<div class="col-md-7"><?php									                            		$db->select('applicable_for_id,applicable_for');
	                            			                            		$db->order_by('applicable_for', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('training_applicable_for'); 	                            $training_evaluation_template_applicable_for_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$training_evaluation_template_applicable_for_options[$option->applicable_for_id] = $option->applicable_for;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('training_evaluation_template[applicable_for]',$training_evaluation_template_applicable_for_options, $record['training_evaluation_template.applicable_for'], 'class="form-control select2me" data-placeholder="Select..." id="training_evaluation_template-applicable_for"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="training_evaluation_template[description]" id="training_evaluation_template-description" placeholder="Enter Description" rows="4">{{ $record['training_evaluation_template.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>