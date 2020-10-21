<div class="portlet">
	<div class="portlet-title">
		<div class="caption" id="cost_center-category">{{ lang('partners.cost_center') }}</div>
		<div class="actions">
            <a class="btn btn-default" onclick="add_form('cost_center', 'cost_center')">
                <i class="fa fa-plus"></i>
            </a>
		</div>
	</div>
</div>

<div id="personal_cost_center">
    <?php $cost_center_count = count($cost_center_tab); ?>
    <input type="hidden" name="cost_center_count" id="cost_center_count" value="{{ $cost_center_count }}" />
    <?php 
    $count_cost_center = 0;
    foreach($cost_center_tab as $index => $cost_center){ 
        $count_cost_center++;
?>
<div class="portlet">
	<div class="portlet-title">
		<div class="tools">
            <a class="text-muted" id="delete_cost_center-<?php echo $count_cost_center;?>" onclick="remove_form(this.id, 'cost_center', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
		</div>
	</div>
	<div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
			<!-- START FORM -->
			<div class="form-group">
                <label class="control-label col-md-3"><?php echo lang('partners.cost_center'); ?></label>
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-list-ul"></i>
                        </span>
                        <select data-placeholder="Select..." class="form-control select2me" name="partners_personal_history[cost_center-cost_center][]" id="partners_personal_history-cost_center-cost_center-<?php echo $index;?>" >
                        	<?php

                        		$db->select('project_id,project');
                                $db->where('deleted', '0');
                                $options = $db->get('users_project');

                                $users_profile_project_options = '';
                                echo '<option value="">Select...</option>';
                                foreach($options->result() as $option)
                                {
                                    if($cost_center['cost_center-cost_center'] != $option->project_id)
                                    	echo '<option value="'.$option->project_id.'">'. $option->project.'</option>';
                                    else
                                    	echo '<option value="'.$option->project_id.'" selected="selected">'. $option->project.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3"><?php echo lang('partners.code'); ?></label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="partners_personal_history[cost_center-code][]" id="partners_personal_history-cost_center-code-<?php echo $index;?>" value="<?php echo $cost_center['cost_center-code']; ?>" placeholder=""/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3"><?php echo lang('partners.percentage'); ?></label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="partners_personal_history[cost_center-percentage][]" id="partners_personal_history-cost_center-percentage" value="<?php echo $cost_center['cost_center-percentage']; ?>" placeholder="<?php echo lang('partners.p_percentage'); ?>"/>
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
