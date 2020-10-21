@extends('layouts.master')

@section('page_styles')
	<link href="{{ theme_path() }}css/pages/user-manager.css" rel="stylesheet" type="text/css"/>
    <link href="{{ theme_path() }}plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2_metro.css" />
@stop



@section('page_content')
	@parent
   
	<div class="row">
		<div class="col-md-12">
			<div class="portlet calendar">
				<div class="portlet-title">
					<div class="caption">&nbsp;</div>
				</div>
				<div class="portlet-body">

					<div class="row">


						<div class="col-md-9 col-sm-9">
							<div id="calendar" class="has-toolbar"></div>
						</div>
						<div class="col-md-3 col-sm-12">
							<!-- BEGIN DRAGGABLE EVENTS PORTLET-->    
							<h4>{{ lang('work_calendar.weekly') }}</h4>
							<div id="event_box_weekly"></div>

							<h4>{{ lang('work_calendar.shift_sched') }}</h4>
							<div id="event_box"></div>

							<div id="external-events">
								
								<hr />
								
								<hr class="visible-xs" />
							</div>

							<!-- END DRAGGABLE EVENTS PORTLET-->            
						</div>
						<div class="col-md-3 col-sm-12">
							<!-- LINK TO MANAGE CALENDAR-->    
							<h4>Link</h4>
							<a rel="{{ get_mod_route('my_calendar') }}" href="{{ get_mod_route('my_calendar') }}"  class="label label-success">{{ lang('work_calendar.mycalendar_button') }}</a>				

						</div>						
					</div>

					<!-- END CALENDAR PORTLET-->
				</div>
			</div>
		</div>
	</div>
	<style>
		.portlet.calendar .fc-button {
			color : #545454;
			top : -56px;
		}
	</style>
@stop

<div id="calman_form" class="modal fade" tabindex="-1" data-width="400"></div>
<div id="calman_list" class="modal fade" tabindex="-1" data-width="800"></div>
<div id="calman_view" class="modal fade" tabindex="-1" data-width="800"></div>



@section('page_plugins')
	@parent
	<script src="{{ theme_path() }}plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
	<script src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
	<script src="{{ theme_path() }}plugins/holder.js"></script>
	<script src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="{{ theme_path() }}plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
	<script src="{{ theme_path() }}plugins/fuelux/js/spinner.min.js"></script>
    <script src="{{ theme_path() }}plugins/select2/select2.min.js"></script>
	<script src="{{ theme_path() }}plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
	<script src="{{ theme_path() }}plugins/bootstrap-touchspin/bootstrap.touchspin.js"></script>
	<script src="{{ theme_path() }}plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
	<script src="{{ theme_path() }}plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
@stop

@section('view_js')
	@parent
	{{ get_list_js( $mod ) }}
	<script type="text/javascript" src="{{ theme_path() }}modules/work_calendar/edit.js"></script>
@stop
