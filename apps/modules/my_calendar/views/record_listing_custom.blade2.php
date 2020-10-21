@extends('layouts.master')

@section('page_styles')
@parent	
<link href="{{ theme_path() }}plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" />

<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css"/>
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
<link href="{{ theme_path() }}plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2.css" />
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2_metro.css" />
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-timepicker/compiled/timepicker.css" />

<style>
.portlet.calendar .fc-button {
	color : #545454;
	top : -56px;
}
</style>
@stop

@section('page_content')
@parent

<!-- BEGIN EXAMPLE TABLE PORTLET-->

<!-- BEGIN PAGE CONTENT-->
<div class="row">

	<div class="col-md-12">

		<!-- <div class="modal fade modal-container" tabindex="-1" aria-hidden="true" data-width="800" ></div> -->

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
						<h4>Forms to Apply</h4><hr class="margin-none">
						<p class="small text-muted margin-bottom-20 margin-top-10">Note: Drag the form type below to the desired start date.</p>
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
						<a href="time_workcalendar_manager.php" class="label label-success">Calendar Manager</a>
						<a href="time_timerecords.php" class="label label-success">Time Records</a>
					</div>								
				</div>

				<!-- END CALENDAR PORTLET-->
			</div>
		</div>
	</div>
</div><!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('page_plugins')
@parent
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{ theme_path() }}plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script> 
<script src="{{ theme_path() }}plugins/jquery.ui.touch-punch.min.js" type="text/javascript"></script>  
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="{{ theme_path() }}plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="{{ theme_path() }}plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript" ></script>	

<script type="text/javascript" src="{{ theme_path() }}plugins/ckeditor/ckeditor.js"></script>  
<script type="text/javascript" src="{{ theme_path() }}plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>

<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript" ></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-switch/static/js/bootstrap-switch.min.js"></script>
<script src="{{ theme_path() }}scripts/ui-extended-modals.js"></script> 
<!-- Additional for FORM COMPONENTS -->
<script src="{{ theme_path() }}plugins/jquery-inputmask/jquery.inputmask.bundle.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript" ></script>

@stop

@section('view_js')
@parent
<script src="{{ theme_path() }}scripts/form-components.js"></script>  
<script src="{{ theme_path() }}scripts/ui-extended-modals.js"></script> 
<script type="text/javascript" src="{{ theme_path() }}modules/my_calendar/edit.js"></script>

@stop