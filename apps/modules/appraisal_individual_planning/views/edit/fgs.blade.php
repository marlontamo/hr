<div class="portlet">
	<div class="portlet-title">
		<div class="caption bold">{{ lang('appraisal_individual_planning.performance_planning_form') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body">
		<p class="margin-bottom-25"><label class="bold">{{ $templatefile->template }}</label> 
		<span class="text-muted small">{{ lang('appraisal_individual_planning.strictly_confi') }}</span>
		</p>
		<!-- EMPLOYEES INFO-->
        <div class="portlet">
			<div class="portlet-body">
				<table class="table table-bordered table-striped">
					<input type="hidden" name="user_id" value="{{ $appraisee->user_id }}" />
					<input type="hidden" name="template_id" value="{{ $appraisee->template_id }}" />
					<input type="hidden" name="planning_id" value="{{ $appraisee->planning_id }}" />
					<input type="hidden" name="status_id" value="{{ $appraisee->status_id }}" />
					<tbody>
						<tr class="success">
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('appraisal_individual_planning.appraisee') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ $appraisee->fullname }}" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('appraisal_individual_planning.immediate_sup') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ $appraisee->immediate }}" readonly>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('appraisal_individual_planning.job_title') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly value="{{ $appraisee->position }}">
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('appraisal_individual_planning.job_title') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ $appraisee->immediate_position }}" readonly>
									</div>
								</div>
							</td>
						</tr>
						<tr class="success">
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('appraisal_individual_planning.date_joined') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ date('M d, Y', strtotime( $appraisee->effectivity_date ) ) }}" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('appraisal_individual_planning.planning_period') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ date('M d, Y', strtotime( $record['date_from'] ) ) }} to {{ date('M d, Y', strtotime( $record['date_to'] ) ) }}" readonly>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('appraisal_individual_planning.sub_dept') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="{{ $appraisee->company }}" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('appraisal_individual_planning.planning_date') }}</label>
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
			foreach( $sections as $section ):
				$has_balancescorecard = false;
				foreach( $section->children as $child ):
					if( $child->section_type_id == 2 ||  $child->section_type_id == 4)
						$has_balancescorecard = true;
				endforeach;

				if( $has_balancescorecard ): ?>
					<div class="portlet-title">
						<div class="caption">{{ $section->template_section }} {{ ($section->weight > 0 ? '(' + $section->weight + ')' : '') }}</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>
							</div>
					</div> 
					<div class="portlet-body">
						<div class="clearfix"> <?php
							foreach( $section->children as $child ):
								switch( $child->section_type_id )
								{
									case 2: //balance Scorecard ?>
										<div class="panel panel-success">
											<div class="panel-heading">
												<h3 class="panel-title">
													{{ $child->template_section }} ({{ $child->weight }}%)
												</h3>
											</div>
											@include('edit/sections/balance_scorecard', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))
										</div> <?php 
										break;
									case 4: ?>
										<div class="panel panel-success">
											<div class="panel-heading">
												<h3 class="panel-title">
													{{ $child->template_section }} ({{ $child->weight }}%)
												</h3>
											</div>
											@include('edit/sections/library_crowd', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))
										</div> <?php
										break;
									default:
								}
							endforeach;	?>
						</div>
					</div><?php
				endif;
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
										Planning Logs
										<br>
										<span class="text-muted small">Composed of historical logs, date/time and status of planning.</span>
									</td>
									<td>
										<a class="btn btn-primary btn-sm pull-right" data-toggle="modal" href="javascript: view_transaction_logs( {{ $appraisee->planning_id }}, {{ $appraisee->user_id }} )"> <i class="fa fa-list"></i> View Planning Logs</a>
									</td>
								</tr>
								<tr>
									<td>
										Discussion Logs
										<br>
										<span class="text-muted small">Composed of historical chat logs, date and time of discussion.</span>
									</td>
									<td>
										<button type="button" class="btn blue btn-sm pull-right" onclick="view_discussion( $(this).closest('form'), -1 )"><i class="fa fa-list"></i> View Discussion</button>
										<!-- <a class="btn btn-primary btn-sm pull-right" data-toggle="modal" href="#for_discussion"> <i class="fa fa-list"></i> View Discussion</a> -->
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
                    <div class="col-md-offset-4 col-md-8">
                    	@if( $appraisee->to_user_id == $user['user_id'] )
	                    	<?php switch( $appraisee->status_id ):
								case 0;
								case 1; ?>
									@include('buttons/partner/no_status') <?php
									break;
								case 3;  ?>
									@include('buttons/partner/pending') <?php
									break;
								case 4;  ?>
									@include('buttons/partner/approved') <?php
									break;
							endswitch;?>
						@endif
                    	<a class="btn default btn-sm back_button_gray" href="{{ $mod->url }}">{{ lang('common.back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
