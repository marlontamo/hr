<?php $editable = false?>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption" id="education-category">{{ lang('my201.skills') }}</div>
        @if(in_array('skills', $partners_keys))
            @if($is_editable['skills'])
                <?php $editable = true?>
    		<div class="actions">
                <a class="btn btn-default" onclick="add_form('skills', 'skills')">
                    <i class="fa fa-plus"></i>
                </a>
    		</div>
            @endif
        @endif
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
    @if($editable)
	<div class="portlet-title">
		<div class="tools">
            <a class="text-muted" id="delete_skills-<?php echo $count_skills;?>" onclick="remove_form(this.id, 'skills', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
		</div>
	</div>
    @endif
	<div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
		<!-- START FORM -->
                @if(in_array('skill-type', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('my201.skills_type') }}<span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" {{ ($is_editable['skill-remarks'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal_history[skill-type][]" id="partners_personal_history-skill-type" 
                        value="<?php echo array_key_exists('skill-type', $skill) ? $skill['skill-type'] : ""; ?>" placeholder="Enter Type"/>
                    </div>
                </div>
                @endif
                @if(in_array('skill-name', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('my201.skills_name') }}<span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" {{ ($is_editable['skill-remarks'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal_history[skill-name][]" id="partners_personal_history-skill-name" 
                        value="<?php echo array_key_exists('skill-name', $skill) ? $skill['skill-name'] : ""; ?>" placeholder="Enter Name"/>
                    </div>
                </div>
                @endif
                @if(in_array('skill-level', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('my201.proficiency_level') }}<span class="required">*</span></label>
                    <div class="col-md-6">
                        <?php
                            $users_proficiency_level_options = array('Advance' => 'Advance', 'Intermediate' => 'Intermediate', 'Beginner' => 'Beginner');
                            $disabled = ($is_editable['skill-level'] == 1) ? '' : 'disabled';
                        ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-star"></i>
                             </span>
                        {{ form_dropdown('partners_personal_history[skill-level][]',$users_proficiency_level_options, $skill['skill-level'], 'class="form-control select2me" '.$disabled.' data-placeholder="Select..."') }}
                        </div>
                    </div>
                </div>
                @endif
                @if(in_array('skill-remarks', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('common.remarks') }}</label>
                    <div class="col-md-6">
                        <textarea rows="3" class="form-control" {{ ($is_editable['skill-remarks'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal_history[skill-remarks][]" id="partners_personal_history-skill-remarks" ><?php echo array_key_exists('skill-remarks', $skill) ? $skill['skill-remarks'] : ""; ?></textarea>
                    </div>
                </div>
                @endif
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
                @if($editable)
                    <button class="btn green btn-sm" type="button" onclick="save_partner( $(this).parents('form') )" ><i class="fa fa-check"></i> {{ lang('common.save') }}</button>
                    <button class="btn blue btn-sm" type="submit"><i class="fa fa-undo"></i> {{ lang('common.reset') }}</button>                               
                @endif
            </div>
        </div>
    </div>
</div>
