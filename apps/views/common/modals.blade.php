<!-- /.: Module Add Modal View : module-mnager.php-->
<div id="add-module" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Module Section</h4>
            </div>
            <div class="modal-body">
                <div class="portlet" id="form_wizard_1">
                    <div class="row">
                        <div class="portlet-body form">
                            <form action="#" class="form-horizontal" id="submit_form">
                                <div class="form-wizard">
                                    <div class="form-body">
                                        <ul class="nav nav-pills nav-justified steps">
                                            <li>
                                                <a href="#tab1" data-toggle="tab" class="step">
                                                <span class="number">1</span>
                                                <span class="desc"><i class="fa fa-check"></i> Basic Information</span>   
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab2" data-toggle="tab" class="step">
                                                <span class="number">2</span>
                                                <span class="desc"><i class="fa fa-check"></i> Design and Layout</span>   
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab3" data-toggle="tab" class="step active">
                                                <span class="number">3</span>
                                                <span class="desc"><i class="fa fa-check"></i> Database Configurations</span>   
                                                </a>
                                            </li>
                                        </ul>
                                        <div id="bar" class="progress progress-striped" role="progressbar">
                                            <div class="progress-bar progress-bar-success"></div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="alert alert-danger display-none">
                                                <button class="close" data-dismiss="alert"></button>
                                                You have some form errors. Please check below.
                                            </div>
                                            <div class="alert alert-success display-none">
                                                <button class="close" data-dismiss="alert"></button>
                                                Your form validation is successful!
                                            </div>
                                            
                                            <!-- tab1-->
                                            <div class="tab-pane active" id="tab1">
                                                <h4>Lorem Ipsum sit amet</h4>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Module Name<span class="required">*</span></label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" maxlength="25" name="module_name" id="maxlength_defaultconfig" placeholder="">
                                                        <small class="help-block">
                                                        Enter Module Name.
                                                        </small>
                                                    </div>
                                                </div>
                                                 <div class="form-group">
                                                    <label class="control-label col-md-4">Module Caption<span class="required">*</span></label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" maxlength="25" name="module_caption" id="maxlength_defaultconfig" placeholder="">
                                                        <small class="help-block">
                                                        Enter Module caption.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Code<span class="required">*</span></label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" maxlength="25" name="module_code" id="maxlength_defaultconfig" placeholder="">
                                                        <small class="help-block">
                                                        Enter Code.
                                                        </small>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Status</label>
                                                    <div class="col-md-7">
                                                         <div class="make-switch" data-on-label="&nbsp;Enable&nbsp;" data-off-label="&nbsp;Disable&nbsp;">
                                                            <input type="checkbox" checked class="toggle"/>
                                                        </div>
                                                        <small class="help-block">
                                                        Enable and Disable Status.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label  col-md-4">Module Description</label>
                                                    <div class="col-md-7">
                                                        <textarea id="maxlength_textarea" class="form-control" maxlength="225" rows="2"></textarea>
                                                    <small class="help-block">
                                                        Enter module description.
                                                    </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab1-->
                                            
                                            <!-- tab2-->
                                            <div class="tab-pane" id="tab2">
                                                <h3 class="block">Provide your profile details</h3>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Visibility</label>
                                                    <div class="col-md-7">
                                                       
                                                        <div class="make-switch" data-on-label="&nbsp;Enable&nbsp;" data-off-label="&nbsp;Disable&nbsp;">
                                                            <input type="checkbox" checked class="toggle"/>
                                                        </div>
                                                        <small class="help-block">
                                                        Enable and Disable Visibility of the module.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Enable Actions</label>
                                                    <div class="col-md-7">
                                                       <div class="make-switch" data-on-label="&nbsp;Enable&nbsp;" data-off-label="&nbsp;Disable&nbsp;">
                                                            <input type="checkbox" checked class="toggle"/>
                                                        </div>
                                                        <small class="help-block">
                                                        Enable and Disable Actions of the module.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Set Action Column Alignment</label>
                                                    <div class="col-md-7">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                            <i class="fa fa-list-ul"></i>
                                                            </span>
                                                            <select  class="form-control select2me" data-placeholder="Select...">
                                                                <option value="">Top</option>
                                                                <option value="">Left</option>
                                                                <option value="">Center</option>
                                                                <option value="">Right</option>
                                                            </select>
                                                        </div>
                                                        <!-- /input-group -->
                                                        <small class="help-block">
                                                        Select Column Alignment of the Action for the module.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Action Column Width</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="100">
                                                        <small class="help-block">
                                                        Enter Action Column Width.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Show Multiselect</label>
                                                    <div class="col-md-7">
                                                       <div class="make-switch" data-on-label="&nbsp;Enable&nbsp;" data-off-label="&nbsp;Disable&nbsp;">
                                                            <input type="checkbox" checked class="toggle"/>
                                                        </div>
                                                        <small class="help-block">
                                                        Enable and Disable Multiselect of the module.
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab2-->
                                            
                                            <!-- tab3-->
                                            <div class="tab-pane" id="tab3">
                                                <h3 class="block">Provide your billing and credit card details</h3>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Module Table</label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Dashboard">
                                                        <small class="help-block">
                                                        Enter Module Table Name.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Class Name</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Dashboard">
                                                        <small class="help-block">
                                                        Enter Module Class Name.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Key Field</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Dashboard">
                                                        <small class="help-block">
                                                        Enter Module Key Field Name.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Class Path</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Dashboard">
                                                        <small class="help-block">
                                                        Enter Module Class Path.
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab3-->
                                            
                                        </div>
                                    </div>
                                    <div class="form-actions fluid">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <a href="javascript:;" class="btn default button-previous">
                                                    <i class="m-icon-swapleft"></i> Back 
                                                    </a>
                                                    <a href="javascript:;" class="btn blue button-next">
                                                    Continue <i class="m-icon-swapright m-icon-white"></i>
                                                    </a>
                                                    <a href="javascript:;" class="btn green button-submit">
                                                    Submit <i class="m-icon-swapright m-icon-white"></i>
                                                    </a>                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajax" tabindex="-1" role="basic" aria-hidden="true">
    <img src="{{ theme_path() }}img/ajax-modal-loading.gif" alt="" class="loading">
</div>
<!-- /.modal end -->
                        





<!-- /.: Field Add Modal View : module-mnager-edit.php-->
<div class="modal fade" id="field-add" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Fields Groups</h4>
            </div>
            <div class="modal-body">
                <div class="portlet" id="form_wizard_1">
                    <div class="row">
                        <div class="portlet-body form">
                            <form action="#" class="form-horizontal" id="submit_form">
                                <div class="form-wizard">
                                    <div class="form-body">
                                        <ul class="nav nav-pills nav-justified steps">
                                            <li>
                                                <a href="#tab1" data-toggle="tab" class="step">
                                                <span class="number">1</span>
                                                <span class="desc"><i class="fa fa-check"></i> Basic Information</span>   
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab3" data-toggle="tab" class="step active">
                                                <span class="number">2</span>
                                                <span class="desc"><i class="fa fa-check"></i> Database Configurations</span>   
                                                </a>
                                            </li>
                                        </ul>
                                        <div id="bar" class="progress progress-striped" role="progressbar">
                                            <div class="progress-bar progress-bar-success"></div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="alert alert-danger display-none">
                                                <button class="close" data-dismiss="alert"></button>
                                                You have some form errors. Please check below.
                                            </div>
                                            <div class="alert alert-success display-none">
                                                <button class="close" data-dismiss="alert"></button>
                                                Your form validation is successful!
                                            </div>
                                            
                                            <!-- tab1-->
                                            <div class="tab-pane active" id="tab1">
                                                <h4 class="block">Provide your basic information:</h4>
                                                
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Module Name<span class="required">*</span></label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" maxlength="25" name="module_name" id="maxlength_defaultconfig" placeholder="">
                                                        <small class="help-block">
                                                        Enter Module Name.
                                                        </small>
                                                    </div>
                                                </div>
                                                 <div class="form-group">
                                                    <label class="control-label col-md-4">Module Caption<span class="required">*</span></label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" maxlength="25" name="module_caption" id="maxlength_defaultconfig" placeholder="">
                                                        <small class="help-block">
                                                        Enter Module caption.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Code<span class="required">*</span></label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" maxlength="25" name="module_code" id="maxlength_defaultconfig" placeholder="">
                                                        <small class="help-block">
                                                        Enter Code.
                                                        </small>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Status</label>
                                                    <div class="col-md-7">
                                                         <div class="make-switch" data-on-label="&nbsp;Enable&nbsp;" data-off-label="&nbsp;Disable&nbsp;">
                                                            <input type="checkbox" checked class="toggle"/>
                                                        </div>
                                                        <small class="help-block">
                                                        Enable and Disable Status.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label  col-md-4">Module Description</label>
                                                    <div class="col-md-7">
                                                        <textarea id="maxlength_textarea" class="form-control" maxlength="225" rows="2"></textarea>
                                                    <small class="help-block">
                                                        Enter module description.
                                                    </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab1-->
                                            
                                            <!-- tab3-->
                                            <div class="tab-pane" id="tab3">
                                                <h3 class="block">Provide your billing and credit card details</h3>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Module Table</label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Dashboard">
                                                        <small class="help-block">
                                                        Enter Module Table Name.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Class Name</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Dashboard">
                                                        <small class="help-block">
                                                        Enter Module Class Name.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Key Field</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Dashboard">
                                                        <small class="help-block">
                                                        Enter Module Key Field Name.
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Class Path</label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Dashboard">
                                                        <small class="help-block">
                                                        Enter Module Class Path.
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab3-->
                                            
                                        </div>
                                    </div>
                                    <div class="form-actions fluid">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <a href="javascript:;" class="btn default button-previous">
                                                    <i class="m-icon-swapleft"></i> Back 
                                                    </a>
                                                    <a href="javascript:;" class="btn blue button-next">
                                                    Continue <i class="m-icon-swapright m-icon-white"></i>
                                                    </a>
                                                    <a href="javascript:;" class="btn green button-submit">
                                                    Submit <i class="m-icon-swapright m-icon-white"></i>
                                                    </a>                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajax" tabindex="-1" role="basic" aria-hidden="true">
    <img src="{{ theme_path() }}img/ajax-modal-loading.gif" alt="" class="loading">
</div>
<!-- /.modal end-->

<!-- /.: Field Add Modal Edit: module-mnager-edit.php-->
<div class="modal fade" id="field-edit" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Field Edit Section</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet">
                            <div class="tabbable-custom ">
                                <!-- BEGIN TAB NAV-->
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1_a" data-toggle="tab">Basic Information</a></li>
                                    <li class=""><a href="#tab_2_a" data-toggle="tab">Fields and Database Configurations</a></li>
                                </ul>
                                <!-- END TAB NAV-->
                                <!-- BEGIN TAB CONTENT-->
                                <div class="tab-content">
                                    <!-- BEGIN TAB CONTENT 1a-->
                                    <div class="tab-pane fade active in" id="tab_1_a">
                                        <!-- BEGIN PORTLET-->
                                        <div class="portlet">
                                           
                                            <div class="portlet-body form">
                                                <!-- BEGIN FORM-->
                                                <form action="#" class="form-horizontal">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Module Name</label>
                                                            <div class="col-md-4">
                                                                <div class="input-group">
                                                                    <select class="form-control select2me" data-placeholder="Select...">
                                                                        <option value="">Employee Education</option>
                                                                    </select>
                                                                </div>
                                                                <!-- /input-group -->
                                                                <small class="help-block">
                                                                Select Module. </small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Field Label</label>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Dashboard">
                                                                <small class="help-block">
                                                                Enter Module Key Field Name. </small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Field Group</label>
                                                            <div class="col-md-4">
                                                                <div class="input-group">
                                                                    <select class="form-control select2me" data-placeholder="Select...">
                                                                        <option value="">Education</option>
                                                                    </select>
                                                                </div>
                                                                <!-- /input-group -->
                                                                <small class="help-block">
                                                                Select Module. </small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Sequence</label>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="1">
                                                                <small class="help-block">
                                                                Enter Field sequence. </small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Status</label>
                                                            <div class="col-md-4">
                                                                <div class="make-switch" data-on-label="&nbsp;Enable&nbsp;" data-off-label="&nbsp;Disable&nbsp;">
                                                                    <input type="checkbox" checked class="toggle"/>
                                                                </div>
                                                                <small class="help-block">
                                                                Enable and Disable Status. </small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Quick Edit</label>
                                                            <div class="col-md-4">
                                                                <div class="make-switch" data-on-label="&nbsp;Enable&nbsp;" data-off-label="&nbsp;Disable&nbsp;">
                                                                    <input type="checkbox" checked class="toggle"/>
                                                                </div>
                                                                <small class="help-block">
                                                                Enable and Disable Status. </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Field Group</label>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <select class="form-control select2me" data-placeholder="Select...">
                                                                    <option value="">All Views</option>
                                                                    <option value="">View Section</option>
                                                                    <option value="">Edit Section</option>
                                                                    <option value="">None</option>
                                                                </select>
                                                            </div>
                                                            <!-- /input-group -->
                                                            <small class="help-block">
                                                            Select Module. </small>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Tab Index</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="1">
                                                            <small class="help-block">
                                                            Enter Field sequence. </small>
                                                        </div>
                                                    </div>
                                                    <div class="form-actions fluid">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="col-md-offset-3 col-md-9">
                                                                    <button type="button" class="btn green"><i class="fa fa-check"></i> Save</button>
                                                                    <button type="submit" class="btn blue"><i class="fa fa-undo"></i> Reset</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- END FORM-->
                                            </div>
                                        </div>
                                        <!-- END PORTLET-->
                                    </div>
                                    <!-- END TAB CONTENT 1-->
                                    <!-- BEGIN TAB CONTENT 2a-->
                                    <div class="tab-pane fade" id="tab_2_a">
                                        <!-- BEGIN PORTLET-->
                                        <div class="portlet">
                                            <div class="portlet-body form">
                                                <!-- BEGIN FORM-->
                                                <form action="#" class="form-horizontal">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Table</label>
                                                            <div class="col-md-4">
                                                                <div class="input-group">
                                                                    <select class="form-control select2me" data-placeholder="Select...">
                                                                        <option value="">Table_1</option>
                                                                        <option value="">Table_2</option>
                                                                        <option value="">Table_3</option>
                                                                        <option value="">Table_4</option>
                                                                    </select>
                                                                </div>
                                                                <!-- /input-group -->
                                                                <small class="help-block">
                                                                Select Module. </small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">UI Type</label>
                                                            <div class="col-md-4">
                                                                <div class="input-group">
                                                                    <select class="form-control select2me" data-placeholder="Select...">
                                                                        <option value="">UI_1</option>
                                                                        <option value="">UI_2</option>
                                                                        <option value="">UI_3</option>
                                                                        <option value="">UI_4</option>
                                                                    </select>
                                                                </div>
                                                                <!-- /input-group -->
                                                                <small class="help-block">
                                                                Select Module. </small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Column</label>
                                                            <div class="col-md-4">
                                                                <div class="input-group">
                                                                    <select class="form-control select2me" data-placeholder="Select...">
                                                                        <option value="">Column_1</option>
                                                                        <option value="">Column_2</option>
                                                                        <option value="">Column_3</option>
                                                                        <option value="">Column_4</option>
                                                                    </select>
                                                                </div>
                                                                <!-- /input-group -->
                                                                <small class="help-block">
                                                                Select Module. </small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Field Name</label>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="1">
                                                                <small class="help-block">
                                                                Enter Field sequence. </small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Data Type</label>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="M-1">
                                                                <small class="help-block">
                                                                Should be separated by a ~ (tilde). Possible values: V - Varchar (any character) / M - Mandatory / O - Optional / R - Read Only and Auto-generated value fields / E - Email (if not empty, must be a valid email) / U - URL (if not empty, must be valid URL) / I - Integer / F - Float / GE - Greater or equal / GT - Greater than / LE - Less or Equal / LT - Less Than / N - Numeric. / UN - Unique </small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Encrypt</label>
                                                            <div class="col-md-8">
                                                                <div class="make-switch" data-on-label="&nbsp;Enable&nbsp;" data-off-label="&nbsp;Disable&nbsp;">
                                                                    <input type="checkbox" checked class="toggle"/>
                                                                </div>
                                                                <small class="help-block">
                                                                Enable and Disable Encryption. </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-actions fluid">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="col-md-offset-3 col-md-9">
                                                                    <button type="button" class="btn green"><i class="fa fa-check"></i> Save</button>
                                                                    <button type="submit" class="btn blue"><i class="fa fa-undo"></i> Reset</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- END FORM-->
                                            </div>
                                        </div>
                                        <!-- END PORTLET-->
                                    </div>
                                    <!-- END TAB CONTENT 2a-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajax" tabindex="-1" role="basic" aria-hidden="true">
    <img src="{{ theme_path() }}img/ajax-modal-loading.gif" alt="" class="loading">
</div>
<!-- /.modal end-->

<!-- /.: Column Add Modal View : module-mnager-edit.php-->
<div id="column-add" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Column Settings</h4>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="portlet-body form">
                               <!-- BEGIN FORM-->
                                <form action="#" class="form-horizontal">
                                     <div class="form-body">
                                     
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Module Table</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Dashboard">
                                                    <small class="help-block">
                                                    Enter Module Table Name.
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Width</label>
                                                                <div class="col-md-8">
                                                                <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="1">
                                                                <small class="help-block">
                                                                Enter Column Width.
                                                                </small>
                                             </div>
                                             <div class="form-group">
                                                <label class="control-label col-md-4">Default</label>
                                                <div class="col-md-7">
                                                     <div class="make-switch" data-on-label="&nbsp;Enable&nbsp;" data-off-label="&nbsp;Disable&nbsp;">
                                                        <input type="checkbox" checked class="toggle"/>
                                                    </div>
                                                    <small class="help-block">
                                                    Enable and Disable Status.
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Visibility</label>
                                                <div class="col-md-7">
                                                     <div class="make-switch" data-on-label="&nbsp;Enable&nbsp;" data-off-label="&nbsp;Disable&nbsp;">
                                                        <input type="checkbox" checked class="toggle"/>
                                                    </div>
                                                    <small class="help-block">
                                                    Enable and Disable Status.
                                                    </small>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                  <label class="control-label col-md-4">Alignment</label>
                                                       <div class="col-md-7">
                                                             <div class="input-group">
                                                                 <select  class="form-control select2me" data-placeholder="Select...">
                                                                       <option value="">Center</option>
                                                                       <option value="">Left</option>
                                                                       <option value="">Right</option>
                                                                  </select>
                                                              </div>
                                                               <!-- /input-group -->
                                                               <small class="help-block">
                                                                    Select Column Alignment.
                                                               </small>
                                                          </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label col-md-4">Sort</label>
                                                <div class="col-md-7">
                                                   <div class="make-switch" data-on-label="&nbsp;Enable&nbsp;" data-off-label="&nbsp;Disable&nbsp;">
                                                        <input type="checkbox" checked class="toggle"/>
                                                    </div>
                                                    <small class="help-block">
                                                    Enable and Disable Sort.
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                  <label class="control-label col-md-4">Sort Direction</label>
                                                       <div class="col-md-7">
                                                             <div class="input-group">
                                                                 <select  class="form-control select2me" data-placeholder="Select...">
                                                                       <option value="">Ascending</option>
                                                                       <option value="">Descending</option>
                                                                  </select>
                                                              </div>
                                                               <!-- /input-group -->
                                                               <small class="help-block">
                                                                    Select Column Alignment.
                                                               </small>
                                                          </div>
                                              </div>
                                                            
                                              <div class="form-actions fluid">
                                                     <div class="row">
                                                           <div class="col-md-12">
                                                                   <div class="col-md-offset-3 col-md-9">
                                                                        <button type="button" class="btn green"><i class="fa fa-check"></i> Save</button>
                                                                        <button type="submit" class="btn blue"><i class="fa fa-undo"></i> Reset</button>
                                                                    </div>
                                                           </div>
                                                      </div>
                                            </div>
                                     </div>                 
                              </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajax" tabindex="-1" role="basic" aria-hidden="true">
    <img src="{{ theme_path() }}img/ajax-modal-loading.gif" alt="" class="loading">
</div>
<!-- /.modal end -->

<!-- /.: Column Edit Modal View : module-mnager-edit.php-->
<div id="column-edit" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Column</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="portlet-body form">
                       <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                                    <label class="control-label col-md-3">Width</label>
                                                    <div class="col-md-8">
                                                    <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="1">
                                                    <small class="help-block">
                                                    Enter Column Width.
                                                    </small>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-3">Alignment</label>
                                           <div class="col-md-8">
                                                 <div class="input-group">
                                                     <select  class="form-control select2me" data-placeholder="Select...">
                                                           <option value="">Center</option>
                                                           <option value="">Left</option>
                                                           <option value="">Right</option>
                                                      </select>
                                                  </div>
                                                   <!-- /input-group -->
                                                   <small class="help-block">
                                                        Select Column Alignment.
                                                   </small>
                                              </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Sort</label>
                                    <div class="col-md-4">
                                       <div class="make-switch" data-on-label="&nbsp;Enable&nbsp;" data-off-label="&nbsp;Disable&nbsp;">
                                            <input type="checkbox" checked class="toggle"/>
                                        </div>
                                        <small class="help-block">
                                        Enable and Disable Sort.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-md-3">Sort Direction</label>
                                   <div class="col-md-8">
                                         <div class="input-group">
                                             <select  class="form-control select2me" data-placeholder="Select...">
                                                   <option value="">Ascending</option>
                                                   <option value="">Descending</option>
                                              </select>
                                          </div>
                                           <!-- /input-group -->
                                           <small class="help-block">
                                                Select Column Alignment.
                                           </small>
                                    </div>
                                </div>
                            </div>
                                                    
                            <div class="form-actions fluid">
                               <div class="row">
                                   <div class="col-md-12">
                                           <div class="col-md-offset-3 col-md-9">
                                                <button type="button" class="btn green"><i class="fa fa-check"></i> Save</button>
                                                <button type="submit" class="btn blue"><i class="fa fa-undo"></i> Reset</button>
                                            </div>
                                   </div>
                               </div>
                            </div>
                        </div>                 
                      </form>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajax" tabindex="-1" role="basic" aria-hidden="true">
    <img src="{{ theme_path() }}img/ajax-modal-loading.gif" alt="" class="loading">
</div>
<!-- /.modal end -->

<!-- /.: Template Add Modal View : template-mnager.php-->
<div id="template-add" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Template</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="portlet-body form">
                       <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Module Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="System">
                                        <small class="help-block">
                                        Enter Module Name.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Template Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig">
                                        <small class="help-block">
                                        Enter the Template Name.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Subject</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig">
                                        <small class="help-block">
                                        Enter the Template Subject.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Description</label>
                                    <div class="col-md-9">
                                        <textarea id="maxlength_textarea" class="form-control" maxlength="225" rows="2"></textarea>
                                        <small class="help-block">
                                        This area define as the description of the template.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Code</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig">
                                        <small class="help-block">
                                        Enter the Template Code
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label  col-md-3">Template Body</label>
                                    <div class="col-md-9">
                                        <textarea class="ckeditor form-control" name="editor1" rows="6"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="button" class="btn green"><i class="fa fa-check"></i> Save</button>
                                            <button type="submit" class="btn blue"><i class="fa fa-undo"></i> Reset</button>
                                            <a class="btn default" href="template-manager2.php">Back</a>                               
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>          
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajax" tabindex="-1" role="basic" aria-hidden="true">
    <img src="{{ theme_path() }}img/ajax-modal-loading.gif" alt="" class="loading">
</div>
<!-- /.modal end -->
                                                
                                                
                                                
                                                