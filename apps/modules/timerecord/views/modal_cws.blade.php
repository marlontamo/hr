<div id="cws_form" class="modal fade" tabindex="-1" data-width="800">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Change Work Schedule</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-8">
                <div class="portlet">
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Employee Name<span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Doe">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">New Schedule<span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <select  class="form-control select2me" data-placeholder="Select...">
                                            <option>8:00am - 5:00pm (M-F)</option>
                                            <option>8:30am - 5:30pm (M-F)</option>
                                            <option>9:00am - 6:00pm (M-F)</option>
                                            <option>9:30am - 6:30pm (M-F)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Current Schedule<span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <select  class="form-control select2me" data-placeholder="Select...">
                                            <option>8:00am - 5:00pm (M-F)</option>
                                            <option>8:30am - 5:30pm (M-F)</option>
                                            <option>9:00am - 6:00pm (M-F)</option>
                                            <option>9:30am - 6:30pm (M-F)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Date From<span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy">
                                            <input type="text" class="form-control" readonly>
                                            <span class="input-group-btn">
                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Date To<span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy">
                                            <input type="text" class="form-control" readonly>
                                            <span class="input-group-btn">
                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Reason<span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <textarea rows="4" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">File Upload</label>
                                    <div class="controls col-md-7">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <span class="btn default btn-file">
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select</span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                            <input type="file" class="default" />
                                            </span>
                                            <span class="fileupload-preview" style="margin-left:5px;"></span>
                                            <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                        </div>
                                        <div class="help-block small">
                                            Supporting Documents
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </form>
                        <!-- END FORM--> 
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="portlet">
                    <div class="portlet-body">
                        <div class="clearfix">
                            <div class="panel panel-success">
                                <!-- Default panel contents -->
                                <div class="panel-heading">
                                    <h4 class="panel-title">Shift Details</h4>
                                </div>
                                
                                <!-- Table -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="small">Shift</th>
                                            <th class="small">Shift Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="small">Time in</td>
                                            <td class="small text-info">9:00am</td>
                                        </tr>
                                        <tr>
                                            <td class="small">Time out</td>
                                            <td class="small text-info">6:00pm</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="clearfix">
                            <div class="panel panel-success">
                                <!-- Default panel contents -->
                                <div class="panel-heading">
                                    <h4 class="panel-title">Approver/s</h4>
                                </div>

                                <ul class="list-group">
                                    <li class="list-group-item">Mahistardo, John<br><small class="text-muted">Manager</small> </li>
                                    <li class="list-group-item">Mendoza, Joel<br><small class="text-muted">Director</small> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
        <button type="button" class="btn green btn-sm">Save changes</button>
    </div>
</div>