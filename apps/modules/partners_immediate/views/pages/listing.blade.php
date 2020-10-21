@extends('layouts.master')

@section('page_styles')
	@parent	
	<link href="{{ theme_path() }}plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css"/>
	@stop

@section('page_content')
@parent

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="row">
	<div class="col-md-9">
		<div class="portlet">
			<div class="portlet-title">
				<!-- div class="caption"><i class="fa {{ $mod->icon}}"></i>List of {{ $mod->short_name }}</div -->
				<div class="caption" id="head-caption">&nbsp;</div>
				<div class="actions">
            		@if( array_key_exists('add', $permission))
	        			@if( $permission['add'] == 1 )
							<a id="goadd" href="javascript:add_partners('')" class="btn btn-success"><i class="fa fa-plus"></i></a>
	        			@endif
	        		@endif
            		@if( array_key_exists('delete', $permission))
	        			@if( $permission['delete'] == 1 )
							<a href="javascript:delete_records()" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
	        			@endif
        			@endif
				</div>
			</div>
			<div class="clearfix">
				<table id="record-table" class="table table-condensed table-striped table-hover">
					<thead>
						<tr>
							<th width="1%">
								<div>
									<span><input type="checkbox" class="group-checkable" data-set=".record-checker"></span>
								</div>
							</th>
							@include('list_template_header')
							<th width="20%">
								{{ lang('common.actions') }}
							</th>
						</tr>
					</thead>
					<tbody id="record-list"></tbody>
				</table>
				<div id="no_record" class="well" style="display:none;">
					<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }}</p>	
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

			<div class="clearfix margin-bottom-20 hidden">
				<h4>Filter Items:</h4>
				<div class="list-group">
					<a class="list-group-item active bg-blue" href="#"><i class="fa fa-check-square-o"></i> All User</a>
					<a class="list-group-item" href="#"><i class="fa fa-square-o"></i> HR Admin</a>
					<a class="list-group-item" href="#"><i class="fa fa-square-o"></i> Manager</a>
					<a class="list-group-item" href="#"><i class="fa fa-square-o"></i> Supervisor</a>
					<a class="list-group-item" href="#"><i class="fa fa-square-o"></i> Rank and File</a>
				</div>
			</div>
		</div>
	</div>
</div>
	<div class="modal fade partner-modal modal-container" tabindex="-1" aria-hidden="true" data-width="600"></div>
<!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('page_plugins')
@parent
<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-switch/static/js/bootstrap-switch.min.js"></script>
<script src="{{ theme_path() }}scripts/ui-extended-modals.js"></script> 
@stop

@section('page_scripts')
@parent
<script type="text/javascript" src="{{ theme_path() }}modules/partners_immediate/lists_custom.js"></script>
@stop

@section('view_js')
@parent
@stop