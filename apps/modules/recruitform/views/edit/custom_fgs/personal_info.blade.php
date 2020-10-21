<h5 class="kiosk-title bold">{{ lang('recruitform.personal_info') }}:</h5>

<div class="form-group">
    <label class="control-label col-md-3 small">
        {{ lang('recruitform.gender') }}<span class="required">*</span>
    </label>
    <div class="col-md-9">
        <?php
            $recruitment_gender_options = array('Male' => lang('common.male'), 'Female' => lang('common.female'));
        ?>
       <div class="input-group">
            <span class="input-group-addon">
               <i class="fa fa-user"></i>
             </span>
        {{ form_dropdown('recruitment_personal[gender]',$recruitment_gender_options, '', 'class="form-control select2me" data-placeholder="Select..."') }}
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.bday') }}<span class="required">*</span></label>
    <div class="col-md-9">
    	<div class="input-group input-medium date date-picker " data-date-format="MM dd, yyyy" data-date-end-date="-18y">
            <div class="input-icon">
                <input type="text" class="form-control" name="recruitment[birth_date]" id="recruitment-birth_date" value="" placeholder="Enter Birthday" >
            </div>
            <span class="input-group-btn">
            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.birthplace') }}</label>
    <div class="col-md-9">
        <div class="input-icon">
            <i class="fa fa-map-marker"></i>
            <input type="text" class="form-control" name="recruitment_personal[birth_place]" id="recruitment_personal-birth_place" value="" placeholder="Enter Birth Place"/>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.religion') }}</label>
    <div class="col-md-9">
        <div class="input-icon">
            <input type="text" class="form-control" name="recruitment_personal[religion]" id="recruitment_personal-religion" value="" placeholder="Enter Religion"/>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.nationality') }}</label>
    <div class="col-md-9">
        <div class="input-icon">
            <input type="text" class="form-control" name="recruitment_personal[nationality]" id="recruitment_personal-nationality" value="" placeholder="Enter Nationality"/>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.civil_status') }}</label>
    <div class="col-md-9">
        <?php
            $recruitment_civil_status_options = array('Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced');
        ?>
        {{ form_dropdown('recruitment_personal[civil_status]',$recruitment_civil_status_options, '', 'class="form-control select2me" data-placeholder="Select..."') }}
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.solo_parent') }}</label>
    <div class="col-md-9">
        <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
            <input type="checkbox" value="1"  name="recruitment_personal[solo_parent][temp]" id="recruitment_personal-solo_parent-temp" class="dontserializeme toggle"/>
            <input type="hidden" name="recruitment_personal[solo_parent]" id="recruitment_personal-solo_parent" value="1"/>
        </div> 
    </div>
</div>