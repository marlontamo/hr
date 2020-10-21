<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('partners.work_assignment') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
        <div class="form-horizontal" >
			<div class="form-body">	                        	
            	<div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.reports_to') }}</label>
                    <div class="col-md-5">
                    	<?php 	$db->select('user_id,display_name');
                    			$db->where('deleted', '0');
                                $db->where('active', '1');
                                $db->where('user_id <>', '1');
                                $db->order_by('display_name');
                    			$options = $db->get('users');

                    			$users_department_immediate_id_options = array('' => 'Select...');
                    			foreach($options->result() as $option)
                    			{
                    				$users_department_immediate_id_options[$option->user_id] = $option->display_name;
                    			} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('users_profile[reports_to_id]',$users_department_immediate_id_options, $record['users_profile.reports_to_id'], 'class="form-control select2me" id="users_profile-reports_to_id" data-placeholder="Select..."') }}
	                        </div> 				</div>	
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.project_hr') }}</label>
                    <div class="col-md-5">
                        <?php   $db->select('user_id,display_name');
                                $db->where('deleted', '0');
                                $db->where('active', '1');
                                $db->where('user_id <>', '1');
                                $db->order_by('display_name');
                                $options = $db->get('users');

                                $users_department_immediate_id_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                    $users_department_immediate_id_options[$option->user_id] = $option->display_name;
                                } ?>                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                                </span>
                                {{ form_dropdown('users_profile[project_hr_id]',$users_department_immediate_id_options, $record['users_profile.project_hr_id'], 'class="form-control select2me" id="users_profile-project_hr_id" data-placeholder="Select..."') }}
                            </div>              </div>  
                </div>                
              <!--   <div class="form-group">
                    <label class="control-label col-md-3">Direct Subordinates</label>
                    <div class="col-md-5">
                       <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-user"></i>
                             </span>
                            <select  class="form-control select2me" data-placeholder="Select...">
                            	<option>Select</option>
                            </select>
                        </div>
                    </div>
                </div> -->
                @if(in_array('organization', $partners_keys))
                <div class="form-group ">
                    <label class="control-label col-md-3">{{ lang('partners.org') }}</label>
                    <div class="col-md-5">
                       <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-user"></i>
                             </span>
                            <input type="text" class="form-control" name="partners_personal[organization]" id="partners_personal-organization" value="{{ $record_personal[1]['partners_personal.organization'] }}" placeholder="Enter Organization"/>
                        </div>
                    </div>
                </div>
                @endif
                @if(in_array('division', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.div') }}</label>
                    <div class="col-md-5">
                    	<?php 	$db->select('division_id,division');
                    			$db->where('deleted', '0');
                    			$options = $db->get('users_division');

                    			$users_profile_division_id_options = array('' => 'Select...');
                    			foreach($options->result() as $option)
                    			{
                    				$users_profile_division_id_options[$option->division_id] = $option->division;
                    			} ?>
                    	<div class="input-group">
							<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('users_profile[division_id]',$users_profile_division_id_options, $record['users_profile.division_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                    </div>
	                </div>	
                </div>
                @endif
                @if(in_array('department', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.dept') }}</label>
                    <div class="col-md-5">
                        <?php   $db->select('department_id,department');
                                $db->where('deleted', '0');
                                $options = $db->get('users_department');

                                $users_profile_department_id_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                    $users_profile_department_id_options[$option->department_id] = $option->department;
                                } ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('users_profile[department_id]',$users_profile_department_id_options, $record['users_profile.department_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>
                @endif 
                @if(in_array('branch', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.branch') }}</label>
                    <div class="col-md-5">
                        <?php   $db->select('branch_id,branch');
                                $db->where('deleted', '0');
                                $options = $db->get('users_branch');

                                $users_profile_branch_id_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                    $users_profile_branch_id_options[$option->branch_id] = $option->branch;
                                } ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('users_profile[branch_id]',$users_profile_branch_id_options, $record['users_profile.branch_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>
                @endif                  
                @if(in_array('section', $partners_keys))
                <div class="form-group ">
                    <label class="control-label col-md-3">{{ $partners_labels['section'] }}</label>
                    <div class="col-md-5">
                        <?php   
                            $db->select('section_id,section');
                            $db->where('deleted', '0');
                            $options = $db->get('users_section');

                            $users_section_section_id_options = array('' => 'Select...');
                            foreach($options->result() as $option)
                            {
                                $users_section_section_id_options[$option->section_id] = $option->section;
                            } 
                        ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('users_profile[section_id]', $users_section_section_id_options, $record['users_profile.section_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>
                @endif
                @if(in_array('group', $partners_keys))              
                <div class="form-group hidden">
                    <label class="control-label col-md-3">{{ lang('partners.group') }}</label>
                    <div class="col-md-5">
                        <?php   $db->select('group_id,group');
                                $db->where('deleted', '0');
                                $options = $db->get('users_group');

                                $users_profile_group_id_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                    $users_profile_group_id_options[$option->group_id] = $option->group;
                                } ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('users_profile[group_id]',$users_profile_group_id_options, $record['users_profile.group_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>
                @endif                             
                <div class="form-group ">
                    <label class="control-label col-md-3">{{ lang('partners.project_name') }}</label>
                    <div class="col-md-5">
                        <?php   
                            $db->select('project_id,project');
                            $db->where('deleted', '0');
                            $options = $db->get('users_project');

                            $users_project = array('' => 'Select...');
                            foreach($options->result() as $option)
                            {
                                $users_project[$option->project_id] = $option->project;
                            } 
                        ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('users_profile[project_id]',$users_project, $record['users_profile.project_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>
                @if(in_array('start_date', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.start_date') }}</label>
                    <div class="col-md-5">
                        <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                            <?php if($record['users_profile.start_date'] == '1970-01-01') { ?>
                                <input type="text" class="form-control" name="users_profile[start_date]" id="users_profile-start_date" value="" placeholder="{{ lang('common.enter') }} {{ lang('partners.start_date') }}" >
                            <?php } else { ?>
                                <input type="text" class="form-control" name="users_profile[start_date]" id="users_profile-start_date" value="{{ $record['users_profile.start_date'] }}" placeholder="{{ lang('common.enter') }} {{ lang('partners.start_date') }}" >
                            <?php } ?>                            
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                @endif  
                @if(in_array('end_date', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.end_date') }}</label>
                    <div class="col-md-5">
                        <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                            <?php if($record['users_profile.end_date'] == '1970-01-01') { ?>
                                <input type="text" class="form-control" name="users_profile[end_date]" id="users_profile-end_date" value="" placeholder="{{ lang('common.enter') }} {{ lang('partners.end_date') }}" >
                            <?php } else { ?>
                                <input type="text" class="form-control" name="users_profile[end_date]" id="users_profile-end_date" value="{{ $record['users_profile.end_date'] }}" placeholder="{{ lang('common.enter') }} {{ lang('partners.end_date') }}" >
                            <?php } ?> 
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                @endif   
                @if(in_array('work_schedule_coordinator', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.coordinator') }}</label>
                    <div class="col-md-5">
                        <?php   
                            $db->select('user_id,display_name');
                            $db->where('deleted', '0');
                            $db->where('active', '1');
                            $db->where('user_id <>', '1');
                            $db->order_by('display_name');
                            $options = $db->get('users');

                            $users_coordinator_id_options = array('' => 'Select...');
                            foreach($options->result() as $option)
                            {
                                $users_coordinator_id_options[$option->user_id] = $option->display_name;
                            } 
                        ?>                            
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                            {{ form_multiselect('users_profile[coordinator_id][]',$users_coordinator_id_options, explode(',', $record['users_profile.coordinator_id']), 'class="form-control select2me" id="users_profile-coordinator_id" data-placeholder="Select..."') }}
                        </div>              
                    </div>  
                </div>
                @endif 
                @if(in_array('credit_setup', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.credit_setup') }}</label>
                    <div class="col-md-5">
                        <?php   
                            $db->select('class_id,class');
                            $db->where('deleted', '0');
                            $db->where('form_code', 'LIP');
                            $options = $db->get('time_form_balance_credit_class');

                            $users_credit_class_options = array('' => 'Select...');
                            foreach($options->result() as $option)
                            {
                                $users_credit_class_options[$option->class_id] = $option->class;
                            } 
                        ?>                            
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                            {{ form_dropdown('users_profile[credit_setup_id]',$users_credit_class_options, $record['users_profile.credit_setup_id'], 'class="form-control select2me" id="users_profile-credit_setup" data-placeholder="Select..."') }}
                        </div>              
                    </div>  
                </div>
                @endif                                    
                @if(in_array('home_leave', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3" style="margin-top: 0px;">{{ lang('partners.home_leave') }}</label>
                    <div class="col-md-5">
                        <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                            <input type="checkbox" value="1" @if( $personal_home_leave ) checked="checked" @endif name="partners_personal[home_leave][temp]" id="partners_personal-home_leave-temp" class="dontserializeme toggle"/>
                            <input type="hidden" name="partners_personal[home_leave]" id="partners_personal-home_leave" value="@if( $personal_home_leave ) 1 else 0 @endif"/>
                        </div> 
                    </div>
                </div>
                @endif                                                               
            </div>
            <div class="form-actions fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-offset-3 col-md-8">
                            <button class="btn green btn-sm" type="button" onclick="save_partner( $(this).parents('form') )"><i class="fa fa-check"></i> {{ lang('common.save') }}</button>
                            <button class="btn blue btn-sm" type="submit"><i class="fa fa-undo"></i> {{ lang('common.reset') }}</button>                               
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>