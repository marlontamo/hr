@extends('layouts/master')

@section('page_styles')
	@parent
	@include('detail/page_styles')
@stop

@section('page-breadcrumb')
	<ul class="page-breadcrumb breadcrumb">
		@section('page-breadcrumb-back')
			<li class="btn-group">
				<a href="{{ get_mod_route('user_manager') }}"><button class="btn blue" type="button">
				<span>{{ lang('employment_status.back') }}</span>
				</button></a>
			</li>
		@show
		<li>
			<i class="fa fa-home"></i>
			<a href="{{ base_url('') }}">{{ lang('employment_status.home') }}</a> 
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="{{ get_mod_route('user_manager') }}">{{ lang('employment_status.user_manager') }}</a>
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
        <div class="col-md-11">
			<form class="form-horizontal">
				<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
				@include('detail/fgs')
				@include('buttons/detail')
			</form>
       	</div>  
    		
	</div>
@stop

@section('page_plugins')
	@parent
	@include('detail/page_plugins')
@stop

@section('page_scripts')
	@parent
	@include('detail/page_scripts')
	<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script> 
@stop

@section('view_js')
	@parent
	{{ get_edit_js( $mod ) }}
@stop