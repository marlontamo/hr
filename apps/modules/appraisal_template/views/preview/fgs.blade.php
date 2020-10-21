<div class="portlet">
	<div class="portlet-title">
		<div class="caption bold">PERFORMANCE PLANNING FORM</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body">
		<p class="margin-bottom-25"><span class="text-muted small">(STRICTLY CONFIDENTIAL)</span></p>
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
										<input type="text" class="form-control" value="" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Immediate Superior</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="" readonly>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Job Title</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Job Title</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value=""  readonly>
									</div>
								</div>
							</td>
						</tr>
						<tr class="success">
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Date Joined</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Appraisal Period</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="" readonly>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Subsidiary/Dept.</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value="" readonly>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Appraisal Date</label>
									<div class="col-md-9">
										<input type="text" class="form-control" value=""  readonly>
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
			$sections = $template->build_sections( $record_id);
			// echo "<pre>";
			// print_r($sections);
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
								$appraisee = array();
								switch( $child->section_type_id )
								{
									case 2: //balance Scorecard ?>
										@include('preview/sections/balance_scorecard', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
										break;
									case 3: //library ?>
										@include('preview/sections/library', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
										break;
									case 4: //library crowd ?>
										@include('preview/sections/library_crowd', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
										break;
									case 5: //summary ?>
										@include('preview/sections/summary', array('sections' => $sections, 'header' => $child->header, 'footer' => $child->footer))<?php 
										break;
									case 6: //supervisor summary ?>
										@include('preview/sections/sup_summary', array('appraisee' => $appraisee, 'header' => $child->header, 'footer' => $child->footer))<?php 
										break;
									case 7: //partner summary ?>
										@include('preview/sections/partner_summary', array('appraisee' => $appraisee, 'header' => $child->header, 'footer' => $child->footer))<?php 
										break;
									case 8: //personnel action ?>
										@include('preview/sections/personnel_action', array('section_id' => $child->template_section_id, 'header' => $child->header, 'footer' => $child->footer))<?php 
										break;
									default:
								} ?>
							</div> <?php
						endforeach;	?>
					</div>
				</div><?php
			endforeach; ?>
		</div>
			<div class="form-actions fluid">
	            <div class="row">
	                <div class="col-md-12">
	                	<div class="col-md-offset-5 col-md-7">
	                    	<!-- <button type="button" class="btn yellow btn-sm" ><i class="fa fa-rss"></i> Observations</button> -->
	                    	<a class="btn default btn-sm" href="{{ $mod->url }}">Back</a>
	                    </div>
	                </div>
	            </div>
	        </div> 
    </div>
</div>
