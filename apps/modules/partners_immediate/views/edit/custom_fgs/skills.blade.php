<div class="portlet">
	<div class="portlet-title">
		<div class="caption" id="education-category">{{ lang('partners_immediate.skills') }}</div>
		<div class="actions">
            <a class="btn btn-default" onclick="add_form('skills', 'skills')">
                <i class="fa fa-plus"></i>
            </a>
		</div>
	</div>
</div>

<!-- Previous Trainings : start doing the loop-->
<div id="personal_skills">
    <?php $skills_count = count($skill_tab); ?>
    <input type="hidden" name="skills_count" id="skills_count" value="{{ $skills_count }}" />
    <?php 
    $count_skills = 0;
    foreach($skill_tab as $index => $skill){ 
        $count_skills++;
?>
<div class="portlet">
	<div class="portlet-title">
		<!-- <div class="caption" id="education-category">Company Name</div> -->
		<div class="tools">
            <a class="text-muted" id="delete_skills-<?php echo $count_skills;?>" onclick="remove_form(this.id, 'skills', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
			<!-- <a class="collapse pull-right" href="javascript:;"></a> -->
		</div>
	</div>
	<div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
		<!-- START FORM -->
               <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.skills') }} {{ lang('partners_immediate.type') }} <span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[skill-type][]" id="partners_personal_history-skill-type" 
                        value="<?php echo array_key_exists('skill-type', $skill) ? $skill['skill-type'] : ""; ?>" placeholder="Enter Type"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.skills') }} {{ lang('partners_immediate.name') }} <span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[skill-name][]" id="partners_personal_history-skill-name" 
                        value="<?php echo array_key_exists('skill-name', $skill) ? $skill['skill-name'] : ""; ?>" placeholder="Enter Name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.proficiency_level') }} <span class="required">*</span></label>
                    <div class="col-md-6">
                        <?php
                            $users_proficiency_level_options = array('Advance' => 'Advance', 'Intermediate' => 'Intermediate', 'Beginner' => 'Beginner');
                        ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-star"></i>
                             </span>
                        {{ form_dropdown('partners_personal_history[skill-level][]',$users_proficiency_level_options, $skill['skill-level'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.remarks') }} </label>
                    <div class="col-md-6">
                        <textarea rows="3" class="form-control" name="partners_personal_history[skill-remarks][]" id="partners_personal_history-skill-remarks" ><?php echo array_key_exists('skill-remarks', $skill) ? $skill['skill-remarks'] : ""; ?></textarea>
                    </div>
                </div>

			</div>
		</div>
	</div>
</div>
<?php } ?>
</div>
<div class="form-actions fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-offset-3 col-md-8">
                <button class="btn green btn-sm" type="button" onclick="save_partner( $(this).parents('form') )" ><i class="fa fa-check"></i> {{ lang('common.save') }} </button>
                <button class="btn blue btn-sm" type="submit"><i class="fa fa-undo"></i> {{ lang('common.reset') }} </button>                               
            </div>
        </div>
    </div>
</div>
