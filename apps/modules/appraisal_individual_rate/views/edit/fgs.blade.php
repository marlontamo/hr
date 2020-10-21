<input type="hidden" name="user_id" value="{{ $appraisee->user_id }}" />
<input type="hidden" name="template_id" value="{{ $appraisee->template_id }}" />
<input type="hidden" name="appraisal_id" value="{{ $appraisee->appraisal_id }}" />
<input type="hidden" name="planning_id" value="{{ $appraisee->planning_id }}" />
<div class="portlet">
	<div class="portlet-title">
		<div class="caption bold">PERFORMANCE APPRAISAL FORM</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body">
		<p class="margin-bottom-25"><label class="bold">{{ $templatefile->template }}</label> <span class="text-muted small">(STRICTLY CONFIDENTIAL)</span>

		<!-- <a class="btn btn-primary btn-sm pull-right" data-toggle="modal" href="javascript: view_transaction_logs( {{ $appraisee->appraisal_id }}, {{ $appraisee->user_id }} )"> <i class="fa fa-list"></i> Appraisal Logs</a> -->
		</p>
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

		<div class="portlet">
			<div class="portlet-body">
				<div class="row profile">
					<div class="col-md-12">
						<div class="tabbable tabbable-custom tabbable-full-width">
							<ul class="nav nav-tabs">
								<li class="active">
									<a data-toggle="tab" href="#profile_tab_1">Self-Review</a>
								</li>
								<li class="">
									<a data-toggle="tab" href="#profile_tab_2">Crowdsource</a>
								</li>
							</ul>
							<div class="tab-content">
								<div id="profile_tab_1" class="tab-pane active">
									<div class="portlet">
										<div class="portlet-body margin-top-15">
											<p><b>Instructions:</b> Your Self-Review must be your objective assessment of your performance for the given period, along with evidences for performance results, identification of area/s of improvements, and action items to address these areas. Write your responses on the appropriate boxes below.</p><br>
											<div class="clearfix">
												<div class="panel panel-success">
													<div class="panel-heading">
														<h3 class="panel-title">SELF-REVIEW FORM</h3>
														<ul class="list-group">
															<li class="list-group-item">
																<p class="bold">Significant Accomplishments/Performance Results for the Period</p> 
																<textarea rows="3" class="form-control" name="performance_appraisal_self_review[accomplishments]">{{ $self_review->accomplishments }}</textarea>
															</li>
															<li class="list-group-item">
																<p class="bold">Evidences to support Significant Accomplishments/Performance Results (cite reports submitted, dates of emails sent, activities or services done or conducted)</p> 
																<textarea rows="3" class="form-control"  name="performance_appraisal_self_review[evidences]">{{ $self_review->evidences }}</textarea>
															</li>
															<li class="list-group-item">
																<p class="bold">Area/s for Improvement (Knowledge, Skills)</p> 
																<textarea rows="3" class="form-control"  name="performance_appraisal_self_review[areas_to_improve]">{{ $self_review->areas_to_improve }}</textarea>
															</li>
															<li class="list-group-item">
																<p class="bold">Action Items to Address Area/s for Improvement with Target Dates (input to Personal Development Plan)</p> 
																<textarea rows="3" class="form-control"  name="performance_appraisal_self_review[items_to_address]">{{ $self_review->items_to_address }}</textarea>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div id="profile_tab_2" class="tab-pane">
									<div class="portlet margin-top-15"> <?php
										//get the template
										$sections = $template->build_sections( $appraisee->template_id );
										foreach( $sections as $section ):
											$has_crowdsource = false;
											foreach( $section->children as $child ): 
												if( $child->section_type_id == 4 ) $has_crowdsource = true;
											endforeach;	
											if( $has_crowdsource ) : ?>
												<div class="portlet-title">
													<div class="caption">{{ $section->template_section }}
														@if( !empty( $section->weight ) )
															({{ $section->weight }}%)
														@endif
													</div>
													<div class="tools"><a href="javascript:;" class="collapse"></a></div>
												</div> 
												<div class="portlet-body">
													<div class="clearfix"> <?php
														foreach( $section->children as $child ): 
															switch( $child->section_type_id )
															{
																case 4: //library crowd ?>
																	<div class="panel panel-success">
																		<div class="panel-heading">
																			<h3 class="panel-title">
																				{{ $child->template_section }}
																				@if( !empty( $child->weight ) )
																					({{ $child->weight }}%)
																				@endif
																			</h3>
																		</div>
																		@include('edit/sections/library_crowd', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))
																	</div> <?php 
																break;
															} 
														endforeach;	?>
													</div>
												</div><?php
											endif;
										endforeach; ?>
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
							                	@if( $appraisee->status_id <= 1 )
								                    <div class="col-md-offset-4 col-md-8">
								                    	<button type="button" class="btn yellow btn-sm" onclick="get_observations( {{$appraisee->year}}, {{$appraisee->user_id}}, '{{$appraisee->fullname}}' )"><i class="fa fa-rss"></i> Observations</button>
														<button type="button" class="btn blue btn-sm" onclick="change_status( $(this).closest('form'), 1)"><i class="fa fa-check"></i> Draft</button>
														<button type="button" class="btn green btn-sm" onclick="change_status( $(this).closest('form'), 8)"><i class="fa fa-check"></i> Submit</button>
									        			<a class="btn default btn-sm" href="{{ $mod->url }}">Back</a>
								                    </div>
							                    @else
								                    <div class="col-md-offset-5 col-md-7">
								                    	<button type="button" class="btn yellow btn-sm" onclick="get_observations( {{$appraisee->year}}, {{$appraisee->user_id}}, '{{$appraisee->fullname}}' )"><i class="fa fa-rss"></i> Observations</button>
								                    	@if( $appraisee->cs_status == 3 && $appraisee->status_id == 8 )
								                    		<button type="button" class="btn yellow btn-sm" onclick="change_status( $(this).closest('form'), 9)"><i class="fa fa-check"></i> For HR Validation</button>
								                    	@endif
								                    	<a class="btn default btn-sm" href="{{ $mod->url }}">Back</a>
								                    </div>
							                    @endif
							                @else
							                	<div class="col-md-offset-5 col-md-7">
							                    	<button type="button" class="btn yellow btn-sm" onclick="get_observations( {{$appraisee->year}}, {{$appraisee->user_id}}, '{{$appraisee->fullname}}' )"><i class="fa fa-rss"></i> Observations</button>
							                    	<a class="btn default btn-sm" href="{{ $mod->url }}">Back</a>
							                    </div>
							                @endif
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
