<div class="portlet">
    <div class="portlet-title kiosk-title bold">
        <div class="caption" id="family-category">{{ lang('recruitform.family') }}</div>
        <div class="tools">
            <a class="collapse" href="javascript:;"></a>
        </div>
    </div>
    <div class="margin-bottom-25 help-block small">
        SINGLE: children, parents and siblings;
        &nbsp;
        MARRIED: spouse, children and parents
    </div>
    <div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
                <!-- START FORM -->             
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.relationship') }}</label>
                    <div class="col-md-8">
                        <?php   $db->select('family_relationship_id,family_relationship');
                                $db->where('deleted', '0');
                                $options = $db->get('partners_family_relationship');

                                $family_relationship_options = array('' => 'Select..');
                                foreach($options->result() as $option)
                                {
                                    $family_relationship_options[$option->family_relationship] = $option->family_relationship;
                                } ?>

                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('family_category',$family_relationship_options, 'Father', 'class="form-control select2me" id="family_category"') }}                   
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" onclick="add_form('family', 'family')"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                        <div class="help-block small">
                            {{ lang('recruitform.select_relationship') }}
                        </div>
                        <!-- /input-group -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="personal_family">
    <input type="hidden" name="family_count" id="family_count" value="1">
    <div class="portlet">
        <div class="portlet-title">
        <div class="caption small" id="family-category">
            <input type="hidden" name="recruitment_personal_history[family-relationship][]" 
            id="recruitment_personal_history-family-relationship" value="Father" />
            {{ lang('recruitform.father') }}
        </div>
            <div class="tools">
                <a class="text-muted" id="delete_family-1" onclick="remove_form(this.id, 'family', 'history')"  style="margin-botom:-15px;" href="#"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
                <!-- <a class="collapse pull-right" href="javascript:;"></a> -->
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-horizontal">
                <div class="form-body">
                    <!-- START FORM --> 
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.name') }}<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" name="recruitment_personal_history[family-name][]" id="recruitment_personal_history-family-name1" placeholder="Enter Title"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.bday') }}<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                <input type="text" class="form-control" onchange="_calculateAge(this, 1);"
                                name="recruitment_personal_history[family-birthdate][]" 
                                id="recruitment_personal_history-family-birthdate1" placeholder="Enter Birthday" >
                                <span class="input-group-btn">
                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.age') }}</label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input readonly type="text" class="form-control" name="recruitment_personal_history[family-age][]" id="recruitment_personal_history-family-age1" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.occupation') }}</label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" name="recruitment_personal_history[family-occupation][]" id="recruitment_personal_history-family-occupation1" placeholder="Enter Occupation"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.employer') }}</label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" name="recruitment_personal_history[family-employer][]" id="recruitment_personal_history-family-employer1" placeholder="Enter Employer"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>