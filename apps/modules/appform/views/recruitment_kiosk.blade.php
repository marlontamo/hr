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
	<title>{{ $system['application_title'] }} Application</title>
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
	<link href="{{ theme_path() }}plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL SCRIPTS -->
    
	<!-- BEGIN THEME STYLES --> 
	<link href="{{ theme_path() }}css/style-metronic.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/style.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/plugins.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="{{ theme_path() }}css/pages/login-soft.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="{{ theme_path() }}css/pages/recruitment-kiosk.css" rel="stylesheet" type="text/css"/>
	<!-- END THEME STYLES -->
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" />

    <link rel="shortcut icon" href="{{ base_url() }}favicon.ico" />
</head>
<!-- BEGIN BODY -->
<body class="rec-kiosk">
	<!-- BEGIN LOGO -->
<!-- 	<div class="logo">
		<img src="{{ theme_path() }}img/workwise-login-logo.png" style="height: 180px; margin-top: -28px;" alt="Workwise" /> 
	</div> -->

	<!-- END LOGO -->
    
	<!-- BEGIN rec-kiosk -->
	<div class="content">
		<!-- BEGIN rec-kiosk FORM -->
		<form class="rec-kiosk-form form-horizontal" id="form-1" partner_id="1" method="post">
		<input type="hidden" value="" name="record_id" id="record_id">
			<h4 class="kiosk-title">{{ lang('appform.app_form') }}</h4>
			<hr class="rec-kiosk-title">
			<div class="message_app_div" style="display:none">
				<br />
				<p>{{ lang('appform.msg_appreciation') }}</p>
				<p></p>
			</div>
			<button style="display:none" type="submit" class="btn-success pull-right btn_close">
				{{ lang('appform.nice_day') }}<i class="m-icon-swapright m-icon-white"></i>
			</button> 
			@include('forms/general')   
		
            <hr class="rec-kiosk-title">
           
			@include('forms/contacts')  
			@include('forms/buttons')  

		</form>
		
		<!-- END rec-kiosk FORM --> 
	</div>
	
	<!-- END rec-kiosk -->
	<!-- BEGIN COPYRIGHT -->
	<div class="copyright">
		<?php echo date('Y'); ?> {{ $system['copyright'] }}
	</div>
	<!-- END COPYRIGHT -->
	<script>
		const base_url = '{{ base_url($lang) }}/';
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
	
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript" ></script>
    
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="{{ theme_path() }}plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>	
	<script src="{{ theme_path() }}plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/select2/select2.min.js"></script>     
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="{{ theme_path() }}scripts/app.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
	<!--<script src="{{ theme_path() }}modules/common/global.js" type="text/javascript"></script> -->
	<script src="{{ theme_path() }}modules/appform/edit_custom.js" type="text/javascript"></script> 
	<!-- END PAGE LEVEL SCRIPTS --> 
	
	<!-- Add Module JS -->
	{{ get_module_js( $mod ) }}
	<script>
		jQuery(document).ready(function() {     
		  App.init();
		  // FormComponents.init();
		});
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>