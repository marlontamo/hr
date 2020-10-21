<div class="form-group hidden-sm hidden-xs" id="mobile-count-<?php echo $counting; ?>">
    <label class="control-label col-md-3 small">Mobile         
        <span class="mobile_count_display" id="mobile_display_count-<?php echo $counting; ?>"><?php echo $count; ?></span>
    </label>
        <div class="col-md-7">
            <div class="input-icon">
                <i class="fa fa-mobile"></i>
            <input type="text" class="form-control mask_number_contact" maxlength="16" name="recruitment_personal[mobile][]" id="recruitment_personal-mobile" placeholder="Enter Mobile Number" value="">
        </div>
    </div>
    <span class="hidden-xs hidden-sm add_delete_mobile">
        <a class="btn btn-default action_mobile" id="delete_mobile-<?php echo $counting; ?>" onclick="remove_form(this.id, 'mobile')" ><i class="fa fa-trash-o"></i></a>
        <a class="btn btn-default action_mobile add_mobile" id="add_mobile" onclick="add_form('contact_mobile', 'mobile')"><i class="fa fa-plus"></i></a>
    </span>
</div>


