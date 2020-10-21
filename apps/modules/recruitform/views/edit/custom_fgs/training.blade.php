<div class="portlet">
    <div class="portlet-title">
        <div class="caption" id="training-category">{{ lang('recruitform.training') }}</div>
        <div class="tools">
            <a class="collapse" href="javascript:;"></a>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
                <!-- START FORM -->             
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.category') }}</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select  class="form-control select2me" data-placeholder="Select..." name="training_category" id="training_category">
                                <option value="Training">{{ lang('recruitform.train') }}</option>
                                <option value="Seminar">{{ lang('recruitform.seminar') }}</option>
                            </select>

                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" onclick="add_form('training_seminar', 'training')"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                        <div class="help-block small">
                            {{ lang('recruitform.add_training') }}
                        </div>
                        <!-- /input-group -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="personal_training">
    <input type="hidden" name="training_count" id="training_count" value="1" /><div class="portlet">
    <div class="portlet-title">
        <div class="caption" id="training-category">
            <input type="hidden" name="recruitment_personal_history[training-category][]" id="recruitment_personal_history-training-category" 
            value="Training" />
            {{ lang('recruitform.train') }}</div>
            <div class="tools">
                <a class="text-muted" id="delete_training-1" onclick="remove_form(this.id, 'training', 'history')"  style="margin-botom:-15px;" href="#"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
                <!-- <a class="collapse pull-right" href="javascript:;"></a> -->
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-horizontal">
                <div class="form-body">
                    <!-- START FORM --> 
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.title') }}<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" name="recruitment_personal_history[training-title][]" id="recruitment_personal_history-training-title" placeholder="Enter Title"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.venue') }}<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" name="recruitment_personal_history[training-venue][]" id="recruitment_personal_history-training-venue" placeholder="Enter Venue"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.start_date') }}<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-group input-medium pull-left">
                                <select  class="form-control form-select" data-placeholder="Select Month.." name="recruitment_personal_history[training-start-month][]" id="recruitment_personal_history-training-start-month">
                                    <option value="January">{{ lang('cal_january') }}</option>
                                    <option value="February">{{ lang('cal_february') }}</option>
                                    <option value="March">{{ lang('cal_march') }}</option>
                                    <option value="April">{{ lang('cal_april') }}</option>
                                    <option value="May">{{ lang('cal_may') }}</option>
                                    <option value="June">{{ lang('cal_june') }}</option>
                                    <option value="July">{{ lang('cal_july') }}</option>
                                    <option value="August">{{ lang('cal_august') }}</option>
                                    <option value="September">{{ lang('cal_september') }}</option>
                                    <option value="October">{{ lang('cal_october') }}</option>
                                    <option value="November">{{ lang('cal_november') }}</option>
                                    <option value="December">{{ lang('cal_december') }}</option>
                                </select>
                            </div>
                            <span class="pull-left padding-left-right-10">-</span>
                            <span class="pull-left"><input type="text" class="form-control input-small mask_number_year" maxlength="4" name="recruitment_personal_history[training-start-year][]" id="recruitment_personal_history-training-start-year" placeholder="Year"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.end_date') }}<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-group input-medium pull-left">
                                <select  class="form-control form-select" data-placeholder="Select Month.." name="recruitment_personal_history[training-end-month][]" id="recruitment_personal_history-employment-training-end-month">
                                    <option value="January">{{ lang('cal_january') }}</option>
                                    <option value="February">{{ lang('cal_february') }}</option>
                                    <option value="March">{{ lang('cal_march') }}</option>
                                    <option value="April">{{ lang('cal_april') }}</option>
                                    <option value="May">{{ lang('cal_may') }}</option>
                                    <option value="June">{{ lang('cal_june') }}</option>
                                    <option value="July">{{ lang('cal_july') }}</option>
                                    <option value="August">{{ lang('cal_august') }}</option>
                                    <option value="September">{{ lang('cal_september') }}</option>
                                    <option value="October">{{ lang('cal_october') }}</option>
                                    <option value="November">{{ lang('cal_november') }}</option>
                                    <option value="December">{{ lang('cal_december') }}</option>
                                </select>
                            </div>
                            <span class="pull-left padding-left-right-10">-</span>
                            <span class="pull-left"><input type="text" class="form-control input-small mask_number_year" maxlength="4" name="recruitment_personal_history[training-end-year][]" id="recruitment_personal_history-training-end-year" placeholder="Year"></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>