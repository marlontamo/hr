<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Level 2 and 3 Training Evaluation Master</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Level 2 and 3 Training Evaluation Master</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Evaluation Type</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_revalida_master[revalida_type]" id="training_revalida_master-revalida_type" value="{{ $record['training_revalida_master.revalida_type'] }}" placeholder="Enter Evaluation Type" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Training Course</label>
				<div class="col-md-7"><?php									                            		$db->select('course_id,Course');
	                            			                            		$db->order_by('Course', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('training_course'); 	                            $training_revalida_master_course_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$training_revalida_master_course_id_options[$option->course_id] = $option->Course;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('training_revalida_master[course_id]',$training_revalida_master_course_id_options, $record['training_revalida_master.course_id'], 'class="form-control select2me" data-placeholder="Select..." id="training_revalida_master-course_id"') }}
	                        </div> 				</div>	
			</div>	</div>
</div>