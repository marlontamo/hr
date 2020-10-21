<input type="hidden" name="user_id" value="{{ $appraisee->user_id }}" />
<input type="hidden" name="template_id" value="{{ $appraisee->template_id }}" />
<input type="hidden" name="appraisal_id" value="{{ $appraisee->appraisal_id }}" />
<input type="hidden" name="planning_id" value="{{ $appraisee->planning_id }}" />
<div class="portlet">
	<div class="portlet-title">
		<div class="caption bold">{{ lang('performance_appraisal_admin.performance_appraisal_form') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body">
		<p class="margin-bottom-25"><label class="bold">{{ $templatefile->template }}</label> <span class="text-muted small">{{ lang('performance_appraisal_admin.strictly_confi') }}</span>
		<!-- <a class="btn btn-primary btn-sm pull-right" data-toggle="modal" href="javascript: view_transaction_logs( {{ $appraisee->appraisal_id }}, {{ $appraisee->user_id }} )"> <i class="fa fa-list"></i> Appraisal Logs</a></p> -->

        <div class="portlet">
			<div class="portlet-body">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr class="success">
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_admin.appraisee') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ $appraisee->fullname }}" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_admin.immediate_sup') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ $appraisee->immediate }}" readonly>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_admin.job_title') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ $appraisee->position }}" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_admin.job_title') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ $appraisee->immediate_position }}"  readonly>
									</div>
								</div>
							</td>
						</tr>
						<tr class="success">
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_admin.date_joined') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ date('M d, Y', strtotime( $appraisee->effectivity_date ) ) }}" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_admin.appraisal_period') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ date('M d, Y', strtotime( $appraisee->date_from ) ) }} to {{ date('M d, Y', strtotime( $appraisee->date_to ) ) }}" readonly>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_admin.sub_dept') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ $appraisee->company }}" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_admin.appraisal_date') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="<?php if( !empty($appraisal_date) ) echo date('M d, Y', strtotime( $appraisal_date ) )?>"  readonly>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<!-- BEGIN OF FORM-->
		<div class="portlet"><?php
			//get the template
			$sections = $template->build_sections( $appraisee->template_id );
			foreach( $sections as $section ): ?>
				<div class="portlet-title">
					<div class="caption">{{ $section->template_section }}
						@if( !empty( $section->weight ) )
							({{ $section->weight }}%)
						@endif
					</div>
					<div class="tools">
						<a href="javascript:;" class="collapse"></a>
						</div>
				</div> 
				<div class="portlet-body">
					<div class="clearfix"> <?php
						foreach( $section->children as $child ): ?>
							<div class="panel panel-success">
								<div class="panel-heading">
									<h3 class="panel-title">
										{{ $child->template_section }}
										@if( !empty( $child->weight ) )
											({{ $child->weight }}%)
										@endif
									</h3>
								</div><?php
								switch( $child->section_type_id )
								{
									case 2: //balance Scorecard ?>
										@include('review/sections/balance_scorecard', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
										break;
									case 3: //library ?>
										@include('review/sections/library', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
										break;
									case 4: //library crowd ?>
										@include('review/sections/library_crowd', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
										break;
									case 5: //summary ?>
										@include('review/sections/personal_development_plan', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php
										break;
									case 6: //supervisor summary ?>
										@include('review/sections/sup_summary', array('appraisee' => $appraisee, 'header' => $child->header, 'footer' => $child->footer))<?php 
										break;
									case 7: //partner summary ?>
										@include('review/sections/partner_summary', array('appraisee' => $appraisee, 'header' => $child->header, 'footer' => $child->footer))<?php 
										break;
									case 8: //personnel action ?>
										@include('review/sections/personnel_action', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
										break;
									default:
								} ?>
							</div> <?php
						endforeach;	?>
					</div>
				</div><?php
			endforeach; ?>
		</div>

		<!-- START APPROVER'S LOG-->
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">LOGS</div>
				<div class="tools">
					<a class="collapse" href="javascript:;"></a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="clearfix">
					<div class="panel panel-success">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h4 class="panel-title">Approver/s</h4>
						</div>

						<table class="table">
							<thead>
								<tr>
									<th>APPROVER</th>
									<th>DATE/TIME</th>
									<th>STATUS</th>
								</tr>
							</thead>
							<tbody>
							@if( !empty($approversLog) )
								@foreach($approversLog as $applog)
								<tr>
									<td>{{ $applog['display_name'] }} <br><small class="text-muted">{{ $applog['position'] }}</small></td>
									<td>
									@if( strtotime($applog['approved_date']) && $applog['approved_date'] != '1970-01-01' )
										<span class="text-success">{{ date('M d, Y', strtotime($applog['approved_date'])) }}</span>
										<br />
										<span id="date_set" class="small text-muted">{{ date('h:i a', strtotime($applog['approved_date'])) }}</span>
									@endif
									</td>
									<td>
										<span class="{{ $applog['class'] }}"> {{ $applog['performance_status'] }}</span><br>
									@if( $applog['approver_id'] == $applog['to_user_id'] )
										<span class="small text-danger">Attention to {{ $applog['display_name'] }}</span>
									@endif
									</td>
								</tr>
								@endforeach
							@else
								<tr>
									<td colspan="3" align="center">
										No Approver/s Setup
									</td>
								</tr>
							@endif
							@if($appraisee->status_id == 2)
								<tr>
									<td colspan="3">
										<div class="form-group">
											<label class="control-label col-md-2">Remarks <br /> <span class="small text-muted">(required if you choose to disapprove):*</span></label>
											<div class="col-md-9">
												<textarea class="form-control" id="remarks" rows="4" name="remarks"></textarea>
											</div>
										</div>										
									</td>
								</tr>
							@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		@if($appraisee->status_id >= 12)
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption">Ratee</div>
					<div class="tools">
						<a href="javascript:;" class="collapse"></a>
					</div>
				</div> 			
				<div class="portlet-body form">
					<div class="form-group">
						<label class="control-label col-md-4">
							<span class="required">* </span>
							Accept Appraisal Rating
						</label>
						<div class="col-md-5">
							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
								<input disabled="disabled" type="checkbox" value="1" @if( $appraisee->appraisee_acceptance || empty($record_id) ) checked="checked" @endif name="individual_appraisal[appraisee_acceptance][tmp]" id="individual_appraisal_appraisee_acceptance_tmp" class="dontserializeme toggle"/>
								<input type="hidden" name="individual_appraisal[appraisee_acceptance]" id="individual_appraisal_appraisee_acceptance" value="@if( $appraisee->appraisee_acceptance || empty($record_id) ) 1 @else 0 @endif"/>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4">
							<span class="required">* </span>
							Remarks
						</label>
						<div class="col-md-5">
							<textarea class="form-control" name="individual_appraisal[appraisee_remarks]" id="individual_appraisal_appraisee_remarks" placeholder="Enter Remarks" rows="4" readonly>{{ $appraisee->appraisee_remarks }}</textarea>
						</div>
					</div>						
				</div>			
			</div>
		@endif	
		<div class="form-actions fluid">
            <div class="row">
                <div class="col-md-12">
                	<div class="col-md-offset-4 col-md-7">
						@if( ($applicable_status_id == 0 || $applicable_status_id == 1 || $applicable_status_id == 3) && $appraisee->planning_created_by == $login_user_id)                		
							<button type="button" class="btn blue btn-sm" onclick="change_status( $(this).closest('form'), 3)"> {{ lang('common.save_draft') }}</button>
	                    	<button type="button" class="btn yellow btn-sm" onclick="change_status( $(this).closest('form'), 2)"><i class="fa"></i> {{ lang('performance_appraisal_admin.send_to_approver') }}</button>
						@elseif($applicable_status_id == 2 && ((isset($approver) && $approver->approver_id == $login_user_id)))
	                    	<button type="button" class="btn green btn-sm" onclick="change_status( $(this).closest('form'), 4)"><i class="fa"></i> {{ lang('common.approve') }}</button>							                    
							<button type="button" class="btn red btn-sm" onclick="change_status( $(this).closest('form'), 1)"> {{ lang('common.disapprove') }}</button>	                    	
	                	@endif                    	
                    	<a class="btn default btn-sm back_button_gray" href="{{ $mod->url }}/index/{{$record_id}}">{{ lang('common.back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
