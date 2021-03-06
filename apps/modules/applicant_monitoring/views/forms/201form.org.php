<script type="text/javascript" src="<?php echo theme_path() ?>plugins/bootstrap-tagsinput/typeahead.js"></script>
<script src="<?php echo theme_path() ?>plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript" ></script>
<link href="<?php echo theme_path() ?>plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo theme_path() ?>plugins/select2/select2.min.js" type="text/javascript" ></script>
<link href="<?php echo theme_path() ?>plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>

<?php 
    $hidden = "";
    $disabled = "";
    if($is_interviewer == 1){
        $hidden = "style='display:none'";
        $disabled = "disabled";
    }
?>

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
                            <div class="caption"><?=lang('applicant_monitoring.interview_sched')?></div>
                            <div class="tools">
                                <a class="collapse" href="javascript:;"></a>
                            </div>
                        </div>
                        <p><?=lang('applicant_monitoring.note_add_interview')?></p>

                        <div class="portlet-body form">
                            <!-- START FORM -->
                            <form action="#" class="form-horizontal" name="schedule-form">
                                <input type="hidden"  name="process_id" value="<?php echo $process_id?>">
                                <div class="form-body">
                                    <div class="portlet">
                                        <div class="portlet-body" >
                                            <table class="table table-condensed table-striped table-hover" >
                                                <thead>
                                                    <tr>
                                                        <th width="15%" class="padding-top-bottom-10" ><?=lang('applicant_monitoring.date')?></th>
                                                        <th width="45%" class="padding-top-bottom-10 hidden-xs" ><?=lang('applicant_monitoring.interviewer')?></th>
                                                        <th width="10%" class="padding-top-bottom-10" ><?=lang('common.actions')?></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="saved-scheds"><?php
                                                    if( $saved_scheds ):
                                                        foreach( $saved_scheds as $sched ): ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo date('M d, Y - h:i a', strtotime($sched->date))?>
                                                                </td> 
                                                                <td>
                                                                    <?php echo $sched->full_name?>
                                                                </td>
                                                                <td></td>
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
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?=lang('common.close')?></button>
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
                            <div class="caption"><?=lang('applicant_monitoring.interview_details')?></div>
                            <div class="tools">
                                <a class="collapse" href="javascript:;"></a>
                            </div>
                        </div>
                        <p><?=lang('applicant_monitoring.note_interview_result')?></p>

                        <div class="portlet-body form">
                            <div class="form-body">
                                <div class="portlet">
                                    <div class="portlet-body" >
                                        <table class="table table-condensed table-striped table-hover" >
                                            <thead>
                                                <tr>
                                                    <th width="30%" class="padding-top-bottom-10" ><?=lang('applicant_monitoring.interviewer')?></th>
                                                    <th width="25%" class="padding-top-bottom-10 "><?=lang('applicant_monitoring.date')?></th>
                                                    <th width="20%" class="padding-top-bottom-10 "><?=lang('applicant_monitoring.result')?></th>
                                                    <th width="25%" class="padding-top-bottom-10" ><?=lang('common.actions')?></th>
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
                                                                    <a class="btn btn-xs text-muted"><i class="fa fa-print"></i> <?=lang('applicant_monitoring.print')?></a>
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
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?=lang('common.close')?></button>
                    </div>
                </div> 
 
                <div id="tab_jo" class="tab-pane">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><?=lang('applicant_monitoring.jo_details')?></div>
                            <div class="tools">
                                <a class="collapse" href="javascript:;"></a>
                            </div>
                        </div>
                        <p><?=lang('applicant_monitoring.note_jo_details')?></p>

                        <div class="portlet-body form margin-top-25">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" name="jo-form" method="post">
                                <inpput type="hidden" value="<?php echo $process_id?>" name="process_id"/>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('applicant_monitoring.employee_status')?>
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <?php
                                            $option = $this->db->get_where('partners_employment_status', array('active' => 1, 'deleted' => 0));
                                            $options = array();
                                            foreach ($option->result() as $opt) {
                                                $options[$opt->employment_status_id] = $opt->employment_status;
                                            }

                                            echo form_dropdown('jo[employment_status_id]',$options, $employment_status_id, 'disabled class="form-control select2me" data-placeholder="Select..."');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('applicant_monitoring.start_date')?></label>
                                    <div class="col-md-6">
                                        <div class="input-group input-medium date date-picker" data-date-format="dd-MM-yyyy">
                                            <input type="text" name="jo[start_date]" class="form-control" value="<?php echo $start_date?>" readonly>
                                            <span class="input-group-btn">
                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('applicant_monitoring.month_no')?>
                                    </label>
                                    <div class="col-md-6">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" name="jo[no_months]" disabled value="<?php echo $no_months?>">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('applicant_monitoring.template')?>
                                    </label>
                                    <div class="col-md-6">
                                            <div class="input-group">
                                                <?php
                                                    $option = $this->db->get_where('system_template', array('code' => 'STEP-4', 'mod_id' => $mod->mod_id, 'deleted' => 0));
                                                    $options = array();
                                                    foreach ($option->result() as $opt) {
                                                        $options[$opt->template_id] = $opt->name;
                                                    }

                                                    echo form_dropdown('jo[template_id]',$options, $template_id, 'disabled class="form-control select2me" data-placeholder="Select..."');
                                                ?>
                                            </div>
                                            <div class="help-block small">
                                                <?=lang('applicant_monitoring.note_print')?>
                                            </div>
                                        
                                    </div>
                                </div>

                                <br><br>
                                
                                <!--Compensation and Benefits-->
                                <div class="portlet ">
                                    <div class="portlet-title">
                                        <div class="caption"><?=lang('applicant_monitoring.compben')?></div>
                                        <div class="pull-right">
                                            <!-- <a class="btn btn-success btn-xs pull-right" href="javascript:add_benefit_row();">+ <?=lang('applicant_monitoring.add_benefits')?></a> -->
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
                                                                
                                                                <th width="25%" class="padding-top-bottom-10" ><?=lang('applicant_monitoring.benefits')?></th>
                                                                <th width="25%" class="padding-top-bottom-10 hidden-xs" ><?=lang('applicant_monitoring.amount')?></th>
                                                                <th width="30%" class="padding-top-bottom-10"><?=lang('applicant_monitoring.mode')?></th>
                                                                <th width="10%" class="padding-top-bottom-10" ><?=lang('common.actions')?></th>
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
                                                                        <?php echo form_dropdown('compben[benefit_id]',$cbopt, $benefit->benefit_id, 'disabled class="form-control select2me" data-placeholder="Select..."')?>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" disabled name="compben[amount]" value="<?php echo $benefit->amount?>" >
                                                                    </td>
                                                                    <td>
                                                                        <?php echo form_dropdown('compben[rate_id]',$rateopt, $benefit->rate_id, 'disabled class="form-control select2me" data-placeholder="Select..."')?>
                                                                    </td>
                                                                    <td>
                                                                        <!-- <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_row($(this))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></a> -->
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
                        <button class="btn btn-default btn-sm" data-dismiss="modal" type="button"><?=lang('common.close')?></button>
                        <!-- <button type="button" onclick="save_jo()" class="demo-loading-btn btn btn-success btn-sm"><?=lang('common.save')?></button> -->
                        <button type="button" class="btn btn-sm btn-info"><i class="fa fa-print"></i> <?=lang('applicant_monitoring.print')?></button>
                       <!--  <button class="demo-loading-btn btn btn-success btn-sm" onclick="move_to_cs(<?php echo $process_id?>)" type="button"><?=lang('applicant_monitoring.cs')?></button> -->
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
                                <input type="hidden" value="<?php echo $process->process_id?>" name="process_id" />
                                <input type="hidden" value="<?php echo $recruit->recruit_id?>" name="recruit_id">  
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

                                                echo form_dropdown('signing[template_id]',$options, $template_id, 'disabled class="form-control select2me" data-placeholder="Select..."');
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
                                        <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Accept&nbsp;&nbsp;" data-off-label="&nbsp;Decline&nbsp;">
                                            <input type="checkbox" disabled value="0" <?php if( $signing_accepted ) echo 'checked="checked"'?> name="cs_status[temp]" id="signing-accepted-temp" class="dontserializeme toggle"/>
                                            <input type="hidden" name="signing[accepted]" id="signing-accepted" value="<?php echo ($signing_accepted)  ? 1 : 0 ; ?>"/>
                                        </div> 
                                        <small class="help-block">
                                        The status if the applicant sign or accept the offer.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group declined_blacklisted">
                                    <label class="control-label col-md-4">BlackListed</label>
                                    <div class="col-md-7">
                                        <div class="make-switch" data-off="success" data-on="danger" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                            <input type="checkbox" disabled value="1" <?php if( $blacklisted ) echo 'checked="checked"'; ?> name="recruitment[blacklisted][temp]" id="recruitment-blacklisted-temp" class="dontserializeme toggle"/>
                                            <input type="hidden" name="recruitment[blacklisted]" id="recruitment-blacklisted" value="<?php echo ( $blacklisted ) ? 1 : 0 ; ?>"/>
                                        </div> 
                                        <small class="help-block">
                                        Mark as block listed if applicant rejects the offer.
                                        </small>
                                    </div>
                                </div>
                               </form>
                             <!-- END FORM--> 
                        </div>
                    </div>
                    <div class="modal-footer margin-top-0">
                        <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">Close</button>                       
                        <button type="button" class="btn btn-sm btn-info"><i class="fa fa-print"></i> Print</button>                       
                    </div>
                </div>

                <div id="tab_preemp" class="tab-pane">
                    <div class="portlet">
                            <div class="portlet-body" >
                                <!-- Table -->
                                <table class="table table-condensed table-striped table-hover" >
                                    <thead>
                                        <tr>                                        
                                            <th width="47%" class="padding-top-bottom-10" ><?=lang('applicant_monitoring.requirements')?></th>
                                            <th width="32%" class="padding-top-bottom-10 "><?=lang('applicant_monitoring.completed')?></th>
                                            <th width="26%" class="padding-top-bottom-10" ><?=lang('common.actions')?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $qry = "SELECT ec.checklist, pec.checklist_id, pec.submitted, ec.for_submission, 
                                            pec.created_on, pec.modified_on, pec.process_id, ec.print_function
                                            FROM {$this->db->dbprefix}recruitment_process_employment_checklist pec
                                            LEFT JOIN {$this->db->dbprefix}recruitment_employment_checklist ec
                                            ON pec.checklist_id = ec.checklist_id
                                            WHERE pec.deleted = 0 AND pec.process_id = {$process->process_id}";
                                            // echo "<pre>".$qry;
                                            $checklist = $this->db->query($qry);
                                            foreach( $checklist->result() as $list ):
                                        ?>
                                        <tr rel="0">
                                            <!-- this first column shows the year of this holiday item -->
                                            <td>
                                                <?php echo $list->checklist ?>
                                            </td> 

                                            <td>
                                                <?php if($list->for_submission == 1){ 
                                                        if($list->submitted){
                                                    ?>
                                                    <span ><i class="fa fa-check text-success"></i> <?=lang('applicant_monitoring.done')?></span>
                                                    <?php }else{?>
                                                    <div class="make-switch switch-small" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;&nbsp;">
                                                        <input type="checkbox" value="1" <?php if( $list->submitted ) echo 'checked="checked"'; ?> name="recruitment_process_employment_checklist[submitted][temp]" id="recruitment_process_employment_checklist-submitted-temp" class="dontserializeme toggle submitted-temp" data-checkId="<?php echo $list->checklist_id?>" data-processId="<?php echo $list->process_id?>" />
                                                        <input type="hidden" name="recruitment_process_employment_checklist[submitted]" id="recruitment_process_employment_checklist-submitted" value="<?php echo ( $list->submitted ) ? 1 : 0 ; ?>"/>
                                                    </div>
                                                <?php }
                                                    }else{ ?>
                                                    <span ><i class="fa fa-check text-success"></i> <?=lang('applicant_monitoring.done')?></span>
                                                <?php } ?>

                                                <small class="help-block small">

                                                <?php if($list->submitted == 1){ 
                                                        if(strtotime($list->modified_on)){
                                                            echo date('d M Y h:ia', strtotime($list->modified_on));
                                                        }else if(strtotime($list->created_on)){
                                                            echo date('d M Y h:ia', strtotime($list->created_on));
                                                        }
                                                    }else{
                                                        if(strtotime($list->modified_on)){
                                                            echo date('d M Y h:ia', strtotime($list->modified_on));
                                                        }
                                                    } ?>

                                                </small>
                                            </td>

                                            <td>
                                                <!-- <div class="btn-group">
                                                    <a class="btn btn-xs text-muted" data-toggle="modal" href="#applicant_interview-result"><i class="fa fa-pencil"></i> Edit</a>
                                                </div> -->
                                                <div class="btn-group">
                                                    <a class="btn btn-xs text-muted" onclick="<?php echo $list->print_function ?>(<?php echo $process->process_id ?>)"><i class="fa fa-print"></i> <?=lang('applicant_monitoring.print')?></a>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="modal-footer margin-top-0 pull-right">
                            <button class="btn btn-default btn-sm" data-dismiss="modal" type="button"><?=lang('common.close')?></button>
                          
                        </div>
                </div>

                <div id="tab_201" class="tab-pane active">
                    <div class="portlet">
                        <div class="portlet-body form margin-top-25">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal margin-top-25" name="201-form" method="post">
                                <input type="hidden" value="<?php echo $process_id?>" name="process_id" />
                                <input type="hidden" value="<?php echo $recuser_user_id?>" name="user_id" />
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('applicant_monitoring.company')?> <span class="required">*</span></label>
                                    <div class="col-md-6">
                                        <?php
                                            $option = $this->db->get_where('users_company', array('deleted' => 0));
                                            $options = array('' => 'Select...');
                                            foreach ($option->result() as $opt) {
                                                $options[$opt->company_id] = $opt->company;
                                            }

                                            echo form_dropdown('users_profile[company_id]',$options, $recuser_company_id, $disabled.' class="form-control select2me" data-placeholder="Select..."');
                                        ?> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('applicant_monitoring.dept')?> <span class="required">*</span></label>
                                    <div class="col-md-6">
                                        <?php
                                            $option = $this->db->get_where('users_department', array('deleted' => 0));
                                            $options = array('' => 'Select...');
                                            foreach ($option->result() as $opt) {
                                                $options[$opt->department_id] = $opt->department;
                                            }

                                            echo form_dropdown('users_profile[department_id]',$options, $recuser_department_id, $disabled.' class="form-control select2me" data-placeholder="Select..."');
                                        ?> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('applicant_monitoring.reports_to')?> <span class="required">*</span></label>
                                    <div class="col-md-6">
                                        <?php
                                            $option = $this->db->get_where('users', array('deleted' => 0, 'active' => 1));
                                            $options = array('' => 'Select...');
                                            foreach ($option->result() as $opt) {
                                                $options[$opt->user_id] = $opt->full_name;
                                            }

                                            echo form_dropdown('users_profile[reports_to_id]',$options, $recuser_reports_to_id, $disabled.' class="form-control select2me" data-placeholder="Select..."');
                                        ?> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('applicant_monitoring.location')?> <span class="required">*</span></label>
                                    <div class="col-md-6">
                                        <?php
                                            $option = $this->db->get_where('users_location', array('deleted' => 0));
                                            $options = array('' => 'Select...');
                                            foreach ($option->result() as $opt) {
                                                $options[$opt->location_id] = $opt->location;
                                            }

                                            echo form_dropdown('users_profile[location_id]',$options, $recuser_location_id, $disabled.' class="form-control select2me" data-placeholder="Select..."');
                                        ?> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('applicant_monitoring.work_sched')?> <span class="required">*</span></label>
                                    <div class="col-md-6">
                                        <?php
                                            $option = $this->db->get_where('time_shift', array('deleted' => 0));
                                            $options = array('' => 'Select...');
                                            foreach ($option->result() as $opt) {
                                                $options[$opt->shift_id] = $opt->shift;
                                            }

                                            echo form_dropdown('partners[shift_id]',$options, $recuser_shift_id, $disabled.' class="form-control select2me" data-placeholder="Select..."');
                                        ?> 
                                    </div>
                                </div>
                               

                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('applicant_monitoring.project')?> <span class="required">*</span></label>
                                    <div class="col-md-6">
                                        <select  class="form-control select2me" name="users_profile[project_id]" id="users_profile-project_id">
                                            <option value="">Select...</option>
                                            <?php
                                                $option = $this->db->get_where('users_project', array('deleted' => 0));
                                                foreach($option->result() as $option)
                                                {
                                                    echo '<option value="'.$option->project_id.'">'.$option->project.'</option>';
                                                } 
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('applicant_monitoring.id_no')?>
                                    </label>
                                    <div class="col-md-6">
                                        <div class="input-icon">
                                            <input type="text" name="users[login]" id="users-login" <?=$disabled?> value="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </form>
                             <!-- END FORM--> 
                        </div>
                    </div>
                    <div class="modal-footer margin-top-0">
                        <button class="btn btn-default btn-sm" data-dismiss="modal" type="button"><?=lang('common.close')?></button>
                        <button type="button" <?=$hidden?> onclick="save_201()" class="demo-loading-btn btn btn-success btn-sm"><?=lang('applicant_monitoring.save_201')?></button>
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
                <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_row($(this))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></a>
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
                <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_row($(this))"><i class="fa fa-trash-o"></i> ?=lang('common.delete')?></a>
            </td>
        </tr>
    </tbody>
</table>
