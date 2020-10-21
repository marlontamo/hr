@extends('layouts.master')

@section('page_styles')
	@parent
	
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/data-tables/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}css/pages/blog.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}css/pages/news.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-modal/css/bootstrap-modal.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-toastr/toastr.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2_metro.css" />		

	<style>
		div.spinner {
			/*//position:relative;*/
			background: none;
			border: none;
			/*display: none;*/
			padding-top: 5px;
			padding-bottom: 5px;
			overflow: hidden;
			/*//width: 550px;
			//height: 300px;
			//border:1px solid red;*/
		}
		
		div.spinner img{
			margin-top: 5px;
			margin-bottom: 5px;
			position:absolute;
			top:50%;
			left: 50%;
		}
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
				<a href="{{ $mod->url }}"><button class="btn blue" type="button">
				<span>{{ lang('form_application.back') }}</span>
				</button></a>
			</li>
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ base_url('') }}">{{ lang('form_application.home') }}</a> 
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


				<div class="col-md-4">

					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">{{ lang('form_application.leave_form') }}</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body" style="display: block;">

							<div class="clearfix">
								
								<ul class="media-list">
									<?php 
										foreach( $regularLeaves as $form ){
											// if( $form['is_leave'] == 1 ){
									 ?>
									<li class="media">
										<a href="#" class="hidden-xs pull-left">
											<i class="{{ $form['class'] }}" style="color:#646464;font-size:24px;line-height:24px;"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">{{ $form['form'] }}</h4>
											<p class="small">
												{{ $form['description'] }}
											</p>
											@if(array_key_exists ( $form['form_id'] , $no_credit_disable ))
												@if($no_credit_disable[$form['form_id']] == 0)
													<a class="btn btn-xs default" disabled >{{ lang('form_application.apply') }}<i class="fa fa-arrow-circle-o-right"></i></a> 
													<br>
													<div class="small text-danger">
														<small>You have no remaining credits or 
														<br>You are not yet entitled to file this form.
														<br>Use LWOP if necessary.
														</small>
													</div>
													<br>
													<a class="btn btn-xs green" href="{{ get_mod_route('form_application', 'add/lwop' ) }}">{{ lang('form_application.apply') }} leave without pay<i class="fa fa-arrow-circle-o-right"></i></a> 
												@else
													<a class="btn btn-xs green" href="{{ get_mod_route('form_application', 'add/' . strtolower($form['form_code'])) }}">{{ lang('form_application.apply') }}<i class="fa fa-arrow-circle-o-right"></i></a> 
												@endif
											@else
												<a class="btn btn-xs green" href="{{ get_mod_route('form_application', 'add/' . strtolower($form['form_code'])) }}">{{ lang('form_application.apply') }}<i class="fa fa-arrow-circle-o-right"></i></a> 
											@endif
										</div>
									</li>								
									<?php
											// }
									 	} 
									 ?>								
								</ul>

							</div>
						</div>
					</div>

				</div>

				<div class="col-md-4">

					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">{{ lang('form_application.other_forms') }}</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>

						<div class="portlet-body">
							<div class="clearfix">
								<ul class="media-list">
									<?php 
										foreach( $otherForms as $form ){
											if( $form['is_leave'] == 0 ){
									 ?>
										<li class="media">
											<a class="hidden-xs pull-left" href="#">
												<i class="{{ $form['class'] }}" style="color:#646464;font-size:24px;line-height:24px;"></i>
											</a>
											<div class="media-body">
												<h4 class="media-heading">{{ $form['form'] }}</h4>
												<p class="small">
													{{ $form['description'] }} 
												</p>
												<a href="{{ get_mod_route('form_application', 'add/' . strtolower($form['form_code'])) }}" class="btn btn-xs green">{{ lang('form_application.apply') }}<i class="fa fa-arrow-circle-o-right"></i></a> 
											</div>
										</li>							
									<?php
											}
									 	} 
									 ?>		
									 @if($is_dtru_applicable)
									 <?php $updating = $updating->row_array();?>
									 <li class="media">
										<a class="hidden-xs pull-left" href="#">
											<i class="{{ $updating['class'] }}" style="color:#646464;font-size:24px;line-height:24px;"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">{{ $updating['form'] }}</h4>
											<p class="small">
												{{ $updating['description'] }} 
											</p>
											<a href="{{ get_mod_route('timerecord') }}/updating" class="btn btn-xs green">{{ lang('form_application.apply') }}<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>	
									@endif	
								</ul>
							</div>
						</div>
					</div>

				</div>


				<div class="col-md-4">

					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">{{ lang('form_application.special_leave') }}</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body" style="display: block;">

							<div class="clearfix">
								
								<ul class="media-list">
									<?php 
										foreach( $specialLeaves as $form ){
											// if( $form['is_leave'] == 1 ){
									 ?>
									<li class="media">
										<a href="#" class="hidden-xs pull-left">
											<i class="{{ $form['class'] }}" style="color:#646464;font-size:24px;line-height:24px;"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">{{ $form['form'] }}</h4>
											<p class="small">
												{{ $form['description'] }}
											</p>
											<a class="btn btn-xs green" href="{{ get_mod_route('form_application', 'add/' . strtolower($form['form_code'])) }}">{{ lang('form_application.apply') }}<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>								
									<?php
											// }
									 	} 
									 ?>								
								</ul>

							</div>
						</div>
					</div>

				</div>

				<div class="col-md-2 hidden">

					<div class="portlet">
						<!-- <div class="portlet-title">
							<div class="caption">Menu Link</div>
						</div>	 -->	

						<div class="clearfix">
							<div class="panel panel-success">
								<!-- Default panel contents -->
								<div class="panel-heading">
									<h4 class="panel-title">{{ lang('form_application.leave_status') }}</h4>
								</div>
								
								<!-- Table -->
								<table class="table">
									<thead>
										<tr>
											<th class="small">{{ lang('form_application.type') }}</th>
											<th class="small">{{ lang('form_application.pending') }}</th>
											<th class="small">{{ lang('form_application.approved') }}</th>
										</tr>
									</thead>
									
									<tbody>
										<?php foreach( $form_status as $form_status_info ){ 
											if( $form_status_info['is_leave'] == 1 && in_array($form_status_info['form_id'], $leave_forms)){
										?>
										<tr>
											<td class="small">{{ $form_status_info['form'] }}</td>
											<td class="small text-info">{{ $form_status_info['pending'] }}</td>
											<td class="small text-success">{{ $form_status_info['approved'] }}</td>
										</tr>
										<?php 
											}
										} ?>
									</tbody>
								
								</table>
							</div>
						</div>

						<div class="clearfix">
							<div class="panel panel-success">
								<!-- Default panel contents -->
								<div class="panel-heading">
									<h4 class="panel-title">{{ lang('form_application.other_fstatus') }}</h4>
								</div>
								
								<!-- Table -->
								<table class="table">
									<thead>
										<tr>
											<th class="small">{{ lang('form_application.type') }}</th>
											<th class="small">{{ lang('form_application.pending') }}</th>
											<th class="small">{{ lang('form_application.approved') }}</th>
										</tr>
									</thead>
									
									<tbody>
										<?php foreach( $form_status as $form_status_info ){ 
											if( $form_status_info['is_leave'] == 0  && in_array($form_status_info['form_id'], $other_forms)){
										?>
										<tr>
											<td class="small">{{ $form_status_info['form'] }}</td>
											<td class="small text-info">{{ $form_status_info['pending'] }}</td>
											<td class="small text-success">{{ $form_status_info['approved'] }}</td>
										</tr>
										<?php 
											}
										} ?>
									</tbody>

								</table>
							</div>
						</div>


					</div>

				</div>


			</div>



    
    <!--START MODAL DIALOG ELEMENTS-->
    @include('common/modals')
    <!--END MODAL DIALOG ELEMENTS-->
    
@stop

@section('page_plugins')
	@parent
    
	<script type="text/javascript" src="{{ theme_path() }}plugins/data-tables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/data-tables/DT_bootstrap.js"></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/jquery-validation/dist/additional-methods.min.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <!-- <script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script> -->
    <script type="text/javascript" src="{{ theme_path() }}plugins/jquery.lazyload.js"></script> 
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>   
    <script type="text/javascript" src="{{ theme_path() }}plugins/fuelux/js/spinner.min.js"></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/select2/select2.min.js"></script>	
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" ></script>	    
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-touchspin/bootstrap.touchspin.js" ></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-modal/js/bootstrap-modal.js" ></script>	

 	<script src="{{ theme_path() }}plugins/bootstrap-toastr/toastr.min.js"></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript" ></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
	
	<!-- Additional for FORM COMPONENTS -->
	<script src="{{ theme_path() }}plugins/jquery-inputmask/jquery.inputmask.bundle.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript" ></script>	
@stop

@section('page_scripts')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/timerecord/edit_custom.js"></script>	     
	<script src="{{ theme_path() }}scripts/table-managed.js"></script>   
    <script src="{{ theme_path() }}scripts/form-wizard.js"></script>
	<script src="{{ theme_path() }}scripts/ui-extended-modals.js"></script> 
	<script src="{{ theme_path() }}scripts/form-components.js"></script>       
@stop

@section('view_js')
	@parent
    

@stop