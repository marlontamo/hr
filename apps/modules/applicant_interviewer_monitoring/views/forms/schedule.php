<script type="text/javascript" src="<?php echo theme_path() ?>plugins/bootstrap-tagsinput/typeahead.js"></script>
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
            
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">Interview</div>
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
                                <!-- <span class="pull-right margin-bottom-15"><div class="btn btn-success btn-xs" onclick="add_sched_row()">+ Add Schedule</div></span> -->
                                <div class="portlet-body" >
                                    <table class="table table-condensed table-striped table-hover" >
                                        <thead>
                                            <tr>
                                                <th width="29%" class="padding-top-bottom-10" ><?=lang('applicant_monitoring.date')?></th>
                                                <th width="35%" class="padding-top-bottom-10 hidden-xs" ><?=lang('applicant_monitoring.interviewer')?></th>
                                                <th width="25%" class="padding-top-bottom-10" >Location</th>
                                                <th width="15%" class="padding-top-bottom-10" >Action</th>
                                            </tr>
                                        </thead>
                                        <?php                        
                                            $option = $this->db->get_where('users_location', array('deleted' => 0));
                                            $options = array('' => 'Select...');
                                            foreach ($option->result() as $opt) {
                                                $options[$opt->location_id] = $opt->location;
                                            }
                                        ?>
                                        <tbody id="saved-scheds"><?php
                                            if(isset( $saved_scheds )):
                                                foreach( $saved_scheds as $sched ): ?>
                                                    <tr class="step1_interview">
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
                                                            <input type="text" name="location[]" id="location" type="text" class="form-control" value="<?php echo $sched->location ?>">
                                                        <?php
                                                            // echo form_dropdown('location_id[]',$options, $sched->location_id, 'class="form-control select2me" data-placeholder="Select..."');
                                                        ?>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_row($(this))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                endforeach;
                                            endif;
                                        ?></tbody>
                                    </table>
                                     <div id="no_record" class="well" style="display:none">
                                        <p class="bold"><i class="fa fa-exclamation-triangle"></i> <?php echo lang('common.no_record_found') ?></p>
                                        <span><p class="small margin-bottom-0"><?php echo 'Zero (0) was found. Click Add Schedule button to add to interview schedule.' ?></p></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
                                
        </div>
    </div>
    <div class="modal-footer margin-top-0">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
        <!-- <button type="button" data-loading-text="Loading..." onclick="save_schedule()" class="demo-loading-btn btn btn-success btn-sm">Save</button> -->
    </div>
</div>

<table style="display:none" id="sched-row">
    <tbody>
        <tr class="step1_interview">
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
                <input type="text" name="location[]" id="location" type="text" class="form-control" >
            <?php
                // echo form_dropdown('location_id[]',$options, '', 'class="form-control select2me" data-placeholder="Select..."');
            ?>
            </td>
            <td>
                <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_row($(this))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></a>
            </td>
        </tr>
    </tbody>
</table>

<script type="text/javascript">

    var step1_interview = $('.step1_interview').length;
    if( !(step1_interview > 1) ){
        $("#no_record").show();
    }
</script>