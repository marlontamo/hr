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
        <!-- Edit -->
        <div class="portlet">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">{{ lang('clearance_signatories.clearance_signatories_information') }} <span class="small text-muted"> {{ lang('clearance_signatories.edit') }}</span></div>
        </div>
            
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <!-- <form action="#" class="form-horizontal"> -->
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-4">{{ lang('clearance_signatories.signatory_layout') }}
                            
                        </label>
                        <div class="col-md-5">
                            <input type="text" disabled="disabled" class="form-control" name="partners_clearance_layout[layout_name]" id="partners_clearance_layout-layout_name" value="{{ $record['layout_name'] }}" placeholder="{{ lang('clearance_signatories.p_signatory_layout') }}" />   
                        </div>
                    </div>
                    <br>
                    <!--Signatories Remarks-->
                    <input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
                    <div class="portlet sign_remarks @if(!$record_id>0) hidden @endif">
                        <div class="portlet-title">
                            <div class="caption">{{ lang('clearance_signatories.signatories_remarks') }}</div>
                            <div class="tools">
                                <a class="collapse" href="javascript:;"></a>
                            </div>
                        </div>
                        <p class="margin-bottom-25 small">{{ lang('clearance_signatories.signatories_note') }}</p>

                        <div class="portlet-body">
                            <div class="panel panel-info">
                                <div class="panel-heading" style="background-color: #2e7af4;color:#FFF">
                                    <h3 class="panel-title">Other Properties
                                    </h3>
                                </div>  
                            </div>      
                            <!-- /. Clearance: modal -->
                            <?php //include "partners_clearance_signatory-add.php" ?>
                            <!-- /.modal -->
                            <div id="signatories" name="signatories">
                            </div>
                        </div>

                        <div class="portlet-body">
                            <div class="panel panel-info">
                                <div class="panel-heading" style="background-color: #2e7af4;color:#FFF">
                                    <h3 class="panel-title">Head Office
                                    </h3>
                                </div>  
                            </div>                          
                            <!-- /. Clearance: modal -->
                            <?php //include "partners_clearance_signatory-add.php" ?>
                            <!-- /.modal -->
                            <div id="signatories_head_office" name="signatories_head_office">
                            </div>
                        </div>                          
                    </div>
                    <!--End-->


                    <div class="modal fade modal-container modal-signatories" tabindex="-1" aria-hidden="true" data-width="600"></div>

                </div>

                <!-- <div class="form-actions fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-offset-4 col-md-8">
                               <a href="clearance_emp-view.php" class="btn btn-default btn-sm" type="button"> Back to list</a>
                                                           
                            </div>
                        </div>
                    </div>
                </div> -->
            <!-- </form> -->
            <!-- END FORM--> 
        </div>
    </div>

            @include('buttons/detail')

                        <!-- <div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-offset-3 col-md-9"> -->
                                        <!-- <button class="btn green btn-sm" type="button" onclick="save_fg( $(this).parents('form') )"><i class="fa fa-check"></i> Save</button> -->
                                        <!-- <button 
                                            class="btn green btn-sm" 
                                            type="button" 
                                            onclick="save_record( $(this).closest('form'), '')"><i class="fa fa-check"></i> Save
                                        </button>
                                        <button class="btn blue btn-sm" type="submit" onclick="save_record( $(this).parents('form'), 'new')">Save &amp; Add New</button>
                                        <a href="{{ $mod->url }}" class="btn default btn-sm">Back</a> 
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    <!-- </form> -->
                     <!-- END FORM -->
                <!-- </div> -->
            <!-- </div> -->
        </div>
        </form>
        <!-- End Edit -->
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
@stop


@section('view_js')
	@parent

	{{ get_detail_js( $mod ) }}

@stop
