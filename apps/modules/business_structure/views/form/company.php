
<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="portlet">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form id="company-form" class="form-horizontal">
                    <input type="hidden" name="company[company_id]" value="<?php echo $company_id?>">
                    <div class="form-body">

                        <p class="margin-bottom-25"></p>

                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Company Name<span class="required">*</span></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="company[company]" value="<?php echo $company?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Company Code<span class="required">*</span></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="company[company_code]" value="<?php echo $company_code?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Business Group</label>
                            <div class="col-md-7"><?php 
                                echo form_dropdown('company[business_group_id]',$group_options, $group_id, 'class="form-control" data-placeholder="Select..."');
                            ?>
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
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Cancel</button>
    <button type="button" onclick="save_company()" class="btn btn-success btn-sm">Save</button>
</div>
