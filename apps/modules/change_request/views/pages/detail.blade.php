@extends('layouts/master')
@section('page_styles')
	@parent
	<link href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css" rel="stylesheet" type="text/css"/>
@stop
@section('page_content')
	@parent

	<div class="row">
        <div class="col-md-11">
			@include('detail/fgs')
			@include('buttons/detail')
       	</div>  		
	</div>
@stop

@section('page_scripts')
	@parent
	<script src="{{ theme_path() }}plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript" ></script>
	@include('edit/page_scripts')

@stop