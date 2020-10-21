@extends('layouts.master')

@section('page_content')
	@parent
   
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="row">
		<div class="col-md-9">
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption"><i class="fa {{ $mod->icon}}"></i>{{ $current_group->group_name }}</div>
					<div class="caption" id="head-caption">&nbsp;</div>
				</div>
				<div class="clearfix">
					@include('dashboard/members')
				</div>
			</div>
		</div>
		<div class="col-md-3 visible-lg visible-md">
			<div class="portlet">				
                @include('members/list_filter')
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
	<script type="text/javascript" src="{{ theme_path() }}modules/{{ $mod->mod_code }}/members.js"></script>
@stop
