@extends('layouts.master')

@section('page-breadcrumb')
	<ul class="page-breadcrumb breadcrumb">
		@section('page-breadcrumb-back')
			<li class="pull-right btn-group" style="position:relative;">
				<a href="{{ site_url('payroll/setup') }}"><button class="btn blue" type="button">
				<span>Back</span>
				</button></a>
			</li>
		@show
		<li class="btn-group">
			<button data-close-others="true" data-delay="1000" data-hover="dropdown" data-toggle="dropdown" class="btn blue dropdown-toggle" type="button">
			<span></span> <i class="fa fa-angle-down"></i>
			</button>
			<ul role="menu" class="dropdown-menu pull-right">
				<li><a href="{{ $mod->url }}"><i class="fa fa-refresh"></i> Refresh</a></li>
				
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
			<a href="{{ site_url('payroll/setup') }}">{{ lang('closed_transaction.payroll_setup') }}</a>
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
				<div class="clearfix">
					<table id="record-table" class="table table-condensed table-striped table-hover">
	                    <thead>
	                        <tr>
	                            <th width="1%" class="hidden-xs">
	                                <div>
	                                    <span><input type="checkbox" class="group-checkable" data-set=".record-checker"></span>
	                                </div>
	                            </th>
	                            @include('list_template_header')
	                            <th width="5%">
	                                {{ lang('common.actions') }}
	                            </th>
	                        </tr>
	                    </thead>
	                    <tbody id="record-list"></tbody>
	                </table>
	                <div id="no_record" class="well" style="display:none;">
						<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }}</p>
						<span><p class="small margin-bottom-0">{{ lang('common.zero_record') }}</p></span>
					</div>
					<div id="loader" class="text-center"><img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." /> {{ lang('common.get_record') }}</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 visible-lg visible-md">
			<div class="portlet">
				<div class="clearfix margin-bottom-20">
                	@include('common/search-form')
                	<div class="actions margin-top-20 clearfix">
	                	<span class="pull-right"><a class="text-muted" id="trash" href="javascript:view_trash()">{{ lang('common.trash_folder') }} <i class="fa fa-trash-o"></i></a></span>
					</div>
				</div>
				
                @include('list_filter')
			</div>
		</div>
	</div>
	<!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('page_plugins')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/common/lists.js"></script>
@stop

@section('view_js')
	@parent
	{{ get_list_js( $mod ) }}
@stop
