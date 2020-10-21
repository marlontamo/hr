<link href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" type="text/css"/>
<link href="{{ theme_path() }}plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css"/>
<script src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript" ></script>
<script src="{{ theme_path() }}modules/upload_utility/util.js" type="text/javascript" ></script>

<div class="modal-body">
    <div class="row">
        <div class="portlet">
            <div class="portlet-body" >
                <form name="import-form" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Template<span class="required">*</span></label>
                            <div class="col-md-5">
                                <select name="template_id" id="template_id" class="form-control select2me" data-placeholder="Select...">
                                    @foreach( $templates as $template )
                                        <option value="{{ $template->template_id }}">{{ $template->template_name }}</option>
                                    @endforeach
                                </select>
                                <div class="help-block small">
                                    Select template for importing.
                                </div>
                            </div>
                        </div>

                        <div class="form-group margin-top-25">
                            <label class="control-label col-md-3">Select File <span class="required">*</span>
                            </label>
                            <div class="col-md-9">
                                <div class="fileupload fileupload-new" data-provides="fileupload" id="template-container">
                                    <span class="btn btn-info btn-file">
                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Browse File</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                    <input type="hidden" name="template" id="template" value=""/>
                                    <input type="file" id="template-fileupload" class="default" name="files[]" />
                                    </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a style="float: none; margin-left:5px;" class="close fileupload-exists fileupload-delete"></a>
                                </div>
                                <div class="help-block small">
                                    Select file for importing.
                                </div>
                            </div>
                        </div>

                        <div id="import-summary" class="hidden">
                            <h4 class="form-section margin-bottom-10">Summary</h4>
                            <p class="margin-bottom-25 small text-muted">Shows the summary of importing. </p>

                            <div class="alert alert-success valid_log hidden batch-alert">
                                <strong>Success!</strong>
                                The file has <span id="valid_count"></span> valid row(s) out of <span id="total_rows"> total.</span>.
                                <a href="" class="pull-right small"> </a>
                            </div>

                            <div class="alert alert-danger error_log hidden batch-alert">
                                <strong>Error!</strong>
                                The file has <span id="error_count"></span> invalid rows out of <span id="total_rows"></span>.
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer margin-top-0">
    <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">Cancel</button>
    <a href="javascript:start_import()" type="button" class="btn btn-success"><i class="fa fa-upload"></i> Start Uploading</a>
</div>