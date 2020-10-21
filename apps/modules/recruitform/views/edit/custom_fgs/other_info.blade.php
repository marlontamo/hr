<h5 class="kiosk-title bold">{{ lang('recruitform.other_info') }}:</h5>

<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.height') }}</label>
    <div class="col-md-9">
        <div class="input-icon">
            <input type="text" class="form-control" name="recruitment_personal[height]" id="recruitment_personal-height" value="" placeholder="Enter Height"/>
        </div>
    </div>
</div>

<div class="form-group hidden-sm hidden-xs">
    <label class="control-label col-md-3 small">{{ lang('recruitform.weight') }}</label>
    <div class="col-md-9">
        <div class="input-icon">
            <input type="text" class="form-control" name="recruitment_personal[weight]" id="recruitment_personal-weight" value="" placeholder="Enter Weight"/>
        </div>
    </div>
</div>
<div class="form-group hidden-sm hidden-xs">
    <label class="control-label col-md-3 small">{{ lang('recruitform.hobby') }}</label>
    <div class="col-md-9">
        <div class="input-icon">
            <i class="fa fa-star"></i>
            <input type="text" class="form-control" name="recruitment_personal[interests_hobbies]" id="recruitment_personal-interests_hobbies" value="" placeholder="Enter Interest and Hobbies"/>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.languages') }}</label>
    <div class="col-md-9">
        <div class="input-icon">                                   
        <input type="text" class="form-control" name="recruitment_personal[language]" id="recruitment_personal-language" value="" placeholder="Enter Language Known"/>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.dialects') }}</label>
    <div class="col-md-9">
        <div class="input-icon">
        <input type="text" class="form-control" name="recruitment_personal[dialect]" id="recruitment_personal-dialect" value="" placeholder="Enter Dialects"/>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.no_dependents') }}</label>
    <div class="col-md-9">
        <div class="input-icon">
        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" class="form-control" name="recruitment_personal[dependents_count]" id="recruitment_personal-dependents_count" value="" placeholder="Enter No. of Dependents"/>
        </div>
    </div>
</div>