<script type="text/javascript" src="<?php echo theme_path() ?>plugins/bootstrap-tagsinput/typeahead.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo theme_path() ?>plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css"/>

<script src="<?php echo theme_path() ?>plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript" ></script> 
<?php 
    $hidden = "";
    $disabled = "";
    if($is_interviewer == 1){
        $hidden = "style='display:none'";
        $disabled = "disabled";
    }
    $hrd_manager = $this->mod->get_role_permission(4); //hrd manager
    $edit_remarks = false;
    if (in_array($userinfo->role_id,$hrd_manager) || $userinfo->user_id == 38){
        $edit_remarks = true;
    }
?>

<!-- <div class="modal-content"> -->
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
                <?php
                    if ($process->status_id == 5){
                ?>
                        <li class="<?php if($process->status_id == 5) echo 'active' ?>"><a data-toggle="tab" href="#tab_final_interview"><?=lang('applicant_monitoring.final_interview')?></a></li>
                <?php
                    }
                    else{
                ?>
                        <li><a data-toggle="tab" href="#tab_schedule"><?=lang('applicant_monitoring.schedule')?></a></li>
                        <li class="<?php if($process->status_id == 2) echo 'active' ?>"><a data-toggle="tab" href="#tab_interview"><?=lang('applicant_monitoring.interview')?></a></li>
                        <li class="<?php if($process->status_id == 3) echo 'active' ?>"><a data-toggle="tab" href="#tab_examination">Examination</a></li>       
                        <li class="<?php if($process->status_id == 4) echo 'active' ?>"><a data-toggle="tab" href="#tab_bi">BI</a></li>                
                <?php
                    }
                ?>
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
                            <?php
                                if($process->status_id > 1){
                                    $disabled = "disabled";  
                                    $hidden = "style='display:none'"; 
                                }                            
                            ?>                            
                            <!-- START FORM -->
                            <form action="#" class="form-horizontal" name="schedule-form">
                                <input type="hidden"  name="process_id" value="<?php echo $process_id?>">
                                <input type="hidden"  name="type" value="1">
                                <div class="form-body">
                                    <div class="portlet">
                                        <span class="pull-right margin-bottom-15" <?=$hidden?>><div class="btn btn-success btn-xs" onclick="add_sched_row()">+ <?=lang('applicant_monitoring.add_interviewer')?></div></span>
                                        <div class="portlet-body" >
                                            <table class="table table-condensed table-striped table-hover" >
                                                <thead>
                                                    <tr>
                                                        <th width="29%" class="padding-top-bottom-10" ><?=lang('applicant_monitoring.date')?></th>
                                                        <th width="31%" class="padding-top-bottom-10 hidden-xs" ><?=lang('applicant_monitoring.interviewer')?></th>
                                                        <th width="25%" class="padding-top-bottom-10" >Location</th>
                                                        <th width="25%" class="padding-top-bottom-10" ><?=lang('common.actions')?></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="saved-scheds">
                                                <?php                        
                                                    $option = $this->db->get_where('recruitment_interview_location', array('deleted' => 0));
                                                    $options = array('' => 'Select...');
                                                    foreach ($option->result() as $opt) {
                                                        $options[$opt->interview_location_id] = $opt->interview_location;
                                                    }
                                                    if( $saved_scheds ):
                                                        foreach( $saved_scheds as $sched ): ?>
                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                                                        <input name="sched_date[]" type="text" size="16" class="form-control" value="<?php echo date('M d, Y', strtotime($sched->date))?>">
                                                                        <span class="input-group-btn">
                                                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                                        </span>
                                                                    </div> -->
                                                                    <div class="input-group date form_datetime">                                       
                                                                        <input type="text" size="16" readonly class="form-control sched_datetime" name="sched_date[]" value="<?php echo date('F d, Y - H:i', strtotime($sched->date))?>" />
                                                                        <span class="input-group-btn" >
                                                                            <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                                                                        </span>
                                                                    </div>
                                                                </td> 
                                                                <td>
                                                                    <input type="hidden"  name="sched_user_id[]" value="<?php echo $sched->user_id?>" class="form-control">
                                                                    <input type="text" <?=$disabled?> name="partner_name" value="<?php echo $sched->full_name?>" type="text" class="form-control" autocomplete="off">
                                                                </td>
                                                                <td>
                                                                    <!-- <input type="text" name="location[]" id="location" type="text" class="form-control" value="<?php echo $sched->location ?>"> -->
                                                                <?php 
                                                                    echo form_dropdown('location_id[]',$options, $sched->location_id, $disabled.' class="form-control select2me" data-placeholder="Select..."');
                                                                ?>
                                                                </td>
                                                                <td >
                                                                    <a <?=$hidden?> class="btn btn-xs text-muted" href="javascript:void(0)" onclick="send_email(<?php echo $process_id?>, <?php echo $sched->user_id?>)"><i class="fa fa-envelope-o"></i> <?=lang('common.send_email')?></a>
                                                                    <a <?=$hidden?> class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_row($(this))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></a>
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
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?=lang('common.close')?></button>
                        <button <?=$hidden?> type="button" data-loading-text="Loading..." onclick="save_schedule()" class="demo-loading-btn btn btn-success btn-sm"><?=lang('common.save')?></button>
                    </div>
                </div>

                <div id="tab_interview" class="tab-pane <?php if($process->status_id == 2) echo 'active' ?>">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><?=lang('applicant_monitoring.interview_details')?></div>
                            <div class="tools">
                                <a class="collapse" href="javascript:;"></a>
                            </div>
                        </div>
                        <?php
                            $status = "Initial";
                            if( $process->status_id == 2 && $process->from_seting_final_interview == 2){
                                $status = "Final";
                            }
                        ?>
                        <p>This section manage to <strong><?php echo $status ?></strong> interview results. All pending status can only edit by the interviewer.</p>
                        <div class="portlet-body form">
                            <?php
                                if($process->status_id > 2){
                                    $disabled = "disabled";  
                                    $hidden = "style='display:none'"; 
                                }                         
                                else{
                                    $disabled = "";  
                                    $hidden = "";                                     
                                }   
                            ?>                            
                            <!-- <form action="#" class="form-horizontal"> -->
                            <div class="form-body">
                                <div class="portlet">
                                    <div class="portlet-body" >
                                        <table class="table table-condensed table-striped table-hover" >
                                            <thead>
                                                <tr>
                                                    <th width="35%" class="padding-top-bottom-10" ><?=lang('applicant_monitoring.interviewer')?></th>
                                                    <th width="22%" class="padding-top-bottom-10 "><?=lang('applicant_monitoring.date')?></th>
                                                    <th width="20%" class="padding-top-bottom-10 "><?=lang('applicant_monitoring.result')?></th>
                                                    <th width="23%" class="padding-top-bottom-10" ><?=lang('common.actions')?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="saved-interviews"><?php
                                                $interview_success = 1;
                                                if( $saved_scheds ):
                                                    foreach( $saved_scheds as $sched ): 
                                                        if($sched->result == "Hold")
                                                        {
                                                            $interview_success = 9;
                                                        }
                                                        elseif($sched->result == "Reject"){
                                                           $interview_success = 10;
                                                        }
                                                        elseif($sched->result == "Pending"){
                                                           $interview_success = 0;
                                                        }                                                        
                                                            ?>
                                                        <tr rel="0">
                                                            <td style="font-size:13px !important;">
                                                                <?php echo $sched->full_name ?><br>
                                                                <span class="small text-muted"><?php echo $sched->position?></span>
                                                            </td> 
                                                            <td style="font-size:13px !important;">
                                                                <?php echo date('M-d', strtotime( $sched->date )) ?>
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
                                                                <?php if(($sched->interviewer == $login_user && $interview_success != 1) || $edit_remarks):?>
                                                                <div class="btn-group">
                                                                    <a class="btn btn-xs text-muted" href="javascript:edit_interview_result(<?php echo $sched->schedule_id?>);"><i class="fa fa-pencil"></i> <?=lang('common.edit')?></a>
                                                                </div>
                                                                <?php else:?>
                                                                <div class="btn-group">
                                                                    <a class="btn btn-xs text-muted" href="javascript:view_interview_result(<?php echo $sched->schedule_id?>);"><i class="fa fa-search"></i> <?=lang('common.view')?></a>
                                                                </div>
                                                                <?php endif;?>
                                                                <div class="btn-group">
                                                                    <a class="btn btn-xs text-muted" href="javascript:print_interview(<?php echo $sched->process_id?>);"><i class="fa fa-print"></i> <?=lang('applicant_monitoring.print')?></a>
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
                        <!-- </form> -->
                        </div>
                    </div>
                    <div class="modal-footer margin-top-0">
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?=lang('common.close')?></button>
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm" onclick="print_interview(<?php echo $process_id?>)"><?=lang('common.print_only')?></button>
                        <?php if( $process->status_id == 2 && $process->from_seting_final_interview == 2) {
                        ?>
                            <button <?=$hidden?> type="button" onclick="move_to_jo(<?php echo $process_id?>,<?php echo $interview_success ?>)" class="demo-loading-btn btn btn-success btn-sm"><?=lang('applicant_monitoring.move_to_jo')?></button>
                        <?php
                            }
                            else{
                        ?>
                            <button <?=$hidden?> type="button" onclick="move_to_exam(<?php echo $process_id?>,<?php echo $interview_success ?>)" class="demo-loading-btn btn btn-success btn-sm"><?=lang('applicant_monitoring.move_to_exam')?></button>
                        <?php
                            }
                        ?>
                    </div>
                </div> 
                <div id="tab_final_interview" class="tab-pane <?php if($process->status_id == 5) echo 'active' ?>">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><?=lang('applicant_monitoring.interview_sched')?></div>
                            <div class="tools">
                                <a class="collapse" href="javascript:;"></a>
                            </div>
                        </div>
                        <p><?=lang('applicant_monitoring.note_add_interview')?></p>

                        <div class="portlet-body form">
                            <?php
                                if($process->status_id > 5){
                                    $disabled = "disabled";  
                                    $hidden = "style='display:none'"; 
                                }                         
                                else{
                                    $disabled = "";  
                                    $hidden = "";                                     
                                }   
                            ?>                             
                            <!-- START FORM -->
                            <form action="#" class="form-horizontal" name="schedule-form">
                                <input type="hidden"  name="process_id" value="<?php echo $process_id?>">
                                <input type="hidden"  name="type" value="2">
                                <div class="form-body">
                                    <div class="portlet">

                                        <span class="pull-right margin-bottom-15" <?=$hidden?>><div class="btn btn-success btn-xs" onclick="add_sched_row(2)">+ <?=lang('applicant_monitoring.add_interviewer')?></div></span>
                                        <div class="portlet-body" >
                                            <table class="table table-condensed table-striped table-hover" >
                                                <thead>
                                                    <tr>
                                                        <th width="29%" class="padding-top-bottom-10" ><?=lang('applicant_monitoring.date')?></th>
                                                        <th width="31%" class="padding-top-bottom-10 hidden-xs" ><?=lang('applicant_monitoring.interviewer')?></th>
                                                        <th width="25%" class="padding-top-bottom-10" >Location</th>
                                                        <th width="25%" class="padding-top-bottom-10" ><?=lang('common.actions')?></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="saved-scheds-final">
                                                <?php                        
                                                    $option = $this->db->get_where('recruitment_interview_location', array('deleted' => 0));
                                                    $options = array('' => 'Select...');
                                                    foreach ($option->result() as $opt) {
                                                        $options[$opt->interview_location_id] = $opt->interview_location;
                                                    }
                                                    if( $saved_scheds ):
                                                        foreach( $saved_scheds as $sched ): ?>
                                                            <tr>
                                                                <td>
                                                                    <!-- <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                                                        <input name="sched_date[]" type="text" size="16" class="form-control" value="<?php echo date('M d, Y', strtotime($sched->date))?>">
                                                                        <span class="input-group-btn">
                                                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                                        </span>
                                                                    </div> -->
                                                                    <div class="input-group date form_datetime">                                       
                                                                        <input type="text" size="16" readonly class="form-control sched_datetime" name="sched_date[]" value="<?php echo date('F d, Y - H:i', strtotime($sched->date))?>" />
                                                                        <span class="input-group-btn" >
                                                                            <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                                                                        </span>
                                                                    </div>
                                                                </td> 
                                                                <td>
                                                                    <input type="hidden"  name="sched_user_id[]" value="<?php echo $sched->user_id?>" class="form-control">
                                                                    <input type="text" <?=$disabled?> name="partner_name" value="<?php echo $sched->full_name?>" type="text" class="form-control" autocomplete="off">
                                                                </td>
                                                                <td>
                                                                    <!-- <input type="text" name="location[]" id="location" type="text" class="form-control" value="<?php echo $sched->location ?>"> -->
                                                                <?php 
                                                                    echo form_dropdown('location_id[]',$options, $sched->location_id, $disabled.' class="form-control select2me" data-placeholder="Select..."');
                                                                ?>
                                                                </td>
                                                                <td >
<!--                                                                     <a <?=$hidden?> class="btn btn-xs text-muted" href="javascript:void(0)" onclick="send_email(<?php echo $process_id?>, <?php echo $sched->user_id?>)"><i class="fa fa-envelope-o"></i> <?=lang('common.send_email')?></a> -->
                                                                    <a <?=$hidden?> class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_row($(this))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></a>
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
                    <div class="modal-footer margin-top-0" <?=$hidden?>>
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?=lang('common.close')?></button>
                        <button type="button" data-loading-text="Loading..." onclick="save_schedule()" class="demo-loading-btn btn btn-success btn-sm"><?=lang('common.save')?></button>
                    </div>
                </div>
                <div id="tab_examination" class="tab-pane <?php if($process->status_id == 3) echo 'active' ?>">
                <?php require 'exam.php'; ?>
                </div>

                <div id="tab_bi" class="tab-pane <?php if($process->status_id == 4) echo 'active' ?>">
                <?php 
                    if($process->status_id == 2 && $process->from_seting_final_interview == 2){                
                        require 'bi_forms_view.php'; 
                    }
                    else{
                        require 'bi_forms.php';
                    }
                ?>
                </div>

            </div>                        
        </div>
    </div>
<!-- </div> -->

<table style="display:none" id="sched-row">
    <tbody>
        <tr>
            <td>
                <!-- <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                    <input name="sched_date[]" type="text" size="16" class="form-control">
                    <span class="input-group-btn">
                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                </div> -->
                <div class="input-group date form_datetime">                                       
                    <input type="text" size="16" readonly class="form-control sched_datetime" name="sched_date[]" value="<?php echo date('F d, Y - H:i', strtotime($sched->date))?>" />
                    <span class="input-group-btn">
                        <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
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

<script type="text/javascript">

    $('select.select2me').select2();
    
</script>