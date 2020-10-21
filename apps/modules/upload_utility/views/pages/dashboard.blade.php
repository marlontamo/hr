@extends('layouts.master')

@section('page_styles')
	@parent
	<link href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css"/>
@stop

@section('page_content')
	@parent

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
												<div class="caption">Choose what to upload</div>
												<div class="tools">
													<a href="javascript:;" class="collapse"></a>
												</div>
											</div>
											<p class="small text-muted">Select a template to upload.</p>
											<div class="portlet-body margin-top-25">
											<form action="#" class="form-horizontal" name="upload-form">
												<div class="">
					                                <label class="control-label small text-success bold">Template:</label>
					                                <select  class="form-control select2me" name="template_id" id="template_id" data-placeholder="Select...">
				                                    	<option value="">Select...</option>
				                                    	@foreach($templates as $template)
															<option value="{{ $template->template_id }}">{{ $template->template_name }}</option>
														@endforeach
				                                    </select>
					                            </div>
					                            
										    	<div class="">
					                                <label class="control-label small text-success bold">Select File:</label>
					                                <input type="hidden" name="template" id="template" value=""/>
									                <div class="fileupload fileupload-new" data-provides="fileupload" id="template-container">
									                    <span class="btn btn-info btn-file">
									                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Browse File</span>
									                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
									                    <input type="file" id="template-fileupload" class="default" name="files[]" />
									                    </span>
									                    <span class="fileupload-preview" style="margin-left:5px;"></span>
									                    <a style="float: none; margin-left:5px;" class="close fileupload-exists fileupload-delete"></a>
									                </div>
									            </div>
									            
									            <hr/>
									            <a class="btn btn-success" type="button" href="javascript:start_upload()"><i class="fa fa-upload"></i> Start Uploading</a>
											</form>
											</div>
										</div>
									</div>
									<div class="col-md-9">
										<div class="portlet">
											<div class="portlet-title">
												<div class="caption">Upload History</div>
												<div class="tools">
													<a href="javascript:;" class="collapse"></a>
												</div>
											</div>
											<p class="small text-muted">This section shows the list and information of uploading history.</p>
											<div class="portlet-body ">
												<div class="clearfix">
													<table id="record-table" class="table table-condensed table-striped table-hover">
									                    <thead>
									                        <tr>
									                            @include('list_template_header')
									                            <th width="20%">
									                                {{ lang('common.actions') }}
									                            </th>
									                        </tr>
									                    </thead>
									                    <tbody id="record-list"></tbody>
									                </table>
									                <div id="no_record" class="well" style="display:none;">
														<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }}</p>
														<span><p class="small margin-bottom-0">{{ lang('common.zero_record') }}</p></span>
													</div>
													<div id="loader" class="text-center"><img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." /> {{ lang('common.get_record') }}</div>
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
	
@stop

@section('page_plugins')
	@parent
	<script src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}modules/upload_utility/util.js" type="text/javascript" ></script>

	<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/common/lists.js"></script>
@stop

@section('view_js')
	@parent
	{{ get_list_js( $mod ) }}
@stop