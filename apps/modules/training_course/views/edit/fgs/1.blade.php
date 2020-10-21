<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Course</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Course</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_course[course]" id="training_course-course" value="{{ $record['training_course.course'] }}" placeholder="Enter Course" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Category</label>
				<div class="col-md-7"><?php									                            		$db->select('category_id,category');
	                            			                            		$db->order_by('category', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('training_category'); 	                            $training_course_category_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$training_course_category_id_options[$option->category_id] = $option->category;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('training_course[category_id]',$training_course_category_id_options, $record['training_course.category_id'], 'class="form-control select2me" data-placeholder="Select..." id="training_course-category_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Type</label>
				<div class="col-md-7"><?php									                            		$db->select('type_id,type');
	                            			                            		$db->order_by('type', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('training_type'); 	                            $training_course_type_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$training_course_type_id_options[$option->type_id] = $option->type;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('training_course[type_id]',$training_course_type_id_options, $record['training_course.type_id'], 'class="form-control select2me" data-placeholder="Select..." id="training_course-type_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Provider</label>
				<div class="col-md-7"><?php									                            		$db->select('provider_id,provider');
	                            			                            		$db->order_by('provider', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('training_provider'); 	                            $training_course_provider_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$training_course_provider_id_options[$option->provider_id] = $option->provider;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('training_course[provider_id]',$training_course_provider_id_options, $record['training_course.provider_id'], 'class="form-control select2me" data-placeholder="Select..." id="training_course-provider_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Facilitator</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_course[facilitator]" id="training_course-facilitator" value="{{ $record['training_course.facilitator'] }}" placeholder="Enter Facilitator" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Is Planned?</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['training_course.planned'] ) checked="checked" @endif name="training_course[planned][temp]" id="training_course-planned-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="training_course[planned]" id="training_course-planned" value="<?php echo $record['training_course.planned'] ? 1 : 0 ?>"/>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Position</label>
				<div class="col-md-7"><?php                                                        		$db->select('position_id,position');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('users_position');
									$training_course_position_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$training_course_position_id_options[$option->position_id] = $option->position;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('training_course[position_id][]',$training_course_position_id_options, explode(',', $record['training_course.position_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="training_course-position_id"') }}
	                        </div> 				</div>	
			</div>	</div>
</div>