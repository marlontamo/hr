<input type="hidden" name="user_id" value="{{ $appraisee->user_id }}" />
<input type="hidden" name="template_id" value="{{ $appraisee->template_id }}" />
<input type="hidden" name="appraisal_id" value="{{ $appraisee->appraisal_id }}" />
<input type="hidden" name="planning_id" value="{{ $appraisee->planning_id }}" />
<input type="hidden" name="manager_id" value="{{ $manager_id }}" />
<div class="portlet">
	<div class="portlet-title">
		<div class="caption bold">{{ lang('performance_appraisal_manage.performance_appraisal_form') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body">
		<p class="margin-bottom-25"><label class="bold">{{ $templatefile->template }}</label> <span class="text-muted small">{{ lang('performance_appraisal_manage.strictly_confi') }}</span>
		<!-- <a class="btn btn-primary btn-sm pull-right" data-toggle="modal" href="javascript: view_transaction_logs( {{ $appraisee->appraisal_id }}, {{ $appraisee->user_id }} )"> <i class="fa fa-list"></i> Appraisal Logs</a> -->
		</p>
		<div class="tabbable tabbable-custom tabbable-full-width">
			<ul class="nav nav-tabs">
				<li class="active">
					<a data-toggle="tab" href="#profile_tab_1">Appraisal Form</a>
				</li>
				<li class="">
					<a data-toggle="tab" href="#profile_tab_2">Self-Review</a>
				</li>
			</ul>
			<div class="tab-content">
				<div id="profile_tab_1" class="tab-pane active">
					<!-- EMPLOYEES INFO-->
			        <div class="portlet">
						<div class="portlet-body">
							<table class="table table-bordered table-striped">
								<tbody>
									<tr class="success">
										<td>
											<div class="form-group">
												<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_manage.appraisee') }}</label>
												<div class="col-md-9">
													<input type="text" class="form-control" value="{{ $appraisee->fullname }}" readonly>
												</div>
											</div>
										</td>
										<td>
											<div class="form-group">
												<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_manage.immediate_sup') }}</label>
												<div class="col-md-9">
													<input type="text" class="form-control" value="{{ $appraisee->immediate }}" readonly>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_manage.job_title') }}</label>
												<div class="col-md-9">
													<input type="text" class="form-control" value="{{ $appraisee->position }}" readonly>
												</div>
											</div>
										</td>
										<td>
											<div class="form-group">
												<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_manage.job_title') }}</label>
												<div class="col-md-9">
													<input type="text" class="form-control" value="{{ $appraisee->immediate_position }}"  readonly>
												</div>
											</div>
										</td>
									</tr>
									<tr class="success">
										<td>
											<div class="form-group">
												<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_manage.date_joined') }}</label>
												<div class="col-md-9">
													<input type="text" class="form-control" value="{{ date('M d, Y', strtotime( $appraisee->effectivity_date ) ) }}" readonly>
												</div>
											</div>
										</td>
										<td>
											<div class="form-group">
												<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_manage.appraisal_period') }}</label>
												<div class="col-md-9">
													<input type="text" class="form-control" value="{{ date('M d, Y', strtotime( $appraisee->date_from ) ) }} to {{ date('M d, Y', strtotime( $appraisee->date_to ) ) }}" readonly>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_manage.sub_dept') }}</label>
												<div class="col-md-9">
													<input type="text" class="form-control" value="{{ $appraisee->company }}" readonly>
												</div>
											</div>
										</td>
										<td>
											<div class="form-group">
												<label class="control-label col-md-3 bold">{{ lang('performance_appraisal_manage.appraisal_date') }}</label>
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
													@include('final_approval/sections/balance_scorecard', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
													break;
												case 3: //library ?>
													@include('final_approval/sections/library', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
													break;
												case 4: //library crowd ?>
													@include('final_approval/sections/library_crowd', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
													break;
												case 5: //summary ?>
													@include('final_approval/sections/summary', array('sections' => $sections, 'header' => $child->header, 'footer' => $child->footer))<?php 
													break;
												case 6: //supervisor summary ?>
													@include('final_approval/sections/sup_summary', array('appraisee' => $appraisee, 'header' => $child->header, 'footer' => $child->footer))<?php 
													break;
												case 7: //partner summary ?>
													@include('final_approval/sections/partner_summary', array('appraisee' => $appraisee, 'header' => $child->header, 'footer' => $child->footer))<?php 
													break;
												case 8: //personnel action ?>
													@include('final_approval/sections/personnel_action', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
													break;
												default:
											} ?>
										</div> <?php
									endforeach;	?>
								</div>
							</div><?php
						endforeach; ?>
					</div>
				</div>
				<div id="profile_tab_2" class="tab-pane">
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
													<input type="text" class="form-control" value="<?php if( !empty($appraisee->selfrate_date) ) echo date('M d, Y', strtotime( $appraisee->selfrate_date ) )?>"  readonly>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="portlet">
						<div class="portlet-body">
							<div class="row profile">
								<div class="col-md-12">
									<div class="portlet">
										<div class="portlet-body margin-top-15">
											<div class="clearfix">
												<div class="panel panel-success">
													<div class="panel-heading">
														<h3 class="panel-title">SELF-REVIEW FORM</h3>
														<ul class="list-group">
															<li class="list-group-item">
																<p class="bold">Significant Accomplishments/Performance Results for the Period</p> 
																<textarea rows="3" class="form-control" name="performance_appraisal_self_review[accomplishments]" disabled>{{ $self_review->accomplishments }}</textarea>
															</li>
															<li class="list-group-item">
																<p class="bold">Evidences to support Significant Accomplishments/Performance Results (cite reports submitted, dates of emails sent, activities or services done or conducted)</p> 
																<textarea rows="3" class="form-control"  name="performance_appraisal_self_review[evidences]" disabled>{{ $self_review->evidences }}</textarea>
															</li>
															<li class="list-group-item">
																<p class="bold">Area/s for Improvement (Knowledge, Skills)</p> 
																<textarea rows="3" class="form-control"  name="performance_appraisal_self_review[areas_to_improve]" disabled>{{ $self_review->areas_to_improve }}</textarea>
															</li>
															<li class="list-group-item">
																<p class="bold">Action Items to Address Area/s for Improvement with Target Dates (input to Personal Development Plan)</p> 
																<textarea rows="3" class="form-control"  name="performance_appraisal_self_review[items_to_address]" disabled>{{ $self_review->items_to_address }}</textarea>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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
				<div class="clearfix">
					<div class="panel panel-success">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h4 class="panel-title">Historical</h4>
						</div>

						
						<table class="table">
							<tbody>
								<tr>
									<td>
										Appraisal Logs
										<br>
										<span class="text-muted small">Composed of historical logs, date/time and status of planning.</span>
									</td>
									<td>
										<a class="btn btn-primary btn-sm pull-right" data-toggle="modal" href="javascript: view_transaction_logs( {{ $appraisee->appraisal_id }}, {{ $appraisee->user_id }} )"> <i class="fa fa-list"></i> View Appraisal Logs</a>
									</td>
								</tr>
								<tr>
									<td>
										Discussion Logs
										<br>
										<span class="text-muted small">Composed of historical chat logs, date and time of discussion.</span>
									</td>
									<td>
		        						<button type="button" class="btn blue btn-sm pull-right" onclick="cs_discussion_form(<?php echo $appraisee->appraisal_id?>, '', <?php echo $appraisee->user_id?>, '', true, -1)"> View Discussion</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
									</div>
								</div>
		<div class="form-actions fluid">
            <div class="row">
                <div class="col-md-12">
					@if( $appraisee->to_user_id == $user['user_id'] && $appraisee->period_status )
	                	@if( $appraisee->status_id == 5 )
		                    <div class="col-md-offset-4 col-md-8">
		                    	<button type="button" class="btn yellow btn-sm" onclick="get_observations( {{$appraisee->year}}, {{$appraisee->user_id}}, '{{$appraisee->fullname}}' )"><i class="fa fa-rss"></i> {{ lang('performance_appraisal_manage.observations') }}</button>
								<button type="button" class="btn green btn-sm" onclick="change_status( $(this).closest('form'), 6)"><i class="fa fa-check"></i> {{ lang('common.submit') }}</button>
			        			<!-- <button type="button" class="btn blue btn-sm" onclick="view_discussion( $(this).closest('form'), 3 )"> {{ lang('performance_appraisal_manage.discussion_logs') }}</button> -->
		                    	<a class="btn default btn-sm" href="{{ $mod->url }}">{{ lang('common.back') }}</a>
		                    </div>
	                    @elseif( $appraisee->status_id == 2 )
		                    <div class="col-md-offset-4 col-md-8">
		                    	<button type="button" class="btn yellow btn-sm" onclick="get_observations( {{$appraisee->year}}, {{$appraisee->user_id}}, '{{$appraisee->fullname}}' )"><i class="fa fa-rss"></i> {{ lang('performance_appraisal_manage.observations') }}</button>
								<button type="button" class="btn green btn-sm" onclick="change_status( $(this).closest('form'), 7)"><i class="fa fa-check"></i> {{ lang('performance_appraisal_manage.approved') }}</button>
			        			<!-- <button type="button" class="btn blue btn-sm" onclick="view_discussion( $(this).closest('form'), 3 )"> {{ lang('performance_appraisal_manage.discussion_logs') }}</button> -->
		                    	<a class="btn default btn-sm" href="{{ $mod->url }}">{{ lang('common.back') }}</a>
		                    </div>
		                @elseif( $appraisee->status_id == 7 )
		                    <div class="col-md-offset-4 col-md-8">
		                    	<button type="button" class="btn yellow btn-sm" onclick="get_observations( {{$appraisee->year}}, {{$appraisee->user_id}}, '{{$appraisee->fullname}}' )"><i class="fa fa-rss"></i> {{ lang('performance_appraisal_manage.observations') }}</button>
								<button type="button" class="btn green btn-sm" onclick="change_status( $(this).closest('form'), 4)"><i class="fa fa-check"></i> {{ lang('performance_appraisal_manage.approved') }}</button>
			        			<!-- <button type="button" class="btn blue btn-sm" onclick="view_discussion( $(this).closest('form'), 3 )"> {{ lang('performance_appraisal_manage.discussion_logs') }}</button> -->
		                    	<a class="btn default btn-sm" href="{{ $mod->url }}">{{ lang('common.back') }}</a>
		                    </div>
		                 @elseif( $appraisee->status_id == 11 )
		                    <div class="col-md-offset-4 col-md-8">
		                    	<button type="button" class="btn yellow btn-sm" onclick="get_observations( {{$appraisee->year}}, {{$appraisee->user_id}}, '{{$appraisee->fullname}}' )"><i class="fa fa-rss"></i> {{ lang('performance_appraisal_manage.observations') }}</button>
								<button type="button" class="btn green btn-sm" onclick="change_status( $(this).closest('form'), 7)"><i class="fa fa-check"></i> {{ lang('performance_appraisal_manage.approved') }}</button>
			        			<!-- <button type="button" class="btn blue btn-sm" onclick="view_discussion( $(this).closest('form'), 3 )"> {{ lang('performance_appraisal_manage.discussion_logs') }}</button> -->
		                    	<a class="btn default btn-sm" href="{{ $mod->url }}">{{ lang('common.back') }}</a>
		                    </div>    
	                    @else
		                    <div class="col-md-offset-5 col-md-7">
		                    	<button type="button" class="btn yellow btn-sm" onclick="get_observations( {{$appraisee->year}}, {{$appraisee->user_id}}, '{{$appraisee->fullname}}' )"><i class="fa fa-rss"></i> {{ lang('performance_appraisal_manage.observations') }}</button>
		                    	<a class="btn default btn-sm" href="{{ $mod->url }}">{{ lang('common.back') }}</a>
		                    </div>
	                    @endif
	                @else
	                	<div class="col-md-offset-5 col-md-7">
	                    	<button type="button" class="btn yellow btn-sm" onclick="get_observations( {{$appraisee->year}}, {{$appraisee->user_id}}, '{{$appraisee->fullname}}' )"><i class="fa fa-rss"></i> {{ lang('performance_appraisal_manage.observations') }}</button>
	                    	<a class="btn default btn-sm" href="{{ $mod->url }}">{{ lang('common.back') }}</a>
	                    </div>
	                @endif
                </div>
            </div>
        </div>
    </div>
</div>
