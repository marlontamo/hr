@extends('layouts.master')

@section('page_styles')
    @parent
    <link href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" type="text/css"/>
    <link href="{{ theme_path() }}plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css"/>
@stop

@section('page_content')
@parent

<!-- BEGIN PAGE CONTENT-->

<div class="row">
    <div class="col-md-12">
        <div class="portlet"> 
            <div class="portlet-body">
                <div class="tabbable-custom ">
                    <ul class="nav nav-tabs ">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Uploading</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Backup</a></li>
                        <li><a href="#tab_3" data-toggle="tab">Restore</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="row margin-top-25">
                                <div class="col-md-3">

                                    <div class="portlet ">
                                        <div class="portlet-title">
                                            <div class="caption">Items</div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse"></a>
                                            </div>
                                        </div>
                                        <p class="small text-muted">Select module to upload file.</p>
                                        <!-- <h4 class="bold">HDI Systech</h4> -->
                                        <div class="portlet-body margin-top-25">
                                            <div class="list-group">
                                                <a href="#company-tab" class="list-group-item active bg-green">
                                                Company <icon class="fa fa-angle-right pull-right"></icon>
                                                </a>
                                                <a href="#user-tab" class="list-group-item">User</a>
                                                <a href="#" class="list-group-item">Shift </a>
                                                <a href="#" class="list-group-item">Holiday</a>
                                                <a href="#" class="list-group-item">Leave Balance</a>
                                                <a href="#" class="list-group-item">
                                                Partners
                                                </a>
                                                <a href="#" class="list-group-item">User</a>
                                                <a href="#" class="list-group-item">Shift </a>
                                                <a href="#" class="list-group-item">Holiday</a>
                                                <a href="#" class="list-group-item">Leave Balance</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="portlet">
                                        <div class="portlet-title">
                                            <div class="caption">Uploading</div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse"></a>
                                            </div>
                                        </div>
                                        <p class="small text-muted">This section shows the summary of uploading. It also categorize the successful and file with errors.</p>
                                        <div class="portlet-body">
                                            <form action="#" class="form-horizontal" name="upload-form">
                                                <div class="form-body">

                                                    

                                                    <div class="form-group margin-top-25">
                                                        <label class="control-label col-md-3">Upload <span class="required">*</span></label>
                                                        <div class="col-md-9">
                                                            <input type="hidden" name="template" id="template" value=""/>
                                                            <div class="fileupload fileupload-new" data-provides="fileupload" id="template-container">
                                                                <span class="btn btn-info btn-file">
                                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select File</span>
                                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                                <input type="file" id="upload-excel" class="default" name=""/>
                                                                </span>
                                                                <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                                <a href="#" class="close fileupload-exists fileupload-delete" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                                
                                                            </div>

                                                            <div class="help-block small">
                                                                Select file for uploading.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h4 class="form-section margin-bottom-10">Summary</h4>
                                                    <p class="margin-bottom-25 small text-muted">Shows the summary of uploading. </p>

                                                    <div class="alert alert-success batch-alert" id="success-upload-excel" style="display:none">
                                                        <strong>Success!</strong>
                                                        You have <span id="count-valid-files"></span> valid record/s.
                                                        <a class="pull-right small" href=""> </a>
                                                    </div>

                                                    <div class="alert alert-danger batch-alert" id="error-upload-excel" style="display:none">
                                                        <strong>Error!</strong>
                                                        <span id="count-empty-files"></span>
                                                        <a class="pull-right small" href=""> View Details</a>
                                                    </div>

                                                    <a class="btn btn-success margin-top-25 margin-bottom-25" type="button" href="javascript:start_upload()"><i class="fa fa-upload"></i> Start Uploading</a>

                                                    <h4 class="form-section margin-bottom-10 ">Template</h4>
                                                    <p class="margin-bottom-25 small text-muted">This section has th downloadable template. </p>

                                                    <div class="alert alert-info batch-alert">
                                                        <strong>Download:</strong>
                                                        Company_Template.csv
                                                        <a class="pull-right small" href=""><i class="fa fa-download"></i> Download</a>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <div class="row margin-top-25">
                                <div class="col-md-3">

                                    <div class="portlet ">
                                        <div class="portlet-title">
                                            <div class="caption">Back Up</div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse"></a>
                                            </div>
                                        </div>
                                        <p class="small text-muted">Navigations to view current and historical back-up files.</p>

                                        <div class="list-group margin-top-25 margin-bottom-10">
                                            <a href="#" class="list-group-item active bg-green">
                                            Current <icon class="fa fa-angle-right pull-right"></icon>
                                            </a>
                                        </div>

                                        <h4 class="margin-top-25">History: </h4>

                                        <div class="list-group">
                                            <span href="#" class="list-group-item"><i class="fa fa-folder-open-o"></i> 2015-01-01 12:00 am</span>
                                            <span href="#" class="list-group-item"><i class="fa fa-folder-open-o"></i> 2015-01-01 12:00 am</span>
                                            <span href="#" class="list-group-item"><i class="fa fa-folder-open-o"></i> 2015-01-01 12:00 am</span>
                                            <span href="#" class="list-group-item"><i class="fa fa-folder-open-o"></i> 2015-01-01 12:00 am</span>
                                            <span href="#" class="list-group-item"><i class="fa fa-folder-open-o"></i> 2015-01-01 12:00 am</span>
                                            <a href="system_utilities_all-backups.php" class="list-group-item bg-light-blue">
                                            <b>VIEW ALL BACK-UP</b>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="portlet">
                                        <div class="portlet-title">
                                            <div class="caption">Summary</div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse"></a>
                                            </div>
                                        </div>
                                        <p class="small text-muted">This section shows the summary of back-ups and the status of files.</p>
                                        <div class="portlet-body">
                                            


                                            <div class="alert alert-success batch-alert">
                                                <strong>Success!</strong>
                                                You have 4000 valid file/s.
                                                <a class="pull-right small" href=""> </a>
                                            </div>

                                            <div class="alert alert-danger batch-alert">
                                                <strong>Error!</strong>
                                                Your 100 file/s are not supported.
                                            </div>

                                            <a class="btn btn-success" type="button" href="#"><i class="fa fa-upload"></i> Start Back-Up</a>

                                            <div class="table-responsive margin-top-25">

                                                <h4 class="form-section margin-bottom-10">Database: Workwise V4</h4>

                                                <table class="table table-striped table-hover">
                                                    <thead >
                                                        <tr class="success">
                                                            <th width="50%">Table</th>
                                                            <th width="25%">Records</th>
                                                            <th width="25%">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Table 1</td>
                                                            <td>3,200</td>
                                                            <td><i class="fa fa-check text-success"></i> <span class="text-success">Successful</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td><i class="fa fa-check text-success"></i> <span class="text-success">Successful</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 3</td>
                                                            <td>200</td>
                                                            <td><i class="fa fa-check text-success"></i> <span class="text-success">Successful</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 4</td>
                                                            <td>3000</td>
                                                            <td><i class="fa fa-check text-success"></i> <span class="text-success">Successful</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 5</td>
                                                            <td>200</td>
                                                            <td><i class="fa fa-check text-success"></i> <span class="text-success">Successful</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td><i class="fa fa-refresh text-muted"></i> <span class="text-muted"> Running...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td><i class="fa fa-refresh text-muted"></i> <span class="text-muted"> Running...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td><i class="fa fa-refresh text-muted"></i> <span class="text-muted"> Running...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td><i class="fa fa-refresh text-muted"></i> <span class="text-muted"> Running...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td><i class="fa fa-refresh text-muted"></i> <span class="text-muted"> Running...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td><i class="fa fa-refresh text-muted"></i> <span class="text-muted"> Running...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td><i class="fa fa-refresh text-muted"></i> <span class="text-muted"> Running...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table 2</td>
                                                            <td>200</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <div class="row margin-top-25">
                                <div class="col-md-3">

                                    <div class="portlet ">
                                        <div class="portlet-title">
                                            <div class="caption">Restore</div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse"></a>
                                            </div>
                                        </div>
                                        <p class="small text-muted">Historical list to restore back-up files.</p>


                                        <h4 class="margin-top-25">History: </h4>

                                        <div class="list-group">
                                            <a href="#" class="list-group-item active bg-blue"><i class="fa fa-folder-open-o"></i> 2015-01-01 12:00 am <icon class="fa fa-angle-right pull-right"></icon></a>
                                            <a href="#" class="list-group-item"><i class="fa fa-folder-open-o"></i> 2015-01-01 12:00 am</a>
                                            <a href="#" class="list-group-item"><i class="fa fa-folder-open-o"></i> 2015-01-01 12:00 am</a>
                                            <a href="#" class="list-group-item"><i class="fa fa-folder-open-o"></i> 2015-01-01 12:00 am</a>
                                            <a href="#" class="list-group-item"><i class="fa fa-folder-open-o"></i> 2015-01-01 12:00 am</a>
                                            <a href="#" class="list-group-item bg-light-blue">
                                            <b>SEE MORE</b>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="portlet">
                                        <div class="portlet-title">
                                            <div class="caption">Summary</div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse"></a>
                                            </div>
                                        </div>
                                        <p class="small text-muted">This section shows the summary of back-ups and the status of files.</p>
                                        <div class="portlet-body">
                                            


                                            <div class="alert alert-success batch-alert">
                                                <strong>Success!</strong>
                                                You have 4000 valid file/s.
                                                <a class="pull-right small" href=""> </a>
                                            </div>

                                            <div class="alert alert-danger batch-alert">
                                                <strong>Error!</strong>
                                                Your 100 file/s are not supported.
                                            </div>

                                            <a class="btn btn-success" type="button" href="#"><i class="fa fa-refresh"></i> Start Restore</a>

                                            <div class="table-responsive margin-top-25">

                                                <h4 class="form-section margin-bottom-10">Database: Workwise V4</h4>

                                                <table class="table table-striped table-hover">
                                                    <thead >
                                                        <tr class="success">
                                                            <th width="30%">Filename</th>
                                                            <th width="25%">Date/Time</th>
                                                            <th width="20%">Size</th>
                                                            <th width="25%">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td><i class="fa fa-check text-success"></i> <span class="text-success">Successful</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td><i class="fa fa-check text-success"></i> <span class="text-success">Successful</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td><i class="fa fa-check text-success"></i> <span class="text-success">Successful</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td><i class="fa fa-check text-success"></i> <span class="text-success">Successful</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td><i class="fa fa-check text-success"></i> <span class="text-success">Successful</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td><i class="fa fa-refresh text-muted"></i> <span class="text-muted"> Running...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td><i class="fa fa-refresh text-muted"></i> <span class="text-muted"> Running...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td><i class="fa fa-refresh text-muted"></i> <span class="text-muted"> Running...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td><i class="fa fa-refresh text-muted"></i> <span class="text-muted"> Running...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td><i class="fa fa-refresh text-muted"></i> <span class="text-muted"> Running...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td><i class="fa fa-refresh text-muted"></i> <span class="text-muted"> Running...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td><i class="fa fa-refresh text-muted"></i> <span class="text-muted"> Running...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Table_1.zip</td>
                                                            <td>2015-01-01 12:00 am</td>
                                                            <td>51 KB</td>
                                                            <td> <span class="text-muted"> Waiting...</span></td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END PAGE CONTENT-->   
@stop

@section('page_plugins')
@parent
    <script src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}modules/upload_manager/upload.js" type="text/javascript" ></script>

    <script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
    <script type="text/javascript" src="{{ theme_path() }}modules/common/lists.js"></script>
@stop

@section('view_js')
@parent
{{ get_list_js( $mod ) }}
@stop
