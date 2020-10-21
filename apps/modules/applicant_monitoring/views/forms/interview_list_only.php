<?php
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

        $hrd_manager = $this->mod->get_role_permission(4); //hrd manager
        $edit_remarks = false;
        if (in_array($userinfo->role_id,$hrd_manager) || $userinfo->user_id == 38){
            $edit_remarks = true;
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
?>