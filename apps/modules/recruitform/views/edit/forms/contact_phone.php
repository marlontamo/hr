<div class="form-group hidden-sm hidden-xs" id="phone-count-<?php echo $counting; ?>">
    <label class="control-label col-md-3 small">Phone
        <span class="phone_count_display" id="phone_display_count-<?php echo $counting; ?>"><?php echo $count; ?></span>
    </label>
        <div class="col-md-7">
            <div class="input-icon">
                <i class="fa fa-phone"></i>
            <input type="text" class="form-control mask_number_contact" maxlength="16" name="recruitment_personal[phone][]" id="recruitment_personal[phone]" placeholder="Enter Telephone Number" value="">
        </div>
    </div>
    <span class="hidden-xs hidden-sm add_delete_phone">
        <a class="btn btn-default action_phone" id="delete_phone-<?php echo $counting; ?>" onclick="remove_form(this.id, 'phone')" ><i class="fa fa-trash-o"></i></a>
        <a class="btn btn-default action_phone add_phone" id="add_phone" onclick="add_form('contact_phone', 'phone')"><i class="fa fa-plus"></i></a>
    </span>
</div>