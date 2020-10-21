<div class="portlet">
	<div class="portlet-title">
		<div class="caption"> {{ lang('performance_appraisal.appraisal') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_appraisal.goal_setting') }}
			</label>
			<div class="col-md-5"><?php									                            		
				$query = "SELECT planning_id, 
								CONCAT(year, ' - ', performance, ' (', 
								DATE_FORMAT(date_from, '%d-%b'), ' to ', 
								DATE_FORMAT(date_to, '%d-%b-%y'), ') : ') as planning,
								CONCAT(' (', 
								DATE_FORMAT(date_from, '%d-%b'), ' to ', 
								DATE_FORMAT(date_to, '%d-%b-%y'), ')') as planning_date, 
								notes,
								u.full_name								
							FROM {$db->dbprefix}performance_planning pp 
							LEFT JOIN {$db->dbprefix}users u ON pp.created_by = u.user_id
							INNER JOIN {$db->dbprefix}performance_setup_performance psp 
							ON psp.performance_id = pp.performance_type_id 
							WHERE pp.deleted = 0 AND pp.status_id = 0 
							ORDER BY planning_id DESC ";
				$options = $db->query($query);
				$performance_appraisal_planning_id_options = array('' => 'Select...');
				foreach($options->result() as $option)
				{
					$performance_appraisal_planning_id_options[$option->planning_id] = $option->planning . "<span style='color:#666 !important'>Immediate : ".$option->full_name."</span>";
				}
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('performance_appraisal[planning_id]',$performance_appraisal_planning_id_options, $record['performance_appraisal.planning_id'], 'class="form-control select2me" data-placeholder="Select..." id="performance_appraisal-planning_id"') }}
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_appraisal.from') }}
			</label>
			<div class="col-md-6">
				<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
					<input type="text" class="form-control" name="performance_appraisal[date_from]" id="performance_appraisal-date_from" value="{{ $record['performance_appraisal.date_from'] }}" placeholder="Enter Date From">
					<span class="input-group-btn">
						<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
				<div class="help-block small">{{ lang('performance_appraisal.start_date') }}</div>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_appraisal.to') }}
			</label>
			<div class="col-md-6">
				<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
					<input type="text" class="form-control" name="performance_appraisal[date_to]" id="performance_appraisal-date_to" value="{{ $record['performance_appraisal.date_to'] }}" placeholder="Enter Date To">
					<span class="input-group-btn">
						<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
				<div class="help-block small">{{ lang('performance_appraisal.end_date') }}</div>
			</div>
		</div>
		<div class="form-group hidden">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_appraisal.year') }}
			</label>
			<div class="col-md-5">
				<input type="text" class="form-control" name="performance_appraisal[year]" id="performance_appraisal-year" value="{{ $record['performance_appraisal.year'] }}" placeholder="Enter Year" readonly/>
			</div>
		</div>		
		<div class="form-group hidden">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_appraisal.performance_type') }}
			</label>
			<div class="col-md-5"><?php									                            		
				$db->select('performance_id,performance');
				$db->order_by('performance', '0');
				$db->where('deleted', '0');
				$options = $db->get('performance_setup_performance');
				$performance_appraisal_performance_type_id_options = array('' => 'Select...');
				foreach($options->result() as $option)
				{
					$performance_appraisal_performance_type_id_options[$option->performance_id] = $option->performance;
				} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('performance_appraisal[performance_type_id]',$performance_appraisal_performance_type_id_options, $record['performance_appraisal.performance_type_id'], 'class="form-control select2me" data-placeholder="Select..." id="performance_appraisal-performance_type_id" ') }}
				</div>
			</div>
		</div>
		<div class="form-group hidden">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_appraisal.template') }}</label>
			<div class="col-md-6">
				<?php
				$db->select('template_id,template');
				$db->where('deleted', '0');
				$options = $db->get('performance_template');
				$performance_appraisal_template_id_options = array();
					foreach($options->result() as $option)
					{
						$performance_appraisal_template_id_options['selection'][$option->template_id] = $option->template;
					} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('performance_appraisal[template_id][]',$performance_appraisal_template_id_options, explode(',', $record['performance_appraisal.template_id']), 'class="form-control select2" data-placeholder="Select..." multiple id="performance_appraisal-template_id"') }}
				</div>
			</div>	
		</div>
		<div class="form-group hidden">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_appraisal.employment_status_filter') }}
			</label>
			<div class="col-md-6">
				<?php
				$db->select('employment_status_id,employment_status');
				$db->where('deleted', '0');
				$options = $db->get('partners_employment_status');
				$employment_status_id_options = array();
					foreach($options->result() as $option)
					{
						$employment_status_id_options['Selection'][$option->employment_status_id] = $option->employment_status;
					} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('performance_appraisal[employment_status_id][]',$employment_status_id_options, explode(',', $record['performance_appraisal.employment_status_id']), 'class="form-control select2" data-placeholder="Select..." multiple id="performance_appraisal-employment_status_id" ') }}
				</div>
			</div>	
		</div>
		<div class="form-group hidden">
			<label class="control-label col-md-4">{{ lang('performance_appraisal.filter_by') }}</label>
			<div class="col-md-6">
				<?php
					$db->select('filter_id,filter_by');
					$db->order_by('filter_by', '0');
					$db->where('deleted', '0');
					$options = $db->get('performance_planning_filter');
					$performance_appraisal_filter_by_options = array('' => 'Select...');
					foreach($options->result() as $option)
					{
						$performance_appraisal_filter_by_options[$option->filter_id] = $option->filter_by;
					} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('performance_appraisal[filter_by]',$performance_appraisal_filter_by_options, $record['performance_appraisal.filter_by'], 'class="form-control select2me" data-placeholder="Select..." id="performance_appraisal-filter_by"') }}
				</div>
			</div>
		</div>	
		<div class="form-group hidden">
			<label class="control-label col-md-4">{{ lang('performance_appraisal.selection') }}</label>
			<div class="col-md-6">
				<?php
				$db->select('company_id,company');
				$db->where('deleted', '0');
				$options = $db->get('users_company');
				$performance_appraisal_filter_id_options = array();
				foreach($options->result() as $option)
				{
					$performance_appraisal_filter_id_options[$option->company_id] = $option->company;
				} ?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('performance_appraisal[filter_id][]',$performance_appraisal_filter_id_options, explode(',', $record['performance_appraisal.filter_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="performance_appraisal-filter_id"') }}
				</div>
			</div>	
		</div>	
		<div class="form-group hidden">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_appraisal.applicable_for') }}
			</label>
			<div class="col-md-6">
				<?php
				$db->select('user_id,full_name');
				$db->where('deleted', '0');
				$db->order_by('full_name', '0');
				$options = $db->get('users');
				$performance_appraisal_applicable_user_id_options = array();
				foreach($options->result() as $option)
				{
					$performance_appraisal_applicable_user_id_options[$option->user_id] = $option->full_name;
				} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('performance_appraisal_applicable[user_id][]',$performance_appraisal_applicable_user_id_options, explode(',', $record['performance_appraisal_applicable.user_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="performance_appraisal_applicable-user_id"') }}
				</div>
			</div>
		</div>	
		<!-- <div class="form-group hidden">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				Selection
			</label>
			<div class="col-md-5">
				<input type="text" class="form-control" name="performance_appraisal_applicable[reference_id]" id="performance_appraisal_applicable-reference_id" rows="4" value="{{ $record['performance_appraisal_applicable.reference_id'] }}">
			</div>
		</div> -->
		<div class="form-group">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_appraisal.notes') }}
			</label>
			<div class="col-md-5">
				<textarea class="form-control" name="performance_appraisal[notes]" id="performance_appraisal-notes" placeholder="Enter Notes" rows="4">{{ $record['performance_appraisal.notes'] }}</textarea>
			</div>
		</div>			
		<div class="form-group">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_appraisal.period_status') }}
			</label>
			<div class="col-md-5">
				<div class="make-switch" data-on-label="&nbsp;{{ lang('performance_appraisal.open') }}&nbsp;" data-off-label="&nbsp;{{ lang('performance_appraisal.close') }}&nbsp;">
					<input type="checkbox" value="1" @if( $record['performance_appraisal.status_id'] || empty($record_id) ) checked="checked" @endif name="performance_appraisal[status_id][temp]" id="performance_appraisal-status_id-temp" class="dontserializeme toggle"/>
					<input type="hidden" name="performance_appraisal[status_id]" id="performance_appraisal-status_id" value="@if( $record['performance_appraisal.status_id'] || empty($record_id) ) 1 @else 0 @endif"/>
				</div>
			</div>
		</div>	
	</div>
</div>
<br>
<div class="portlet hidden">
	<div class="portlet-title">
		<div class="caption">{{ lang('performance_appraisal.reminder') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">		
		<div class="form-group">
			<label class="control-label col-md-4">{{ lang('performance_appraisal.reminder_type') }}</label>
			<div class="col-md-5">
				<div class="input-group">
					<?php
					$db->select('notification_id, notification');
					$db->order_by('notification', '0');
					$db->where('deleted', '0');
					$options = $db->get('performance_setup_notification'); 	                            
					$performance_setup_notification_id_options = array('' => 'Select...');
					foreach($options->result() as $option)
					{
						$performance_setup_notification_id_options[$option->notification_id] = $option->notification;
					} 
					?>
					{{ form_dropdown('notification_id',$performance_setup_notification_id_options, '', 'class="form-control select2me" data-placeholder="Select..." id="notification_id"') }}
					<span class="input-group-btn">
						<button type="button" class="btn btn-success" onclick="add_form('appraisal_reminder', 'reminder')">
							<i class="fa fa-plus"></i>
						</button>
					</span>
				</div>
				<div class="help-block small">
					{{ lang('performance_appraisal.reminder_note') }}
				</div>
				<!-- /input-group -->
			</div>
		</div>
		<br>
		<div class="portlet margin-top-25">
			<h5 class="form-section margin-bottom-10">
				<b>{{ lang('performance_appraisal.reminder_list') }}</b>
			</h5>
			<div class="portlet-body" >
				<!-- Table -->
				<table class="table table-condensed table-striped table-hover <?php if( is_array($reminder_ids) && sizeof($reminder_ids) ==0 ) echo 'hidden' ?>" id="reminder-table" >
					<thead>
						<tr>
							<th width="18%" class="padding-top-bottom-10" >{{ lang('performance_appraisal.type') }}</th>
							<th width="29%" class="padding-top-bottom-10" >{{ lang('performance_appraisal.date') }}</th>
							<th width="13%" class="padding-top-bottom-10" >{{ lang('common.status') }}</th>
							<th width="27%" class="padding-top-bottom-10" >{{ lang('performance_appraisal.attachments') }}</th>
							<th width="13%" class="padding-top-bottom-10" >{{ lang('common.actions') }}</th>
						</tr>
					</thead>
					<tbody id="reminder" class="appraisal_reminder">
						@if(is_array($reminder_ids))
							@foreach($reminder_ids as $index => $value)
							<tr>
								<td>
									<input type="hidden" class="form-control" maxlength="64" value="{{$value['reminder_id']}}" name="performance_appraisal_reminder[reminder_id][]" id="performance_appraisal_reminder-reminder_id">
									<select name="performance_appraisal_reminder[notification_id][]" class="form-control select2me" data-placeholder="Select..." id="performance_appraisal_reminder-notification_id">
									<?php
										foreach($options->result() as $option)
										{
									?>
										<option value="{{$option->notification_id}}" <?php if($option->notification_id == $value['notification_id']) echo "selected";?> >{{$option->notification}}</option>
									<?php
										} 
									?>
									</select>					
								</td>
								<td>
									<div class="input-group date date-picker" data-date-format="MM dd, yyyy">
										<input type="text" class="form-control reminder_date" name="performance_appraisal_reminder[date][]" id="performance_appraisal_reminder-date" placeholder="Enter Date" readonly value="{{date('F d, Y', strtotime($value['date']))}}">
										<span class="input-group-btn">
											<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
										</span>
									</div>
								</td>
								<td>
									<div class="make-switch" data-on-label="&nbsp;{{ lang('performance_appraisal.on') }}&nbsp;" data-off-label="&nbsp;{{ lang('performance_appraisal.off') }}&nbsp;"  data-on="success" data-off="warning">
										<input type="checkbox" value="1" @if( $value['status_id'] ) checked="checked" @endif name="performance_appraisal_reminder[status_id][temp][]" id="performance_appraisal_reminder-status_id-temp" class="dontserializeme toggle reminder_stat"/>
										<input type="hidden" name="performance_appraisal_reminder[status_id][]" id="performance_appraisal_reminder-status_id" value="@if( $value['status_id'] ) 1 else 0 @endif" class="score_status_id"/>
									</div>
								</td>
								<td>
									<?php 
				                    	$attachment_file = array_key_exists('file', $value) ? $value['file'] : ""; 
				                    ?>
									<div data-provides="fileupload" class="fileupload fileupload-new" id="performance_appraisal_reminder-file-container">
								        <input class="reminder_attach-file" type="hidden" name="performance_appraisal_reminder[file][]" id="performance_appraisal_reminder-file" value="{{$value['file']}}"/>
								        <div class="input-group">
								            <span class="input-group-btn"><!-- 
								                <span class="uneditable-input"> -->
								                <!-- </span>
								            </span> -->
								            <span class="btn default btn-file add_file">
								                <span class="fileupload-new" 
								                <?php if (!empty($attachment_file)){ echo 'style="display:none"';}?> ><i class="fa fa-paper-clip"></i> {{ lang('performance_appraisal.select_file') }}</span>
								                <span class="fileupload-exists small" 
								                <?php if (!empty($attachment_file)){ echo 'style="display:inline-block"';}?>><i class="fa fa-undo"></i> Change</span>
								                <input type="file" class="reminder_file" id="performance_appraisal_reminder-file-fileupload" type="file" name="files[]">
								            </span>
								            <a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete small" 
								                <?php if (!empty($attachment_file)){ echo 'style="display:inline-block"';}?>><i class="fa fa-trash-o"></i> {{ lang('common.remove') }}</a>
								            
								            <ul class="padding-none margin-top-11">
								                <!-- <i class="fa fa-file fileupload-exists"></i>  -->
								                <span class="fileupload-preview">

								                    <?php
								                    if (!empty($attachment_file)){
								                        $file = FCPATH . urldecode( $attachment_file );
								                        if( file_exists( $file ) )
								                        {
								                            $f_info = get_file_info( $file );
								                            $f_type = filetype( $file );

								                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
								                            $f_type = finfo_file($finfo, $file);

								                            switch( $f_type )
								                            {
								                                case 'image/jpeg':
								                                $icon = 'fa-picture-o';
								                                break;
								                                case 'video/mp4':
								                                $icon = 'fa-film';
								                                break;
								                                case 'audio/mpeg':
								                                $icon = 'fa-volume-up';
								                                break;
								                                default:
								                                $icon = 'fa-file-text-o';
								                            }
								                            $filepath = base_url()."performance_appraisal/download_file/".$value['reminder_id'];
								                            // $file_view = base_url().$details['attachment-file'];

								                            echo '<li class="padding-3" style="list-style:none;"><a href="'.$filepath.'">
								                            <span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								                            <span>'. basename($f_info['name']) .'</span>
								                            </a>
								                            </li>';
								                        }
								                    }
								                    ?>
								                </span>
								            </ul>

								        </div>
								    </div>
								</td>
								<td>
									<a class="btn btn-xs text-muted delete_row" data-record-id="{{$value['reminder_id']}}" ><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
								</td>
							</tr>
							@endforeach
						@endif
					</tbody>
				</table>
				@if( is_array($reminder_ids) && sizeof($reminder_ids) ==0 )
					<div class="well" id="reminder-note">
						<span class="small bold">{{ lang('performance_appraisal.no_reminder') }}</span>
					</div>
				@endif
			</div>
		</div>

	</div>
</div>