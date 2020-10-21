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
		<p class="margin-bottom-25"><label class="bold">{{ $templatefile->template }}</label> <span class="text-muted small">(STRICTLY CONFIDENTIAL)</span></p>
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
			foreach( $sections as $section ):
				foreach( $section->children as $child ):
					$where = array(
                        'appraisal_id' => $appraisee->appraisal_id,
                        'user_id' => $appraisee->user_id,
                        'contributor_id' => $manager_id,
                        'template_section_id' => $child->template_section_id
                    );

					$db->limit(1);
					$checked = $db->get_where('performance_appraisal_contributor', $where);
					if( $checked->num_rows() == 1 )
					{
						switch( $child->section_type_id )
						{
							case 4: //library crowd ?>
								<div class="portlet-title">
									<div class="caption">{{ $section->template_section }}</div>
									<div class="tools">
										<a href="javascript:;" class="collapse"></a>
										</div>
								</div> 
								<div class="portlet-body">
									<div class="clearfix">
										<div class="panel panel-success">
											<div class="panel-heading">
												<h3 class="panel-title">
													{{ $child->template_section }} ({{ $child->weight }}%)
												</h3>
											</div>
											@include('review/sections/library_crowd', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))
										</div>
									</div>
								</div><?php 
								break;
							default:
						}
					}
				endforeach;
			endforeach; ?>
		</div>
		
			<div class="form-actions fluid">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="col-md-offset-4 col-md-8">
	                    	@if( $appraisee->status_id != 4 )
	                    		<button type="button" class="btn blue btn-sm" onclick="change_status( $(this).closest('form'), 1)"><i class="fa fa-check"></i> Save as draft</button>
	                    	@endif
	                    	@if( $appraisee->status_id == 3 )
	                    		<button type="button" class="btn yellow btn-sm" onclick="get_discussion_form( {{$appraisee->appraisal_id}}, '', {{$appraisee->user_id}}, {{$appraisee->contributor_id}}, true )">Discussion Logs</button>
	                    	@else
	                    		<button type="button" class="btn yellow btn-sm" onclick="get_discussion_form( {{$appraisee->appraisal_id}}, '', {{$appraisee->user_id}}, {{$appraisee->contributor_id}}, false )">Discussion Logs</button>
	                    	@endif
	                    	@if( $appraisee->status_id != 4 )
	                    		<button type="button" class="btn green btn-sm" onclick="change_status( $(this).closest('form'), 4)"><i class="fa fa-check"></i> Submit</button>
	                    	@endif

	        				<a class="btn default btn-sm" href="{{ $mod->url }}">Back</a>
	                    </div>
	                </div>
	            </div>
	        </div>
        
    </div>
</div>
