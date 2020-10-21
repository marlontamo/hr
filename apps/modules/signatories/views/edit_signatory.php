<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" id="edit_signatory">
                	<input type="hidden" name="id" value="<?php echo $signatory->id?>" />
                    <input type="hidden" name="set_for" value="<?php echo $set_for?>" />
					<input type="hidden" name="company_id" value="<?php echo $company_id?>" />
                    <input type="hidden" name="department_id" value="<?php echo $department_id?>" />
                    <input type="hidden" name="position_id" value="<?php echo $position_id?>" />
                    <input type="hidden" name="user_id" value="<?php echo $user_id?>" />
                    <input type="hidden" name="class_id" value="<?php echo $class_id?>" />
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-4">Company</label>
                            <div class="col-md-7">
                            	<input type="text" value="<?php echo $company?>" class="form-control form-control-inline" disabled="disabled"/>
                            </div>
                        </div>
                        <?php if( isset($department) ):?>
                            <div class="form-group">
                                <label class="control-label col-md-4">Department</label>
                                <div class="col-md-7">
                                    <input type="text" value="<?php echo $department?>" class="form-control form-control-inline" disabled="disabled"/>
                                </div>
                            </div>
                        <?php endif;?>
                        <?php if( isset($position) ):?>
                            <div class="form-group">
                                <label class="control-label col-md-4">Position</label>
                                <div class="col-md-7">
                                    <input type="text" value="<?php echo $position?>" class="form-control form-control-inline" disabled="disabled"/>
                                </div>
                            </div>
                        <?php endif;?>
                        <?php if( isset($employee) ):?>
                            <div class="form-group">
                                <label class="control-label col-md-4">Employee</label>
                                <div class="col-md-7">
                                    <input type="text" value="<?php echo $employee?>" class="form-control form-control-inline" disabled="disabled"/>
                                </div>
                            </div>
                        <?php endif;?>
                        <div class="form-group">
                            <label class="control-label col-md-4">Condition<span class="required">*</span></label>
                            <div class="col-md-7">
                               <?php echo form_dropdown('condition', $conditions, $signatory->condition, 'class="form-control select2me" data-placeholder="Select..."')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">User<span class="required">*</span></label>
                            <div class="col-md-7">
                                <?php echo form_dropdown('approver_id', $users, $signatory->approver_id, 'class="form-control select2me" data-placeholder="Select..."')?>
                                <div class="help-block small">
                                    Select Approver
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Sequence</label>
                            <div class="col-md-7">
                                <input type="text" name="sequence" value="<?php echo $signatory->sequence?>" class="form-control form-control-inline"/>
                                <div class="help-block small">
                                    Enter Sequence
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Signatory<span class="required">*</span></label>
                            <div class="col-md-7">
                                   <div class="make-switch switch-sm" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                        <input type="checkbox" name="approver" class="toggle" <?php if($signatory->approver) echo 'checked'?>/>
                                    </div>
                                <div class="help-block small">
                                    Enable to allow permission to approve.
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Email<span class="required">*</span></label>
                            <div class="col-md-7">
                                   <div class="make-switch switch-sm" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                        <input type="checkbox" name="email" class="toggle" <?php if($signatory->email) echo 'checked'?>/>
                                    </div>
                                <div class="help-block small">
                                    Enable to notify via email.
                                </div>
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
    <a type="button" class="btn green btn-sm" onclick="javascript: save_signatory()">Save</a>
</div>