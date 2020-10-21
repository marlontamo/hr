<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="portlet">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form class="form-horizontal" id="position-form">
                    <input type="hidden" name="plan_id" value="<?php echo $plan_id?>">
                    <input type="hidden" name="position_id" value="<?php echo $position_id?>">
                    <div class="form-body">

                            <div class="portlet-body">
                                <!-- Table -->
                                <table class="table table-condensed table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="29%" class="padding-top-bottom-10"><?=lang('annual_manpower_planning.rank')?></th>
                                            <th width="29%" class="padding-top-bottom-10"><?=lang('annual_manpower_planning.month')?></th>
                                            <th width="23%" class="padding-top-bottom-10"><?=lang('annual_manpower_planning.qty')?></th>
                                            <th width="19%" class="padding-top-bottom-10"><?=lang('annual_manpower_planning.budget')?></th>
                                            <!-- <th width="15%" class="padding-top-bottom-10">Actions</th> -->
                                        </tr>
                                    </thead>
                                    <tbody class="saved-plans" >
                                        <?php
                                            $months = array(
                                                '1' => lang('cal_january'),
                                                '2' => lang('cal_february'),
                                                '3' => lang('cal_march'),
                                                '4' => lang('cal_april'),
                                                '5' => lang('cal_may'),
                                                '6' => lang('cal_june'),
                                                '7' => lang('cal_july'),
                                                '8' => lang('cal_august'),
                                                '9' => lang('cal_september'),
                                                '10' => lang('cal_october'),
                                                '11' => lang('cal_november'),
                                                '12' => lang('cal_december')
                                            );

                                            $jobrank = $this->db->get_where('users_job_rank', array('deleted' => 0));
                                            $job_ranks = array();
                                            foreach($jobrank->result() as $jr)
                                            {
                                                $job_ranks[$jr->job_rank_id] = $jr->job_rank;
                                            }

                                            $plans = $this->mod->get_position_plans( $plan_id, $position_id );
                                            if($plans)
                                            {
                                                foreach( $plans as $plan ): ?>
                                                    <tr class="count_tohire">
                                                        <td>
                                                            <?php echo form_dropdown('job_rank_id[]', $job_ranks, $plan->job_rank_id, 'class="form-control select2me" data-placeholder="Select..." disabled') ?>   
                                                        </td>
                                                        <td>
                                                            <?php echo form_dropdown('month[]', $months, $plan->month, 'class="form-control select2me" data-placeholder="Select..." disabled') ?>   
                                                        </td>
                                                        <td>
                                                            <input name="needed[]" type="text" class="form-control" maxlength="64" value="<?php echo $plan->needed?>" disabled>
                                                        </td>
                                                        <td>
                                                            <input name="budget[]" type="text" class="form-control" maxlength="64" value="<?php echo $plan->budget?>" disabled>
                                                        </td>
                                                        <!-- <td>
                                                            <button class="btn btn-xs text-muted" type="button" onclick="delete_position_plan($(this).closest('tr'))"><i class="fa fa-trash-o"></i> Delete</button>
                                                        </td> -->
                                                    </tr><?php
                                                endforeach;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                 <div id="no_record" class="well" style="display:none;">
                                    <p class="bold"><i class="fa fa-exclamation-triangle"></i> <?php echo lang('common.no_record_found') ?></p>
                                    <span><p class="small margin-bottom-0"><?=lang('annual_manpower_planning.no_record_hire')?></p></span>
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
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?=lang('common.close')?></button>
    <!-- <button type="button" class="btn green btn-sm" \ onclick="save_position()">Save</button> -->
</div>
<table style="display:none">
    <tbody class="row-template">
        <tr>
            <td>
                <?php echo form_dropdown('job_rank_id[]', $job_ranks, '', 'class="form-control select2me" data-placeholder="Select..."') ?>   
            </td>
            <td>
                <?php echo form_dropdown('month[]', $months, '', 'class="form-control select2me" data-placeholder="Select..."') ?>   
            </td>
            <td>
                <input name="needed[]" type="text" class="form-control" maxlength="64" value="">
            </td>
            <td>
                <input name="budget[]" type="text" class="form-control" maxlength="64" value="">
            </td>
            <td>
                <button class="btn btn-xs text-muted" type="button" onclick="delete_position_plan($(this).closest('tr'))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></button>
            </td>
        </tr>
    </tbody>
</table>
<script>

    $('select.select2me').select2();
    var count_tohire = $('.count_tohire').length;
    if(!count_tohire > 0){
        $("#no_record").show();
    }
</script>