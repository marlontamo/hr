@extends('layouts/master')

@section('page_styles')
	@parent
	@include('edit/page_styles')
@stop

@section('page-breadcrumb')
	<ul class="page-breadcrumb breadcrumb">
		@section('page-breadcrumb-back')
			<li class="btn-group">
				<a href="{{ get_mod_route('healthinfo') }}"><button class="btn blue" type="button">
				<span>Back</span>
				</button></a>
			</li>
		@show
		<li>
			<i class="fa fa-home"></i>
			<a href="{{ base_url('') }}">Home</a> 
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="{{ get_mod_route('healthinfo') }}">{{ lang('clinicrecords.health_info') }}</a>
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
				@include('edit/fgs')
				@include('buttons/edit')
			</form>
       	</div>  
    		
	</div>
@stop

@section('page_plugins')
	@parent
	@include('edit/page_plugins')
@stop

@section('page_scripts')
	@parent
	@include('edit/page_scripts')
	<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script> 
@stop

@section('view_js')
	@parent
	{{ get_edit_js( $mod ) }}
@stop