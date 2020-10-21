@extends('layouts.master')

@section('page_styles')
	@parent
	<link href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/jquery-multicheckbox/jquery.multiselect.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/jquery-multicheckbox/jquery.multiselect.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
	<link href="{{ theme_path() }}css/pages/portfolio.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
@stop

@section('page_content')
	@parent
   
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="row">
		<div class="col-md-9">
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption"><i class="fa {{ $mod->icon}}"></i>{{ $current_group->group_name }}</div>
					<div class="caption" id="head-caption">&nbsp;</div>
				</div>
				<div class="clearfix">
					@include('dashboard/files')
				</div>
			</div>
		</div>
		<div class="col-md-3 visible-lg visible-md">
			<div class="portlet">				
                @include('files/list_filter')
			</div>
		</div>
	</div>
	<!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('page_plugins')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/common/lists.js"></script>
	<script src="{{ theme_path() }}plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
@stop

@section('view_js')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}modules/{{ $mod->mod_code }}/files.js"></script>
@stop
