<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.0.2
Version: 1.5.4
Author: KeenThemes
Website: http://www.keenthemes.com/
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	@section('head')
		@include('common/head')
	@show
</head>
<!-- END HEAD -->
<link href="{{ theme_path() }}plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" />

<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css"/>
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
<link href="{{ theme_path() }}plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2.css" />
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2_metro.css" />
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-timepicker/compiled/timepicker.css" />

<style>
.portlet.calendar .fc-button {
	color : #545454;
	top : -56px;
}
</style>
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-closed">
	@section('header')
		@include('common/header')
	@show

	<div class="clearfix"></div>
	
	@section('container')
		<div class="page-container">
			@section('sidebar')
				<div class="page-sidebar navbar-collapse collapse">
					<ul class="page-sidebar-menu">
						<li>
							<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
							<div class="sidebar-toggler hidden-phone"></div>
							<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
						</li>
						<li>
							&nbsp; <!-- hide temporarily this search form -->
							<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
							<form class="hidden sidebar-search" action="extra_search.html" method="POST">
								<div class="form-container">
									<div class="input-box">
										<a href="javascript:;" class="remove"></a>
										<input type="text" placeholder="Search..."/>
										<input type="button" class="submit" value=" "/>
									</div>
								</div>
							</form>
							<!-- END RESPONSIVE QUICK SEARCH FORM -->
						</li>

						@include('menu/'. $current_db .'/'.$user['role_id'])
						
						<li class="">
							<a href="{{ base_url('logout') }}">
							<i class="fa fa-key"></i> 
							<span class="title">Logout</span>
							</a>
						</li>
					</ul>
				</div>
			@show
			
				<div class="page-content">
						@section('page-header')
							@include('common/page-header')
						@show
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">

				<div class="col-md-12">

					<!-- <div class="modal fade modal-container" tabindex="-1" aria-hidden="true" data-width="800" ></div> -->

					<div class="portlet calendar">

						<div class="portlet-title">
							<div class="caption">&nbsp;</div>
						</div>

						<div class="portlet-body">

							<div class="row">


								<div class="col-md-9 col-sm-9">
									<div id="calendar" class="has-toolbar"></div>
								</div>

								<div class="col-md-3 col-sm-12">
									<!-- BEGIN DRAGGABLE EVENTS PORTLET-->    
									<h4>{{ lang('my_calendar.forms_apply') }}</h4><hr class="margin-none">
									<p class="small text-muted margin-bottom-20 margin-top-10">{{ lang('my_calendar.note') }}</p>
									<div id="event_box"></div>

									<div id="external-events">
										<hr />
										<hr class="visible-xs" />
									</div>

									<!-- END DRAGGABLE EVENTS PORTLET-->            
								</div>

								<div class="col-md-3 col-sm-12 ">
									<!-- LINK TO MANAGE CALENDAR-->    
									<h4>{{ lang('my_calendar.link') }}</h4>
									<p><a rel="<?php echo base_url();?>time/calendar" href="<?php echo base_url();?>time/calendar"  class="label label-success">{{ lang('my_calendar.cmanager_button') }}</a>
									<a rel="<?php echo base_url();?>time/timerecords" href="<?php echo base_url();?>time/timerecords"  class="label label-success">{{ lang('my_calendar.timer_button') }}</a></p>
									
									@if($is_dtru_applicable)
									<a rel="<?php echo base_url();?>time/timerecords/updating" href="<?php echo base_url();?>time/timerecords/updating"  class="label label-success">{{ lang('my_calendar.timer_button') }} Updating</a>
									@endif
									
								</div>								
							</div>

							<!-- END CALENDAR PORTLET-->
						</div>
					</div>
				</div>
			</div>

			<!-- END PAGE CONTENT--> 
				</div>
		</div>
	@show


	<!-- BEGIN FOOTER -->
	<div class="footer">
		<div class="footer-inner">
			{{ date('Y')}} &copy; {{ $system['application_title'] . ' by ' . $system['author'] }}
		</div>
		<div class="footer-tools">
			<span class="go-top">
			<i class="fa fa-angle-up"></i>
			</span>
		</div>
	</div>
	<!-- END FOOTER -->

	<div class="modal fade modal-container" tabindex="-1" aria-hidden="true" data-width="800"></div>


	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	@section('js_plugins')
		@include('common/js')
	@show
	
	<!-- Add Module JS -->
	{{ get_module_js( $mod ) }}

<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{ theme_path() }}plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script> 
<script src="{{ theme_path() }}plugins/jquery.ui.touch-punch.min.js" type="text/javascript"></script>  
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="{{ theme_path() }}plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="{{ theme_path() }}plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript" ></script>	

<script type="text/javascript" src="{{ theme_path() }}plugins/ckeditor/ckeditor.js"></script>  
<script type="text/javascript" src="{{ theme_path() }}plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>

<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript" ></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-switch/static/js/bootstrap-switch.min.js"></script>
<!-- Additional for FORM COMPONENTS -->
<script src="{{ theme_path() }}plugins/jquery-inputmask/jquery.inputmask.bundle.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript" ></script>

	
	<script>
		jQuery(document).ready(function() {
			// initiate layout and plugins
			App.init();

			get_notification(false);
			get_inbox(false);
		});
	</script>

<script src="{{ theme_path() }}scripts/form-components.js"></script>  
<script src="{{ theme_path() }}scripts/ui-extended-modals.js"></script> 
<script type="text/javascript" src="{{ theme_path() }}modules/my_calendar/edit.js"></script>

</body>
<!-- END BODY -->
</html>