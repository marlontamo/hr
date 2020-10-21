@extends('layouts.master')

@section('page_content')
@parent

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="row">
	<div class="col-md-11">
		<!-- BEGIN FORM-->
		<div class="row">
			<!-- FORM -->
			<div class="col-md-12">

							<div class="portlet">
								<div class="portlet-body form">
			                        <form action="#" class="form-horizontal">
			                            <div class="form-body" style="padding-bottom:0px;">

			                            	<div class="note note-default">

							                    <h2>
							                    <span class="module-title">Process: </span><span class="module-caption">  Actions and Protocols</span>
							                    </h2>
							                    <p class="small">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet  consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt utdolore magna aliquam erat volutpat.</p>

							                    <hr class="margin-bottom-25" />

												<div class="clearfix margin-bottom-25">
													<label class="col-md-9"><h4><span class="sub-title">Incident Report</span></h4>
														<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

													</label>
													<div class="col-md-3 padding-top-10">
														<a class="btn btn-default" type="button" rel="{{ get_mod_route('incident_report') }}" href="{{ get_mod_route('incident_report') }}">View</a>
														<a class="btn btn-success" type="button" rel="{{ get_mod_route('incident_report', 'add') }}" href="{{ get_mod_route('incident_report', 'add') }}">Create</a>
													</div>
												</div>

												<div class="clearfix margin-bottom-25">
													<label class="col-md-9"><h4><span class="sub-title">Notice to Explain</span></h4>
														<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

													</label>
													<div class="col-md-3 padding-top-10">
														<a class="btn btn-default" type="button" href="clinic_records.php">View</a>
														<a class="btn btn-success" type="button" href="clinic_records_add.php">Create</a>
													</div>
												</div>

												<div class="clearfix margin-bottom-25">
													<label class="col-md-9"><h4><span class="sub-title">Disciplinary Action</span></h4>
														<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

													</label>
													<div class="col-md-3 padding-top-10">
														<a class="btn btn-default" type="button" href="safe_mahour.php">View</a>
														<a class="btn btn-success" type="button" href="safe_manhour_add.php">Create</a>
													</div>
												</div>

												<div class="clearfix margin-bottom-25">
													<label class="col-md-9"><h4><span class="sub-title">IR Procedure</span></h4>
														<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

													</label>
													<div class="col-md-3 padding-top-10">
														<a class="btn btn-default" type="button" href="safe_mahour.php">View</a>
														<a class="btn btn-success" type="button" href="safe_manhour_add.php">Create</a>
													</div>
												</div>



											</div>

										</div>
			                        </form>
								</div>
							</div>
			</div>
		</div>
        <!-- END FORM-->
	</div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('page_plugins')
@parent
<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
<script type="text/javascript" src="{{ theme_path() }}modules/common/lists.js"></script>
@stop

@section('view_js')
@parent
{{ get_list_js( $mod ) }}
@stop
