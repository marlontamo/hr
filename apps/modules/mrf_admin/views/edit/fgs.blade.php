<div class="portlet">
	<div class="portlet-title">
		<div class="caption"> {{ lang('mrf.mrf_form') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span>{{ lang('mrf.company') }}
			</label>
			<div class="col-md-5">
				<input type="text" class="form-control dontserializeme" value="{{ $record['company'] }}" placeholder="Enter Requested By" readonly /> 
				<?php
					$db->select('company_id,company');
					$db->order_by('company', '0');
					$db->where('deleted', '0');
					$options = $db->get('users_company');
					$recruitment_request_company_id_options = array('' => 'Select...');
					foreach($options->result() as $option)
					{
						$recruitment_request_company_id_options[$option->company_id] = $option->company;
					} 
				?>
				<div class="input-group hidden">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('recruitment_request[company_id]',$recruitment_request_company_id_options, $record['recruitment_request.company_id'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_request-company_id"') }}
				</div>
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span>{{ lang('mrf.dept') }}
			</label>
			<div class="col-md-5">
				<?php
					$db->select('department_id,department');
					$db->order_by('department', '0');
					$db->where('deleted', '0');
					$options = $db->get('users_department');
					$recruitment_request_department_id_options = array('' => 'Select...');
					foreach($options->result() as $option)
					{
						$recruitment_request_department_id_options[$option->department_id] = $option->department;
					} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('recruitment_request[department_id]',$recruitment_request_department_id_options, $record['recruitment_request.department_id'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_request-department_id" '.$record['disabled']) }}
				</div>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('mrf.dept_head') }}</label>
			<div class="col-md-5">
				<input type="text" class="form-control dontserializeme" value="{{ $record['recruitment_request.immediate'] }}" readonly id="recruitment_request-immediate" /> 
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span>{{ lang('mrf.hiring_type') }}
			</label>
			<div class="col-md-5">
				<?php	
				$hiring_type= array(
					'1' => 'External',
					'2' => 'Internal',
					'3' => 'External/Internal'
					)
				?>
				<div class="input-group">
					<span class="input-group-addon">
						 <i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('recruitment_request[hiring_type]',$hiring_type, $record['recruitment_request.hiring_type'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_request-hiring_type" '.$record['disabled']) }}
				</div>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>
			{{ lang('mrf.nature_req') }}</label>
			<div class="col-md-5">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
					<?php
						$option = array('1'=>'Budgeted',
							'0'=>'Not Budgeted',
							'2'=> 'Change of Plan');
						
						// $value = isset( $key->key_value ) ? $key->key_value : '';
						echo form_dropdown('recruitment_request[budgeted]', $option, $record['recruitment_request.budgeted'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_request-budgeted"'.$record['disabled']);
					?>
				</div>	
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('mrf.purpose') }}</label>
			<div class="col-md-5">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
					<?php
						$natures = $db->get_where('recruitment_request_nature', array('deleted' => 0));
						$option = array(''=>'Select...');
						foreach( $natures->result() as $nature )
						{
							$option[$nature->nature_id] = $nature->nature;
						}
						// $value = isset( $key->key_value ) ? $key->key_value : '';
						echo form_dropdown('recruitment_request[nature_id]', $option, $record['recruitment_request.nature_id'], 'class="form-control select2me" data-placeholder="Select..." '.$record['disabled']);
					?>
				</div>	
			</div>
		</div>
		<div class="form-group change_plan hidden">
			<label class="control-label col-md-3">
				<!-- <span class="required">* </span> -->
				Budget From</label>
			<div class="col-md-7">
				<div class="input-group">
					<input type="text" class="form-control input-medium" value="{{ $record['recruitment_request.budget_from'] }}" id="recruitment_request-budget_from" name="recruitment_request[budget_from]" <?php echo $record['disabled'] ?> />
					&nbsp; To &nbsp;
					<input type="text" class="form-control input-medium" value="{{ $record['recruitment_request.budget_to'] }}" id="recruitment_request-budget_to" name="recruitment_request[budget_to]" <?php echo $record['disabled'] ?> />
				</div>
			</div>	
		</div>
		<div class="form-group" {{ ($record['recruitment_request.nature_id'] != 5) ? 'style="display:none"' : '' }}>
			<label class="control-label col-md-3">
			{{ lang('mrf.replace_of') }}
			</label>
			<div class="col-md-5">
				<?php
					$db->select('user_id, full_name');
					$db->order_by('full_name', '0');
					$db->where('deleted', '0');
					$db->where('active', '1');
					$db->where('user_id != 1');
					$options = $db->get('users');
					$users_id_options = array('' => 'Select...');
					foreach($options->result() as $option)
					{
						$users_id_options[$option->user_id] = $option->full_name;
					} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('recruitment_request[replacement_of]',$users_id_options, $record['recruitment_request.replacement_of'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_request-replacement_of" '.$record['disabled']) }}
				</div>
			</div>	
		</div>
		<div class="form-group due_to" {{ ($record['recruitment_request.nature_id'] != 5) ? 'style="display:none"' : '' }}>
			<label class="control-label col-md-3">
			{{ lang('mrf.due_to') }}
			</label>
			<div class="col-md-5">
				<?php
					$db->select('due_to_id, due_to');
					$db->where('recruitment_request_due_to.deleted', '0');
					$options = $db->get('recruitment_request_due_to');
					$due_to_options = array('' => 'Select...');
					foreach($options->result() as $option)
					{
						$due_to_options[$option->due_to_id] = $option->due_to;
					} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('recruitment_request[due_to_id]',$due_to_options, $record['recruitment_request.due_to_id'], 'class="form-control select2me " data-placeholder="Select..." id="recruitment_request-due_to_id" '.$record['disabled']) }}
				</div>
			</div>	
		</div>
		<div class="form-group location" {{ ($record['recruitment_request.due_to_id'] == 4) ? '' : 'style="display:none"' }}>
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('mrf.location') }}</label>
			<div class="col-md-5">
				<input type="text" class="form-control" value="{{ $record['recruitment_request.replacement_transfer_location'] }}" name="recruitment_request[replacement_transfer_location]" {{ $record['disabled'] }}/> 
			</div>	
		</div>
		<div class="form-group date_from" {{ ($record['recruitment_request.due_to_id'] != 5) ? 'style="display:none"' : '' }}>
			<label class="control-label col-md-3">
				<span class="required">* </span>{{ lang('mrf.date_from') }}
			</label>
			<div class="col-md-5">
				<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy" data-date-start-date="+0d">
					<input type="text" class="form-control" name="recruitment_request[replacement_transfer_leave_date_from]" id="recruitment_request-date_from" value="{{ $record['recruitment_request.replacement_transfer_leave_date_from'] }}" placeholder="Enter Date From" {{ $record['disabled'] }} >
					<span class="input-group-btn {{ ($record['disabled']) ? 'hidden' : '' }}">
						<button class="btn default" type="button" ><i class="fa fa-calendar" ></i></button>
					</span>
				</div>
			</div>	
		</div>	
		<div class="form-group date_to" {{ ($record['recruitment_request.due_to_id'] != 5) ? 'style="display:none"' : '' }}>
			<label class="control-label col-md-3">
				<span class="required">* </span>{{ lang('mrf.date_to') }}
			</label>
			<div class="col-md-5">
				<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy" data-date-start-date="+0d">
					<input type="text" class="form-control" name="recruitment_request[replacement_transfer_leave_date_to]" id="recruitment_request-date_to" value="{{ $record['recruitment_request.replacement_transfer_leave_date_to'] }}" placeholder="Enter Date To" {{ $record['disabled'] }} >
					<span class="input-group-btn {{ ($record['disabled']) ? 'hidden' : '' }}">
						<button class="btn default" type="button" ><i class="fa fa-calendar" ></i></button>
					</span>
				</div>
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('mrf.req_by') }}</label>
			<div class="col-md-5">
				<?php
					if( empty( $record_id ) )
					{
						$record['recruitment_request.user_id'] = $user['user_id'];
						$name = $user['lastname'] .', '. $user['firstname'];
					}
					else{
						$db->limit(1);
						$recby = $db->get_where('users', array('user_id' => $record['recruitment_request.user_id']))->row();
						$name = $recby->full_name;
					}
				?>
				<input type="hidden" class="form-control" name="recruitment_request[user_id]" id="recruitment_request-user_id" value="{{ $record['recruitment_request.user_id'] }}" placeholder="Enter Requested By" />
				<input type="text" class="form-control dontserializeme" value="{{ $name }}" placeholder="Enter Requested By" readonly /> 
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span>{{ lang('mrf.req_on') }}
			</label>
			<div class="col-md-5">
				<input type="text" class="form-control dontserializeme" value="{{ date('F d, Y') }}" placeholder="Enter Requested By" readonly /> 
				<div class="hidden input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
					<input type="text" class="form-control" name="recruitment_request[created_on]" id="recruitment_request-created_on" value="{{ date('F d, Y') }}" placeholder="Enter Requested on" readonly>
					<span class="input-group-btn">
						<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
			</div>	
		</div>	

	</div>
</div> 

<?php
	$key_classes = $mrf->get_key_classes();
	if( $key_classes )
	{
		foreach( $key_classes as $key_class ):
			if($key_class->key_class_code != "hra_remarks"):?>
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ $key_class->key_class }}</div>
						<div class="tools"><a class="collapse" href="javascript:;"></a></div>
					</div>
					<p class="margin-bottom-25">{{ $key_class->description }}</p>
					<div class="portlet-body form"><?php
					if($key_class->key_class_code == 'position_details'){
					?>
					<div class="form-group">
						<label class="control-label col-md-3">
							<span class="required">* </span>{{ lang('mrf.position') }} Title
						</label>
						<div class="col-md-5">
							<?php
								$db->select('position_id,position');
								$db->order_by('position', '0');
								$db->where('deleted', '0');
								$options = $db->get('users_position');
								$recruitment_request_position_id_options = array('' => 'Select...');
								foreach($options->result() as $option)
								{
									$recruitment_request_position_id_options[$option->position_id] = $option->position;
								} 
							?>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-list-ul"></i>
								</span>
								{{ form_dropdown('recruitment_request[position_id]',$recruitment_request_position_id_options, $record['recruitment_request.position_id'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_request-position_id" '.$record['disabled']) }}
							</div>
						</div>	
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">
							<span class="required">* </span>Employment Status
						</label>
						<div class="col-md-5">
							<?php
								$db->select('employment_status_id,employment_status');
								$db->order_by('employment_status', '0');
								$db->where('deleted', '0');
								$options = $db->get('partners_employment_status');
								$recruitment_request_employment_status_id_options = array('' => 'Select...');
								foreach($options->result() as $option)
								{
									$recruitment_request_employment_status_id_options[$option->employment_status_id] = $option->employment_status;
								} 
							?>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-list-ul"></i>
								</span>
								{{ form_dropdown('recruitment_request[employment_status_id]',$recruitment_request_employment_status_id_options, $record['recruitment_request.employment_status_id'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_request-employment_status_id" '.$record['disabled']) }}
							</div>
						</div>	
					</div>

					<div class="form-group" id="contract_duration">
						<label class="control-label col-md-3">
							<!-- <span class="required">* </span> -->
							Contract Duration
							<br><span class="small text-muted">(in month/s)</span>
						</label>
						<div class="col-md-5">
					    	<input type="text" name="recruitment_request[contract_duration]" id="recruitment_request-contract_duration" value="{{ $record['recruitment_request.contract_duration'] }}"  class="form-control" {{ $record['disabled'] }} >
					    </div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">
							<span class="required">* </span>{{ lang('mrf.qty') }}
						</label>
						<div class="col-md-5">
					    	<input type="text" name="recruitment_request[quantity]" id="recruitment_request-quantity" value="{{ $record['recruitment_request.quantity'] }}"  class="form-control" {{ $record['disabled'] }} >
					    </div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3"><span class="required">* </span>{{ lang('mrf.age_range') }}</label>
						<div class="col-md-9">
							<div class="input-group">
								<input {{ $record['disabled'] }} type="text" class="form-control input-medium" value="{{ $record['recruitment_request.age_range_from'] }}" name="recruitment_request[age_range_from]" /> 
								&nbsp; - &nbsp;
								<input {{ $record['disabled'] }} type="text" class="form-control input-medium" value="{{ $record['recruitment_request.age_range_to'] }}" name="recruitment_request[age_range_to]" /> 
							</div>
						</div>	
					</div>	
					<div class="form-group">
						<label class="control-label col-md-3">
							<span class="required">* </span>{{ lang('mrf.gender') }}
						</label>
						<div class="col-md-5">
							<?php
								$db->select('age_gender,age_gender');
								$options = $db->get('recruitment_age_gender');
								$recruitment_request_age_gender = array('' => 'Select...');
								foreach($options->result() as $option)
								{
									$recruitment_request_age_gender[$option->age_gender] = $option->age_gender;
								} 
							?>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-list-ul"></i>
								</span>
								{{ form_dropdown('recruitment_request[gender]',$recruitment_request_age_gender, $record['recruitment_request.gender'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_request-gender" '.$record['disabled']) }}
							</div>
						</div>	
					</div>	
					<div class="form-group">
						<label class="control-label col-md-3">
							<span class="required">* </span>{{ lang('mrf.civil_status') }}
						</label>
						<div class="col-md-5">
							<?php
								$db->select('civil_status_id,civil_status');
								$options = $db->get('partners_civil_status');
								$recruitment_request_civil_status = array('' => 'Select...');
								foreach($options->result() as $option)
								{
									$recruitment_request_civil_status[$option->civil_status_id] = $option->civil_status;
								} 
							?>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-list-ul"></i>
								</span>
								{{ form_dropdown('recruitment_request[civil_status_id]',$recruitment_request_civil_status, $record['recruitment_request.civil_status_id'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_request-civil_status_id" '.$record['disabled']) }}
							</div>
						</div>	
					</div>											
					<div class="form-group">
						<label class="control-label col-md-3">
							<span class="required">* </span>{{ lang('mrf.date_needed') }}
						</label>
						<div class="col-md-5">
							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="recruitment_request[date_needed]" id="recruitment_request-date_needed" value="{{ $record['recruitment_request.date_needed'] }}" placeholder="Enter Date Needed" {{ $record['disabled'] }} >
								<span class="input-group-btn" {{ ($record['disabled']) ? 'hidden' : '' }}>
									<button class="btn default" type="button" ><i class="fa fa-calendar" ></i></button>
								</span>
							</div>
							<div class="help-block small">
                            	LEADTIME:<br>
								45 working days - Managerial<br>
								30 working days - Technical Supervisory<br>
								20 working days - Staff
                        	</div>
						</div>	
					</div>	
					<div class="form-group">
						<label class="control-label col-md-3"><span class="required">* </span>{{ lang('mrf.max_no_personel') }}</label>
						<div class="col-md-5">
							<input {{ $record['disabled'] }} type="text" class="form-control" value="{{ $record['recruitment_request.max_no_personel'] }}" name="recruitment_request[max_no_personel]" /> 
						</div>	
					</div>	
					<div class="form-group">
						<label class="control-label col-md-3"><span class="required">* </span>{{ lang('mrf.total_no_incumbet') }}</label>
						<div class="col-md-5">
							<input {{ $record['disabled'] }} type="text" class="form-control" value="{{ $record['recruitment_request.total_no_incumbent'] }}" name="recruitment_request[total_no_incumbent]" /> 
						</div>	
					</div>											
					<div class="form-group">
						<label class="control-label col-md-3">Salary Range</label>
						<div class="col-md-9">
							<div class="input-group">
								<input {{ $record['disabled'] }} type="text" class="form-control input-medium mask_number" {{ $record['disabled'] }} value="{{ $record['recruitment_request.salary_from'] }}" id="recruitment_request-salary_from" name="recruitment_request[salary_from]" />
								&nbsp; - &nbsp;
								<input {{ $record['disabled'] }} type="text" class="form-control input-medium mask_number" {{ $record['disabled'] }} value="{{ $record['recruitment_request.salary_to'] }}" id="recruitment_request-salary_from" name="recruitment_request[salary_to]" />
							</div>
						</div>	
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Remarks</label>
						<div class="col-md-5">
							<textarea {{ $record['disabled'] }} class="form-control" name="recruitment_request[description]" id="recruitment_request-description" placeholder="Enter Remarks" rows="4">{{ $record['recruitment_request.description'] }}</textarea>
						</div>	
					</div>
					<?php	
					}
					else if($key_class->key_class_code == 'requirements'){
					?>
					<div class="form-group">
						<label class="control-label col-md-3">Appropriate Educational Attainment</label>
						<div class="col-md-5">
							<textarea {{ $record['disabled'] }} class="form-control" name="recruitment_request[educational_attainment]" id="recruitment_request-description" placeholder="Enter Educcational Attainment" rows="4">{{ $record['recruitment_request.educational_attainment'] }}</textarea>
						</div>	
					</div>
					<?php
					}
						$keys = $mrf->get_keys( $key_class->key_class_id, $record_id );
						if( $keys )
						{
							foreach( $keys as $key ):
								switch( $key->key_code ):
									case 'notes':
									case 'require_licensure':
									//case 'hra_remarks': ?>
										@include('edit/keys/textarea', array('key' => $key))<?php
										break;
									case 'course':
									case 'years_of_experience': ?>
										@include('edit/keys/textfield', array('key' => $key))<?php
										break;
									case 'nature_of_request': ?>
										@include('edit/keys/nature_of_request', array('key' => $key))<?php
										break;
									case 'paid_sourcing_tools':
									case 'budgeted': ?>
										@include('edit/keys/yes_no', array('key' => $key))<?php
										break;
									case 'preferred_gender': ?>
										@include('edit/keys/gender', array('key' => $key))<?php
										break;
                                    case 'assignment': ?>
                                        @include('edit/keys/assignment', array('key' => $key))<?php
                                    break;  
                                    case 'project_duration': ?>
                                        @include('edit/keys/project_duration', array('key' => $key))<?php
                                    break;      
                                    case 'age': ?>
                                        @include('edit/keys/age', array('key' => $key))<?php
                                    break;
                                    case 'work_shift': ?>
                                        @include('edit/keys/work_shift', array('key' => $key))<?php
                                    break; 
                                    case 'career_level': ?>
                                        @include('edit/keys/career_level', array('key' => $key))<?php
                                    break;									
									case 'job_description': ?>
										@include('edit/keys/wysiwyg', array('key' => $key))<?php
										break;
									case 'attachment': ?>
										@include('edit/keys/attachment', array('key' => $key))<?php
										break;
									case 'sourcing_tools':
									case 'employment_type':
									case 'job_class':
									case 'educational_attainment': ?>
										@include('edit/keys/dropdowns', array('key' => $key))<?php
										break;
									case 'optional_requirements': 
									case 'key_requirements': ?>
										@include('edit/keys/key_requirements', array('key' => $key))<?php
										break;
								endswitch;
							endforeach;
						} ?>
					</div>
				</div> <?php
			endif;
		endforeach;
	}
?>

@if( $record['recruitment_request.status_id'] > 1 )
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('mrf.approver_remarks') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">{{ lang('mrf.app_note') }}</p>

	<div class="portlet-body">
		<!-- BEGIN FORM-->
        <!-- <form action="#" class="form-horizontal"> -->
        <div class="form-body">
	        <div class="row">
				<div class="col-md-12">
					
					@foreach($approver as $key => $approvers)
							@if( $approvers['status_id'] != 0 )
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">
										Approver {{ $approvers['sequence'] }}
									</label>
									<div class="col-md-5 col-sm-7">
			                    		<input disabled type="text" rows="1" class="form-control" name="approver" value="{{ $approvers['display_name'] }}"/>
									</div>
								</div>
								@if($approvers['status']!="")
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">
										Status
									</label>
									<div class="col-md-5 col-sm-7">
			                    		<?php 
								        	switch( $approvers['status'] )
								        	{
								        		case 'For Approval':
								        			$badge = "badge-warning";
								        			break;
								        		case 'Approved':
								        			$badge = "badge-success";
								        			break;
								        		default:
								        			$badge = "badge-danger";
								        			break;

								        	}
								        ?>
								        
											<span class="badge {{ $badge }}">{{ $approvers['status'] }}</span>
											<br>
											@if($current_user != $approvers['approver_id'])
											<span class="text-muted small">{{ $approvers['modified_on'] }}</span>
											@endif
										
									</div>
								</div>
								@endif	
								<div class="form-group">

									<label class="control-label col-md-3 col-sm-3 text-right text-muted">
										<span class="required">* </span>
										{{ lang('common.remarks') }}
									</label>
									<div class="col-md-5 col-sm-7">
			                    		<textarea <?php if($current_user != $approvers['approver_id'] || $approvers['status_id'] > 2) echo "disabled" ?> rows="2" class="form-control" name="recruitment[comment]">{{ $approvers['comment'] }}</textarea>
									</div>
								</div>
								<hr />
							@endif							
					@endforeach
				</div>
			</div>
	    </div>
        <!-- </form> -->
	</div>
</div>
@endif
@if( $record['recruitment_request.status_id'] >= 3 )
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">HRA Remarks</div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
		</div>
	</div>
	<p class="margin-bottom-25">This section manage to add remarks about the requests.</p>

	<div class="portlet-body">
		<!-- BEGIN FORM-->
        <!-- <form class="form-horizontal" action="#"> -->
            <div class="form-body">        	
                <!-- BEGIN FORM-->                
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Remarks
                        	<span class="required">*</span>
                        </label>
                        <div class="col-md-5">
                            <textarea <?php if($record['recruitment_request.status_id'] == 7) echo "disabled" ?> class="form-control" rows="2" name="recruitment_request[hr_remarks]">{{ $record['recruitment_request.hr_remarks'] }}</textarea>
                        </div>
                    </div>
					@if( in_array($record['recruitment_request.status_id'], array(7,5)) )
                    <div class="form-group">
                        <label class="control-label col-md-3">Remarks By
                        	<span class="required">*</span>
                        </label>
                        <div class="col-md-5">
					<?php
						$db->select('user_id, full_name');
						$db->order_by('full_name', '0');
						$db->where('deleted', '0');
						$db->where('active', '1');
						$db->where('user_id', $record['recruitment_request.hr_remarks_by']);
						$hr_remarks_by = $db->get('users')->row_array();
						// $users_id_options = array('' => 'Select...');
					?>
                        	<input type="text" <?php if($record['recruitment_request.status_id'] == 7) echo "disabled" ?> class="form-control dontserializeme" size="16" id="recruitment_request-hr_remarks_by" name="recruitment_request[hr_remarks_by]" value="{{ $hr_remarks_by['full_name'] }}">
                        </div>
                    </div>
                	<div class="form-group">
                        <label class="control-label col-md-3">Delivery Date
                        </label>
                        <div class="col-md-5">
                            <div data-date-format="MM dd, yyyy" class="input-group input-medium date date-picker" data-date-start-date="+0d">
                                <input type="text" class="form-control" size="16" id="recruitment_request-delivery_date" name="recruitment_request[delivery_date]" value="{{ ($record['recruitment_request.delivery_date'] != '1970-01-01' && $record['recruitment_request.delivery_date'] != '0000-00-00' ? $record['recruitment_request.delivery_date'] : '') }}">
                                <span class="input-group-btn">
                                <button type="button" class="btn default"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>                    
<!--                     <div class="form-group">
                        <label class="control-label col-md-3">HR Remarks On
                        	<span class="required">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="text" <?php if($record['recruitment_request.status_id'] == 7) echo "disabled" ?> class="form-control dontserializeme" size="16" id="recruitment_request-hr_remarks_on" name="recruitment_request[hr_remarks_on]" value="{{ $record['recruitment_request.hr_remarks_on'] }}">
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label class="control-label col-md-3">Remarks
                        	<span class="required">*</span>
                        </label>
                        <div class="col-md-5">
                            <textarea <?php if($record['recruitment_request.status_id'] == 5) echo "disabled" ?> class="form-control" rows="2" name="recruitment_request[closing_remarks]">{{ $record['recruitment_request.closing_remarks'] }}</textarea>
                        </div>
                    </div>
					@if( in_array($record['recruitment_request.status_id'], array(5)) )
<!--                     <div class="form-group">
                        <label class="control-label col-md-3">Closed Remarks
                        	<span class="required">*</span>
                        </label>
                        <div class="col-md-5"> -->
					<?php
						$db->select('user_id, full_name');
						$db->order_by('full_name', '0');
						$db->where('deleted', '0');
						$db->where('active', '1');
						$db->where('user_id', $record['recruitment_request.closed_by']);
						$closed_by = $db->get('users')->row_array();
						// $users_id_options = array('' => 'Select...');
					?>
<!--                         	<input type="text" <?php if($record['recruitment_request.status_id'] == 5) echo "disabled" ?> class="form-control dontserializeme" size="16" id="recruitment_request-closed_by" name="recruitment_request[closed_by]" value="{{ $closed_by['full_name'] }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Closed On
                        	<span class="required">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="text" <?php if($record['recruitment_request.status_id'] == 5) echo "disabled" ?> class="form-control dontserializeme" size="16" id="recruitment_request-closed_on" name="recruitment_request[closed_on]" value="{{ $record['recruitment_request.closed_on'] }}">
                        </div>
                    </div> -->
					@endif
					@endif
                </div>    
            </div>
        <!-- </form>         -->
	</div>
</div>
@endif