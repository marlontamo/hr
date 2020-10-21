@extends('layouts.master')

@section('page_styles')
	@parent	
	
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/gritter/css/jquery.gritter.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-toastr/toastr.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2_metro.css" />
	<link href="{{ theme_path() }}css/pages/profile.css" rel="stylesheet" type="text/css" />
	<link href="{{ theme_path() }}css/custom.css" rel="stylesheet" type="text/css"/>

	<style type="text/css">
	.tab-content .portlet-body .row { margin-top: -10px; }
	</style>
	@stop
		
@section('page-header')
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN PAGE TITLE & BREADCRUMB-->
			<h3 class="page-title">
				{{ $mod->long_name }} <small>{{ $mod->description }}</small>
			</h3>
			<ul class="page-breadcrumb breadcrumb">				
				<li class="btn-group">
					<a href="<?php echo get_mod_route('partners');?>"><button type="button" class="btn blue">
					<span>{{ lang('common.back') }}</span>
					</button></a>
				</li>
				<li>
					<i class="fa fa-home"></i>
					<a href="{{ base_url('') }}">Home</a> 
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<!-- jlm i class="fa {{ $mod->icon }}"></i -->
					<a href="{{ $mod->url }}">{{ $mod->long_name }}</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>{{ ucwords( $mod->method )}}</li>
			</ul>
			<!-- END PAGE TITLE & BREADCRUMB-->
		</div>
	</div>
@stop

@section('page_content')
	@parent
<div class="row">
	<div class="col-md-12">
		<!-- SECTION 1 -->
		<div class="portlet margin-bottom-0">
			<div class="portlet-title">
				<div class="caption">
					{{$profile_name}}
				</div>
				<div class="tools">
					<a class="collapse" href="javascript:;"></a>
				</div>
			</div>
			<div class="portlet-body">
				<input type="hidden" value="{{$record['record_id']}}" name="record_id" id="record_id">
				<div class="row">
					<!-- IMAGE AREA -->
					<div class="col-md-2 col-sm-4">
						<ul class="list-unstyled profile-nav">
							<li>
								<img src="{{ base_url($profile_photo) }}" class="img-responsive" alt="" style="width:180px;"/> 
								<!-- <a href="#" class="profile-edit">edit</a> -->
							</li>
						</ul>
					</div>
					<!-- COMPANY INFORMATION -->
					<div class="col-md-6 col-sm-8">
                        <h4 id="position-name">{{$profile_position}}</h4>
                        <h5 id="company-name" class="margin-bottom-15">{{$profile_company}}</h5>
                        <ul class="list-inline text-muted margin-bottom-10">
                            <li><i class="fa fa-envelope"></i> <span id="email"> {{$profile_email}}</span></li>
                        </ul>
						<!--  LOOP ALL PHONE NUMBERS HERE -->
						<ul class="list-inline text-muted margin-bottom-10">
							<?php foreach($profile_telephones as $telephone){ 
									if(!empty($telephone)){ ?>
									<li><i class="fa fa-phone"></i> <?=$telephone?></li>
							<?php 	}
								  } ?>
						</ul>
						<!--  LOOP ALL FAX NUMBERS HERE -->
						<ul class="list-inline text-muted margin-bottom-10">
							<?php foreach($profile_fax as $fax_no){ 
									if(!empty($fax_no)){ ?>
									<li><i class="fa fa-print"></i> <?=$fax_no?></li>
							<?php 	}
								  } ?>
						</ul>
						<!-- LOOP ALL MOBILE NUMBERS HERE -->
						<ul class="list-inline text-muted margin-bottom-10">
							<?php foreach($profile_mobiles as $mobile){
									if(!empty($mobile)){ ?>
									<li><i class="fa fa-mobile"></i> <?=$mobile?></li>
							<?php 	}
								  } ?>
						</ul>
					</div>
					<!-- PERSONAL INFORMATION -->
					<div class="col-md-4 col-sm-12">
						<div class="portlet sale-summary margin-bottom-0">
							<div class="portlet-body">
								<ul class="list-unstyled">
									<li><h5 class="margin-bottom-0">{{ lang('partners.quick_info') }}</h5>
									</li>
									<li>
										<span class="text-muted"><i class="fa fa-calendar"></i>&nbsp; {{ lang('partners.bday') }}</span> 
										<span class="pull-right" id="birthday"> {{$profile_birthdate}}</span>
										<br />
										<span class="pull-right small text-muted"> {{$profile_age}} yrs old</span>
									</li>
									<li>
										<span class="text-muted"><i class="fa fa-map-marker"></i>&nbsp; {{ lang('partners.livein') }}</span> 
										<span class="pull-right" id="city"> {{$profile_live_in}}</span>
										<br />
										<span class="pull-right small text-muted"> {{$profile_country}}</span>
									</li>
									<li>
										<span class="text-muted"><i class="fa fa-user"></i>&nbsp; {{ lang('partners.civil_status') }}</span> 
										<span class="pull-right" id="civilstatus"> {{$profile_civil_status}}</span>
										<br />
										<span class="pull-right small text-muted"> <?php echo strtolower($profile_civil_status) == "married" ? "Spouse ".$profile_spouse : "" ?></span>
									</li>
									<!-- <li>
                                        <a class="btn icn-only green" onclick="javascipt:edit_profile();">Change Request <i class="m-icon-swapright m-icon-white"></i></a>
									</li> -->
								</ul>
							</div>
						</div>
						<div class="clearfix margin-bottom-10 hidden-lg hidden-md"></div>
					</div>
				</div>
			</div>
		</div>
		<!--END SECTION 1 -->
	<!-- SECTION 2 -->
		<div class="portlet">
			<div class="portlet-body">
				<div class="row profile">
					<div class="col-md-12">
						<div class="tabbable tabbable-custom tabbable-full-width">
							<ul class="nav nav-tabs">
								<li class="active">
									<a data-toggle="tab" href="#profile_tab_1">{{ lang('partners.overview') }}</a>
								</li>
								<li class="">
									<a data-toggle="tab" href="#profile_tab_2">{{ lang('partners.historical') }}</a>
								</li>
							</ul>
							<div class="tab-content">
								<!-- OVERVIEW -->
								<div id="profile_tab_1" class="tab-pane active">
									@include('tabs/partners_profile_overview')
								</div>
								<!-- HISTORY -->
								<div id="profile_tab_2" class="tab-pane">
									@include('tabs/partners_profile_history')
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>   
		</div>
	<!-- END SECTION 2 -->

	</div>
</div>

<div class="modal fade modal-container-action" aria-hidden="true" data-width="800" ></div>
<div class="modal fade modal-container-partners" tabindex="-1" aria-hidden="true" data-width="500" ></div>
<!-- END PAGE CONTENT-->

	@stop

@section('page_plugins')
	@parent
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    
    <script type="text/javascript" src="{{ theme_path() }}plugins/fuelux/js/spinner.min.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
	<script src="{{ theme_path() }}plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript" ></script>
	<!-- Additional for FORM COMPONENTS -->
	<script src="{{ theme_path() }}plugins/jquery-inputmask/jquery.inputmask.bundle.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript" ></script>
	<!-- END PAGE LEVEL PLUGINS -->
	@stop

@section('page_scripts')
	@parent	     
	<script src="{{ theme_path() }}scripts/app.js"></script>   
	<script src="{{ theme_path() }}scripts/ui-extended-modals.js"></script> 
    <script src="{{ theme_path() }}scripts/form-components.js"></script>    
	<script type="text/javascript" src="{{ theme_path() }}modules/partners/view_custom.js"></script>     
	@stop

