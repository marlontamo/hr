<meta charset="utf-8" />
<title><?php echo $mod->short_name ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta content="{{ $system['description'] }}" name="description" />
<meta content="{{ $system['author'] }}" name="author" />
<meta name="keywords" content="{{ $system['keywords'] }}" />
<meta name="copyright" content="{{ $system['copyright'] }}" />
<meta name="MobileOptimized" content="320">
<link rel="shortcut icon" href="{{ base_url() }}favicon.ico" />

@section('mandatory_styles')
	<!-- BEGIN GLOBAL MANDATORY STYLES -->          
	<link href="{{ theme_path() }}plugins/jquery-ui/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
	<link type="text/css" rel="stylesheet" href="{{ theme_path() }}plugins/fancybox/source/jquery.fancybox.css">
	@if( get_system_config('other_settings', 'enable_chat') )
	<link href="{{ theme_path() }}plugins/chat/css/jquery.chatjs.css" rel="stylesheet" type="text/css"/>
	@endif

	<!-- link rel="stylesheet" type="text/css" href="{{ theme_path() }}css/emoji_one_area2/emojionearea.min.css" / -->
	<!-- link rel="stylesheet" type="text/css" href="{{ theme_path() }}css/emoji_one_area2/emojione.min.css" / -->
	<!-- link rel="stylesheet" type="text/css" href="{{ theme_path() }}scripts/facemocion/faceMocion.css" / -->
	
	<style type="text/css">
		/*.emojione {
		    font-size: inherit;
		    height: 2ex;
		    width: 2.1ex;
		    min-height: 20px;
		    min-width: 20px;
		    display: inline-block;
		    margin: -.2ex .15em .2ex;
		    line-height: normal;
		    vertical-align: middle;
		    max-width: 100%;
		    top: 0;
		    background-image: none;
		}*/
		.chat-form .btn-cont{
			z-index: 11000;
		}
	</style>
	<!-- END GLOBAL MANDATORY STYLES -->
@show

@section('page_styles')
@show

@section('theme_styles')
	<!-- BEGIN THEME STYLES --> 
	<link href="{{ theme_path() }}css/style-metronic.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/style.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/plugins.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/pages/tasks.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/themes/grey.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="{{ theme_path() }}css/custom.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}css/game.css" rel="stylesheet" type="text/css"/>
	<!-- END THEME STYLES -->
@show