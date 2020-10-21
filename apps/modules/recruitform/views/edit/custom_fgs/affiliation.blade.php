<div class="portlet">
	<div class="portlet-title">
		<div class="caption" id="education-category">{{ lang('recruitform.affiliation') }}</div>
		<div class="actions">
            <a class="btn btn-default" onclick="add_form('affiliation', 'affiliation')">
                <i class="fa fa-plus"></i>
            </a>
		</div>
	</div>
</div>

<div id="personal_affiliation">
    <input type="hidden" name="affiliation_count" id="affiliation_count" value="1" />
<div class="portlet">
    <div class="portlet-title">
        <!-- <div class="caption" id="education-category">Company Name</div> -->
        <div class="tools">
            <a class="text-muted" id="delete_affiliation-1" onclick="remove_form(this.id, 'affiliation', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
            <!-- <a class="collapse pull-right" href="javascript:;"></a> -->
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
        <!-- START FORM -->
               <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.affiliation_name') }}<span class="required">*</span></label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <input type="text" class="form-control" name="recruitment_personal_history[affiliation-name][]" id="recruitment_personal_history-affiliation-name" placeholder="Enter Name"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.position') }}<span class="required">*</span></label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <input type="text" class="form-control" name="recruitment_personal_history[affiliation-position][]" id="recruitment_personal_history-affiliation-position" placeholder="Enter Position"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.start_date') }}<span class="required">*</span></label>                    
                    <div class="col-md-9">
                        <div class="input-group input-medium pull-left">
                            <select  class="form-control form-select" data-placeholder="Select Month.." name="recruitment_personal_history[affiliation-month-start][]" id="recruitment_personal_history-affiliation-month-start">
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
                        <span class="pull-left"><input type="text" class="form-control input-small mask_number_year" maxlength="4" name="recruitment_personal_history[affiliation-year-start][]" id="recruitment_personal_history-affiliation-year-start" placeholder="Year"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.end_date') }}<span class="required">*</span></label>
                    <div class="col-md-9">
                    <div class="input-group input-medium pull-left">
                        <select  class="form-control form-select" data-placeholder="Select Month.." name="recruitment_personal_history[affiliation-month-end][]" id="recruitment_personal_history-affiliation-month-end">
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
                    <span class="pull-left"><input type="text" class="form-control input-small mask_number_year" maxlength="4" name="recruitment_personal_history[affiliation-year-end][]" id="recruitment_personal_history-affiliation-year-end" placeholder="Year"></span>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
