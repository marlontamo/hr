<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('partners_immediate.work_assignment') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
        <div class="form-horizontal" >
			<div class="form-body">	                        	
            	<div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.reports_to') }}</label>
                    <div class="col-md-5">
                    	<?php 	$db->select('user_id,display_name');
                    			$db->where('deleted', '0');
                                $db->where('active', '1');
                    			$options = $db->get('users');

                    			$users_department_immediate_id_options = array('' => 'Select...');
                    			foreach($options->result() as $option)
                    			{
                    				$users_department_immediate_id_options[$option->user_id] = $option->display_name;
                    			} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('users_profile[reports_to_id]',$users_department_immediate_id_options, $record['users_profile.reports_to_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
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
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.org') }}</label>
                    <div class="col-md-5">
                       <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-user"></i>
                             </span>
                            <input type="text" class="form-control" name="partners_personal[organization]" id="partners_personal-organization" value="{{ $record_personal[1]['partners_personal.organization'] }}" placeholder="Enter Organization"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.div') }}</label>
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
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.dept') }}</label>
                    <div class="col-md-5">
                    	<?php 	$db->select('department_id,department');
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
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.group') }}</label>
                    <div class="col-md-5">
                    	<?php 	$db->select('group_id,group');
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