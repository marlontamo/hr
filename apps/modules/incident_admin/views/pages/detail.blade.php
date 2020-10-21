@extends('layouts/master')

@section('page_styles')
	@parent
	<link href="{{ theme_path() }}plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>
	<link type="text/css" rel="stylesheet" href="{{ theme_path() }}plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" />
	<link type="text/css" rel="stylesheet" href="{{ theme_path() }}plugins/bootstrap-tagsinput/app.css">
	<link href="{{ theme_path() }}plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
@stop

@section('page_content')
	@parent

	<div class="row">
        <div class="col-md-9">
			<form >
				<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
				@include('detail/fgs')
				@include('buttons/detail')
			</form>
       	</div>  
    	<div class="col-md-3 visible-lg visible-md">
			<div class="portlet">
				<div class="clearfix margin-bottom-20">
					@include('common/search-form')
					<div class="actions margin-top-20 clearfix">
						<span class="pull-left"><a class="text-muted" href="{{ $mod->url }}">{{ lang('incident_admin.back_to_list') }} &nbsp;<i class="m-icon-swapright"></i></a></span>
						<span class="pull-right"><a class="text-muted" id="trash">{{ lang('common.trash_folder') }} <i class="fa fa-trash-o"></i></a></span>
					</div>
				</div>
			</div>
		</div>		
	</div>
@stop

@section('page_plugins')
	@parent
	<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-tagsinput/typeahead.js"></script>
	<script src="{{ theme_path() }}plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script> 
@stop

@section('page_scripts')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}modules/incident_admin/detail.js"></script> 
@stop