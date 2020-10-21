@extends('layouts/master')

@section('page_styles')
	@parent
	@include('appraisers_review/page_styles')
	@include('appraisers_review/page_styles')
@stop

@section('page_content')
	@parent

	<div class="row">
        <div class="col-md-12">
			<form class="form-horizontal" id="planning-form">
				<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
				@include('appraisers_review/fgs')
			</form>
       	</div>  		
	</div>
@stop

@section('page_plugins')
	@parent
	@include('appraisers_review/page_plugins')
	<script type="text/javascript" src="{{ theme_path() }}plugins/garlic/garlic.js"></script> 
	@include('appraisers_review/page_plugins')
@stop

@section('page_scripts')
	@parent
	@include('appraisers_review/page_scripts')
	@include('appraisers_review/page_scripts')
	<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script> 
	<script type="text/javascript" src="{{ theme_path() }}modules/{{ $mod->mod_code }}/review.js"></script> 
@stop

@section('view_js')
	@parent
	{{ get_edit_js( $mod ) }}
@stop