<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Calendar</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">

			<form id="training-calendar-form">
		<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Training Course</label>
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
                        {{ form_dropdown('training_calendar[course_id]',$training_calendar_course_id_options, $record['training_calendar.course_id'], 'class="form-control select2me" data-placeholder="Select..." id="training_calendar-course_id"') }}
                    </div> 				
                </div>	
		</div>	

		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Training Type</label>
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
                    {{ form_dropdown('training_calendar[calendar_type_id]',$training_calendar_calendar_type_id_options, $record['training_calendar.calendar_type_id'], 'class="form-control select2me" data-placeholder="Select..." id="training_calendar-calendar_type_id"') }}
                </div> 				
            </div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Training Provider</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="training_calendar[calendar_type_id]" id="training_calendar-calendar_type_id" value="{{ $record['training_calendar.calendar_type_id'] }}" placeholder="Enter Training Provider" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Training Category</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="training_calendar[training_category_id]" id="training_calendar-training_category_id" value="{{ $record['training_calendar.training_category_id'] }}" placeholder="Enter Training Category" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Minimum Trainee Capacity</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="training_calendar[training_capacity]" id="training_calendar-training_capacity" value="{{ $record['training_calendar.training_capacity'] }}" placeholder="Enter Minimum Trainee Capacity" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Maximum Trainee Capacity</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="training_calendar[min_training_capacity]" id="training_calendar-min_training_capacity" value="{{ $record['training_calendar.min_training_capacity'] }}" placeholder="Enter Maximum Trainee Capacity" /> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Venue</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="training_calendar[venue]" id="training_calendar-venue" placeholder="Enter Venue" rows="4">{{ $record['training_calendar.venue'] }}</textarea> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Training Course Description</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="training_calendar[topic]" id="training_calendar-topic" placeholder="Enter Topic" rows="4">{{ $record['training_calendar.topic'] }}</textarea> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>To Be Announce</label>
			<div class="col-md-7">							
				<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
			    	<input type="checkbox" value="1" @if( $record['training_calendar.tba'] ) checked="checked" @endif name="training_calendar[tba][temp]" id="training_calendar-tba-temp" class="dontserializeme toggle"/>
			    	<input type="hidden" name="training_calendar[tba]" id="training_calendar-tba" value="<?php echo $record['training_calendar.tba'] ? 1 : 0 ?>"/>
				</div> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Equipment</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="training_calendar[equipment]" id="training_calendar-equipment" value="{{ $record['training_calendar.equipment'] }}" placeholder="Enter Equipment" /> 				
			</div>	
		</div>

		<div class="form-group">
            <label class="control-label col-md-3">Registration Date</label>
            <div class="col-md-7">
                <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                    <input type="text" class="form-control" name="training_calendar[registration_date]" id="training_calendar-registration_date" value="{{ $record['training_calendar.registration_date'] }}" placeholder="Enter Date" readonly>
                    <span class="input-group-btn">
						<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					</span>
                </div>
            </div>
        </div>

        <div class="form-group">
			<label class="control-label col-md-3">Cost Per Pax</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="training_calendar[cost_per_pax]" id="training_calendar-cost_per_pax" value="{{ $record['training_calendar.cost_per_pax'] }}" placeholder="Enter Cost Per Pax" /> 				
			</div>	
		</div>

		<div class="form-group">
            <label class="control-label col-md-3">Last Registration Date</label>
            <div class="col-md-7">
                <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                    <input type="text" class="form-control" name="training_calendar[last_registration_date]" id="training_calendar-last_registration_date" value="{{ $record['training_calendar.last_registration_date'] }}" placeholder="Enter Date" readonly>
                    <span class="input-group-btn">
						<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					</span>
                </div>
            </div>
        </div>

        <div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Evaluation Form</label>
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
                    {{ form_dropdown('training_calendar[feedback_category_id]',$training_calendar_feedback_category_id_options, $record['training_calendar.feedback_category_id'], 'class="select2me form-control " data-placeholder="Select Feedback Category" id="training_calendar-feedback_category_id" multiple') }}
                </div> 			
            </div>	
		</div>

		<div class="form-group">
            <label class="control-label col-md-3">Publish Date</label>
            <div class="col-md-7">
                <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                    <input type="text" class="form-control" name="training_calendar[publish_date]" id="training_calendar-publish_date" value="{{ $record['training_calendar.publish_date'] }}" placeholder="Enter Date" readonly>
                    <span class="input-group-btn">
						<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
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
                    {{ form_dropdown('training_calendar[training_revalida_master_id]',$training_calendar_training_revalida_master_id_options, $record['training_calendar.training_revalida_master_id'], 'class="form-control select2me" data-placeholder="Select..." id="training_calendar-training_revalida_master_id"') }}
                </div> 				
            </div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Certification</label>
			<div class="col-md-7">							
				<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
			    	<input type="checkbox" value="1" @if( $record['training_calendar.with_certification'] ) checked="checked" @endif name="training_calendar[with_certification][temp]" id="training_calendar-with_certification-temp" class="dontserializeme toggle"/>
			    	<input type="hidden" name="training_calendar[with_certification]" id="training_calendar-with_certification" value="<?php echo $record['training_calendar.with_certification'] ? 1 : 0 ?>"/>
				</div> 				
			</div>	
		</div>

		<div class="form-group">
            <label class="control-label col-md-3">Evaluation Date</label>
            <div class="col-md-7">
                <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                    <input type="text" class="form-control" name="training_calendar[revalida_date]" id="training_calendar-revalida_date" value="{{ $record['training_calendar.revalida_date'] }}" placeholder="Enter Date" readonly>
                    <span class="input-group-btn">
						<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					</span>
                </div>
            </div>
        </div>

        <div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Planned?</label>
			<div class="col-md-7">							
				<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
			    	<input type="checkbox" value="1" @if( $record['training_calendar.planned'] ) checked="checked" @endif name="training_calendar[planned][temp]" id="training_calendar-planned-temp" class="dontserializeme toggle"/>
			    	<input type="hidden" name="training_calendar[planned]" id="training_calendar-planned" value="<?php echo $record['training_calendar.planned'] ? 1 : 0 ?>"/>
				</div> 				
			</div>	
		</div>


	</div>
</div>

<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Session</div>
		<div class="actions">
            <a class="btn btn-default" onclick="add_form('training_session', 'training_session')">
                <i class="fa fa-plus"></i>
            </a>
		</div>
	</div>
	

		<div id="training_session">
    <?php //$employment_count = count($employment_tab); ?>
    <input type="hidden" name="employment_count" id="employment_count" value="" />
    <?php 
    $count_employment = 0;
    $months_options = array(
        '' => 'Select...',
        'January' => 'January', 
        'February' => 'February', 
        'March' => 'March', 
        'April' => 'April', 
        'May' => 'May', 
        'June' => 'June', 
        'July' => 'July', 
        'August' => 'August', 
        'September' => 'September', 
        'October' => 'October', 
        'November' => 'November', 
        'December' => 'December'
        );
    //foreach($employment_tab as $index => $employment){ 
       // $count_employment++;
    ?>
    <div class="portlet">
    	<div class="portlet-title">
    		<!-- <div class="caption" id="education-category">Company Name</div> -->
    		<div class="tools">
    			<a class="text-muted" id="delete_employment-<?php echo $count_employment;?>" onclick="remove_form(this.id, 'employment', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
    			<!-- <a class="collapse pull-right" href="javascript:;"></a> -->
    		</div>
    	</div>
    	<div class="portlet-body form">
            <div class="form-horizontal">
                <div class="form-body">
    		<!-- START FORM -->	
                    <div class="form-group">
                        <label class="control-label col-md-3">lalalala<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="partners_personal_history[employment-company][]" id="partners_personal_history-employment-company" 
                            value="" placeholder="Enter Company"/>
                        </div>
                    </div>
    				

    			</div>
    		</div>
    	</div>
    </div>
    <?php //} ?>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Cost</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">	</div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Participants</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">	
		<div class="form-group">
			<label class="control-label col-md-3">Location</label>
			<div class="col-md-6">
				<?php
					$db->select('location_id,location');
					$db->where('deleted', '0');
            		$options = $db->get('users_location');

					$location_id_options = array();
            		foreach($options->result() as $option)
            		{
            			$location_id_options[$option->location_id] = $option->location;
            		} 
            	?>
                <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    <?php echo form_dropdown('training_calendar[location_id]',$location_id_options, $record['training_calendar.location_id'], 'class="form-control select2me" data-placeholder="Select..." multiple="multiple" id="training_calendar-location_id"') ?>
                </div>
        	</div>
        </div>
		<div class="form-group">
			<label class="control-label col-md-3">Company</label>
			<div class="col-md-6">
				<?php
					$db->select('company_id,company');
					$db->where('deleted', '0');
            		$options = $db->get('users_company');

					$company_id_options = array();
            		foreach($options->result() as $option)
            		{
            			$company_id_options[$option->company_id] = $option->company;
            		} 
            	?>
                <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    <?php echo form_dropdown('training_calendar[company_id]',$company_id_options, $record['training_calendar.company_id'], 'class="form-control select2me" data-placeholder="Select..." multiple="multiple" id="training_calendar-company_id"') ?>
                </div>
        	</div>
        </div>	                    
		<div class="form-group">
			<label class="control-label col-md-3">Project</label>
			<div class="col-md-6">
				<?php
					$db->select('project_id,project');
					$db->where('deleted', '0');
            		$options = $db->get('users_project');

					$project_id_options = array();
            		foreach($options->result() as $option)
            		{
            			$project_id_options[$option->project_id] = $option->project;
            		} 
            	?>
                <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    <?php echo form_dropdown('training_calendar[project_id]',$project_id_options, $record['training_calendar.project_id'], 'class="form-control select2me" data-placeholder="Select..." multiple="multiple" id="training_calendar-project_id"') ?>
                </div>
        	</div>
        </div>
		<div class="form-group">
			<label class="control-label col-md-3">Department</label>
			<div class="col-md-6">
				<?php
					$db->select('department_id,department');
					$db->where('deleted', '0');
            		$options = $db->get('users_department');

					$department_id_options = array();
            		foreach($options->result() as $option)
            		{
            			$department_id_options[$option->department_id] = $option->department;
            		} 
            	?>
                <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    <?php echo form_dropdown('training_calendar[department_id]',$department_id_options, $record['training_calendar.department_id'], 'class="form-control select2me" data-placeholder="Select..." multiple="multiple" id="training_calendar-department_id"') ?>
                </div>
        	</div>
        </div>

        <div class="form-group" id="assignment_show">
			<label class="control-label col-md-3">Assignment</label>
			<div class="col-md-6">
				<?php
					$db->select('assignment_id,assignment');
					$db->where('deleted', '0');
            		$options = $db->get('users_assignment');

					$assignment_id_options = array();
            		foreach($options->result() as $option)
            		{
            			$assignment_id_options[$option->assignment_id] = $option->assignment;
            		} 
            	?>
                <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    <?php echo form_dropdown('training_calendar[assignment_id]',$assignment_id_options, $record['training_calendar.assignment_id'], 'class="form-control select2me" data-placeholder="Select..." multiple="multiple" id="training_calendar-assignment_id"') ?>
                </div>
        	</div>
        </div>	

        <div class="form-group" id="assignment_show">
			<label class="control-label col-md-3">Employee</label>
			<div class="col-md-6">
                <div class="input-group">
					<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
					<select name="training_calendar[employees]" class="form-control select2me" data-placeholder="Select..." multiple="multiple" id="training_calendar-employees">

					</select>
                </div>
        	</div>
        </div>
        <div class="form-group" id="assignment_show">
			<label class="control-label col-md-3">&nbsp;</label>
			<div class="col-md-6">
        		<button type="button" class="btn green btn-sm" onclick="add_participants()"><i class="fa fa-plus"></i> Add Other Participants</button>
        		<button type="button" class="btn red btn-sm" onclick="clear_participants()"><i class="fa fa-trash-o"></i> Clear All Participants</button>        	
        	</div>
        </div>  

		<div class="clearfix">
			<table class="table table-condensed table-striped table-hover">
				<thead>
					<tr>
						<th width="22%" style="text-align:center">Employee Name</th>
						<th class="hidden-xs" width="20%" style="text-align:center">Nominate</th>
						<th class="hidden-xs" width="20%" style="text-align:center">Status</th>
						<th width="18%" style="text-align:center">Attendance</th>
						<th width="20%" style="text-align:center">Actions</th>
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
										    	<input type="checkbox" value="1" @if( $row->nominate ) checked="checked" @endif name="training_calendar[with_certification][temp]" id="participants-nominate" class="toggle participants-nominate"/>
										    	<input type="hidden" name="participants[<?php echo $rand ?>][nominate]" class="participants-nominate-val" value="<?php echo $row->nominate ? 1 : 0 ?>"/>
											</div> 								    			
							    		</td>
							    		<td style="text-align:center">
							    			<select name="participants[<?php echo $rand ?>][status]" class="form-control participant_status select2me">
								    			<?php foreach( $participant_status_list as $participant_status ){ ?>
								    				<option value="<?php echo $participant_status->participant_status_id ?>" <?php if( $participant_status->participant_status_id == $row->participant_status_id ){ echo "selected"; } ?>><?php echo $participant_status->participant_status ?></option>
								    			<?php } ?>
							    			</select>
							    		</td>
							    		<td style="text-align:center">
											<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
										    	<input type="checkbox" value="1" @if( $row->no_show ) checked="checked" @endif name="training_calendar[with_certification][temp]" id="participants-no_show" class="toggle participants-no_show"/>
										    	<input type="hidden" name="participants[<?php echo $rand ?>][no_show]" class="participants-no_show-val" value="<?php echo $row->nominate ? 1 : 0 ?>"/>
											</div> 
							    		</td>
							    		<td style="text-align:center">
							    			<a class="btn btn-xs text-muted delete-participant" href="javascript:void(0)"><i class="fa fa-trash-o"></i> Delete</a>
							    			<input type="hidden" class="participants" name="participants[<?php echo $rand ?>][id]" value="<?php echo $row->user_id ?>" />
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