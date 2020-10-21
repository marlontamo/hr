<input type="hidden" name="user_id" value="{{ $appraisee->user_id }}" />
<input type="hidden" name="template_id" value="{{ $appraisee->template_id }}" />
<input type="hidden" name="appraisal_id" value="{{ $appraisee->appraisal_id }}" />
<input type="hidden" name="planning_id" value="{{ $appraisee->planning_id }}" />
<input type="hidden" name="manager_id" value="{{ $manager_id }}" />
<div class="portlet">
	<div class="portlet-title">
		<div class="caption bold">PERFORMANCE APPRAISAL FORM</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body">
		<p class="margin-bottom-25"><label class="bold">{{ $templatefile->template }}</label> <span class="text-muted small">(STRICTLY CONFIDENTIAL)</span>

		<!-- EMPLOYEES INFO-->
        <div class="portlet">
			<div class="portlet-body">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr class="success">
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Appraisee</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ $appraisee->fullname }}" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Immediate Superior</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ $appraisee->immediate }}" readonly>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Job Title</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ $appraisee->position }}" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Job Title</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ $appraisee->immediate_position }}"  readonly>
									</div>
								</div>
							</td>
						</tr>
						<tr class="success">
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Date Joined</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ date('M d, Y', strtotime( $appraisee->effectivity_date ) ) }}" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Appraisal Period</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ date('M d, Y', strtotime( $appraisee->date_from ) ) }} to {{ date('M d, Y', strtotime( $appraisee->date_to ) ) }}" readonly>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Subsidiary/Dept.</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ $appraisee->company }}" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Appraisal Date</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="<?php if( !empty($appraisee->date) ) echo date('M d, Y', strtotime( $appraisee->date ) )?>"  readonly>
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
									@include('summary/sections/balance_scorecard', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
									break;
								case 3: //library ?>
									@include('summary/sections/library', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
									break;
								case 4: //library crowd ?>
									@include('summary/sections/library_crowd', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
									break;
								case 5: //summary ?>
									@include('summary/sections/personal_development_plan', array('sections' => $sections, 'header' => $child->header, 'footer' => $child->footer))<?php 
									break;
								case 6: //supervisor summary ?>
									@include('summary/sections/sup_summary', array('appraisee' => $appraisee, 'header' => $child->header, 'footer' => $child->footer))<?php 
									break;
								case 7: //partner summary ?>
									@include('summary/sections/partner_summary', array('appraisee' => $appraisee, 'header' => $child->header, 'footer' => $child->footer))<?php 
									break;
								case 8: //personnel action ?>
									@include('summary/sections/personnel_action', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
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
									@if( strtotime($applog['created_on']) && $applog['created_on'] != '1970-01-01' )
										<span class="text-success">{{ date('M d, Y', strtotime($applog['created_on'])) }}</span>
										<br />
										<span id="date_set" class="small text-muted">{{ date('h:i a', strtotime($applog['created_on'])) }}</span>
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
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

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
							<input type="checkbox" @if( $appraisee->status_id == 13 ) disabled="disabled" @endif value="1" @if( $appraisee->appraisee_acceptance || empty($record_id) ) checked="checked" @endif name="individual_appraisal[appraisee_acceptance][tmp]" id="individual_appraisal_appraisee_acceptance_tmp" class="dontserializeme toggle"/>
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
						<textarea class="form-control" @if( $appraisee->status_id == 13 ) readonly @endif name="individual_appraisal[appraisee_remarks]" id="individual_appraisal_appraisee_remarks" placeholder="Enter Remarks" rows="4">{{ $appraisee->appraisee_remarks }}</textarea>
					</div>
				</div>						
			</div>			
		</div>

		<div class="form-actions fluid">
            <div class="row">
                <div class="col-md-12">
					@if( $appraisee->to_user_id == $user['user_id'] && $appraisee->period_status )
	                    <div class="col-md-offset-5 col-md-7">
	                    	@if($appraisee->status_id == 4)
	                    		<button type="button" class="btn green btn-sm" onclick="change_status( $(this).closest('form'), 13)"> {{ lang('common.submit') }}</button>	                    	
	                    	@endif
	                    	<a class="btn default btn-sm" href="{{ $mod->url }}">Back</a>
	                    </div>
	                @endif
                </div>
            </div>
        </div>
    	
    </div>
</div>
