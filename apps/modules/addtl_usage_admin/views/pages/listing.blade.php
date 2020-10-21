@extends('layouts.master')

@section('page-header')
	
	<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<h3 class="page-title">
			{{ $mod->long_name }} <small>{{ $mod->description }}</small>
		</h3>
		<ul class="page-breadcrumb breadcrumb">
			<li class="btn-group">
				<a href="{{ $detail_url }}"><button class="btn blue" type="button">
				<span>Back</span>
				</button></a>
			</li>
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ base_url('') }}">Home</a> 
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<!-- jlm i class="fa {{ $mod->icon }}"></i -->
				<a href="{{ $mod->url }}">{{ $mod->long_name }}</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>{{ ucwords( $mod->method )}}</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>

@stop

@section('page_content')
	@parent
   
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="row">
		<div class="col-md-9">

			<!-- EMPLOYEES INFO-->
        	<div class="portlet">
        		<div class="portlet-title">
					<div class="caption">Additional Leave Details</div>
					<div class="tools">
						<a class="collapse" href="javascript:;"></a>
						</div>
				</div>
				<div class="portlet-body">
					<!-- Table - fields should be read only.-->
                	<table class="table table-bordered table-striped">
						<tbody>
							<tr class="success">
								<td>
									<div class="form-group">
										<label class="control-label col-md-3 bold">Employee</label>
										<div class="col-md-9">
											<input disabled type="text" class="form-control" value="{{ $name }}">
										</div>
									</div>
								</td>
								<td>
									<div class="form-group">
										<label class="control-label col-md-3 bold">Date Hired</label>
										<div class="col-md-9">
											<input disabled type="text" class="form-control" value="{{ date( 'F d, Y', strtotime($date_hired) ) }}">
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="portlet">
				<div class="portlet-body">
					<div >
						<ul class="nav nav-tabs ">
							@if ($addtl_credit)
								<li class=""><a href="{{ get_mod_route('addtl_credit_admin', 'index/'.$user_id) }}">Credit</a></li>
							@endif
							@if ($addtl_usage)
								<li class="active"><a href="{{ get_mod_route('addtl_usage_admin', 'index/'.$user_id) }}">Usage</a></li>
							@endif
						</ul>
					</div>
				</div>
				<div class="portlet-title">
					<div class="caption hidden"><i class="fa {{ $mod->icon}}"></i>List of {{ $mod->short_name }}</div>
					<div class="caption" id="head-caption">&nbsp;</div>

					<div class="actions">
						@if( isset( $permission['add']) && $permission['add'] )
							<!-- <a id="goadd" href="{{ $mod->url }}/add" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></a> -->
						@endif
						@if( isset( $permission['delete']) && $permission['delete'] )
							<!-- <a href="javascript:delete_records()" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a> -->
						@endif
					</div>
				</div>
				<div class="clearfix">
					<input type="hidden" name="form_id" value="{{$form_id}}">
					<input type="hidden" name="user_id" value="{{$user_id}}">
					<!-- <input type="hidden" name="period_from" value="{{$period_from}}">
					<input type="hidden" name="period_to" value="{{$period_to}}">
					<input type="hidden" name="year" value="{{$year}}">
					<input type="hidden" name="addl_type" value="{{$addl_type}}"> -->

					<table id="record-table" class="table table-condensed table-striped table-hover">
	                    <thead>
	                        <tr>
	                            <!-- <th width="1%" class="hidden-xs">
	                                <div>
	                                    <span><input type="checkbox" class="group-checkable" data-set=".record-checker"></span>
	                                </div>
	                            </th> -->
	                            @include('list_template_header')
	                            <th width="20%">
	                                Actions
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
