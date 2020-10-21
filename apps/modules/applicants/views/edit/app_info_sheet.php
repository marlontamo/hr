@extends('layouts.master')

@section('page_styles')
@parent	
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/data-tables/DT_bootstrap.css" />
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
					<a href="<?php echo get_mod_route('applicants');?>"><button type="button" class="btn blue">
					<span>Back</span>
					</button></a>
				</li>
				<li>
					<i class="fa fa-home"></i>
					<a href="{{ site_url('dashboard') }}">Home</a> 
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
{{ test }}

@stop

@section('page_plugins')
@parent
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript" ></script>
    
<script type="text/javascript" src="{{ theme_path() }}plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="{{ theme_path() }}plugins/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="{{ theme_path() }}plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript" ></script>
<!-- Additional for FORM COMPONENTS -->
<script src="{{ theme_path() }}plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript" ></script> 
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
	
	<script type="text/javascript" src="{{ theme_path() }}modules/applicants/edit_custom.js"></script>   

@stop



