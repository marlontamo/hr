<div class="portlet">
	<div class="portlet-title">
		<div class="caption" id="education-category">{{ lang('recruitform.skills') }}</div>
		<div class="actions">
            <a class="btn btn-default" onclick="add_form('skills', 'skills')">
                <i class="fa fa-plus"></i>
            </a>
		</div>
	</div>
</div>

<!-- Previous Trainings : start doing the loop-->
<div id="personal_skills">
    <input type="hidden" name="skills_count" id="skills_count" value="1" />
    <div class="portlet">
    <div class="portlet-title">
        <!-- <div class="caption" id="education-category">Company Name</div> -->
        <div class="tools">
            <a class="text-muted" id="delete_skills-1" onclick="remove_form(this.id, 'skills', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
            <!-- <a class="collapse pull-right" href="javascript:;"></a> -->
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
              <!-- START FORM -->
{{--               <div class="form-group">
                <label class="control-label col-md-3 small">{{ lang('recruitform.skills_type') }}<span class="required">*</span></label>
                <div class="col-md-9">
                    <div class="input-icon">
                        <input type="text" class="form-control" name="recruitment_personal_history[skill-type][]" id="recruitment_personal_history-skill-type" placeholder="Enter Type"/>
                    </div>
                </div>
            </div> --}}
            <div class="form-group">
                <label class="control-label col-md-3 small">{{ lang('recruitform.skills_name') }}<span class="required">*</span></label>
                <div class="col-md-9">
                    <div class="input-icon">
                        <input type="text" class="form-control" name="recruitment_personal_history[skill-name][]" id="recruitment_personal_history-skill-name" placeholder="Enter Name"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 small">{{ lang('recruitform.proficiency_level') }}<span class="required">*</span></label>
                <div class="col-md-9">
                    <div class="input-icon">
                        <i class="fa fa-star"></i>
                        <select  class="form-control form-select" data-placeholder="Select..." name="recruitment_personal_history[skill-level][]" id="recruitment_personal_history-skill-level">
                            <option value="Advance">Advance</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Beginner">Beginner</option>
                        </select>
                 </div>
             </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-3 small">{{ lang('common.remarks') }}</label>
            <div class="col-md-9">
                <div class="input-icon">
                    <textarea rows="3" class="form-control" name="recruitment_personal_history[skill-remarks][]" id="recruitment_personal_history-skill-remarks" ></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
