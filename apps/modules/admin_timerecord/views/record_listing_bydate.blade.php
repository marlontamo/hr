@extends('layouts.master')

@section('theme_styles')
	@parent
	<!-- <link href="< ?php echo theme_path(); ?>plugins/select2/select2.css" rel="stylesheet" type="text/css"/> -->
	<link href="{{ theme_path() }}plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap-datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css"/>
@stop

@section('page_content')
	@parent

	<div class="row">

	    <div class="col-md-12">

	        <!-- Listing -->
	        <div class="portlet" >

	            <div class="breadcrumb hidden-lg hidden-md hidden-sm hidden-xs">
	                <div class="block input-icon right">
	                    <i class="fa fa-search"></i>
	                    <input type="text" placeholder="Search..." class="form-control">
	                </div>
	            </div>
				<div class="portlet-body">
					<ul class="nav nav-tabs ">
						<li class="">
						<a href="{{ get_mod_route('admin_timerecord') }}" id="tab_for_review">
						Review
						</a></li>
						<li class="active">
						<a href="{{ get_mod_route('admin_timerecord', 'override') }}" id="tab_for_override">
						Override</a></li>
						<li class="">
						<a data-toggle="tab" href="#period_override_tab" id="tab_for_period_override">
						Period Override</a></li>
					</ul>

					<div class="tab-content">
						<div id="review_tab" class="tab-pane ">
							@include('tabs/tab_review')
						</div>
						<!-- HISTORY -->
						<div id="override_tab" class="tab-pane active">
							<div class="margin-bottom-15">
								<span class="small text-muted">Select specific date to override if necessary.</span>
							</div>
							@include('tabs/tab_override')
						</div>
						<div id="period_override_tab" class="tab-pane">
							<div class="margin-bottom-15">
								<span class="small text-muted">Select specific period to override if necessary.</span>
							</div>
							@include('tabs/tab_period_override')
						</div>
					</div>
				</div>
				
	        </div>


	    </div>


	</div>
@stop


@section('view_js')
	@parent
	{{ get_list_js( $mod ) }}
	<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>
@stop