@extends('layouts.master')

@section('theme_styles')
	@parent
	<link href="<?php echo theme_path(); ?>plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
@stop

@section('page_content')
	@parent

	<div class="row">

	    <div class="col-md-11">

	        <!-- Listing -->
	        <div class="portlet" id="list">

	            <div class="breadcrumb hidden-lg hidden-md">
	                <div class="block input-icon right">
	                    <i class="fa fa-search"></i>
	                    <input type="text" placeholder="Search..." class="form-control">
	                </div>
	            </div>

	            <div class="portlet-title">
	                <div class="caption" id="class-title">Time Shift Class</div>
	                <div class="actions margin-bottom-10">
	                </div>
	            </div>

	            <div class="portlet-title">
	            @include('company_shift_filter')
	        	</div>

	            <div class="portlet-body">
	                <!-- Table -->

	                <div id="loader" class="text-center" style="display: none;">
					    <img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." />Fetching record(s)
					</div>

					<div id="no_record" class="well" >
					    <p class="bold"><i class="fa fa-exclamation-triangle"></i> No record/s found!</p>
					    <span><p class="small margin-bottom-0">No available Time Shift Class.</p></span>
					</div>

	                <table id="list-table" class="table table-condensed table-hover" style="display: none;">
	                    <thead>
	                        <tr>
								<!-- th width="17%">Company</th -->
								<th width="30%" class="hidden-xs">Class</th>
								<th width="18%">Shift</th>
								<th width="22%" class="hidden-xs">Value</th>
	                            <th width="12%" class="hidden-xs">Actions</th>
	                        </tr>
	                    </thead>

	                    <tbody id="list-time-class" >
	                    	
	                    </tbody>
	                </table>

	                <!-- End Table -->
	            </div>

	        </div>


	    </div>

	    <div class="col-md-1 visible-lg visible-md">
	        <div class="portlet">
				<div class="clearfix">
                	<!-- @include('common/search-form') -->
				</div>
	        </div>
	    </div>

	</div>
@stop

@section('page_plugins')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
@stop

@section('view_js')
	@parent
	{{ get_list_js( $mod ) }}
	<script type="text/javascript" src="<?php echo theme_path(); ?>plugins/select2/select2.min.js"></script>
@stop