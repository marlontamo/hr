<div class="portlet">
	<div class="portlet-title">
		<div class="caption" id="education-category">{{ lang('partners.educ_bg') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
		<!-- START FORM -->				
                <div class="form-group">
                	<label class="control-label col-md-3">{{ lang('partners.category') }}</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select  class="form-control select2me" data-placeholder="Select..." name="education_category" id="education_category">
                            	<option value="Primary">{{ lang('partners.primary') }}</option>
                                <option value="Secondary">{{ lang('partners.secondary') }}</option>
                                <option value="Tertiary">{{ lang('partners.tertiary') }}</option>
                                <option value="Vocational">{{ lang('partners.vocational') }}</option>
                                <option value="Graduate Studies">{{ lang('partners.graduate') }}</option>
                               <!--  <option value="Masters">Masters</option>
                                <option value="Doctorate">Doctorate</option> -->
                            </select>
                        
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-default" onclick="add_form('educational_background', 'education')"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                        <div class="help-block">
                        	{{ lang('partners.add_education') }}
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
    <?php $education_count = count($education_tab); ?>
    <input type="hidden" name="education_count" id="education_count" value="{{ $education_count }}" />
    <?php 
    $type_with_degree = array('tertiary', 'graduate studies', 'vocational');
    $count_education = 0;
    foreach($education_tab as $index => $education){  
        $count_education++;
?>
    <div class="portlet">
    	<div class="portlet-title">
    		<div class="caption" id="education-category">
                <input type="hidden" name="partners_personal_history[education-type][]" id="partners_personal_history-education-type" 
                            value="<?php echo array_key_exists('education-type', $education) ? $education['education-type'] : ""; ?>" />
                <?php echo $education_type = array_key_exists('education-type', $education) ? $education['education-type'] : ""; ?>
            </div>
    		<div class="tools">
    			<a class="text-muted" id="delete_education-<?php echo $count_education;?>" onclick="remove_form(this.id, 'education', 'history')"  style="margin-botom:-15px;" href="#"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
    			<!-- <a class="collapse pull-right" href="javascript:;"></a> -->
    		</div>
    	</div>
    	<div class="portlet-body form">
            <div class="form-horizontal">
                <div class="form-body">
    		<!-- START FORM -->	
    				<div class="form-group">
                        <label class="control-label col-md-3">{{ lang('partners.school') }}<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="partners_personal_history[education-school][]" id="partners_personal_history-education-school" 
                            value="<?php echo array_key_exists('education-school', $education) ? $education['education-school'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('partners.school') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">{{ lang('partners.start_year') }}<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="partners_personal_history[education-year-from][]" id="partners_personal_history-education-year-from" 
                            value="<?php echo array_key_exists('education-year-from', $education) ? $education['education-year-from'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('partners.start_year') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">{{ lang('partners.end_year') }}<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="partners_personal_history[education-year-to][]" id="partners_personal_history-education-year-to" 
                            value="<?php echo array_key_exists('education-year-to', $education) ? $education['education-year-to'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('partners.end_year') }}"/>
                        </div>
                    </div>
                    <?php if(in_array(strtolower($education_type), $type_with_degree)) { ?>
                    <div class="form-group">
                        <label class="control-label col-md-3">{{ lang('partners.degree') }}<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="partners_personal_history[education-degree][]" id="partners_personal_history-education-degree" 
                            value="<?php echo array_key_exists('education-degree', $education) ? $education['education-degree'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('partners.degree') }}"/>
                        </div>
                    </div>
                    <?php 
                    }else{
                    ?>
                    <div class="form-group" style="display:none;">
                        <label class="control-label col-md-3">{{ lang('partners.start_year') }}<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="hidden" class="form-control" name="partners_personal_history[education-degree][]" id="partners_personal_history-education-degree" 
                            value="" placeholder="{{ lang('common.enter') }} {{ lang('partners.degree') }}"/>
                        </div>
                    </div>
                    <?php
                        } 
                    ?>
                    <div class="form-group">
                        <label class="control-label col-md-3">{{ lang('common.status') }}<span class="required">*</span></label>
                        <div class="col-md-7 checkbox-list">
                            <label class="checkbox-inline">
                                <?php $education_status = array_key_exists('education-status', $education) ? $education['education-status'] : ""; ?>
                                <input type="checkbox" name="partners_personal_history[education-status][]" id="partners_personal_history-education-status-graduate-<?php echo $count_education;?>" 
                                 value="Graduated" <?php echo strtolower($education_status) == 'graduated' ? "checked" : "" ?> onclick="check_graduate_status(this, <?php echo $count_education;?>);"/>
                                {{ lang('partners.grad') }}
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="partners_personal_history[education-status][]" id="partners_personal_history-education-status-undergraduate-<?php echo $count_education;?>" 
                                 value="Undergrad" <?php echo strtolower($education_status) != 'graduated' ? "checked" : "" ?> onclick="check_graduate_status(this, <?php echo $count_education;?>);"> 
                                 {{ lang('partners.ungrad') }}
                            </label>
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
                <button class="btn green btn-sm" type="button" onclick="save_partner( $(this).parents('form') )" ><i class="fa fa-check"></i> {{ lang('common.save') }}</button>
                <button class="btn blue btn-sm" type="submit"><i class="fa fa-undo"></i> {{ lang('common.reset') }}</button>                               
            </div>
        </div>
    </div>
</div>