<div>
    <?php if ($time_from != '0000-00-00 00:00:00') { ?>
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted text-left small'>{{ lang('form_application_manage.time_in') }}:</label>
        <div class='col-md-9'>
            <span> <?php echo date("F d, Y - h:ia", strtotime($time_from)); ?></span>
        </div>
    </div>
    <?php } ?>
    <?php if ($time_to != '0000-00-00 00:00:00') { ?>
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted text-left small'>{{ lang('form_application_manage.time_out') }}:</label>
        <div class='col-md-9'>
            <span> <?php echo date("F d, Y - h:ia", strtotime($time_to)); ?></span>
        </div>
    </div>
    <?php } ?>
   <!--  <div class='clearfix'>
        <label class='control-label col-md-3 text-muted text-left small'>Hours:</label>
        <div class='col-md-9'>
            <span> <?php echo $hrs; ?></span>
        </div>
    </div> -->
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted small'>{{ lang('form_application_manage.date_filed') }}</label>
        <div class='col-md-9'>
            <span class="small"> <?php echo date("F d, Y - h:ia", strtotime($created_on)); ?></span>
        </div>
    </div>      
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted text-left small'>{{ lang('form_application_manage.reason') }}:</label>
        <div class='col-md-9'>
            <span><?php echo $reason; ?></span>
        </div>
    </div>
    <?php if(count($remarks)): 
    ?>
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted text-left small'>{{ lang('form_application_manage.recent_note') }}:</label>
        <?php
        for($j=0; $j < count($remarks); $j++):
            if(array_key_exists('comment', $remarks[$j])): ?>
        <div class='col-md-9'>
            <span style='display:block; word-wrap:break-word;'>
                <?php
                echo "<b>".$remarks[$j]['display_name']."</b>:";
                ?>
            </span>
            <span style='display:block; word-wrap:break-word;'>
                <?php
                echo $remarks[$j]['comment'];
                ?>
            </span>
        </div>
        <?php       endif;
        endfor;
        ?>

    </div>
    <?php
    endif; ?>

    <br>
    <div class='clearfix margin-top-10'>
        <label class='control-label col-md-3 text-muted text-left small'>{{ lang('form_application_manage.remarks') }} ({{ lang('form_application_manage.required_decline') }}):<span class='required'>*</span></label>
        <div class='col-md-9'>
            <textarea rows='4' id='comment-<?php echo $forms_id; ?>' class='form-control'></textarea>
        </div>
    </div>
    <hr class='margin-top-10 margin-bottom-10'>
    <div align='center'>
        <button type='button' class='btn btn-success btn-xs approve-pop small text-success margin-right-10 margin-left-10' data-forms-id='{{ $forms_id }}' data-form-owner='{{ $user_id }}' data-user-name='' data-user-id='{{ $approver_id }}' data-decission='1'><i class='fa fa-check'></i> {{ lang('form_application_manage.approve') }}</button>
        <button type='button' class='btn btn-danger btn-xs decline-pop small text-danger margin-right-10' data-forms-id='{{ $forms_id }}' data-form-owner='{{ $user_id }}' data-user-name='' data-user-id='{{ $approver_id }}' data-decission='0'><i class='fa fa-pencil' ></i> {{ lang('form_application_manage.decline') }}</button>
        <button type='button' class='btn btn-default btn-xs close-pop small text-muted'><i class='fa fa-times'></i> {{ lang('form_application_manage.close') }}</button>
    </div>
</div>