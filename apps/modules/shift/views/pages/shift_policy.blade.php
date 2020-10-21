@extends('layouts/master')

@section('page_styles')
	@parent
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2_metro.css" />
@stop

@section('page-header')
	
	<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<h3 class="page-title">
			{{ $mod->long_name }} <small>Shift Policy</small>
		</h3>
		<ul class="page-breadcrumb breadcrumb">
			<li class="btn-group">
				<a href="{{ get_mod_route('shift') }}"><button class="btn blue" type="button">
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
			<li>Shift Policy</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>

@stop

@section('page_content')
	@parent
	<div class="row">
        <div class="col-md-11">
        	<input type="hidden" name="view" id="view" value="detail" >
        	<input type="hidden" name="shift_id" id="shift_id" value="{{ $record['record_id'] }}" >
        	<div class="portlet">
				<div class="portlet-title">
					<div class="caption">Shift Information</div>
					<div class="tools"><a class="collapse" href="javascript:;"></a></div>
				</div>
				<div class="portlet-body form">	
					<div class="form-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-2 col-sm-2 text-right text-muted">Company :</label>
									<div class="col-md-8 col-sm-8">
										<span>{{ implode(', ' ,$record['companies']) }} </span>
									</div>
								</div>
							</div>
						</div>
						<div class="row hidden">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-2 col-sm-2 text-right text-muted">Department :</label>
									<div class="col-md-8 col-sm-8">
										<span>{{ is_array($record['department']) ? implode(', ' ,$record['department']) : $record['department'] }} </span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-2 col-sm-2 text-right text-muted">Shift :</label>
									<div class="col-md-8 col-sm-8">
										<span>{{ $record['time_shift.shift'] }} </span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-2 col-sm-2 text-right text-muted">From :</label>
									<div class="col-md-8 col-sm-8">
										<span>{{ date('h:i A',strtotime($record['time_shift.time_start'])) }} </span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-2 col-sm-2 text-right text-muted">To :</label>
									<div class="col-md-8 col-sm-8">
										<span>{{ date('h:i A',strtotime($record['time_shift.time_end'])) }} </span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption">Policy</div>
					<div class="tools"><a class="collapse" href="javascript:;"></a></div>
				</div>
				<div class="portlet-body form">	
					<table class="table table-striped table-hover table-bordered" id="shift-class-table" table-count="{{ count($shift_classes) }}">
						<thead>
							<tr>
								<th style="width:30%">Class</th>
								<th style="width:20%">Value</th>
								<th style="width:40%">Description</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($shift_classes as $shift_class)
								<tr class="small">
									<td><a href="#" class="class_id" class-id="{{ $shift_class['class_id'] }}" class-name="{{ $shift_class['class_code'] }}" datatype="{{ $shift_class['data_type'] }}" class-value="{{ $shift_class['default_value'] }}">{{ $shift_class['class_code'] }}</a>
									</td>
									<td><a href="#" class="class_value" data-type="{{ $shift_class['data_type'] }}" data-pk="{{ $shift_class['class_id'] }}"  data-original-title="" {{ ($shift_class['data_type'] == "combodate") ? 'data-template="HH:mm" data-format="HH:mm" viewformat="HH:mm"' : '' }}>{{ ($shift_value !== false && isset($shift_value[$shift_class['class_id']])) ? $shift_value[$shift_class['class_id']] : $shift_class['default_value'] }}</a> </td>
									<td>{{ $shift_class['class'] }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
        </div>
    </div>


@stop

@section('page_plugins')
	@parent
@stop

@section('page_scripts')
	@parent
	@include('edit/page_scripts')
	<script type="text/javascript" src="{{ theme_path() }}plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script> 
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/moment.min.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.min.js"></script>

 	<script type="text/javascript">
 		var module_url = "{{ $mod->route }}";

		$.fn.editable.defaults.mode = 'inline';
		//global settings 
	    $.fn.editable.defaults.inputclass = 'form-control';
	    //$.fn.editable.defaults.url = base_url + module_url + '/save_class_value';

        //editables element samples 
        $('.class_value').editable({
        	url: base_url + module_url + '/save_class_value',
        	params: { shift_id : $('#shift_id').val()},
        	success: function(data) {
		        handle_ajax_message( data.message );
		    },
        });	
        
        $('.class_id').on('click', function() {
         	get_shift_class_company_form($(this).attr('class-id'), $('#shift_id').val(),$(this).attr('class-name'), $(this).attr('datatype'),$(this).attr('class-value'));
        });

        function get_shift_class_company_form(class_id, shift_id, class_name, data_type, class_value)
		{
			$.ajax({
				url:  base_url + module_url + '/get_shift_class_company_form',
				type:"POST",
				data: 'shift_id='+shift_id+'&class_id='+class_id+'&class='+class_name+'&data_type='+data_type+'&class_value='+class_value,
				dataType: "json",
				async: false,
				success: function ( response ) {
					if( typeof(response.shift_class_company_form) != 'undefined' )
					{
						$('.modal-container').attr('data-width', '1000');
						$('.modal-container').html(response.shift_class_company_form);
						$('.modal-container').modal();
					}		
				}
			});
		}

</script>
@stop

