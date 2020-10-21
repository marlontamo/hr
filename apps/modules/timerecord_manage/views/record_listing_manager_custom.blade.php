@extends('layouts.master')

@section('page_styles')
	@parent
	
	<style>
		.popover {min-width: 400px !important;}
    </style>    
    
@stop

@section('theme_styles')
	@parent
	<link href="{{ theme_path() }}plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css"/>
@stop

@section('page_content')
	@parent

	<div class="row">

	    <div class="col-md-9">

	        <!-- Listing -->
	        <div class="portlet" >

	            <div class="breadcrumb hidden-lg hidden-md hidden-sm hidden-xs">
	                <div class="block input-icon right">
	                    <i class="fa fa-search"></i>
	                    <input type="text" placeholder="Search..." class="form-control">
	                </div>
	            </div>
				<div class="portlet-body">
					<div >
						<ul class="nav nav-tabs ">
							@if ($permission_tr_personal)
							<li class=""><a href="{{ get_mod_route('timerecord') }}">{{ lang('common.personal') }}</a></li>
								@if($mod->is_dtru_applicable())
								<li class=""><a href="{{ get_mod_route('timerecord') }}/updating">Updating</a></li>
								@endif
							@endif
							@if ($permission_tr_manage)
							<li class="active"><a href="{{ get_mod_route('timerecord_manage') }}">{{ lang('common.manage') }}</a></li>
							<!-- <li class="active"><a href="{{ get_mod_route('timerecord_manage') }}">Manage by date</a></li> -->
							@endif
						</ul>
					</div>
				</div>

			<!-- SECTION 2 -->
				<!-- <div class="portlet"> -->
					<div class="portlet-body">
						<!-- <div class="row profile">
							<div class="col-md-12">
								<div class="tabbable tabbable-custom tabbable-full-width"> -->
									<!-- <ul class="nav nav-tabs" style="float:right;"> -->
									<ul class="nav nav-pills margin-top-25" >
										<li class="active">
											<a data-toggle="tab" href="#profile_tab_1" id="tab_by_employee">
											<i class="fa fa-user"></i>&nbsp;By Employee</a>
										</li>
										<li class="">
											<a data-toggle="tab" href="#profile_tab_2" id="tab_by_date">
											<i class="fa fa-calendar"></i>&nbsp;By Date</a>
										</li>
									</ul>
									<div class="tab-content">
										<!-- OVERVIEW -->
										<div id="profile_tab_1" class="tab-pane active">
											<div class="margin-bottom-15">
												<span class="small text-muted">Select name of employee to show specific dtr.</span>
											</div>
											@include('tabs/by_employee')
										</div>
										<!-- HISTORY -->
										<div id="profile_tab_2" class="tab-pane">
											<div class="margin-bottom-15">
												<span class="small text-muted">Select date to view dtr of your subordinates.</span>
											</div>
											@include('tabs/by_date')
										</div>
									</div>
								</div><!-- 
							</div>
						</div>
					</div>    -->
				<!-- </div> -->
			<!-- END SECTION 2 -->

	        </div>
	  
	    </div>


	    <div class="col-md-3 by_date_filter hidden">
	        <div class="portlet" style="margin-top:13px;">

	            <div class="portlet-title" style="margin-bottom:3px;">
	                <div class="caption">Link</div>
	            </div>
	            <div class="portlet-body">
	                
	                <div class="margin-top-10">
	                    <a href="{{ get_mod_route('my_calendar') }}" class="label label-success">My Calendar</a>
	                </div>
	            </div>

	        </div>
	    </div>


	    <div class="col-md-3 visible-lg visible-md by_employee_filter">
	        <div class="portlet">

	            <style>
	                .event-block {
	                    cursor: pointer;
	                    margin-bottom: 5px;
	                    display: inline-block;
	                    position: relative;
	                }
	            </style>

	            <div class="portlet-title" style="margin-bottom:3px;">
	                <div class="caption">Calendar Month</div>
	            </div>


	            <div class="portlet-body">

	                <span class="small text-muted margin-bottom-10">
	                	Show inclusive date per calendar month
	                </span>
	                
	                <div id="sf-container" class="margin-top-10">
	                    <span id="yr-fltr-prev" data-year-value="{{$prev_year['value']}}" class="event-block label label-info year-filter">
	                    	{{$prev_year['value']}}
	                    </span>
	                    
	                    <!-- </a> -->
	                    
	                    <!-- ml stands for month list -->
	                    @foreach($month_list as $month_key => $month_value)
	                    	<span id="ml-{{$month_key}}" data-month-value="{{$month_key}}" class="event-block label label-default month-list">
	                    		{{$month_value}}
	                    	</span>
	                    @endforeach

	                    <span id="yr-fltr-next" data-year-value="{{$next_year['value']}}" class="event-block label label-info year-filter">
	                    	{{$next_year['value']}}
	                    </span>
	                </div>
	            </div>


	            <div class="portlet-title margin-top-20" style="margin-bottom:3px;">
	                <div class="caption">Pay dates</div>
	            </div>
	            <div class="portlet-body">
	                <span class="small text-muted">Show inclusive date for the last 5 pay dates</span>
	                <div id="period-filter-container" class="margin-top-10">
	                </div>
	            </div>

	            <div class="portlet-title margin-top-20" style="margin-bottom:3px;">
	                <div class="caption">Link</div>
	            </div>
	            <div class="portlet-body">
	                
	                <div class="margin-top-10">
	                    <a href="{{ get_mod_route('my_calendar') }}" class="label label-success">My Calendar</a>
	                </div>
	            </div>

	        </div>
	    </div>

	</div>
@stop


@section('view_js')
	@parent
	<script src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>
	<script type="text/javascript" src="<?php echo theme_path(); ?>plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/timerecord_manage/manage.js"></script>

	<script type="text/javascript">
        $(document).ready(function(){

        	// $("#partner-filter").select2({
        	// 	placeholder: "Select a partner...",
        	// });

			$('#partner-filter').select2({
			    placeholder: "Select an option",
			    allowClear: true
			});

        	$("#sub-filter").select2({
        		placeholder: "Select a partner...",
        	});

			if (jQuery().datepicker) {
			    $('#selected_date').parent('.date-picker').datepicker({
			        rtl: App.isRTL(),
			        autoclose: true
			    });
			    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
			}
        }); 
    </script>
@stop
