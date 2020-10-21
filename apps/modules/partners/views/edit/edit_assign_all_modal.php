<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="col-md-7">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" id="edit_assign_all">
                    <input type="hidden" name="id" id="id" value="<?php echo $id?>" />
                    <input type="hidden" name="set_for" value="<?php echo $set_for?>" />
					<input type="hidden" name="company_id" value="<?php echo $company_id?>" />
                    <input type="hidden" name="department_id" value="<?php echo $department_id?>" />
                    <input type="hidden" name="position_id" value="<?php echo $position_id?>" />
                    <input type="hidden" name="user_id" value="<?php echo $user_id?>" />
                    <div class="form-body">
                        <!-- <div class="form-group">
                            <label class="control-label col-md-4"></label>
                            <div class="col-md-7">
                                <h3><?php //echo $class?></h3>
                            </div>
                        </div> -->
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
                               <?php echo form_dropdown('condition', $conditions, $signatory->condition, 'class="form-control select2me" placeholder="Select..."')?>
                                <!-- <select name="condition" id="condition" class="form-control select2me" data-placeholder="Select...">
                                    <option value=""></option>
                                    <?php foreach($conditions as $condition):?>
                                        <option value="<?php echo $condition?>"><?php echo $condition?></option>
                                    <?php endforeach;?>
                                </select> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">User<span class="required">*</span></label>
                            <div class="col-md-7">
                                <?php echo form_dropdown('approver_id', $users, $signatory->approver_id, 'class="form-control select2me" data-placeholder="Select..." id="approver_id" ')?>
                                <div class="help-block small">
                                    Select Approver
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Sequence</label>
                            <div class="col-md-7">
                                <input type="text" name="sequence" id="sequence" value="<?php echo $signatory->sequence ?>" class="form-control form-control-inline"/>
                                <div class="help-block small">
                                    Enter Sequence
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Signatory<span class="required">*</span></label>
                            <div class="col-md-7">
                                    <div class="make-switch switch-sm" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                        <input type="checkbox" id="approver-temp" name="approver" class="toggle" value="1" <?php if( $signatory->approver ) echo 'checked="checked"; '?>/>
                                        <input id="approver" type="hidden" name="approver" value="">
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
                                        <input type="checkbox" id="email-temp" name="email" class="toggle" value="1" <?php if( $signatory->email ) echo 'checked="checked"; '?>/>
                                        <input id="email-val" type="hidden" name="email" value="">
                                    </div>
                                <div class="help-block small">
                                    Enable to notify via email.
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM--> 
                <div class="form-group">
                    <label class="control-label col-md-4"></label>
                        <button type="button" class="btn green btn-sm" onclick="save_class_users()">Save</button>
                </div>
            </div>
        </div>
        <div class="col-md-5 padding-left-5">

            <div class="portlet-body form">
                <form class="form-horizontal" id="signatories">
                    <div class="form-body">
                        <table class="table table-condensed table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="1%" class="hidden">
                                    <th width="40%">Approver</th>
                                    <th width="18%" class="hidden-xs">Condition</th>
                                    <th width="18%" class="hidden-xs">Sequence</th>
                                    <th width="24%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="portlet-body" id="signatory-listing"></div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div> 
<div class="modal-footer margin-top-0">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
    <button type="button" class="btn green btn-sm" onclick="push_to_class_users(<?php echo $user_id?>)">Assign All</button>
</div>

<script>
$(document).ready(function(){
    $('#approver-temp').change(function(){
        if( $(this).is(':checked') )
            $('#approver').val('1');
        else
            $('#approver').val('0');
    });
    $('#email-temp').change(function(){
        if( $(this).is(':checked') )
            $('#email-val').val('1');
        else
            $('#email-val').val('0');
    });
});
</script>
