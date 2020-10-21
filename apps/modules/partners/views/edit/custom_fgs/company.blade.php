<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('partners.company_info') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
        <div class="form-horizontal" >
			<div class="form-body">
            	<div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.company') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                    	<?php	$db->select('company_id,company');
                    			$db->where('deleted', '0');
                    			$options = $db->get('users_company');

                    			$users_profile_company_options = array('' => 'Select...');
                    			foreach($options->result() as $option)
                    			{
                    				$users_profile_company_options[$option->company_id] = $option->company;
                    			} ?>
                    	<div class="input-group">
							<span class="input-group-addon">
                            	<i class="fa fa-list-ul"></i>
	                        </span>
	                    {{ form_dropdown('users_profile[company_id]',$users_profile_company_options, $record['users_profile.company_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                    </div>
	                </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.location') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                    	<?php 	$db->select('location_id,location');
                    			$db->where('deleted', '0');
                    			$options = $db->get('users_location');

                    			$users_profile_location_id_options = array('' => 'Select...');
                    			foreach($options->result() as $option)
                    			{
                    				$users_profile_location_id_options[$option->location_id] = $option->location;
                    			} ?>
                    	<div class="input-group">
                    		<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                        </span>
	                    {{ form_dropdown('users_profile[location_id]',$users_profile_location_id_options, $record['users_profile.location_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                    </div>
	                </div>	
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.position') }} {{ lang('partners.title') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                    	<?php 	$db->select('position_id,position');
                    			$db->where('deleted', '0');
                    			$options = $db->get('users_position');

                    			$users_profile_position_id_options = array('' => 'Select...');
                    			foreach($options->result() as $option)
                    			{
                    				$users_profile_position_id_options[$option->position_id] = $option->position;
                    			} ?>
                    	<div class="input-group">
							<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                        </span>
	                    {{ form_dropdown('users_profile[position_id]',$users_profile_position_id_options, $record['users_profile.position_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                    </div>
	                </div>	
                </div>
                <div class="form-group ">
                    <label class="control-label col-md-3">{{ lang('partners.role') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                    	<?php 	$db->select('role_id,role');
                                $db->where('role_id >', 1);
                    			$db->where('deleted', '0');
                                $db->order_by('role');
                    			$options = $db->get('roles');

								$users_role_id_options = array('' => 'Select...');
	                            foreach($options->result() as $option)
	                            {
	                            	$users_role_id_options[$option->role_id] = $option->role;
	                            } ?>
	                    <div class="input-group">
							<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                        </span>
	                    {{ form_dropdown('users[role_id]',$users_role_id_options, $record['users.role_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                    </div>
	                </div>	
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.id_no') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="partners[id_number]" id="partners-id_number" value="{{ $record['partners.id_number'] }}" placeholder=" {{ lang('partners.id_no') }}"/>
                    </div>
                </div>
                @if(in_array('old_id_number', $partners_keys))
                    <div class="form-group">
                        <label class="control-label col-md-3">{{ $partners_labels['old_id_number'] }}<span class="required">*</span></label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="partners_personal[old_id_number]" id="partners_personal-old_id_number"  value="{{ $old_id_number }}" placeholder="{{ $partners_labels['old_id_number'] }}"/>
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.biometric') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="partners[biometric]" id="partners-biometric" value="{{ $record['partners.biometric'] }}" placeholder="{{ lang('common.enter') }} {{ lang('partners.biometric') }} {{ lang('partners.number') }}"/> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.work_sched') }}</label>
                    <div class="col-md-5">
                        <?php   $db->select('calendar_id,calendar');
                                $db->where('deleted', '0');
                                $options = $db->get('time_shift_weekly');
                                
                                $partners_calendar_id_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                    $partners_calendar_id_options[$option->calendar_id] = $option->calendar;
                                } ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('partners[calendar_id]',$partners_calendar_id_options, $record['partners.calendar_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>                
            </div>   
        </div>                     
	</div>
</div>