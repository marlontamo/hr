@extends('layouts/master')

@section('page_styles')
	@parent
	<link href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>
	<link type="text/css" rel="stylesheet" href="{{ theme_path() }}plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" />
	<link type="text/css" rel="stylesheet" href="{{ theme_path() }}plugins/bootstrap-tagsinput/app.css">
@stop

@section('page-breadcrumb')
	<ul class="page-breadcrumb breadcrumb">
		@section('page-breadcrumb-back')
			<li class="pull-right btn-group" style="position:relative;">
				<a href="{{ $mod->url }}"><button class="btn blue" type="button">
				<span>{{ lang('common.back') }}</span>
				</button></a>
			</li>
		@show
		<li class="btn-group">
			<button data-close-others="true" data-delay="1000" data-hover="dropdown" data-toggle="dropdown" class="btn blue dropdown-toggle" type="button">
			<span></span> <i class="fa fa-angle-down"></i>
			</button>
			<ul role="menu" class="dropdown-menu pull-right">
				<li><a href="#" onclick="print_disciplinary({{$record_id}})"><i class="fa fa-print"></i> Print</a></li>
				
				<li class="hidden import-button"><a href="javascript:void(0)" onclick="mod_import({{ $mod->mod_id }})"><i class="fa fa-cloud-download"></i> Import</a></li>
				<li class="divider hidden"></li>
				<li class="hidden"><a href="#"><i class="fa fa-cloud-upload"></i> Export</a></li>
			</ul>
		</li>
		<li>
			<i class="fa fa-home"></i>
			<a href="{{ base_url('') }}">Home</a> 
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<!-- jlm i class="fa {{ $mod->icon }}"></i -->
			<a href="{{ $mod->url }}">{{ $mod->long_name }}</a>
			@if( $mod->method != "index" )
				<i class="fa fa-angle-right"></i>
			@endif
		</li>
		@if( $mod->method != "index" )
			<li>{{ ucwords( $mod->method )}}</li>
		@endif
	</ul>
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
						<span class="pull-left"><a class="text-muted" href="{{ $mod->url }}">{{ lang('common.back_to_list') }} &nbsp;<i class="m-icon-swapright"></i></a></span>
						<span class="pull-right"><a class="text-muted" id="trash">{{ lang('common.trash_folder') }} <i class="fa fa-trash-o"></i></a></span>
					</div>
				</div>
			</div>
		</div>		
	</div>
@stop

@section('page_plugins')
	@parent
	<script src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-tagsinput/typeahead.js"></script>
@stop

@section('page_scripts')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}modules/incident_admin/detail.js"></script> 
	<script type="text/javascript" src="{{ theme_path() }}modules/disciplinary_admin/detail.js"></script> 
@stop