<h5 class="kiosk-title bold">{{ lang('recruitform.personal_contact') }}:</h5>

<div id="personal_phone">
    <input type="hidden" name="phone_count" id="phone_count" value="1" />
    <input type="hidden" name="phone_counting" id="phone_counting" value="1" />
    <div class="form-group">
        <label class="control-label col-md-3 small">{{ lang('recruitform.phone') }}
        </label>
        <div class="col-md-7">
            <div class="input-icon">
                <i class="fa fa-phone"></i>
                <input type="text" class="form-control mask_number_contact" maxlength="64" name="recruitment_personal[phone][]" id="recruitment_personal-phone">
            </div>
        </div>
        <span class="hidden-xs hidden-sm add_delete_phone" >
            <a class="btn btn-default action_phone add_phone" id="add_phone" onclick="add_form('contact_phone', 'phone')" ><i class="fa fa-plus"></i></a>
        </span>
    </div>
</div>
<div id="personal_mobile">  
    <input type="hidden" name="mobile_count" id="mobile_count" value="1" />
    <input type="hidden" name="mobile_counting" id="mobile_counting" value="1" />
    <div class="form-group">
        <label class="control-label col-md-3 small">{{ lang('recruitform.mobile') }}
        </label>
        <div class="col-md-7">
            <div class="input-icon">
                <i class="fa fa-mobile"></i>
                <input type="text" class="form-control mask_number_contact" maxlength="64" name="recruitment_personal[mobile][]" id="recruitment_personal-mobile">
            </div>
        </div>
        <span class="hidden-xs hidden-sm add_delete_mobile">
            <a class="btn btn-default action_mobile add_mobile" id="add_mobile" onclick="add_form('contact_mobile', 'mobile')"><i class="fa fa-plus"></i></a>
        </span>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.email') }}
        <span class="required">*</span>
    </label>
    <div class="col-md-9">
        <div class="input-icon">
            <i class="fa fa-envelope"></i>
            <input type="text" class="form-control" maxlength="64" name="recruitment[email]" id="recruitment-email">
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.address') }}
        <span class="required">*</span>
    </label>
    <div class="col-md-9">
        <div class="input-icon">
            <i class="fa fa-map-marker"></i>
            <input type="text" class="form-control" maxlength="64" name="recruitment_personal[address_1]" id="recruitment_personal-address_1">
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.city') }}
        <span class="required">*</span>
    </label>
    <div class="col-md-9">
        <div class="input-icon">
            <i class="fa fa-map-marker"></i>
            <input type="text" class="form-control" maxlength="64" name="recruitment_personal[city_town]" id="recruitment_personal-city_town">
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">{{ lang('recruitform.province') }}</label>
    <div class="col-md-9">
        <div class="input-icon">
            <i class="fa fa-map-marker"></i>
            <input type="text" class="form-control" name="recruitment_personal[province]" id="recruitment_personal-province"/>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.country') }}
        <span class="required">*</span>
    </label>
    <div class="col-md-9">
        <div class="input-icon">
            <i class="fa fa-map-marker"></i>
            <input type="text" class="form-control" maxlength="64" name="recruitment_personal[country]" id="recruitment_personal-country">
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.zip') }}
        <!-- <span class="required">*</span> -->
    </label>
    <div class="col-md-9">
        <div class="input-icon">
            <!-- <i class="fa fa-envelope"></i> -->
            <input type="text" class="form-control" maxlength="64" name="recruitment_personal[zip_code]" id="recruitment_personal-zip_code">
        </div>
    </div>
</div>