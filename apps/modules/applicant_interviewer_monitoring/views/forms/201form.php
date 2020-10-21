<script type="text/javascript" src="<?php echo theme_path() ?>plugins/bootstrap-tagsinput/typeahead.js"></script>
<script src="<?php echo theme_path() ?>plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript" ></script>
<link href="<?php echo theme_path() ?>plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo theme_path() ?>plugins/select2/select2.min.js" type="text/javascript" ></script>
<link href="<?php echo theme_path() ?>plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>


<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title margin-bottom-5"><?php echo $recruit->firstname . ' ' . $recruit->lastname?></h4> 
        <p class="margin-bottom-10 text-muted"><?php echo $position?></p> 
        <ul class="list-inline text-muted"><?php
            if(!empty($phone)): ?>
                <li class="small">
                <i class="fa fa-phone"></i>
                <span><?php echo $phone?></span>
                </li> <?php
            endif;
            if(!empty($mobile)): ?>
                <li class="small">
                <i class="fa fa-mobile"></i>
                <span><?php echo $mobile?></span>
                </li> <?php
            endif;
             if(!empty($recruit->email)): ?>
                <li class="small">
                <i class="fa fa-envelope"></i>
                <span><?php echo $recruit->email?></span>
                </li> <?php
            endif; ?>
        </ul>

    </div>
    <div class="modal-body padding-bottom-0">
        <div class="">
            <ul class="nav nav-tabs ">
                <li><a data-toggle="tab" href="#tab_schedule"><?=lang('applicant_monitoring.schedule')?></a></li>
                <li class="<?php if($process->status_id == 2) echo 'active' ?>"><a data-toggle="tab" href="#tab_assessment">Assessment</a></li>
                <li><a data-toggle="tab" href="#tab_interview"><?=lang('applicant_monitoring.interview')?></a></li>
                <?php if($process->status_id > 2): ?>
                <li class=""><a data-toggle="tab" href="#tab_bi">BI</a></li>
                <?php endif; ?>
                <li><a data-toggle="tab" href="#tab_jo"><?=lang('applicant_monitoring.jo')?></a></li>
                <li><a data-toggle="tab" href="#tab_cs"><?=lang('applicant_monitoring.cs')?></a></li>
                <li><a data-toggle="tab" href="#tab_preemp"><?=lang('applicant_monitoring.preemp')?></a></li>
                <li class="active"><a data-toggle="tab" href="#tab_201"><?=lang('applicant_monitoring.create_201')?></a></li>
            </ul>
            <div class="tab-content margin-top-20" style="min-height:300px;">
                <div id="tab_schedule" class="tab-pane">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">Interview Schedule</div>
                            <div class="tools">
                                <a class="collapse" href="javascript:;"></a>
                            </div>
                        </div>
                        <p>This section manage to add interview schedule and person assigned.</p>

                        <div class="portlet-body form">
                            <!-- START FORM -->
                            <form action="#" class="form-horizontal" name="schedule-form">
                                <input type="hidden"  name="process_id" value="<?php echo $process_id?>">
                                <div class="form-body">
                                    <div class="portlet">
                                        <span class="pull-right margin-bottom-15"><div class="btn btn-success btn-xs" onclick="add_sched_row()">+ Add Schedule</div></span>
                                        <div class="portlet-body" >
                                            <table class="table table-condensed table-striped table-hover" >
                                                <thead>
                                                    <tr>
                                                        <th width="15%" class="padding-top-bottom-10" >Date</th>
                                                        <th width="45%" class="padding-top-bottom-10 hidden-xs" >Interviewer</th>
                                                        <th width="10%" class="padding-top-bottom-10" >Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="saved-scheds"><?php
                                                    if( $saved_scheds ):
                                                        foreach( $saved_scheds as $sched ): ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                                                        <input name="sched_date[]" type="text" size="16" class="form-control" value="<?php echo date('M d, Y', strtotime($sched->date))?>">
                                                                        <span class="input-group-btn">
                                                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                                        </span>
                                                                    </div>
                                                                </td> 
                                                                <td>
                                                                    <input type="hidden"  name="sched_user_id[]" value="<?php echo $sched->user_id?>" class="form-control">
                                                                    <input type="text" name="partner_name" value="<?php echo $sched->full_name?>" type="text" class="form-control" autocomplete="off">
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_row($(this))"><i class="fa fa-trash-o"></i> Delete</a>
                                                                </td>
                                                            </tr> <?php
                                                        endforeach;
                                                    endif;
                                                ?></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer margin-top-0">
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
                        <button type="button" data-loading-text="Loading..." onclick="save_schedule()" class="demo-loading-btn btn btn-success btn-sm">Save</button>
                    </div>
                </div>
                
                <div id="tab_assessment" class="tab-pane <?php if($process->status_id == 2) echo 'active' ?>">
                <?php require 'exam.php'; ?>
                </div>
                <div id="tab_bi" class="tab-pane ">
                <?php require 'bi_forms.php'; ?>
                </div>
                
                <div id="tab_interview" class="tab-pane">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">Interview Details</div>
                            <div class="tools">
                                <a class="collapse" href="javascript:;"></a>
                            </div>
                        </div>
                        <p>This section manage to interview results.</p>

                        <div class="portlet-body form">
                            <div class="form-body">
                                <div class="portlet">
                                    <div class="portlet-body" >
                                        <table class="table table-condensed table-striped table-hover" >
                                            <thead>
                                                <tr>
                                                    <th width="30%" class="padding-top-bottom-10" >Interviewer</th>
                                                    <th width="25%" class="padding-top-bottom-10 ">Date</th>
                                                    <th width="20%" class="padding-top-bottom-10 ">Result</th>
                                                    <th width="25%" class="padding-top-bottom-10" >Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="saved-interviews"><?php
                                                if( $saved_scheds ):
                                                    foreach( $saved_scheds as $sched ): ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $sched->full_name?><br>
                                                                <span class="small text-muted"><?php echo $sched->position?></span>
                                                            </td> 
                                                            <td>
                                                                <?php echo date('M-d', strtotime( $sched->date ))?>
                                                                <span class="text-muted small"><?php echo date('D', strtotime( $sched->date ))?></span>
                                                                <br>
                                                                <span class="text-muted small"><?php echo date('Y', strtotime( $sched->date ))?></span>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                    if( empty( $sched->result ) ):
                                                                        echo '<span class="badge badge-warning">Pending</span>';
                                                                    else:
                                                                        echo '<span class="badge '.$sched->class.'">'.$sched->result.'</span>';
                                                                    endif;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a class="btn btn-xs text-muted" href="javascript:view_interview_result(<?php echo $sched->schedule_id?>);"><i class="fa fa-search"></i> <?=lang('common.view')?></a>
                                                                </div>
                                                                <div class="btn-group">
                                                                    <a class="btn btn-xs text-muted"><i class="fa fa-print"></i> Print</a>
                                                                </div>
                                                            </td>
                                                        </tr> <?php
                                                    endforeach;
                                                endif;
                                            ?></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer margin-top-0">
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
                        <button type="button" data-loading-text="Loading..." onclick="move_to_jo(<?php echo $process_id?>)" class="demo-loading-btn btn btn-success btn-sm">Move to Job Offer</button>
                    </div>
                </div> 

                <div id="tab_jo" class="tab-pane">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">Job Offer Details</div>
                            <div class="tools">
                                <a class="collapse" href="javascript:;"></a>
                            </div>
                        </div>
                        <p>This section manage to add interview schedule and person assigned.</p>

                        <div class="portlet-body form margin-top-25">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" name="jo-form" method="post">
                                <inpput type="hidden" value="<?php echo $process_id?>" name="process_id"/>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Employee Status
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <?php
                                            $option = $this->db->get_where('partners_employment_status', array('active' => 1, 'deleted' => 0));
                                            $options = array();
                                            foreach ($option->result() as $opt) {
                                                $options[$opt->employment_status_id] = $opt->employment_status;
                                            }

                                            echo form_dropdown('jo[employment_status_id]',$options, $employment_status_id, 'class="form-control select2me" data-placeholder="Select..."');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Start Date</label>
                                    <div class="col-md-6">
                                        <div class="input-group input-medium date date-picker" data-date-format="dd-MM-yyyy">
                                            <input type="text" name="jo[start_date]" class="form-control" value="<?php echo $no_months?>" readonly>
                                            <span class="input-group-btn">
                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">No. of months
                                    </label>
                                    <div class="col-md-6">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" name="jo[no_months]" value="<?php echo $no_months?>">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Template
                                    </label>
                                    <div class="col-md-6">
                                            <div class="input-group">
                                                <?php
                                                    $option = $this->db->get_where('system_template', array('code' => 'STEP-4', 'mod_id' => $mod->mod_id, 'deleted' => 0));
                                                    $options = array();
                                                    foreach ($option->result() as $opt) {
                                                        $options[$opt->template_id] = $opt->name;
                                                    }

                                                    echo form_dropdown('jo[template_id]',$options, $template_id, 'class="form-control select2me" data-placeholder="Select..."');
                                                ?>
                                            </div>
                                            <div class="help-block small">
                                                Click button to print chosen template.
                                            </div>
                                        
                                    </div>
                                </div>

                                <br><br>
                                
                                <!--Compensation and Benefits-->
                                <div class="portlet ">
                                    <div class="portlet-title">
                                        <div class="caption">Compensation and Benefits</div>
                                        <div class="pull-right">
                                            <a class="btn btn-success btn-xs pull-right" href="javascript:add_benefit_row();">+ Add Benefits</a>
                                        </div>
                                    </div>
                                    
                                    <div class="portlet-body form">
                                        <div class="form-body">
                                            <div class="portlet">
                                                <div class="portlet-body" >
                                                    <!-- Table -->
                                                    <table class="table table-condensed table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                
                                                                <th width="25%" class="padding-top-bottom-10" >Benefits</th>
                                                                <th width="25%" class="padding-top-bottom-10 hidden-xs" >Amount</th>
                                                                <th width="30%" class="padding-top-bottom-10">Mode</th>
                                                                <th width="10%" class="padding-top-bottom-10" >Action</th>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                            $compben = $this->db->get_where('recruitment_benefit', array('deleted' => 0));
                                                            $cbopt = array();
                                                            foreach( $compben->result() as $cb )
                                                            {
                                                                $cbopt[$cb->benefit_id] = $cb->benefit;
                                                            }

                                                            $rates = $this->db->get_where('payroll_rate_type', array('deleted' => 0));
                                                            $rateopt = array();
                                                            foreach( $rates->result() as $rate )
                                                            {
                                                                $rateopt[$rate->payroll_rate_type_id] = $rate->payroll_rate_type;
                                                            }
                                                        ?>
                                                        <tbody id="saved-benefits">
                                                        <?php
                                                            $qry = "SELECT a.*, b.benefit
                                                            FROM {$this->db->dbprefix}recruitment_process_offer_compben a
                                                            LEFT JOIN {$this->db->dbprefix}recruitment_benefit b on b.benefit_id = a.benefit_id
                                                            WHERE a.process_id = {$process_id}";
                                                            $benefits = $this->db->query($qry);
                                                            foreach( $benefits->result() as $benefit ): ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo form_dropdown('compben[benefit_id]',$cbopt, $benefit->benefit_id, 'class="form-control select2me" data-placeholder="Select..."')?>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="compben[amount]" value="<?php echo $benefit->amount?>" >
                                                                    </td>
                                                                    <td>
                                                                        <?php echo form_dropdown('compben[rate_id]',$rateopt, $benefit->rate_id, 'class="form-control select2me" data-placeholder="Select..."')?>
                                                                    </td>
                                                                    <td>
                                                                        <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_row($(this))"><i class="fa fa-trash-o"></i> Delete</a>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            endforeach;
                                                        ?>    
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                             <!-- END FORM--> 
                        </div>
                    </div>
                    <div class="modal-footer margin-top-0">
                        <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">Close</button>
                        <button type="button" onclick="save_jo()" class="demo-loading-btn btn btn-success btn-sm">Save</button>
                        <button type="button" class="btn btn-sm btn-info"><i class="fa fa-print"></i> Print</button>
                        <button class="demo-loading-btn btn btn-success btn-sm" onclick="move_to_cs(<?php echo $process_id?>)" type="button">Contract Signing</button>
                    </div>
                </div>

                <div id="tab_cs" class="tab-pane">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">Contract Signing</div>
                            <div class="tools">
                                <a class="collapse" href="javascript:;"></a>
                            </div>
                        </div>
                        <p>This section manages contract signing template.</p>

                        <div class="portlet-body form margin-top-25">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal margin-top-25" name="cs-form" method="post">
                                <inpput type="hidden" value="<?php echo $process_id?>" name="process_id" />
                                <div class="form-group">
                                    <label class="control-label col-md-4">Template
                                    </label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <?php
                                                $option = $this->db->get_where('system_template', array('code' => 'STEP-5', 'mod_id' => $mod->mod_id, 'deleted' => 0));
                                                $options = array('' => 'Select...');
                                                foreach ($option->result() as $opt) {
                                                    $options[$opt->template_id] = $opt->name;
                                                }

                                                echo form_dropdown('signing[template_id]',$options, $signing_template_id, 'class="form-control select2me" data-placeholder="Select..."');
                                            ?> 
                                                    
                                            <span class="input-group-btn">
                                            <button type="button" data-dismiss="modal" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
                                            </span>
                                        </div>
                                        <div class="help-block small">
                                            Click button to print chosen template.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Status</label>
                                    <div class="col-md-7">
                                        <div class="make-switch" data-on-label="&nbsp;Accept&nbsp;" data-off-label="&nbsp;Decline&nbsp;">
                                            <input type="checkbox" value="1" name="cs_status[temp]" <?php if( $signing_accepted ) echo 'checked="checked"'?> id="signing-accepted-temp" class="dontserializeme toggle"/>
                                        </div>
                                        <small class="help-block">
                                            The status if the applicant sign or accept the contract.
                                        </small>
                                        <input type="hidden" name="signing[accepted]" id="signing-accepted" value="<?php echo $signing_accepted?>"/>
                                    </div>
                                </div>
                            </form>
                             <!-- END FORM--> 
                        </div>
                    </div>
                    <div class="modal-footer margin-top-0">
                        <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">Close</button>
                        <button type="button" onclick="save_cs()" class="demo-loading-btn btn btn-success btn-sm">Save</button>
                        <button type="button" class="btn btn-sm btn-info"><i class="fa fa-print"></i> Print</button>
                        <button class="demo-loading-btn btn btn-success btn-sm" onclick="move_to_preemp(<?php echo $process_id?>)" type="button">Move to Pre-Employment</button>
                    </div>
                </div>

                <div id="tab_preemp" class="tab-pane">
                </div>

                <div id="tab_201" class="tab-pane active">
                    <div class="portlet">
                        <div class="portlet-body form margin-top-25">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal margin-top-25" name="201-form" method="post">
                                <input type="hidden" value="<?php echo $process_id?>" name="process_id" />
                                <input type="hidden" value="<?php echo $recuser_user_id?>" name="user_id" />
                                <div class="form-group">
                                    <label class="control-label col-md-4">Company <span class="required">*</span></label>
                                    <div class="col-md-6">
                                        <?php
                                            $option = $this->db->get_where('users_company', array('deleted' => 0));
                                            $options = array('' => 'Select...');
                                            foreach ($option->result() as $opt) {
                                                $options[$opt->company_id] = $opt->company;
                                            }

                                            echo form_dropdown('users_profile[company_id]',$options, $recuser_company_id, 'class="form-control select2me" data-placeholder="Select..."');
                                        ?> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4">Department <span class="required">*</span></label>
                                    <div class="col-md-6">
                                        <?php
                                            $option = $this->db->get_where('users_department', array('deleted' => 0));
                                            $options = array('' => 'Select...');
                                            foreach ($option->result() as $opt) {
                                                $options[$opt->department_id] = $opt->department;
                                            }

                                            echo form_dropdown('users_profile[department_id]',$options, $recuser_department_id, 'class="form-control select2me" data-placeholder="Select..."');
                                        ?> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4">Reports to <span class="required">*</span></label>
                                    <div class="col-md-6">
                                        <?php
                                            $option = $this->db->get_where('users', array('deleted' => 0, 'active' => 1));
                                            $options = array('' => 'Select...');
                                            foreach ($option->result() as $opt) {
                                                $options[$opt->user_id] = $opt->full_name;
                                            }

                                            echo form_dropdown('users_profile[reports_to_id]',$options, $recuser_reports_to_id, 'class="form-control select2me" data-placeholder="Select..."');
                                        ?> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4">Location <span class="required">*</span></label>
                                    <div class="col-md-6">
                                        <?php
                                            $option = $this->db->get_where('users_location', array('deleted' => 0));
                                            $options = array('' => 'Select...');
                                            foreach ($option->result() as $opt) {
                                                $options[$opt->location_id] = $opt->location;
                                            }

                                            echo form_dropdown('users_profile[location_id]',$options, $recuser_location_id, 'class="form-control select2me" data-placeholder="Select..."');
                                        ?> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4">Work Schedule <span class="required">*</span></label>
                                    <div class="col-md-6">
                                        <?php
                                            $option = $this->db->get_where('time_shift', array('deleted' => 0));
                                            $options = array('' => 'Select...');
                                            foreach ($option->result() as $opt) {
                                                $options[$opt->shift_id] = $opt->shift;
                                            }

                                            echo form_dropdown('partners[shift_id]',$options, $recuser_shift_id, 'class="form-control select2me" data-placeholder="Select..."');
                                        ?> 
                                    </div>
                                </div>
                               

                                <div class="form-group">
                                    <label class="control-label col-md-4">ID Number
                                    </label>
                                    <div class="col-md-6">
                                        <div class="input-icon">
                                            <input type="text" name="users[login]" value="<?php echo $recuser_login?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </form>
                             <!-- END FORM--> 
                        </div>
                    </div>
                    <div class="modal-footer margin-top-0">
                        <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">Close</button>
                        <button type="button" onclick="save_201()" class="demo-loading-btn btn btn-success btn-sm">Save 201</button>
                    </div>
                </div>
            </div>                        
        </div>
    </div>
</div>

<table style="display:none" id="sched-row">
    <tbody>
        <tr>
            <td>
                <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                    <input name="sched_date[]" type="text" size="16" class="form-control">
                    <span class="input-group-btn">
                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                </div>
            </td> 
            <td>
                <input type="hidden"  name="sched_user_id[]" class="form-control">
                <input type="text" name="partner_name" type="text" class="form-control" autocomplete="off">
            </td>
            <td>
                <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_row($(this))"><i class="fa fa-trash-o"></i> Delete</a>
            </td>
        </tr>
    </tbody>
</table>

<table style="display:none" id="benefit-row">
    <tbody>
        <tr>
            <td>
                <?php echo form_dropdown('compben[benefit_id]',$cbopt, '', 'class="form-control select2me" data-placeholder="Select..."')?>
            </td>
            <td>
                <input type="text" class="form-control" name="compben[amount]" value="" >
            </td>
            <td>
                <?php echo form_dropdown('compben[rate_id]',$rateopt, '', 'class="form-control select2me" data-placeholder="Select..."')?>
            </td>
            <td>
                <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_row($(this))"><i class="fa fa-trash-o"></i> Delete</a>
            </td>
        </tr>
    </tbody>
</table>
