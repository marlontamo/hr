@extends('layouts.master')

@section('page_styles')
	<link href="{{ theme_path() }}plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-modal/css/bootstrap-modal.css" />
	<script src="http://maps.google.com/maps/api/js?key=AIzaSyBVhkH3UXaTs1zNn6QCipCgwysucteT1NY&sensor=true" type="text/javascript"></script>
	<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyBVhkH3UXaTs1zNn6QCipCgwysucteT1NY&sensor=true"></script>
	 <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfjkuSkOClNZ6LWSxg_4PokCr6GNw2xUw" type="text/javascript"></script> -->
	<script src="{{ theme_path() }}plugins/gmaps/gmaps.js" type="text/javascript"></script> 
	<!-- <script src="{{ theme_path() }}scripts/maps-google.js" type="text/javascript"></script> -->
	<style>
	#gmap_marker {
	    width: 100%;
	    height: 100%;
	}
	</style>
@stop

@section('page_content')
	@parent
	@include('dashboard')
@stop

@section('page_plugins')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}plugins/flot/jquery.flot.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/flot/jquery.flot.resize.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/flot/jquery.flot.pie.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/flot/jquery.flot.stack.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/flot/jquery.flot.crosshair.js"></script>
	<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
  	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-modal/js/bootstrap-modal.js" ></script>

@stop

@section('view_js')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}modules/demographic/charts.js"></script>
@stop
