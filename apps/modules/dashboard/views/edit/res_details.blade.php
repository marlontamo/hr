<div>
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted small'>Type</label>
        <div class='col-md-9'>
            <span class="small"><?php echo $res_type_desc; ?></span>
        </div>
    </div>
    <div name="et_ut_type" id="et_ut_type" class="@if($res_type==2) hidden @endif">
        <div class="clearfix @if($res_type==1) hidden @endif">
            <label class='control-label col-md-3 text-muted small'>{{ lang('dashboard.ut_date') }}</label>
            <div class='col-md-9'>
                <span class="small"> {{ $date_to }}</span>
            </div>
        </div>
        <div class="clearfix @if($res_type==0) hidden @endif">
            <label class='control-label col-md-3 text-muted small'>{{ lang('dashboard.ut_date') }}</label>
            <div class='col-md-9'>
                <span class="small"> {{ $date_from }}</span>
            </div>
        </div>
    </div>

    <div name="in_between_type" id="in_between_type" class="@if($res_type!=2) hidden @endif">
        <div class='clearfix'>
            <label class='control-label col-md-3 text-muted small'>{{ lang('dashboard.leave_from') }}</label>
            <div class='col-md-9'>
                <span class="small"> {{ $date_from }}</span>
            </div>
        </div>
        <div class='clearfix'>
            <label class='control-label col-md-3 text-muted small'>{{ lang('dashboard.leave_to') }}</label>
            <div class='col-md-9'>
                <span class="small"> {{ $date_to }}</span>
            </div>
        </div>
    </div>

    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted small'>{{ lang('dashboard.ut_reason') }}</label>
        <div class='col-md-9'>
            <span class="small"><?php echo $reason; ?></span>
        </div>
    </div>

    <?php if(count($remarks)): ?>
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted text-left small'><?php echo lang('dashboard.recent_note') ?></label>
        <?php
        for($j=0; $j < count($remarks); $j++):
            if(array_key_exists('comment', $remarks[$j])): ?>
            <div class='col-md-9'>
                <span class="small italic" style='display:block; word-wrap:break-word;'>
                    <?php
                        echo "<b>".$remarks[$j]['display_name']."</b><br>";
                        echo '<span class="text-success">[ '.$remarks[$j]['comment_date'].' ]</span>';
                    ?>
                </span>
                <span class="small" style='display:block; word-wrap:break-word;'>
                    <?php
                        if(empty($remarks[$j]['comment']))
                            echo '-';
                        else
                            echo $remarks[$j]['comment'];
                    ?>
                </span>
            </div>
        <?php 
        endif;
        endfor;
        ?>
    </div>
    <?php endif; ?>

    <br>
    <div class='clearfix margin-top-10'>
        <label class='control-label col-md-3 text-muted text-left small'><?php echo lang('dashboard.remarks_form') ?> <span class='required'>*</span></label>
        <div class='col-md-9'>
            <textarea rows='4' id='comment-<?php echo $forms_id; ?>' class='form-control small'></textarea>
        </div>
        <label class="col-md-3"></label>
        <div class='col-md-9'>
            <span class="text-muted small"><?php echo lang('dashboard.required_decline') ?> </span>
        </div>
    </div>
    <hr class='margin-top-10 margin-bottom-10'>
    <div>
        <button type='button' data-form-name='{{ $form }}' class='btn btn-success btn-sm approve-pop text-success margin-right-5' data-forms-id='{{ $forms_id }}' data-form-owner='{{ $user_id }}' data-user-name='' data-user-id='{{ $approver_id }}' data-decission='1'><i class='fa fa-thumbs-o-up'></i> <?php echo lang('dashboard.approve_form') ?></button>
        <button type='button' data-form-name='{{ $form }}' class='btn btn-danger btn-sm decline-pop text-danger' data-forms-id='{{ $forms_id }}' data-form-owner='{{ $user_id }}' data-user-name='' data-user-id='{{ $approver_id }}' data-decission='0'><i class='fa fa-thumbs-o-down' ></i> <?php echo lang('dashboard.decline_form') ?></button>
        <button type='button' class='btn btn-default btn-sm close-pop text-muted pull-right'><i class='fa fa-long-arrow-right'></i> <?php echo lang('dashboard.close_form') ?></button>
    </div>

</div>