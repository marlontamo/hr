<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="portlet">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form class="form-horizontal" id="incumbent-form">
                    <input type="hidden" name="plan_id" value="<?php echo $plan_id?>">
                    <input type="hidden" name="user_id" value="<?php echo $user_id?>">
                    <input type="hidden" name="position_id" value="<?php echo $position_id?>">
                    <div class="form-body">

                        <div class="form-group">
                            <label class="control-label col-md-4"><?=lang('annual_manpower_planning.plan')?></label>
                            <div class="col-md-5">
                                <div class="input-group"> <?php
                                    $options[0] = 'Select';
                                    $actions = $this->db->get_where('recruitment_manpower_plan_action', array('deleted' => 0));
                                    if ($actions && $actions->num_rows() > 0){
                                        foreach( $actions->result() as $action )
                                        {
                                            $options[$action->action_id] = $action->action;
                                        }
                                    }
                                    echo form_dropdown('action_id', $options, '', 'class="form-control select2me" data-placeholder="Select..." id="action_id"') ?>
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" onclick="add_incumbent_plan()" type="button"><i class="fa fa-plus"></i></button>
                                    </span>
                                </div>

                                <div class="help-block small">
                                    <?=lang('annual_manpower_planning.select_plan')?>
                                </div>
                                <!-- /input-group -->
                            </div>
                        </div>
                        <br>
                        <div class="portlet margin-top-25">

                            <div class="portlet-body">
                                <!-- Table -->
                                <table class="table table-condensed table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="20%" class="padding-top-bottom-10"><?=lang('annual_manpower_planning.plan')?></th>
                                            <th width="25%" class="padding-top-bottom-10"><?=lang('annual_manpower_planning.month')?></th>
                                            <th width="15%" class="padding-top-bottom-10"><?=lang('annual_manpower_planning.budget')?></th>
                                            <th width="15%" class="padding-top-bottom-10">Payroll Under</th>
                                            <th width="15%" class="padding-top-bottom-10"><?=lang('common.actions')?></th>
                                        </tr>
                                    </thead>                                   
                                    <tbody class="saved-plans" >
                                        <?php
                                            $months = array(
                                                '1' => 'January',
                                                '2' => 'February',
                                                '3' => 'March',
                                                '4' => 'April',
                                                '5' => 'May',
                                                '6' => 'June',
                                                '7' => 'July',
                                                '8' => 'August',
                                                '9' => 'September',
                                                '10' => 'October',
                                                '11' => 'November',
                                                '12' => 'December',
                                            );

                                            $plans = $this->mod->get_incumbent_plans( $plan_id, $user_id );

                                            $companies = $this->db->get_where('users_company', array('deleted' => 0));
                                            foreach( $companies->result() as $company )
                                            {
                                                $companys[$company->company_id] = $company->company_code;
                                            }
                                            if($plans)
                                            {
                                                foreach( $plans as $plan ): ?>
                                                    <tr class="count_plans">
                                                        <td>
                                                            <?php echo form_dropdown('action[]', $options, $plan->action_id, 'class="form-control select2me" data-placeholder="Select..."') ?>   
                                                        </td>
                                                        <td>
                                                            <?php echo form_dropdown('month[]', $months, $plan->month, 'class="form-control select2me" data-placeholder="Select..."') ?>   
                                                        </td>
                                                        <td>
                                                            <input name="budget[]" type="text" class="form-control" maxlength="64" value="<?php echo $plan->budget?>">
                                                        </td>
                                                        <td>
                                                            <?php echo form_dropdown('company_id[]', $companys, $plan->company_id, 'class="form-control select2me" data-placeholder="Select..." ') ?>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-xs text-muted" type="button" onclick="delete_incumbent_plan($(this).closest('tr'))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></button>
                                                        </td>
                                                    </tr><?php
                                                endforeach;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                 <div id="no_record" class="well" style="display:none;">
                                    <p class="bold"><i class="fa fa-exclamation-triangle"></i> <?php echo lang('common.no_record_found') ?></p>
                                    <span><p class="small margin-bottom-0"><?=lang('annual_manpower_planning.no_record_plan')?></p></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM--> 
            </div>
        </div>
    </div>
</div>    
<div class="modal-footer margin-top-0">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?=lang('common.cancel')?></button>
    <button type="button" class="btn green btn-sm" \ onclick="save_incumbent()"><?=lang('common.save')?></button>
</div>
<table style="display:none">
    <tbody class="row-template">
        <tr>
            <td>
                <?php echo form_dropdown('action[]', $options, '', 'class="form-control select2me" data-placeholder="Select..."') ?>   
            </td>
            <td>
                <?php echo form_dropdown('month[]', $months, isset($plan->month) ? $plan->month : '', 'class="form-control select2me" data-placeholder="Select..."') ?>   
            </td>
            <td>
                <input name="budget[]" type="text" class="form-control" maxlength="64" value="">
            </td>
            <td>
                <?php echo form_dropdown('company_id[]', $company, '', 'class="form-control select2me" data-placeholder="Select..." ') ?>
            </td>
            <td>
                <button class="btn btn-xs text-muted" type="button" onclick="delete_incumbent_plan($(this).closest('tr'))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></button>
            </td>
        </tr>
    </tbody>
</table>
<script>

    $('select.select2me').select2();

    var count_plans = $('.count_plans').length;
    if(!count_plans > 0){
        $("#no_record").show();
    }
    // console.log(count_plans)
</script>
