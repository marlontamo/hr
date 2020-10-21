@extends('layouts/master')

@section('page_styles')
	@parent
	@include('edit/page_styles')
@stop

@section('page_content')
	@parent

<div class="row">

    <div class="col-md-9">

        <!-- Edit -->
        <div class="portlet" id="editform" style="display: block;">

            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">Company Information <small class="text-muted">edit</small>
                    </div>
                </div>

                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
                    <form method="post" fg_id="1" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Company
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" maxlength="64" name="users_company[company]" id="maxlength_defaultconfig" placeholder="Enter Company Name" value="{{ $record['users_company.company'] }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Company Code
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" maxlength="16" name="users_company[company_code]" id="maxlength_defaultconfig" placeholder="Enter Company Code" value="{{ $record['users_company.company_code'] }}">
                                    <span class="help-block small">16 character max to be used internnaly.</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Address</label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                                       <i class="fa fa-thumb-tack"></i>
                                                     </span>
                                        <input type="text" class="form-control" maxlength="128" name="users_company[address]" id="maxlength_defaultconfig" placeholder="Enter Address" value="{{ $record['users_company.address'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">City</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                                       <i class="fa fa-thumb-tack"></i>
                                                     </span>
                                        <input type="text" class="form-control" maxlength="32" name="users_company[city]" id="maxlength_defaultconfig" placeholder="Enter City" value="{{ $record['users_company.city'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Country</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                                       <i class="fa fa-thumb-tack"></i>
                                                     </span>
                                        <div class="select2-container form-control select2me" id="s2id_autogen1">
                                            <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1"> <span class="select2-chosen">Hong Kong</span><abbr class="select2-search-choice-close"></abbr>  <span class="select2-arrow"><b></b></span>
                                            </a>
                                            <input class="select2-focusser select2-offscreen" type="text" id="s2id_autogen2">
                                            <div class="select2-drop select2-display-none select2-with-searchbox">
                                                <div class="select2-search">
                                                    <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input">
                                                </div>
                                                <ul class="select2-results"></ul>
                                            </div>
                                        </div>
                                        <select class="form-control select2me select2-offscreen" data-placeholder="Select..." tabindex="-1">
                                            <option value="HK">Hong Kong</option>
                                            <option value="ID">Indonesia</option>
                                            <option value="PH">Philippines</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Zipcode</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" maxlength="16" name="users_company[zipcode]" id="maxlength_defaultconfig" placeholder="Enter Zipcode" value="{{ $record['users_company.zipcode'] }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">VAT Registration</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" maxlength="32" name="users_company[vat]" id="maxlength_defaultconfig" placeholder="Enter VAT Registration" value="{{ $record['users_company.vat'] }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">RDO Code</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" maxlength="32" name="users_company[rdo]" id="maxlength_defaultconfig" placeholder="Enter RDO Code" value="{{ $record['users_company.rdo'] }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">SSS Number</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" maxlength="32" name="users_company[sss]" id="maxlength_defaultconfig" placeholder="Enter SSS Number" value="{{ $record['users_company.sss'] }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">SSS Branch Code</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" maxlength="32" name="users_company[sss_branch_code]" id="maxlength_defaultconfig" placeholder="Enter SSS Branch Code" value="{{ $record['users_company.sss_branch_code'] }}">
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="control-label col-md-3">Pag-IBIG Number</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" maxlength="32" name="users_company[hdmf]" id="maxlength_defaultconfig" placeholder="Enter Pag-IBIG Number" value="{{ $record['users_company.hdmf'] }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Pag-IBIG Branch Code</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" maxlength="32" name="users_company[hdmf_branch_code]" id="maxlength_defaultconfig" placeholder="Enter Pag-IBIG Branch Code" value="{{ $record['users_company.hdmf_branch_code'] }}">
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="control-label col-md-3">PhilHealth Number</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" maxlength="32" name="users_company[phic]" id="maxlength_defaultconfig" placeholder="Enter PhilHealth Number" value="{{ $record['users_company.phic'] }}">
                                </div>
                            </div>

                            <h4 class="form-section">Contact Numbers</h4>

                            <!--default view-->
                            <div class="form-group hidden-sm hidden-xs">
                                <label class="control-label col-md-3">Phone</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        <input type="text" class="form-control" maxlength="16" id="defaultconfig[]" id="maxlength_defaultconfig" placeholder="Enter Telephone Number">
                                    </div>
                                </div>
                                <span class="hidden-xs hidden-sm">
                                                <a class="btn btn-default btn-sm" href="#"><i class="fa fa-trash-o"></i></a>
                                            </span>
                            </div>
                            <div class="form-group hidden-sm hidden-xs">
                                <label class="control-label col-md-3">Phone 2</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        <input type="text" class="form-control" maxlength="16" id="defaultconfig[]" id="maxlength_defaultconfig" placeholder="Enter Telephone Number">
                                    </div>
                                </div>
                                <span class="hidden-xs hidden-sm">
                                            	<a class="btn btn-default btn-sm" href="#"><i class="fa fa-trash-o"></i></a>
                                            	<a class="btn btn-default btn-sm" href="#"><i class="fa fa-plus"></i></a>
                                            </span>
                            </div>
                            <div class="form-group hidden-sm hidden-xs">
                                <label class="control-label col-md-3">Mobile</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <input type="text" class="form-control" maxlength="16" id="defaultconfig[]" id="maxlength_defaultconfig" placeholder="Enter Mobile Number">
                                    </div>
                                </div>
                                <span class="hidden-xs hidden-sm">
                                            	<a class="btn btn-default btn-sm" href="#"><i class="fa fa-trash-o"></i></a>
                                            </span>
                            </div>
                            <div class="form-group hidden-sm hidden-xs">
                                <label class="control-label col-md-3">Mobile</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <input type="text" class="form-control" maxlength="16" id="defaultconfig[]" id="maxlength_defaultconfig" placeholder="Enter Mobile Number">
                                    </div>
                                </div>
                                <span class="hidden-xs hidden-sm">
                                            	<a class="btn btn-default btn-sm" href="#"><i class="fa fa-trash-o"></i></a>
                                            	<a class="btn btn-default btn-sm" href="#"><i class="fa fa-plus"></i></a>
                                            </span>
                            </div>
                            <div class="form-group hidden-sm hidden-xs">
                                <label class="control-label col-md-3">Fax No.</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                                       <i class="fa fa-folder-o"></i>
                                                     </span>
                                        <input type="text" class="form-control" maxlength="16" id="company_contacts[]" id="maxlength_defaultconfig" placeholder="Enter Fax Number">
                                    </div>
                                </div>
                                <span class="hidden-xs hidden-sm">
                                            	<a class="btn btn-default btn-sm" href="#"><i class="fa fa-trash-o"></i></a>
                                            	<a class="btn btn-default btn-sm" href="#"><i class="fa fa-plus"></i></a>
                                            </span>
                            </div>
                            <!--end default view-->

                            <!--mobile view-->
                            <div class="form-group visible-sm visible-xs">
                                <label class="control-label col-md-3">Phone</label>
                                <div class="col-md-5">
                                    <div id="">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                       		<i class="fa fa-phone"></i>
                                                     	</span>
                                            <input type="text" class="form-control" maxlength="16" id="company_contacts[]" id="maxlength_defaultconfig" placeholder="Enter Phone Number">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-trash-o"></i> 
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group visible-sm visible-xs">
                                <label class="control-label col-md-3">Phone 2</label>
                                <div class="col-md-5">
                                    <div id="">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                       		<i class="fa fa-phone"></i>
                                                     	</span>
                                            <input type="text" class="form-control" maxlength="16" id="company_contacts[]" id="maxlength_defaultconfig" placeholder="Enter Phone Number">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-trash-o"></i> 
                                                </button>
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-plus"></i> 
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group visible-sm visible-xs">
                                <label class="control-label col-md-3">Mobile</label>
                                <div class="col-md-5">
                                    <div id="">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                       		<i class="fa fa-mobile"></i>
                                                     	</span>
                                            <input type="text" class="form-control" maxlength="16" id="company_contacts[]" id="maxlength_defaultconfig" placeholder="Enter Mobile Number">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-trash-o"></i> 
                                                </button>
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-plus"></i> 
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group visible-sm visible-xs">
                                <label class="control-label col-md-3">Fax</label>
                                <div class="col-md-5">
                                    <div id="">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                       		<i class="fa fa-print"></i>
                                                     	</span>
                                            <input type="text" class="form-control" maxlength="16" id="company_contacts[]" id="maxlength_defaultconfig" placeholder="Enter Fax Number">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-trash-o"></i> 
                                                </button>
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-plus"></i> 
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end mobile view-->



                            <h4 class="form-section">Branding</h4>

                            <div class="form-group ">
                                <label class="control-label col-md-3">Logo</label>
                                <div class="col-md-4">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                        </div>
                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                        <div>
                                            <span class="btn default btn-file">
                                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                            <input type="file" class="default">
                                            </span>
                                            <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                                        </div>
                                    </div>
                                    <small class="help-block">
                                                Browse Image to upload logo.
                                                </small>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button class="btn green btn-sm" type="button" onclick="save_fg( $(this).parents('form') )"><i class="fa fa-check"></i> Save</button>
                                        <button class="btn blue btn-sm" type="submit">Save &amp; Add New</button>
                                        <a href="{{ $mod->url }}" class="btn default btn-sm">Back</a> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
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
	@include('edit/page_plugins')
@stop


@section('page_scripts')
	@parent
	@include('edit/page_scripts')
	<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script> 
@stop


@section('view_js')
	@parent
	{{ get_edit_js( $mod ) }}
@stop
