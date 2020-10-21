<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	@section('head')
		@include('common/head')
	@show

	<!-- BEGIN THEME STYLES --> 
    <link href="{{ theme_path() }}css/pages/user-manager.css" rel="stylesheet" type="text/css"/>
    <link href="{{ theme_path() }}plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
    <link href="{{ theme_path() }}plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
	<!-- END THEME STYLES -->

	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="{{ theme_path() }}plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-toastr/toastr.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2_metro.css" />
	<!-- END PAGE LEVEL STYLES -->

	<link rel="shortcut icon" href="favicon.ico" />

	<style>
		.portlet.calendar .fc-button {
			color : #545454;
			top : -56px;
		}
	</style>
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-closed">

	<!-- BEGIN HEADER -->   
	@section('header')
		@include('common/header')
	@show
	<!-- END HEADER -->

	<div class="clearfix"></div>

	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		
		<!-- BEGIN SIDEBAR -->
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
		<!-- END SIDEBAR -->

		<!-- BEGIN PAGE -->
		<div class="page-content">
		
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->               
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn blue">Save changes</button>
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			


			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
						Work Calendar<!-- <small> time record section</small> -->
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li class="btn-group">
							<button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
							<span>Action</span> <i class="fa fa-angle-down"></i>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li><a href="#">Refresh</a></li>
								<li class="divider"></li>
								<li><a href="#">Import</a></li>
								<li><a href="#">Export</a></li>
								<li class="divider"></li>
								<li><a href="#">Save to PDF</a></li>
							</ul>
						</li>
						<li>
							<i class="fa fa-home"></i>
							<a href="index.php">Home</a> 
							<i class="fa fa-angle-right"></i>
						</li>
						<li><a href="#">Time Record</a></li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->


			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
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
									<h4>{{ lang('my_calendar.forms_apply') }}</h4>
									<div id="event_box"></div>

									<div id="external-events">
										
										<hr />
										
										<hr class="visible-xs" />
									</div>

									<!-- END DRAGGABLE EVENTS PORTLET-->            
								</div>
								<div class="col-md-3 col-sm-12">
									<!-- LINK TO MANAGE CALENDAR-->    
									<h4>Link</h4>
									<a rel="{{ get_mod_route('my_calendar') }}" href="{{ get_mod_route('my_calendar') }}"  class="label label-success">My Calendar</a>
								</div>						
							</div>

							<!-- END CALENDAR PORTLET-->
						</div>
					</div>
				</div>
			</div>

			<!-- END PAGE CONTENT-->   

		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->


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

	<!-- <div class="modal-container modal fade" tabindex="-1" role="basic" aria-hidden="true" style="min-height: 50px;">
		<img src="{{ base_url() }}assets/img/ajax-modal-loading.gif" alt="" class="loading">
	</div> -->

	<div id="calman_loader" style="display:none">
		<img src="{{ base_url() }}assets/img/ajax-modal-loading.gif">
	</div>

	<div id="calman_form" class="modal fade" tabindex="-1" data-width="400"></div>
	<div id="calman_list" class="modal fade" tabindex="-1" data-width="800"></div>
	<div id="calman_view" class="modal fade" tabindex="-1" data-width="800"></div>

	<script>
		const warnafter = "{{ get_system_config('other_settings', 'warnafter') }}";
		const redirafter = "{{ get_system_config('other_settings', 'redirafter') }}";
		const base_url = '{{ base_url($lang) }}/';
		const user_id = '{{ $user['user_id'] }}';
	</script>

	<!-- Add Module JS -->
	{{ get_module_js( $mod ) }}

	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->   
	<!--[if lt IE 9]>
	<script src="{{ theme_path() }}plugins/respond.min.js"></script>
	<script src="{{ theme_path() }}plugins/excanvas.min.js"></script> 
	<![endif]-->   

	<script src="{{ theme_path() }}plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>   

	<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="{{ theme_path() }}plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>  
	<script src="{{ theme_path() }}plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/jquery.blockui.2.66.0-2013.10.09.min.js" type="text/javascript"></script>  
	<script src="{{ theme_path() }}plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/bootstrap-sessiontimeout/jquery.sessionTimeout.min.js" type="text/javascript" ></script>

	<!-- END CORE PLUGINS -->

	<!-- BEGIN PAGE LEVEL PLUGINS -->

	<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
	<script src="{{ theme_path() }}plugins/jquery.ui.touch-punch.min.js" type="text/javascript"></script> 
	<script src="{{ theme_path() }}plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>

	<script type="text/javascript" src="{{ theme_path() }}plugins/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>

	<script type="text/javascript" src="{{ theme_path() }}plugins/holder.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>

    <script type="text/javascript" src="{{ theme_path() }}plugins/fuelux/js/spinner.min.js"></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/select2/select2.min.js"></script>

	<script src="{{ theme_path() }}plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript" ></script>	
    
    <script src="{{ theme_path() }}plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>
	<!-- Additional for FORM COMPONENTS -->
	<script src="{{ theme_path() }}plugins/jquery-inputmask/jquery.inputmask.bundle.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript" ></script>

	<script src="{{ theme_path() }}plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL PLUGINS -->

	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="{{ theme_path() }}scripts/app.js"></script>
  	<script src="{{ theme_path() }}plugins/bootstrap-toastr/toastr.min.js"></script>
  	<script src="{{ theme_path() }}scripts/app.js"></script>
	<script src="{{ theme_path() }}scripts/ui-extended-modals.js"></script> 
	<script src="{{ theme_path() }}scripts/form-components.js"></script>   
	<!-- script src="{{ theme_path() }}scripts/calendar.js"></script -->    
    <!-- script src="{{ theme_path() }}scripts/form-components.js"></script -->  
	<!-- END PAGE LEVEL SCRIPTS -->

	<!-- script src="{{ theme_path() }}scripts/ui-toastr.js"></script -->    
	<script type="text/javascript" src="{{ theme_path() }}modules/common/global.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script>

	<script type="text/javascript" src="{{ theme_path() }}modules/work_calendar/edit.js"></script>

</body>
<!-- END BODY -->