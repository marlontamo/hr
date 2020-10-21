<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="portlet">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form class="form-horizontal" id="position-form">
                    <input type="hidden" name="plan_id" value="<?php echo $plan_id?>">
                    <input type="hidden" name="position_id" value="<?php echo $position_id?>">
                    <div class="form-body">

                        <div class="form-group">
                            <label class="control-label col-md-4">Employment Status</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                <?php
                                    $employment_status = $this->db->get_where('partners_employment_status', array('deleted' => 0));
                                    $employment_statuss = array('' => 'Select...');
                                    foreach($employment_status->result() as $etype)
                                    {
                                        $employment_statuss[$etype->employment_status_id] = $etype->employment_status;
                                    }
                                    echo form_dropdown('employment_status_selected', $employment_statuss, '', 'class="form-control select2me" data-placeholder="Select..." id="employment_status_selected"');
                                ?>
                                    <!-- <input type="text" maxlength="64" class="form-control" name="needed-add" id="needed-add"> -->
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" onclick="add_position_plan()" type="button"><i class="fa fa-plus"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="portlet margin-top-25">

                            <div class="portlet-body">
                                <!-- Table -->
                                <table class="table table-condensed table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="13%" class="padding-top-bottom-10">Employment Status</th>
                                            <th width="10%" class="padding-top-bottom-10"><?=lang('annual_manpower_planning.job_class')?></th>
                                            <th width="10%" class="padding-top-bottom-10"><?=lang('annual_manpower_planning.month')?></th>
                                            <th width="15%" class="padding-top-bottom-10"><?=lang('annual_manpower_planning.budget')?></th>
                                            <th width="10%" class="padding-top-bottom-10"><?=lang('annual_manpower_planning.qty')?></th>
                                            <th width="18%" class="padding-top-bottom-10">Payroll Under</th>
                                            <th width="5%" class="padding-top-bottom-10"><?=lang('common.actions')?></th>
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

                                            $jobrank = $this->db->get_where('users_job_rank', array('deleted' => 0));
                                            $job_ranks = array();
                                            foreach($jobrank->result() as $jr)
                                            {
                                                $job_ranks[$jr->job_rank_id] = $jr->job_rank;
                                            }
        
                                            $job_class = $this->db->get_where('users_job_class', array('deleted' => 0));
                                            $job_classes = array('' => 'Select...');
                                            foreach($job_class->result() as $jclass)
                                            {
                                                $job_classes[$jclass->job_class_id] = $jclass->job_class;
                                            }
                                            
                                            $employment_status = $this->db->get_where('partners_employment_status', array('deleted' => 0));
                                            $employment_statuss = array('' => 'Select...');
                                            foreach($employment_status->result() as $etype)
                                            {
                                                $employment_statuss[$etype->employment_status_id] = $etype->employment_status;
                                            }
                                            
                                            $users_company = $this->db->get_where('users_company', array('deleted' => 0));
                                            $users_companys = array('' => 'Select...');
                                            foreach($users_company->result() as $company)
                                            {
                                                $users_companys[$company->company_id] = $company->company_code;
                                            }

                                            $plans = $this->mod->get_position_plans( $plan_id, $position_id );
                                            if($plans)
                                            {
                                                foreach( $plans as $plan ): ?>
                                                    <tr class="count_tohire">
                                                        <td>
                                                            <?php echo form_dropdown('employment_status_id[]', $employment_statuss, $plan->employment_status_id, 'class="form-control select2me" data-placeholder="Select..."') ?>   
                                                        </td>
                                                        <td>
                                                            <?php echo form_dropdown('job_class_id[]', $job_classes, $plan->job_class_id, 'class="form-control select2me" data-placeholder="Select..."') ?>   
                                                        </td>
                                                        <td>
                                                            <?php echo form_dropdown('month[]', $months, $plan->month, 'class="form-control select2me" data-placeholder="Select..."') ?>   
                                                        </td>
                                                        <td>
                                                            <input name="budget[]" type="text" class="form-control" maxlength="64" value="<?php echo $plan->budget?>">
                                                        </td>
                                                        <td>
                                                            <input name="needed[]" type="text" class="form-control" maxlength="64" value="<?php echo $plan->needed?>">
                                                        </td>
                                                        <td>
                                                            <?php echo form_dropdown('company_id[]', $users_companys, $plan->company_id, 'class="form-control select2me" data-placeholder="Select..."') ?>   
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-xs text-muted" type="button" onclick="delete_position_plan($(this).closest('tr'))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></button>
                                                        </td>
                                                    </tr><?php
                                                endforeach;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                 <div id="no_record" class="well" style="display:none;">
                                    <p class="bold"><i class="fa fa-exclamation-triangle"></i> <?php echo lang('common.no_record_found') ?></p>
                                    <span><p class="small margin-bottom-0"><?php echo 'Zero (0) was found. Click Add button to add to hire count.' ?></p></span>
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
    <button type="button" class="btn green btn-sm" \ onclick="save_position()"><?=lang('common.save')?></button>
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
                <input name="budget[]" type="text" class="form-control" maxlength="64" value="">
            </td>
            <td>
                <input name="needed[]" type="text" class="form-control" maxlength="64" value="">
            </td>
            <td>
                <?php echo form_dropdown('company_id[]', $users_companys, '', 'class="form-control select2me" data-placeholder="Select..."') ?>   
            </td>
            <td>
                <button class="btn btn-xs text-muted" type="button" onclick="delete_position_plan($(this).closest('tr'))"><i class="fa fa-trash-o"></i> Delete</button>
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