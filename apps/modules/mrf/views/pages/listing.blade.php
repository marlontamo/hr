@extends('layouts.master')

@section('page_content')
@parent

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="row">
	<div class="col-md-9">
		<div class="portlet">
			<div class="portlet-body">
				<div class="tabbable-custom ">
					<ul class="nav nav-tabs ">
						@if ($mrf)
						<li class="active"><a href="{{ get_mod_route('mrf') }}">{{ lang('common.personal') }}</a></li>
						@endif
						@if ($mrf_manage)
						<li class=""><a href="{{ get_mod_route('mrf_manage') }}">{{ lang('common.manage') }}</a></li>
						@endif
						@if ($mrf_admin)
						<li class=""><a href="{{ get_mod_route('mrf_admin') }}">{{ lang('common.admin') }}</a></li>
						@endif
					</ul>
				</div>
			</div>
			<br>
			<div class="portlet-title">
				<div class="caption">{{ lang('mrf.mrf_list') }}</div>
				<div class="caption" id="head-caption">&nbsp;</div>
				<div class="actions">
					<div class="btn-group">
						@if( isset( $permission['add']) && $permission['add'] )
						<a id="goadd" href="{{ $mod->url }}/add" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></a>
						@endif
						@if( isset( $permission['delete']) && $permission['delete'] )
						<!-- <a href="javascript:delete_records()" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a> -->
						@endif
					</div>
					<div class="btn-group">
	                    <a class="btn btn-info btn-sm hidden-lg hidden-md" href="#" data-toggle="dropdown" data-close-others="true">
						<i class="fa fa-filter"></i> 
	                    </a>
	                    <div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
	                    	<div class="scroller" data-always-visible="1" data-rail-visible1="1">
	                        	<div class="portlet margin-bottom-10">
									<div class="portlet-title">
										<div class="caption margin-bottom-0"><h5>{{ lang('mrf.leave_forms') }}</h5></div>
									</div>
									<div class="portlet-body">
										<div class="radio-list">
											<label><input class="form-filter option" type="radio" name="optionsRadios" id="optionsRadios2" value="option1" data-form-id="0" checked> {{ lang('common.all') }}</label>
											@foreach ($leave_forms as $form_id => $form)
											<label><input class="form-filter option" type="radio" name="optionsRadios" id="optionsRadios2" value="option4" data-form-id="{{$form_id}}"> {{$form}}</label>
											@endforeach
										</div>
									</div>
								</div>
								<div class="portlet margin-bottom-10">
									<div class="portlet-title">
										<div class="caption margin-bottom-0"><h5>{{ lang('mrf.other_forms') }}</h5></div>
									</div>
									<div class="portlet-body">
										<div class="radio-list">
											@foreach ($other_forms as $form_id => $form)
											<label><input class="form-filter option" type="radio" name="optionsRadios" id="optionsRadios2" value="option4" data-form-id="{{$form_id}}"> {{$form}}</label>
											@endforeach
										</div>
									</div>
								</div>
								<div class="portlet">
									<div class="portlet-title">
										<div class="caption margin-bottom-0"><h5>{{ lang('common.status') }}</h5></div>
									</div>
									<div class="portlet-body">
										<div class="radio-list">
											@foreach ($status as $form_status_id => $stat)
											<label><input class="form-filter option" type="radio" name="optionsRadios" id="optionsRadios2" value="option4" data-form-status-id="{{$stat['form_status_id']}}"> {{$stat['form_status']}}</label>
											@endforeach
										</div>
									</div>
								</div>
							</div>
						</div>
	            	</div>
	                
				</div>
				</div>
				
			</div>
			<div class="clearfix">
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
								{{ lang('common.actions') }}
							</th>
						</tr>
					</thead>
					<tbody id="record-list">
					</tbody>
				</table>
				<div id="no_record" class="well" style="display:none;">
					<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }}</p>
					<span><p class="small margin-bottom-0">{{ lang('common.zero_record') }}</p></span>
				</div>
				<div id="loader" class="text-center"><img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." /> {{ lang('common.get_record') }}</div>
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
<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
<!-- <script type="text/javascript" src="{{ theme_path() }}modules/common/lists.js"></script> -->
<script type="text/javascript" src="{{ theme_path() }}modules/mrf/edit_custom.js"></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-switch/static/js/bootstrap-switch.min.js"></script>
<script src="{{ theme_path() }}scripts/ui-extended-modals.js"></script> 
<script type="text/javascript">
	
	$(".month-nav").on('click', function(){
		get_list('month', $(this).data('month'));
	});

	$(".month-list").live('click', function(){
		get_list('month', $(this).data('month-value'));
	});

	$(".year-filter").live('click', function(){
		get_list('year', $(this).data('year-value'));
	});	

	function get_list(date_type, date_value){

	var request_data = {type: date_type, value: date_value, page: 1};

	$.ajax({
	    url: base_url + module.get('route') + '/get_list',
	    type: "POST",
	    async: false,
	    data: request_data,
	    dataType: "json",
	    beforeSend: function () {

	    	// need to do something 
	    	// on before send?
	    	$("#no_record").hide();
	    	$("#record-list").hide();
	    	$("#loader").show();
	    },
	    success: function (response) { //return;

	    	$("#date-title").html(response.current_title);

			setTimeout(function(){
				
				$("#loader").hide();

			    if(response.list.length){
		    		$("table.table tbody tr").remove();
		    		$("table.table tbody").append(response.list);
					//initPopup();
		    		$("#record-list").show();
		    	}
		    	else{
		    		//console.log('show no record...');
		    		$("#no_record").show();
		    	}
    	
		    	// update nav values
		    	$("#previous_month").data('month', response.pn['prev']);
		    	$("#next_month").data('month', response.pn['nxt']);

		    	// side filter
		    	if(response.sf.length)
		    		$("#sf-container").html(response.sf);
 
			}, 500);

	    },
	    error: function(request, status, error){

	    	console.log("something went wrong. Sorry for that!");   	
	    }
	});
}
</script>

@stop

@section('view_js')
@parent
{{ get_list_js( $mod ) }}
@stop
