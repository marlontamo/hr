<div class="portlet">
	<div class="portlet-title">
		<div class="caption" id="employment-category">{{ lang('recruitform.employment_history') }}</div>
		<div class="actions">
            <a class="btn btn-default" onclick="add_form('employment_history', 'employment')">
                <i class="fa fa-plus"></i>
            </a>
		</div>
	</div>
</div>

<div id="personal_employment">
    <input type="hidden" name="employment_count" id="employment_count" value="1" /><div class="portlet">
   <div class="portlet-title">
      <!-- <div class="caption" id="education-category">Company Name</div> -->
      <div class="tools">
         <a class="text-muted" id="delete_employment-1" onclick="remove_form(this.id, 'employment', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
         <!-- <a class="collapse pull-right" href="javascript:;"></a> -->
     </div>
 </div>
 <div class="portlet-body form">
    <div class="form-horizontal">
        <div class="form-body">
          <!-- START FORM -->	
          <div class="form-group">
            <label class="control-label col-md-3 small">{{ lang('recruitform.comp_name') }}<span class="required">*</span></label>
            <div class="col-md-9">
                <div class="input-icon">
                    <input type="text" class="form-control" name="recruitment_personal_history[employment-company][]" id="recruitment_personal_history-employment-company" placeholder="Enter Company"/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 small">{{ lang('recruitform.pos_title') }}<span class="required">*</span></label>
            <div class="col-md-9">
                <div class="input-icon">
                    <input type="text" class="form-control" name="recruitment_personal_history[employment-position-title][]" id="recruitment_personal_history-employment-position-title" placeholder="Enter Position"/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 small">{{ lang('recruitform.location') }}</label>
            <div class="col-md-9">
                <div class="input-icon">
                    <input type="text" class="form-control" name="recruitment_personal_history[employment-location][]" id="recruitment_personal_history-employment-location" placeholder="Enter Location"/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 small">{{ lang('recruitform.hire_date') }}<span class="required">*</span>
            <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-9">
                <div class="input-group input-medium pull-left">
                    <select  class="form-control form-select" data-placeholder="Select Month.." name="recruitment_personal_history[employment-month-hired][]" id="recruitment_personal_history-employment-month-hired">
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
                <span class="pull-left"><input type="text" class="form-control input-small mask_number_year" maxlength="4" name="recruitment_personal_history[employment-year-hired][]" id="recruitment_personal_history-employment-year-hired" placeholder="Year"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 small">{{ lang('recruitform.end_date') }}<span class="required">*</span>
            <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-9">
                <div class="input-group input-medium pull-left">
                    <select  class="form-control form-select" data-placeholder="Select Month.." name="recruitment_personal_history[employment-month-end][]" id="recruitment_personal_history-employment-month-end">
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
                <span class="pull-left"><input type="text" class="form-control input-small mask_number_year" maxlength="4" name="recruitment_personal_history[employment-year-end][]" id="recruitment_personal_history-employment-year-end" placeholder="Year"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 small">{{ lang('recruitform.last_sal') }}</label>
            <div class="col-md-9">
                <div class="input-icon">
                    <input type="text" class="form-control" name="recruitment_personal_history[employment-last-salary][]" id="recruitment_personal_history-employment-last-salary" placeholder="Enter Last Salary"/>
                </div>
            </div>
        </div>        
        <div class="form-group">
            <label class="control-label col-md-3 small">{{ lang('recruitform.duties') }}</label>
            <div class="col-md-9">
                <div class="input-icon">
                    <textarea rows="3" class="form-control"name="recruitment_personal_history[employment-duties][]" id="recruitment_personal_history-employment-duties" ></textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 small">{{ lang('recruitform.reason_leaving') }}</label>
            <div class="col-md-9">
                <textarea rows="3" class="form-control"name="recruitment_personal_history[employment-reason-for-leaving][]" id="recruitment_personal_history-employment-reason-for-leaving" ></textarea>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>