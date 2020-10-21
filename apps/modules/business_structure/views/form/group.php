
<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="portlet">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form id="group-form" class="form-horizontal">
                    <input type="hidden" name="group[group_id]" value="<?php echo $group_id?>">
                    <input type="hidden" name="group[region_id]" value="<?php echo $region_id?>">
                    <div class="form-body">

                        <p class="margin-bottom-25"></p>

                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Group Name<span class="required">*</span></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="group[group]" value="<?php echo $group?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Group Code<span class="required">*</span></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="group[group_code]" value="<?php echo $group_code?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 text-right">Description</label>
                            <div class="col-md-7">
                                <textarea rows="4" class="form-control" name="group[description]"><?php echo $description?></textarea>
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
    <button type="button" onclick="save_group()" class="btn btn-success btn-sm">Save</button>
</div>
