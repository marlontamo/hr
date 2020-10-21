@extends('layouts.master')

@section('page_styles')
	@parent
	
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2_metro.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css"/>
@stop

@section('page_content')
	@parent

<div class="row">

    <div class="col-md-12">

        <div class="tab-content">

            <div class="tab-pane active" id="tab_0">

                <div class="portlet" style="cursor:pointer">
                    <div class="portlet-title">
                        <div class="caption">{{ lang('habitual_tardiness.settings') }}</div>
    				</div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="#" id="config-general-settings" class="form-horizontal form" name="config-general-settings" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{ lang('habitual_tardiness.minutes_tardy') }}</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="minutes_tardy" value="{{ (isset ($tardiness_settings['minutes_tardy']) ? $tardiness_settings['minutes_tardy'] : '') }}" placeholder="Minutes Tardy">
                                        <span class="help-block" style="font-size:80%">{{ lang('habitual_tardiness.minutes_tardy_note') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{ lang('habitual_tardiness.instances') }}</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="instances" value="{{ (isset ($tardiness_settings['instances']) ? $tardiness_settings['instances'] : '') }}" placeholder="Instances">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{ lang('habitual_tardiness.months_within') }}</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="month_within" value="{{ (isset ($tardiness_settings['month_within']) ? $tardiness_settings['month_within'] : '') }}" placeholder="Months Within">
                                    </div>
                                </div>                                                                
                            </div>
                            <div class="form-actions fluid">
                                <input type="hidden" name="record_id" value="{{ (isset ($tardiness_settings['habitual_tardiness_id']) ? $tardiness_settings['habitual_tardiness_id'] : '-1') }}">
                                <div class="col-md-offset-3 col-md-9">
                                    <button 
                                        type="submit" 
                                        class="btn green submit" 
                                        id="submit-general-settings" 
                                        name="submit-general-settings"
                                        onclick="save_record( $(this).closest('form'), ''); return false;">
                                        <i class="fa fa-check"></i> {{ lang('habitual_tardiness.submit') }}
                                    </button>
                                    <a class="btn default" href="{{ get_mod_route('time_reference') }}">{{ lang('habitual_tardiness.back') }}</a>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@stop

@section('page_plugins')
	@parent
    
    <script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script>
    <script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script src="{{ theme_path() }}plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript" ></script>
    
    <script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>

    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/load-image.min.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript" ></script>



    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript" ></script>
     <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-image.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript" ></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

@stop

@section('page_scripts')
	@parent
	
    
    {{ get_module_js( $mod ) }}
    <script type="text/javascript" src="{{ theme_path() }}modules/system/edit.js"></script>    
@stop

@section('view_js')
	@parent

	<script>
		jQuery(document).ready(function() {       
		
           	$('.selectM3').select2('destroy');   
        	$('.selectM3').select2();
        });
	</script>
@stop