@extends('layouts/master')

@section('page_styles')
	@parent
	@include('detail/page_styles')
@stop

@section('page_content')
	@parent

<div class="row">

    <div class="col-md-9">

    <form method="post" fg_id="1" class="form-horizontal">
    <div class="portlet">
    <div class="portlet-title">
        <div class="caption">{{ lang('career_stream.career_stream_information') }}</div>
        <div class="tools"><a class="collapse" href="javascript:;"></a></div>
    </div>
    <div class="portlet-body form">         
        <div class="form-group">
                <label class="control-label col-md-3">{{ lang('career_stream.job_class') }}</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control" name="users_job_class[job_class]" id="users_job_class-job_class" value="{{ $record['users_job_class.job_class'] }}" placeholder="{{ lang('career_stream.p_job_class') }}" />                
                </div>  
        </div>          
        <div class="form-group">
                <label class="control-label col-md-3">{{ lang('career_stream.job_class_code') }}</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control" name="users_job_class[job_class_code]" id="users_job_class-job_class_code" value="{{ $record['users_job_class.job_class_code'] }}" placeholder="{{ lang('career_stream.p_job_class_code') }}" />                
                </div>  
        </div>          
        <div class="form-group">
                <label class="control-label col-md-3">{{ lang('career_stream.active') }}</label>
                <div class="col-md-7">                          
                    <div class="make-switch" data-on-label="&nbsp;{{ lang('career_stream.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('career_stream.option_no') }}&nbsp;">
                                <input type="checkbox" disabled="disabled" value="1" @if( $record['users_job_class.status_id'] ) checked="checked" @endif name="users_job_class[status_id][temp]" id="users_job_class-status_id-temp" class="dontserializeme toggle"/>
                                <input type="hidden" disabled="disabled" name="users_job_class[status_id]" id="users_job_class-status_id" value="<?php echo $record['users_job_class.status_id'] ? 1 : 0 ?>"/>
                    </div>              
                </div>  
        </div>  
    </div>
        @include('buttons/detail')
    </div>
    </form>
    </div>
	
    
    <!--RIGHT SIDE ACTION BUTTONS-->
    <!-- <div class="col-md-3 visible-lg">
    
        <div class="portlet" id="abId0.45087891281582415">
            <div class="clearfix margin-bottom-20" id="abId0.23150411853566766">
                <div class="input-icon right margin-bottom-10" id="abId0.6490198103711009">
                    <i class="fa fa-search"></i>
                    <input type="text" placeholder="Search..." class="form-control">
                </div>

                <div class="btn-group btn-group-justified">
                    <a class="btn btn-default" id="goadd"><i class="fa fa-plus"></i> Add</a>
                    <a class="btn btn-default" href="#"><i class="fa fa-times"></i> Delete</a>
                </div>
                <div class="btn-group btn-group-justified margin-bottom-10">
                    <a class="btn btn-default" id="trash"><i class="fa fa-trash-o"></i> Trash Bin</a>
                    <a class="btn btn-default" href="admin_user.php"><i class="fa fa-chevron-left"></i> Back</a>
                </div>

            </div>
        </div>
    </div> -->
    <!--END RIGHT SIDE ACTION BUTTONS-->
    
</div>

@stop


@section('page_plugins')
	@parent
	@include('detail/page_plugins')
@stop


@section('page_scripts')
	@parent

	@include('detail/page_scripts')

    <script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
@stop


@section('view_js')
	@parent

	{{ get_edit_js( $mod ) }}

@stop
