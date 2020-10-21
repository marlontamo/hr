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
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-fixed">
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
							<!-- div class="sidebar-toggler hidden-phone"></div -->
							<div>&nbsp;</div>
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
							<i class="fa fa-power-off"></i> 
							<span class="title">Logout</span>
							</a>
						</li>
					</ul>
				</div>
			@show
			
			@section('page-content')
				<div class="page-content">
					@section('content')
						@section('page-header')
							@include('common/page-header')
						@show
						
						@section('page_content')
								
						@show
					@show	
				</div>
			@show
		</div>
	@show


	<!-- BEGIN FOOTER -->
	<div class="footer">
		<div class="footer-inner">
			<span style="color:#fff">{{ date('Y') }} {{ $system['copyright_details'] }}</span> by <a class="text-muted" href="http://www.hdisystech.com" target="_blank">{{ $system['author'] }}</a>
		</div>
		<div class="footer-tools">
			<span class="go-top">
			<i class="fa fa-angle-up"></i>
			</span>
		</div>
	</div>
	<!-- END FOOTER -->

	<div class="modal fade modal-container" tabindex="-1" aria-hidden="true" id="modal_global_id"></div>

	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	@section('js_plugins')
		@include('common/js')
	@show
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
			// initiate layout and plugins
			App.init();
		});
	</script>
	
	@section('module_js')
		<!-- Add Module JS -->
		{{ get_module_js( $mod ) }}
	@show
	
	@section('view_js')
	@show

	<!-- let this section be the last to load -->
	@if( get_system_config('other_settings', 'enable_chat') )
		@section('chat_js')
			@include('common/chat')
		@show
	@endif
</body>
<!-- END BODY -->
</html>