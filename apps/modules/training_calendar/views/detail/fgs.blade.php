<form id="training-calendar-form">
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">Training Calendar</div>
			<div class="tools"><a class="collapse" href="javascript:;"></a></div>
		</div>
		<div class="portlet-body form">
			<div class="form-group">
					<label class="control-label col-md-3">Training Course</label>
					<div class="col-md-7"><?php									                            		
					$db->select('course_id,course');
					$db->order_by('course', '0');
		            $db->where('deleted', '0');
		            $options = $db->get('training_course'); 	                            
		            $training_calendar_course_id_options = array('' => 'Select...');

	        		foreach($options->result() as $option)
	        		{
	        			$training_calendar_course_id_options[$option->course_id] = $option->course;
	        		} ?>							
	            		<div class="input-group">
							<span class="input-group-addon">
	                        <i class="fa fa-list-ul"></i>
	                        </span>
	                        {{ form_dropdown('training_calendar[course_id]',$training_calendar_course_id_options, $record['training_calendar.course_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..." id="training_calendar-course_id"') }}
	                    </div> 				
	                </div>	
			</div>	

			<div class="form-group">
				<label class="control-label col-md-3">Training Type</label>
				<div class="col-md-7"><?php									                            		
				$db->select('calendar_type_id,calendar_type');
				$db->order_by('calendar_type', '0');
	            $db->where('deleted', '0');
	            $options = $db->get('training_calendar_type'); 	                            
	            $training_calendar_calendar_type_id_options = array('' => 'Select...');

	    		foreach($options->result() as $option)
	    		{
	    			$training_calendar_calendar_type_id_options[$option->calendar_type_id] = $option->calendar_type;
	    		} ?>							
	        		<div class="input-group">
						<span class="input-group-addon">
	                    <i class="fa fa-list-ul"></i>
	                    </span>
	                    {{ form_dropdown('training_calendar[calendar_type_id]',$training_calendar_calendar_type_id_options, $record['training_calendar.calendar_type_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..." id="training_calendar-calendar_type_id"') }}
	                </div> 				
	            </div>	
			</div>

			<?php

				$training_course_info = "SELECT * FROM ww_training_course c 
					LEFT JOIN ww_training_provider p ON p.`provider_id` = c.`provider_id`
					LEFT JOIN ww_training_category cat ON cat.`category_id` = c.`category_id`
	                    			WHERE c.course_id  = '" . $record['training_calendar.course_id'] . "' ";

                $training_course_info = $db->query($training_course_info);

				if($training_course_info->num_rows() > 0){

					$training_provider = $training_course_info->row('provider');
					$training_category = $training_course_info->row('category');
					
				}

			?>
			<div class="form-group">
				<label class="control-label col-md-3">Training Provider</label>
				<div class="col-md-7">							
					<input disabled="disabled" type="text" class="form-control" name="training_calendar[calendar_type_id]" id="training_calendar-calendar_type_id" value="<?php echo !empty($record['training_calendar.course_id']) ? $training_provider : ''; ?>" placeholder="Enter Training Provider" /> 				
				</div>	 
			</div>

			<div class="form-group">
				<label class="control-label col-md-3">Training Category</label>
				<div class="col-md-7">							
					<input disabled="disabled" type="text" class="form-control" name="training_calendar[training_category_id]" id="training_calendar-training_category_id" value="<?php echo !empty($record['training_calendar.course_id']) ?$training_category : ''; ?>" placeholder="Enter Training Category" /> 				
				</div>	
			</div>

			<div class="form-group">
				<label class="control-label col-md-3">Minimum Trainee Capacity</label>
				<div class="col-md-7">							
					<input disabled="disabled" type="text" class="form-control" name="training_calendar[training_capacity]" id="training_calendar-training_capacity" value="{{ $record['training_calendar.training_capacity'] }}" placeholder="Enter Minimum Trainee Capacity" /> 				
				</div>	
			</div>

			<div class="form-group">
				<label class="control-label col-md-3">Maximum Trainee Capacity</label>
				<div class="col-md-7">							
					<input disabled="disabled" type="text" class="form-control" name="training_calendar[min_training_capacity]" id="training_calendar-min_training_capacity" value="{{ $record['training_calendar.min_training_capacity'] }}" placeholder="Enter Maximum Trainee Capacity" /> 				
				</div>	
			</div>

			<div class="form-group">
				<label class="control-label col-md-3">Venue</label>
				<div class="col-md-7">							
					<textarea disabled="disabled" class="form-control" name="training_calendar[venue]" id="training_calendar-venue" placeholder="Enter Venue" rows="4">{{ $record['training_calendar.venue'] }}</textarea> 				
				</div>	
			</div>

			<div class="form-group">
				<label class="control-label col-md-3">Training Course Description</label>
				<div class="col-md-7">							
					<textarea disabled="disabled" class="form-control" name="training_calendar[topic]" id="training_calendar-topic" placeholder="Enter Topic" rows="4">{{ $record['training_calendar.topic'] }}</textarea> 				
				</div>	
			</div>

			<div class="form-group">
				<label class="control-label col-md-3">To Be Announce</label>
				<div class="col-md-7">							
					<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
				    	<input disabled="disabled" type="checkbox" value="1" @if( $record['training_calendar.tba'] ) checked="checked" @endif name="training_calendar[tba][temp]" id="training_calendar-tba-temp" class="dontserializeme toggle"/>
				    	<input disabled="disabled" type="hidden" name="training_calendar[tba]" id="training_calendar-tba" value="<?php echo $record['training_calendar.tba'] ? 1 : 0 ?>"/>
					</div> 				
				</div>	
			</div>

			<div class="form-group">
				<label class="control-label col-md-3">Equipment</label>
				<div class="col-md-7">							
					<input disabled="disabled" type="text" class="form-control" name="training_calendar[equipment]" id="training_calendar-equipment" value="{{ $record['training_calendar.equipment'] }}" placeholder="Enter Equipment" /> 				
				</div>	
			</div>

			<div class="form-group">
	            <label class="control-label col-md-3">Registration Date</label>
	            <div class="col-md-7">
	                <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
	                    <input disabled="disabled" type="text" class="form-control" name="training_calendar[registration_date]" id="training_calendar-registration_date" value="{{ $record['training_calendar.registration_date'] }}" placeholder="Enter Date" >
	                    <span class="input-group-btn">
							<button disabled="disabled" class="btn default" type="button"><i class="fa fa-calendar"></i></button>
						</span>
	                </div>
	            </div>
	        </div>

	        <div class="form-group">
				<label class="control-label col-md-3">Cost Per Pax</label>
				<div class="col-md-7">							
					<input disabled="disabled" type="text" class="form-control" name="training_calendar[cost_per_pax]" id="training_calendar-cost_per_pax" value="{{ $record['training_calendar.cost_per_pax'] }}" placeholder="Enter Cost Per Pax" /> 				
				</div>	
			</div>

			<div class="form-group">
	            <label class="control-label col-md-3">Last Registration Date</label>
	            <div class="col-md-7">
	                <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
	                    <input disabled="disabled" type="text" class="form-control" name="training_calendar[last_registration_date]" id="training_calendar-last_registration_date" value="{{ $record['training_calendar.last_registration_date'] }}" placeholder="Enter Date" >
	                    <span class="input-group-btn">
							<button disabled="disabled" class="btn default" type="button"><i class="fa fa-calendar"></i></button>
						</span>
	                </div>
	            </div>
	        </div>

	        <div class="form-group">
				<label class="control-label col-md-3">Evaluation Form</label>
				<div class="col-md-7"><?php									                            		
				$db->select('feedback_category_id,feedback_category');
				$db->order_by('feedback_category', '0');
				$db->where('deleted', '0');
				$options = $db->get('training_feedback_category'); 	                            
				$training_calendar_feedback_category_id_options = array();
	            		foreach($options->result() as $option)
	            		{
	        				$training_calendar_feedback_category_id_options[$option->feedback_category_id] = $option->feedback_category;
	            		} ?>							

	            	<div class="input-group">
						<span class="input-group-addon">
	                    <i class="fa fa-list-ul"></i>
	                    </span>
	                    {{ form_dropdown('training_calendar[feedback_category_id][]',$training_calendar_feedback_category_id_options, explode(',', $record['training_calendar.feedback_category_id']), 'disabled="disabled" class="select2me form-control " data-placeholder="Select Feedback Category" id="training_calendar-feedback_category_id" multiple') }}
	                </div> 			
	            </div>	
			</div>

			<div class="form-group">
	            <label class="control-label col-md-3">Publish Date</label>
	            <div class="col-md-7">
	                <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
	                    <input disabled="disabled" type="text" class="form-control" name="training_calendar[publish_date]" id="training_calendar-publish_date" value="{{ $record['training_calendar.publish_date'] }}" placeholder="Enter Date" >
	                    <span class="input-group-btn">
							<button disabled="disabled" class="btn default" type="button"><i class="fa fa-calendar"></i></button>
						</span>
	                </div>
	            </div>
	        </div>

	        <div class="form-group">
				<label class="control-label col-md-3">Level 2 and 3 Evaluation</label>
				<div class="col-md-7"><?php									                            		
				$db->select('training_revalida_master_id,revalida_type');
				$db->order_by('revalida_type', '0');
	            $db->where('deleted', '0');
	            $options = $db->get('training_revalida_master'); 	                            
	            $training_calendar_training_revalida_master_id_options = array('' => 'Select...');

	    		foreach($options->result() as $option)
	    		{
	    			$training_calendar_training_revalida_master_id_options[$option->training_revalida_master_id] = $option->revalida_type;
	    		} ?>							
	        		<div class="input-group">
						<span class="input-group-addon">
	                    <i class="fa fa-list-ul"></i>
	                    </span>
	                    {{ form_dropdown('training_calendar[training_revalida_master_id]',$training_calendar_training_revalida_master_id_options, $record['training_calendar.training_revalida_master_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..." id="training_calendar-training_revalida_master_id"') }}
	                </div> 				
	            </div>	
			</div>

			<div class="form-group">
				<label class="control-label col-md-3">Certification</label>
				<div class="col-md-7">							
					<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
				    	<input disabled="disabled" type="checkbox" value="1" @if( $record['training_calendar.with_certification'] ) checked="checked" @endif name="training_calendar[with_certification][temp]" id="training_calendar-with_certification-temp" class="dontserializeme toggle"/>
				    	<input disabled="disabled" type="hidden" name="training_calendar[with_certification]" id="training_calendar-with_certification" value="<?php echo $record['training_calendar.with_certification'] ? 1 : 0 ?>"/>
					</div> 				
				</div>	
			</div>

			<div class="form-group">
	            <label class="control-label col-md-3">Evaluation Date</label>
	            <div class="col-md-7">
	                <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
	                    <input disabled="disabled" type="text" class="form-control" name="training_calendar[revalida_date]" id="training_calendar-revalida_date" value="{{ $record['training_calendar.revalida_date'] }}" placeholder="Enter Date" >
	                    <span class="input-group-btn">
							<button disabled="disabled" class="btn default" type="button"><i class="fa fa-calendar"></i></button>
						</span>
	                </div>
	            </div>
	        </div>

	        <div class="form-group">
				<label class="control-label col-md-3">Planned?</label>
				<div class="col-md-7">							
					<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
				    	<input disabled="disabled" type="checkbox" value="1" @if( $record['training_calendar.planned'] ) checked="checked" @endif name="training_calendar[planned][temp]" id="training_calendar-planned-temp" class="dontserializeme toggle"/>
				    	<input disabled="disabled" type="hidden" name="training_calendar[planned]" id="training_calendar-planned" value="<?php echo $record['training_calendar.planned'] ? 1 : 0 ?>"/>
					</div> 				
				</div>	
			</div>
		</div>
	</div>

	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">Training Session</div>
			<div class="tools"><a class="collapse" href="javascript:;"></a></div>
		</div>
		<div class="portlet-body form">
			<div class="clearfix">
				<table class="table table-condensed table-striped table-hover">
					<thead>
						<tr>
							<th width="14%" style="text-align:center">Session No.</th>
							<th class="hidden-xs" width="14%" style="text-align:center">Instructor</th>
							<th class="hidden-xs" width="14%" style="text-align:center">Training Date</th>
							<th width="14%" style="text-align:center">Session Time From</th>
							<th width="14%" style="text-align:center">Session Time To</th>
							<th width="14%" style="text-align:center">Break Time From</th>
							<th width="14%" style="text-align:center">Break Time To</th>
						</tr>
					</thead>
					<tbody id="form-list">
						<?php 
							if(!empty($session_tab)){ 
								$session_count = 0;
								foreach($session_tab as $session){
						?>

										<tr>
								    		<td style="text-align:center"><?php echo $session['session_no'];  ?></td>
								    		<td style="text-align:center"><?php echo $session['instructor'];  ?></td>
								    		<td style="text-align:center"><?php echo $session['session_date'];  ?></td>
								    		<td style="text-align:center"><?php echo date('h:i A',strtotime($session['sessiontime_from']));  ?></td>
								    		<td style="text-align:center"><?php echo date('h:i A',strtotime($session['sessiontime_to']));  ?></td>
								    		<td style="text-align:center"><?php echo date('h:i A',strtotime($session['breaktime_from']));  ?></td>
								    		<td style="text-align:center"><?php echo date('h:i A',strtotime($session['breaktime_to']));  ?></td>
								    		
								    		
								    	</tr>
						<?php
									}
								}
							//}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">Training Cost</div>
			<div class="tools"><a class="collapse" href="javascript:;"></a></div>
		</div>
		<div class="portlet-body form">	
			<div class="clearfix">
				<table class="table table-condensed table-striped table-hover">
					<thead>
						<tr>
							<th width="20%" style="text-align:center">Source</th>
							<th class="hidden-xs" width="20%" style="text-align:center">Remarks</th>
							<th class="hidden-xs" width="20%" style="text-align:center">Cost</th>
							<th width="20%" style="text-align:center">No. of Pax</th>
							<th width="20%" style="text-align:center">Total</th>
						</tr>
					</thead>
					<tbody id="form-list">
						<?php 
							if(!empty($training_cost_tab)){ 
								$training_cost_count = 0;
								foreach($training_cost_tab as $training_cost){
						?>

										<tr>
								    		<td style="text-align:center">
								    			<?php
				                                    $training_cost_options = array('' => 'Select');
				                                    $training_costs = $db->get_where( 'training_source', array('deleted' => 0) );
				                                    foreach( $training_costs->result() as $row )
				                                    {
				                                        $training_cost_options[$row->source_id] =  $row->source;
				                                    }
				                                ?>
								    		<?php echo  $training_cost_options[$row->source_id];  ?></td>
								    		<td style="text-align:center"><?php echo $training_cost['remarks'];  ?></td>
								    		<td style="text-align:center"><?php echo $training_cost['cost'];  ?></td>
								    		<td style="text-align:center"><?php echo $training_cost['pax'];  ?></td>
								    		<td style="text-align:center"><?php echo $training_cost['total'];  ?></td>
								    		
								    		
								    	</tr>
						<?php
									}
								}
							//}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">Training Participants</div>
			<div class="tools"><a class="collapse" href="javascript:;"></a></div>
		</div>
		<div class="portlet-body form">	
			<div class="clearfix">
				<table class="table table-condensed table-striped table-hover">
					<thead>
						<tr>
							<th width="22%" style="text-align:center">Employee Name</th>
							<th class="hidden-xs" width="20%" style="text-align:center">Nominate</th>
							<th class="hidden-xs" width="20%" style="text-align:center">Status</th>
							<th width="18%" style="text-align:center">Attendance</th>
						</tr>
					</thead>
					<tbody id="form-list">
						<?php
							if ($record['record_id'] != ''){
								$db->where('training_calendar_id',$record['record_id']);
								$db->join('partners','training_calendar_participant.user_id = partners.user_id','left');
								$list_participants = $db->get('training_calendar_participant');
								if ($list_participants && $list_participants->num_rows() > 0){
									
									$participant_status_list = $db->get('training_calendar_participant_status')->result();

									foreach ($list_participants->result() as $row) {
										
										$rand = rand(1,10000);
						?>
										<tr>
								    		<td style="text-align:center"><?php echo $row->alias ?></td>
								    		
								    		<td style="text-align:center">
												<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
											    	<input disabled="disabled" type="checkbox" value="1" @if( $row->nominate ) checked="checked" @endif name="participants[<?php echo $rand ?>][temp]" id="participants-nominate" class="toggle participants-nominate"/>
											    	<input type="hidden" name="participants[<?php echo $rand ?>][nominate]" class="participants-nominate-val" value="<?php echo $row->nominate ? 1 : 0 ?>"/>
												</div> 								    			
								    		</td>
								    		<td style="text-align:center">
									    			<?php 
									    			foreach( $participant_status_list as $participant_status ){ 
									    				if( $participant_status->participant_status_id == $row->participant_status_id ){ echo $participant_status->participant_status; 
							    						} 
						    						}?>
								    		</td>
								    		<td style="text-align:center">
												<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
											    	<input disabled="disabled" type="checkbox" value="1" @if( $row->no_show ) checked="checked" @endif name="participants[<?php echo $rand ?>][temp]" id="participants-no_show" class="toggle participants-no_show"/>
											    	<input type="hidden" name="participants[<?php echo $rand ?>][no_show]" class="participants-no_show-val" value="<?php echo $row->nominate ? 1 : 0 ?>"/>
												</div> 
								    		</td>
								    		
								    	</tr>
						<?php
									}
								}
							}
						?>
					</tbody>
				</table>
			</div>
			<fieldset>
				<div class="col-md-2">
				    <label for="date" class="label-desc gray">Total Confirmed:</label>
				    <div class="text-input-wrap">  
						<input class="form-control total_confirmed" name="total_confirmed" id="" readonly value="" placeholder="Total Confirmed" type="text">
				    </div>                                    
				</div>
			</fieldset>		              
		</div>
	</div>
</form>