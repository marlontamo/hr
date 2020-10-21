<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title>{{ $system['application_title'] }} | Lock Screen</title>
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
	<!-- BEGIN THEME STYLES --> 
	<link href="{{ theme_path() }}css/style-metronic.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/plugins.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="{{ theme_path() }}css/pages/lock.css" rel="stylesheet" type="text/css" />
	<link href="{{ theme_path() }}css/custom.css" rel="stylesheet" type="text/css"/>
	<!-- END THEME STYLES -->
    <link rel="shortcut icon" href="{{ base_url() }}favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body>
	<div class="page-lock">
		<div class="page-logo">
			<a class="brand" href="{{ base_url() }}">
			<img src="{{ base_url() }}{{ $system['logo'] }}" class="img-responsive" alt="Emplopad" />
			</a>
		</div>
		<div class="page-body">
			<img class="page-lock-img" src="{{ base_url( $user['photo'] )}}" alt="">
			<div class="page-lock-info">
				<h1>{{ $user['firstname'] .' '. $user['lastname'] }}</h1>
				<span class="email">{{ $user['email'] }}</span>
				<span class="locked">{{ lang('authentication.locked') }}</span>
				<form class="form-inline" id="screenlock">
					<div class="alert alert-danger display-hide">
						<button class="close" data-close="alert"></button>
						<span></span>
					</div>
					<div class="input-group input-medium">
						<input type="password" name="password" class="form-control" placeholder="{{ lang('authentication.password') }}">
						<span class="input-group-btn">        
						<button type="submit" class="btn blue icn-only"><i class="m-icon-swapright m-icon-white"></i></button>
						</span>
					</div>
					<!-- /input-group -->
					<div class="relogin">
						<a href="{{ base_url('logout') }}">{{ lang('authentication.not') }} {{ $user['firstname'] .' '. $user['lastname'] }} ?</a>
					</div>
				</form>
			</div>
		</div>
		<div class="page-footer">
			<span style="color:#fff">{{ date('Y') }} {{ $system['copyright_details'] }}</span> by <a class="text-muted" href="http://www.hdisystech.com" target="_blank">{{ $system['author'] }}</a>
		</div>
	</div>

	<script>
		const base_url = '{{ base_url($lang) }}/';
		const root_url = '{{ base_url() }}';
		const is_mobile = <?php echo is_mobile() ? 'true': 'false'?>;
	</script>

	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->   
	<!--[if lt IE 9]>
	<script src="{{ theme_path() }}plugins/respond.min.js"></script>
	<script src="{{ theme_path() }}plugins/excanvas.min.js"></script> 
	<![endif]-->
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>    
	<script src="{{ theme_path() }}plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="{{ theme_path() }}plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="{{ theme_path() }}plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="{{ theme_path() }}plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL PLUGINS -->   
	<script src="{{ theme_path() }}scripts/app.js"></script>  
	<script src="{{ theme_path() }}scripts/lock.js"></script>

	<!-- Add Module JS -->
	{{ get_module_js( $mod ) }}

	<script>
		jQuery(document).ready(function() {    
		   App.init();
		   Lock.init();
		});
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
