<div class="col-md-12">
    <div class="form-group">
        <label class="control-label col-md-4 col-sm-4 text-right"> Employee:<span class="required">*</span></label>
        <div class="col-md-6 col-sm-6">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                </span>
                <select class="form-control" data-placeholder="Select..." name="time_shift_class_company[partners_id][]" id="time_shift_class_company-partners_id" multiple="multiple">
                    <?php 
                        $partners_id = (strtolower($shift_class_details['partners_id']) == 'all') ? '' : explode(',', $shift_class_details['partners_id']);
                        foreach($partner_id_options as $index => $val) {
                        $selected_partners = (in_array($index, $partners_id)) ? "selected" : "";
                        ?>
                    <option value="<?php echo $index ?>" <?php echo $selected_partners; ?> ><?php echo $val; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>