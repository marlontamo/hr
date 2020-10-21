    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Accountabilities <small class="text-muted">edit</small></h4>
    </div>
    <form class="form-horizontal" id="form-12" partner_id="12" method="POST">
    <div class="modal-body padding-bottom-0">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet" id="bl_container">
                    <div class="portlet-body">
                        <!-- BEGIN FORM-->
                            <form action="#" class="form-horizontal">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Item Name<span class="required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" maxlength="25" name="partners_personal_history[accountabilities-name]" id="partners_personal_history-accountabilities-name" value="<?php echo array_key_exists('accountabilities-name', $details) ? $details['accountabilities-name'] : ""; ?>" placeholder="Enter Item Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Item Code<span class="required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" maxlength="25" name="partners_personal_history[accountabilities-code]" id="partners_personal_history-accountabilities-code" value="<?php echo array_key_exists('accountabilities-code', $details) ? $details['accountabilities-code'] : ""; ?>" placeholder="Enter Item Code">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Quantity</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" maxlength="25" name="partners_personal_history[accountabilities-quantity]" id="partners_personal_history-accountabilities-quantity" value="<?php echo array_key_exists('accountabilities-quantity', $details) ? $details['accountabilities-quantity'] : ""; ?>" placeholder="Enter Item Code">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Date Issued </label>
                                        <div class="col-md-7">
                                        <?php 
                                            $month_issued = array_key_exists('accountabilities-month-issued', $details) ? $details['accountabilities-month-issued'] : ""; 
                                            $day_issued = array_key_exists('accountabilities-day-issued', $details) ? $details['accountabilities-day-issued']."," : ""; 
                                            $year_issued = array_key_exists('accountabilities-year-issued', $details) ? $details['accountabilities-year-issued'] : "";
                                            $date_issued = $month_issued." ".$day_issued." ".$year_issued;                                     
                                        ?>
                                            <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                            <input type="text" class="form-control" name="partners_personal_history[date_issued]" id="partners_personal_history-date_issued" value="<?php echo $date_issued; ?>" placeholder="Enter Date Issued" >
                                                <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Date Returned</label>
                                        <div class="col-md-7">
                                        <?php 
                                            $month_returned = array_key_exists('accountabilities-month-returned', $details) ? $details['accountabilities-month-returned'] : ""; 
                                            $day_returned = array_key_exists('accountabilities-day-returned', $details) ? $details['accountabilities-day-returned']."," : ""; 
                                            $year_returned = array_key_exists('accountabilities-year-returned', $details) ? $details['accountabilities-year-returned'] : ""; 
                                            $date_returned = $month_returned." ".$day_returned." ".$year_returned; 
                                        ?>
                                            <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                            <input type="text" class="form-control" name="partners_personal_history[date_returned]" id="partners_personal_history-date_returned" value="<?php echo $date_returned; ?>" placeholder="Enter Date Returned" >
                                                <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Remarks</label>
                                        <div class="col-md-7">
                                            <textarea rows="3" class="form-control" name="partners_personal_history[accountabilities-remarks]" id="partners_personal_history-accountabilities-remarks" ><?php echo array_key_exists('accountabilities-remarks', $details) ? $details['accountabilities-remarks'] : ""; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
                            <!-- END FORM--> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer margin-top-0">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        <!-- <button type="button" class="btn green">Save</button> -->
        <button type="button" class="btn green" onclick="save_partner( $(this).parents('form') )">Save</button>
    </div>
    </form>