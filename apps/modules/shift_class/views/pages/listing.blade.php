@extends('layouts.master')

@section('page_content')
	@parent
   
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="row">

				<div class="col-md-3">

					<!-- Listing -->
					<div class="portlet" id="list">
                    
                    	<div class="breadcrumb hidden-lg hidden-md">
                            <div class="block input-icon right">
                                <i class="fa fa-search"></i>
                                <input type="text" placeholder="Search..." class="form-control">
                            </div>
                        </div>
                    
						<div class="portlet-title">
							<div class="caption">Class</div>
						</div>		

						<div class="portlet-body">
							<table class="table table-condensed table-striped table-hover">
								<tbody>
								@foreach( $shift_classes as $shift_class )
									<tr rel="1">
										<td><input type="checkbox" class="checkboxes shift_classes" value="{{ $shift_class['class_id'] }}" /></td>
										<td class="text-muted">{{ $shift_class['class_code'] }}</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>

							<!-- End Table -->
						</div>
					</div>
				</div>
                
				<div class="col-md-3">

					<!-- Listing -->
					<div class="portlet" id="list">
                    
                    	<div class="breadcrumb hidden-lg hidden-md">
                            <div class="block input-icon right">
                                <i class="fa fa-search"></i>
                                <input type="text" placeholder="Search..." class="form-control">
                            </div>
                        </div>
                    
						<div class="portlet-title">
							<div class="caption">Shift</div>
						</div>		

						<div class="portlet-body">
							<!-- Table -->

							<table class="table table-condensed table-striped table-hover">
								<tbody>
								@foreach( $shifts as $shift )
									<tr rel="1">
										<td><input type="checkbox" class="checkboxes shifts" value="{{ $shift['shift_id'] }}" /></td>
										<td class="text-muted">{{ $shift['shift'] }}</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>

							<!-- End Table -->
						</div>
					</div>

				</div>

				<div class="col-md-6">

					<!-- Listing -->
					<div class="portlet" id="list">
                    
                    	<div class="breadcrumb hidden-lg hidden-md">
                            <div class="block input-icon right">
                                <i class="fa fa-search"></i>
                                <input type="text" placeholder="Search..." class="form-control">
                            </div>
                        </div>
                    
						<div class="portlet-title">
							<div class="caption">Company</div>
						</div>		

						<div class="portlet-body">
							<!-- Table -->

							<table id="list-table" class="table table-condensed table-hover">
								<thead>
									<tr>
										<th width="40%">Name</th>
										<th width="20%">Config</th>
										<th width="10%">Action</th>
									</tr>
								</thead>
	                    		<tbody id="list-time-class" >
									
								</tbody>
							</table>
			                <div id="no_record" class="well" style="display:none;">
								<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }}</p>
								<span><p class="small margin-bottom-0">{{ lang('common.zero_record') }}</p></span>
							</div>
							<div id="loader" class="text-center"><img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." /> {{ lang('common.get_record') }}</div>

							<!-- End Table -->
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
@stop

@section('view_js')
	@parent
	{{ get_list_js( $mod ) }}
@stop
