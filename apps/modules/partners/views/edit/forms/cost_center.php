<div class="portlet">
	<div class="portlet-title">
		<div class="tools">
            <a class="text-muted" id="delete_cost_center-<?php echo $count;?>" onclick="remove_form(this.id, 'cost_center', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
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
                        <select data-placeholder="Select..." class="form-control select2me" name="partners_personal_history[cost_center-cost_center][]" id="partners_personal_history-cost_center-cost_center-<?php echo $count;?>" >
                        <?php   $db->select('project_id,project');
                                $db->where('deleted', '0');
                                $options = $db->get('users_project');

                                echo '<option value="">Select...</option>';
                                foreach($options->result() as $option)
                                {
                                    echo '<option value="'.$option->project_id.'">'. $option->project.'</option>';
                                } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3"><?php echo lang('partners.code'); ?></label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="partners_personal_history[cost_center-code][]" id="partners_personal_history-cost_center-code-<?php echo $count;?>" placeholder=""/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3"><?php echo lang('partners.percentage'); ?></label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="partners_personal_history[cost_center-percentage][]" id="partners_personal_history-cost_center-percentage" placeholder="<?php echo lang('partners.p_percentage'); ?>"/>
                </div>
            </div>

    </div>
</div>
</div>
</div>
<script language="javascript">
    $(document).ready(function(){
        $('select.form-select').select2();
    });
</script>