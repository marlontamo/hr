@extends('layouts.master')

@section('page_content')
	@parent
	<div class="row">
		@include('filter/region')
		@include('filter/group')
		@include('filter/company')	
	</div>
@stop

@section('page_plugins')
	@parent

@stop

@section('view_js')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}modules/business_structure/setup.js"></script>
@stop
