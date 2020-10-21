<div class="form-group hidden-sm hidden-xs" id="mobile-count-<?php echo $counting; ?>">
    <label class="control-label col-md-3">Mobile         
        <span class="mobile_count_display" id="mobile_display_count-<?php echo $counting; ?>"><?php echo $count; ?></span>
    </label>
        <div class="col-md-5">
           <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
            <input type="text" class="form-control" maxlength="16" name="partners_personal[mobile][]" id="partners_personal-mobile" placeholder="Enter Mobile Number" value="">
        </div>
    </div>
    <span class="hidden-xs hidden-sm add_delete_mobile">
        <a class="btn btn-default action_mobile" id="delete_mobile-<?php echo $counting; ?>" onclick="remove_form(this.id, 'mobile')" ><i class="fa fa-trash-o"></i></a>
        <a class="btn btn-default action_mobile add_mobile" id="add_mobile" onclick="add_form('contact_mobile', 'mobile')"><i class="fa fa-plus"></i></a>
    </span>
</div>


