<div class="portlet">
	<div class="portlet-title kiosk-title bold">
		<div class="caption" id="education-category">{{ lang('recruitform.educ_bg') }}</div>
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
                            <select  class="form-control select2me" data-placeholder="Select..." name="education_category" id="education_category">
                            	<option value="Primary">{{ lang('recruitform.primary') }}</option>
                                <option value="Secondary">{{ lang('recruitform.secondary') }}</option>
                                <option value="Tertiary" >{{ lang('recruitform.tertiary') }}</option>
                                <option value="Vocational">{{ lang('recruitform.vocational') }}</option>
                                <option value="Graduate Studies" selected="selected">{{ lang('recruitform.graduate') }}</option>
                               <!--  <option value="Masters">Masters</option>
                                <option value="Doctorate">Doctorate</option> -->
                            </select>
                        
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-default" onclick="add_form('educational_background', 'education')"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                        <div class="help-block small">
                        	{{ lang('recruitform.add_education') }}
                    	</div>
                        <!-- /input-group -->
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<!-- Education : start doing the loop-->
<div id="personal_education">
    <input type="hidden" name="education_count" id="education_count" value="1" />
<div class="portlet">
    <div class="portlet-title small">
        <div class="caption" id="education-category">
            <input type="hidden" name="recruitment_personal_history[education-type][]" id="recruitment_personal_history-education-type" 
            value="Tertiary" />
            {{ lang('recruitform.graduate') }}
        </div>
        <div class="tools">
           <a class="text-muted" id="delete_education-1" onclick="remove_form(this.id, 'education', 'history')"  style="margin-botom:-15px;" href="#"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
             <a class="collapse pull-right" href="javascript:;"></a> 
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
              <!-- START FORM -->   
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.school') }}<span class="required">*</span></label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <input type="text" class="form-control" name="recruitment_personal_history[education-school][]" id="recruitment_personal_history-education-school" 
                            value="" placeholder="Enter School"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.start_year') }}<span class="required">*</span></label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <input type="text" class="form-control mask_number_year" name="recruitment_personal_history[education-year-from][]" id="recruitment_personal_history-education-year-from" 
                            value="" placeholder="Enter Year From"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.end_year') }}<span class="required">*</span></label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <input type="text" class="form-control mask_number_year" name="recruitment_personal_history[education-year-to][]" id="recruitment_personal_history-education-year-to" 
                            value="" placeholder="Enter Year To"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.honors') }}<span class="required">*</span></label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <input type="text" class="form-control" name="recruitment_personal_history[education-honors_awards][]" id="recruitment_personal_history-education-honors_awards" 
                            value="" placeholder="Enter Honors/Awards"/>
                        </div>
                    </div>
                </div>                
                <?php 
    $type_with_degree = array('tertiary', 'graduate studies', 'vocational');
                if(in_array(strtolower('tertiary'), $type_with_degree)) { 
                    ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.degree') }}<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" name="recruitment_personal_history[education-degree][]" id="recruitment_personal_history-education-degree" 
                                value="" placeholder="Enter Degree"/>
                            </div>
                        </div>
                    </div>
                    <?php 
                }else{
                    ?>
                    <div class="form-group" style="display:none;">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.degree') }}<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="hidden" class="form-control" name="recruitment_personal_history[education-degree][]" id="recruitment_personal_history-education-degree" 
                                value="" placeholder="Enter Degree"/>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('common.status') }}<span class="required">*</span></label>
                    <div class="col-md-9 checkbox-list">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="recruitment_personal_history[education-status][]" id="recruitment_personal_history-education-status-graduate-1"  
                            value="Graduated" onclick="check_graduate_status(this, 1);" />
                            {{ lang('recruitform.grad') }}
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="recruitment_personal_history[education-status][]" id="recruitment_personal_history-education-status-undergraduate-1" 
                            value="Undergrad" onclick="check_graduate_status(this, 1);"/> 
                            {{ lang('recruitform.ungrad') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>