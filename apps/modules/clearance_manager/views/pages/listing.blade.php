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
				                    <span class="module-title">Settings: </span><span class="module-caption">  Actions and Configuration</span>
				                    </h2>
				                    <p class="small">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet  consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt utdolore magna aliquam erat volutpat.</p>

				                    <hr class="margin-bottom-25" />

				                    <!-- <div class="clearfix margin-bottom-25">
										<label class="col-md-9"><h4><span class="sub-title">Clearance Templates</span></h4>
											<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

										</label>
										<div class="col-md-3 padding-top-10">
											<a class="btn btn-default" type="button" href="admin_partner_clearance_templates.php">View List</a>
										</div>
									</div> -->
				                    <div class="clearfix margin-bottom-25">
										<label class="col-md-9"><h4><span class="sub-title">Clearance Signatories</span></h4>
											<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

										</label>
										<div class="col-md-3 padding-top-10">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('clearance_sign') }}" href="{{ get_mod_route('clearance_sign') }}">Settings</a>
										</div>
									</div>
								</div>

								<div class="note note-default">

				                    <h2>
				                    <span class="module-title">Resources: </span><span class="module-caption">  Forms and Listings</span>
				                    </h2>
				                    <p class="small">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet  consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt utdolore magna aliquam erat volutpat.</p>

				                    <hr class="margin-bottom-25" />

									<div class="clearfix margin-bottom-25">
										<label class="col-md-9"><h4><span class="sub-title">Exit Interview Form</span></h4>
											<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

										</label>
										<div class="col-md-3 padding-top-10">
											<a class="btn btn-default" type="button"  rel="{{ get_mod_route('exit_interview_manager') }}" href="{{ get_mod_route('exit_interview_manager') }}">Settings</a>
										</div>
									</div>

									<div class="clearfix margin-bottom-25">
										<label class="col-md-9"><h4><span class="sub-title">Quit Claim and Release</span></h4>
											<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

										</label>
										<div class="col-md-3 padding-top-10">
											<a class="btn btn-default" type="button" href="incident_report_list.php">Settings</a>
										</div>
									</div>

									<div class="clearfix margin-bottom-25">
										<label class="col-md-9"><h4><span class="sub-title">Certificate of Employment</span></h4>
											<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

										</label>
										<div class="col-md-3 padding-top-10">
											<a class="btn btn-default" type="button" href="notice_to_explain.php">Settings</a>
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
