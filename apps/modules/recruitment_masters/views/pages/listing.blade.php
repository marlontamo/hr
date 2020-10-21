@extends('layouts.master')

@section('page_content')
@parent

<!-- BEGIN PAGE CONTENT-->
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
							                    <span class="module-title">Monitoring: </span><span class="module-caption">  Talent Acquisition</span>
							                    </h2>
							                    <p class="small">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet  consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt utdolore magna aliquam erat volutpat.</p>

							                    <hr class="margin-bottom-25" />

												<div class="clearfix margin-bottom-25">
													<label class="col-md-9"><h4><span class="sub-title">Annual Manpower Planning</span></h4>
														<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

													</label>
													<div class="col-md-3 padding-top-10">
														<a class="btn btn-default" type="button" rel="{{ get_mod_route('annual_manpower_planning') }}" href="{{ get_mod_route('annual_manpower_planning') }}">View</a>
													</div>
												</div>

												<div class="clearfix margin-bottom-25">
													<label class="col-md-9"><h4><span class="sub-title">Personnel Requisition Form </span></h4>
														<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

													</label>
													<div class="col-md-3 padding-top-10">
														<a class="btn btn-default" type="button" rel="{{ get_mod_route('mrf_admin') }}" href="{{ get_mod_route('mrf_admin') }}">View</a>
													</div>
												</div>

												<div class="clearfix margin-bottom-25">
													<label class="col-md-9"><h4><span class="sub-title">List of Applicants</span></h4>
														<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

													</label>
													<div class="col-md-3 padding-top-10">
														<a class="btn btn-default" type="button" rel="{{ get_mod_route('applicants') }}" href="{{ get_mod_route('applicants') }}">View</a>
													</div>
												</div>

												<div class="clearfix margin-bottom-25">
													<label class="col-md-9"><h4><span class="sub-title">Applicant Monitoring</span></h4>
														<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

													</label>
													<div class="col-md-3 padding-top-10">
														<a class="btn btn-default" type="button" rel="{{ get_mod_route('applicant_monitoring') }}" href="{{ get_mod_route('applicant_monitoring') }}">View</a>
													</div>
												</div>

												<div class="clearfix margin-bottom-25">
													<label class="col-md-9"><h4><span class="sub-title">Pre-Employment</span></h4>
														<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

													</label>
													<div class="col-md-3 padding-top-10">
														<a class="btn btn-default" type="button" href="#">View</a>
													</div>
												</div>

												<div class="clearfix margin-bottom-25">
													<label class="col-md-9"><h4><span class="sub-title">Application Form</span></h4>
														<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

													</label>
													<div class="col-md-3 padding-top-10">
														<a class="btn btn-default" type="button" rel="<?php echo base_url();?>kiosk" href="<?php echo base_url();?>kiosk">View</a>
													</div>
												</div>

												<div class="clearfix margin-bottom-25">
													<label class="col-md-9"><h4><span class="sub-title">Benefits</span></h4>														
														<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

													</label>
													<div class="col-md-3 padding-top-10">
														<a class="btn btn-default" type="button" rel="{{ get_mod_route('recruit_benefits') }}" href="{{ get_mod_route('recruit_benefits') }}">View</a>
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
			<!-- END PAGE CONTENT-->  
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
