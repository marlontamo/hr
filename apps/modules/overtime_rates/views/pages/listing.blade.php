@extends('layouts.master')

@section('theme_styles')
@parent
	<link href="<?php echo theme_path(); ?>plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
@stop

@section('page_content')
	@parent
   
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="row">
		<div class="col-md-9">
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption"><i class="fa {{ $mod->icon}}"></i>List of {{ $mod->short_name }}</div>
					<div class="caption" id="head-caption">&nbsp;</div>
					<div class="actions">
						@if( isset( $permission['add']) && $permission['add'] )
							<a id="goadd" href="{{ $mod->url }}/add" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></a>
						@endif
						@if( isset( $permission['delete']) && $permission['delete'] )
							<a href="javascript:delete_records()" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
						@endif
					</div>
				</div>
	            <div class="portlet-title">
	            @include('common/employee_filter')
	        	</div>
				<div class="clearfix">
					<table id="record-table" class="table table-condensed table-striped table-hover">
	                    <thead>
	                        <tr>
	                            @include('list_template_header')
	                        </tr>
	                    </thead>
	                    <tbody id="record-list"></tbody>
	                </table>
	                <div id="no_record" class="well" style="display:none;">
						<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }}</p>
						<span><p class="small margin-bottom-0">{{ lang('common.zero_record') }}</p></span>
					</div>
					<div id="select_company" class="well" style="display:none;">
						<p class="bold"><i class="fa fa-exclamation-triangle"></i> Filter Company </p>
						<span><p class="small margin-bottom-0">Select company to display partners' list of overtime</p></span>
					</div>
					<div id="loader" class="text-center"><img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." /> {{ lang('common.get_record') }}</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 visible-lg visible-md">
			<div class="portlet">
				<div class="clearfix margin-bottom-20">
                	@include('common/search-form')
				</div>
			</div>
		</div>
	</div>
	<!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('page_plugins')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/common/lists.js"></script>
	<script type="text/javascript" src="<?php echo theme_path(); ?>plugins/select2/select2.min.js"></script>
@stop

@section('view_js')
	@parent
	{{ get_list_js( $mod ) }}
@stop
