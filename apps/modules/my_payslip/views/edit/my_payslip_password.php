<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="portlet">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form class="form-horizontal" id="check-password">
                    <input type="hidden" name="record_id" value="<?php echo $_POST['record_id'] ?>">
                    <input type="hidden" name="payroll_date" value="<?php echo $_POST['payroll_date'] ?>">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label  col-md-3">Password</label>
                            <div class="col-md-8">
                                <div class="input-icon">
                                <i class="fa fa-key"></i>
                                <input class="form-control placeholder-no-fix" type="password" placeholder="Password" name="password" id="pword"/>
                            </div>
                            <small class="help-block">
                               Enter password.
                               <span style="display:none" id='caps-lock' class="text-danger"><br><i class="fa fa-warning"></i> Caps Lock is on </span> 
                            </small>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM--> 
            </div>
        </div>
    </div>
</div>    
<div class="modal-footer margin-top-0">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
    <a type="button" class="btn green btn-sm" data-dismiss="modal" onclick="ajax_export_custom()">Confirm</a>
</div>
