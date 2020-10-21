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
	<meta charset="utf-8" />
	<title>{{ $system['application_title'] }} {{ lang('authentication.resetpass') }}</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta name="MobileOptimized" content="320">
    
	<!-- BEGIN GLOBAL MANDATORY STYLES -->          
	<link href="{{ theme_path() }}plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
    
	<!-- BEGIN PAGE LEVEL STYLES --> 
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2_metro.css" />
	<!-- END PAGE LEVEL SCRIPTS -->
    
	<!-- BEGIN THEME STYLES --> 
	<link href="{{ theme_path() }}css/style-metronic.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/style.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/plugins.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="{{ theme_path() }}css/pages/login-soft.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/custom.css" rel="stylesheet" type="text/css"/>
	<!-- END THEME STYLES -->
    <link rel="shortcut icon" href="{{ base_url() }}favicon.ico" />
</head>
<!-- BEGIN BODY -->
<body class="login">
	<!-- BEGIN LOGO -->
	<div class="logo">
		<img src="{{ base_url() }}uploads/system/workwise-login-logo.png" class="img-responsive" alt="Workwise" /> 
	</div>
	<!-- END LOGO -->
	<!-- BEGIN LOGIN -->
	<div class="content">
		@include('forms/login')        
		@include('forms/forgot_pass')
		@include('forms/reset_pass')
	</div>
	<!-- END LOGIN -->
	<!-- BEGIN COPYRIGHT -->
	<div class="copyright">
		<span style="color:#fff">{{ date('Y') }} {{ $system['copyright_details'] }}</span> by <a class="text-muted" href="http://www.hdisystech.com" target="_blank">{{ $system['author'] }}</a>
	</div>
	<!-- END COPYRIGHT -->
	<script>
		const base_url = '{{ base_url($lang) }}/';
		const root_url = '{{ base_url() }}';
	</script>

	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->   
	<!--[if lt IE 9]>
	<script src="{{ theme_path() }}plugins/respond.min.js"></script>
	<script src="{{ theme_path() }}plugins/excanvas.min.js"></script> 
	<![endif]-->   
	<script src="{{ theme_path() }}plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="{{ theme_path() }}plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}scripts/underscore.js" type="text/javascript"></script> 
	<script src="{{ theme_path() }}scripts/backbone.js" type="text/javascript"></script> 
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="{{ theme_path() }}plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>	
	<script src="{{ theme_path() }}plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/select2/select2.min.js"></script>     
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="{{ theme_path() }}scripts/app.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}scripts/login.js" type="text/javascript"></script> 
	<!-- END PAGE LEVEL SCRIPTS --> 
	
	<!-- Add Module JS -->
	{{ get_module_js( $mod ) }}

	<script>
		jQuery(document).ready(function() {    
		  App.init();
		  Login.init();

		  jQuery('.reset-form').show();
		  jQuery('#back-btn').hide();
		});
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
