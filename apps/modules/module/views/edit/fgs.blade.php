<div id="tab-1" class="tab-pane active"> 

   	<div class="portlet">
        <div class="portlet-title">
            <div class="caption">Basic Information</div>
        </div>
        <div class="portlet-body form">

            <input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">

            <form method="post" id="form-1" fg_id="1" class="form-horizontal">   
                <!-- <p><span class="label label-success">NOTE:</span>&nbsp;Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy.<br></p> -->
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-2">Module Name</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="modules[short_name]" id="modules-short_name" placeholder="Enter Module Name" value="{{ $record['modules.short_name'] }}">
                            <!-- <small class="help-block">Enter Module Name.</small> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Long Name</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="modules[long_name]" id="modules-long_name" placeholder="Enter Module Description" value="{{ $record['modules.long_name'] }}">
                            <!-- <small class="help-block">Enter Descriptive Name.</small> -->
                        </div>
                    </div>
					<hr />
                    <div class="form-group">
                        <label class="control-label  col-md-2">Icon</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="modules[icon]" id="modules-icon" placeholder="Enter Icon Name" value="{{ $record['modules.icon'] }}">
                            <small class="help-block">Must use Font Awesome Icon names.</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label  col-md-2">Description</label>
                        <div class="col-md-7">
                            <textarea class="form-control" name="modules[description]" id="modules-description"  rows="4">{{ $record['modules.description'] }}</textarea>
                            <!-- <small class="help-block">Enter Module Description.</small> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Disable</label>
                        <div class="col-md-7">
                            <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                <input type="checkbox" value="1" @if( $record['modules.disabled'] ) checked="checked" @endif name="modules[disabled][temp]" id="modules-disabled-temp" class="dontserializeme toggle"/>
                                <input type="hidden" value="@if( $record['modules.disabled'] ) 1 else 0 @endif" name="modules[disabled]" id="modules-disabled"/>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                </div>
                <div class="form-actions fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn green" type="button" onclick="save_fg( $(this).parents('form') )"><i class="fa fa-check"></i> Save</button>
                                <button class="btn blue" type="reset" value="Reset"><i class="fa fa-undo"></i> Reset</button>
                                <a href="{{ $mod->url }}" class="btn default">Back to List</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>

    </div>   <!-- END <div class="portlet"> -->

</div>   <!-- END <div id="tab-1" class="tab-pane active">  -->


<div id="tab-2" class="tab-pane">

    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">Module Configuration</div>
        </div>
        <div class="portlet-body form">

        	<form method="post" id="form-2" fg_id="2" class="form-horizontal"> 
                <!-- <p><span class="label label-success">NOTE:</span>&nbsp;Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy.<br></p> -->
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-2">Module Code</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="modules[mod_code]" id="modules-mod_code" placeholder="Enter Module Code" value="{{ $record['modules.mod_code'] }}">
                            <small class="help-block">Unique Code to be used by the system.</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Route</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="modules[route]" id="modules-route" placeholder="Enter Route" value="{{ $record['modules.route'] }}">
                            <small class="help-block">URI naming.</small>
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label class="control-label col-md-2">Main Table</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="modules[table]" id="modules-table" placeholder="Enter Primary Table" value="{{ $record['modules.table'] }}">
                            <!-- <small class="help-block">Enter Main Table.</small> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Primary Key</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="modules[primary_key]" id="modules-primary_key" placeholder="Enter Primary Key" value="{{ $record['modules.primary_key'] }}">
                            <!-- <small class="help-block">Enter Primary Key.</small> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Enable Action</label>
                        <div class="col-md-7">
                            <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                <input type="checkbox" value="1" @if( $record['modules.enable_mass_action'] ) checked="checked" @endif name="field[modules][enable_mass_action][temp]" id="modules-enable_mass_action-temp" class="dontserializeme toggle"/>
                                <input type="hidden" value="{{ $record['modules.enable_mass_action'] }}" name="modules[enable_mass_action]" id="modules-enable_mass_action"/>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Wizard Type</label>
                        <div class="col-md-7">
                            <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                <input type="checkbox" value="1" @if( $record['modules.wizard_on_new'] ) checked="checked" @endif name="field[modules][wizard_on_new][temp]" id="modules-wizard_on_new-temp" class="dontserializeme toggle"/>
                                <input type="hidden" value="{{ $record['modules.wizard_on_new'] }}" name="modules[wizard_on_new]" id="modules-wizard_on_new"/>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label class="control-label  col-md-2">Template Header</label>
                        <div class="col-md-7">
                            <textarea class="form-control" name="modules[list_template_header]" id="modules-list_template"  rows="4">{{ $record['modules.list_template_header'] }}</textarea>
                            <!-- <small class="help-block">Enter Listing Template Header.</small> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label  col-md-2">Template Row</label>
                        <div class="col-md-7">
                            <textarea class="form-control" name="modules[list_template]" id="modules-list_template"  rows="4">{{ $record['modules.list_template'] }}</textarea>
                            <!-- <small class="help-block">Enter Listing Template.</small> -->
                        </div>
                    </div>
                </div>
                <div class="form-actions fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn green" type="button" onclick="save_fg( $(this).parents('form') )"><i class="fa fa-check"></i> Save</button>
                                <button class="btn blue" type="reset" value="Reset"><i class="fa fa-undo"></i> Reset</button>
                                <a href="{{ $mod->url }}" class="btn default">Back to List</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>

    </div>

</div>



<div id="tab-3" class="tab-pane">

    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">Field Groups</div>
            <div class="actions">
                <a id="goto_fg_add" href="javascript:edit_fg('')" class="btn btn-default btn-sm">
                    <i class="fa fa-plus"></i>
                </a>
                <a href="javascript: delete_fgs()" class="btn btn-default btn-sm">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" action="#">
                <div class="form-body">
                    <table class="table table-condensed table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="1%"><input type="checkbox" class="group-checkable" data-set=".fg-checker" /></th>
                                <th width="30%">Label</th>
                                <th width="34%" class="hidden-xs">Description</th>
                                <th width="15%">Status</th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="field-group-list">

                        </tbody>
                    </table>   
                </div>
            </form>
        </div>
    </div>
</div>
<div id="tab-4" class="tab-pane">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">Fields</div>
            <div class="actions">
                <a id="goto_field_add" href="javascript:edit_field('')" class="btn btn-default btn-sm">
                    <i class="fa fa-plus"></i>
                </a>
                <a href="javascript:delete_fields()" class="btn btn-default btn-sm">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" action="#">
                <div class="form-body">
                    <table class="table table-condensed table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="1%"><input type="checkbox" class="group-checkable" data-set=".field-checker" /></th>
                                <th width="20%">Label</th>
                                <th width="20%" class="hidden-xs">UITYPE</th>
                                <th width="20%" class="hidden-xs">Field Group</th>
                                <th width="9%" class="hidden-xs">Sequence</th>
                                <th width="10%">Status</th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="field-list">

                        </tbody>
                    </table>   
                </div>
            </form>

        </div>

    </div>
    
</div>