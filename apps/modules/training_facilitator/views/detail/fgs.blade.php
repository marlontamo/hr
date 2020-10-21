<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Facilitator</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">	

			<div class="form-group">
				<label class="control-label col-md-3">Facilitator</label>
				<div class="col-md-7">							
					<input disabled="disabled" type="text" class="form-control" name="training_facilitator[facilitator]" id="training_facilitator-facilitator" value="{{ $record['training_facilitator.facilitator'] }}" placeholder="Enter Facilitator" /> 			
				</div>	
			</div>	

			<div class="form-group">
				<label class="control-label col-md-3">Is Internal?</label>
				<div class="col-md-7">							
					<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
				    	<input disabled="disabled" type="checkbox" value="1" @if( $record['training_facilitator.is_internal'] ) checked="checked" @endif name="training_facilitator[is_internal][temp]" id="training_facilitator-is_internal-temp" class="dontserializeme toggle"/>
				    	<input type="hidden" name="training_facilitator[is_internal]" id="training_facilitator-is_internal" value="<?php echo $record['training_facilitator.is_internal'] ? 1 : 0 ?>"/>
					</div> 				
				</div>	
			</div>

			<div class="form-group">
				<label class="control-label col-md-3">Provider</label>
				<div class="col-md-7">
				<?php 
					$db->select('provider_id,provider');
					$db->order_by('provider', '0');
					$db->where('deleted', '0');
					$options = $db->get('training_provider'); 	                            
					$training_facilitator_provider_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
									$training_facilitator_provider_id_options[$option->provider_id] = $option->provider;
                        			                        		} ?>							
                    <div class="input-group">
						<span class="input-group-addon">
                        <i class="fa fa-list-ul"></i>
                        </span>
                        {{ form_dropdown('training_facilitator[provider_id]',$training_facilitator_provider_id_options, $record['training_facilitator.provider_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..." id="training_facilitator-provider_id"') }}
                    </div> 					
                </div>	
			</div>

			<div class="form-group">
				<label class="control-label col-md-3">Course</label>
				<div class="col-md-7"><?php									                            		
				$db->select('course_id,course');
				$db->order_by('course', '0');
				$db->where('deleted', '0');
				$options = $db->get('training_course'); 	                            
				$training_facilitator_course_id_options = array();
                        		foreach($options->result() as $option)
                        		{
                    				$training_facilitator_course_id_options[$option->course_id] = $option->course;
	                    		} ?>							

	            	<div class="input-group">
						<span class="input-group-addon">
	                    <i class="fa fa-list-ul"></i>
	                    </span>
	                    {{ form_dropdown('training_facilitator[course_id][]',$training_facilitator_course_id_options, explode(',', $record['training_facilitator.course_id']), 'disabled="disabled" class="select2me form-control " data-placeholder="Select Course" id="training_facilitator-course_id" multiple') }}
	                </div> 			
	            </div>	
			</div>

		</div>
</div>