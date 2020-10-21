<div>
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted small'>{{ lang('form_application_manage.employee') }}:</label>
        <div class='col-md-9'>
            <span class="small">{{ $display_name }}</span>
        </div>
    </div>
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted small'>{{ lang('form_application_manage.from') }}</label>
        <div class='col-md-9'>
            <span class="small"> <?php echo date("F d, Y - h:ia", strtotime($time_from)); ?></span>
        </div>
    </div>
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted small'>{{ lang('form_application_manage.to') }}</label>
        <div class='col-md-9'>
            <span class="small"> <?php echo date("F d, Y - h:ia", strtotime($time_to)); ?></span>
        </div>
    </div>
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted small'>{{ lang('form_application_manage.hours') }}</label>
        <div class='col-md-9'>
            <span class="small"> <?php echo $hrs; ?></span>
        </div>
    </div>
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted small'>{{ lang('form_application_manage.reason') }}</label>
        <div class='col-md-9'>
            <span class="small"><?php echo $reason; ?></span>
        </div>
    </div>

    <?php if(count($remarks)): ?>
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted small'>{{ lang('form_application_manage.recent_note') }}:</label>
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
        <label class='control-label col-md-3 text-muted small'>{{ lang('form_application_manage.remarks') }} ({{ lang('form_application_manage.required_decline') }})<span class='required'>*</span></label>
        <div class='col-md-9'>
            <textarea rows='4' id='comment-<?php echo $forms_id; ?>' class='form-control small'></textarea>
        </div>
    </div>
    <hr class='margin-top-10 margin-bottom-10'>
    <div>
        <button type='button' class='btn btn-success btn-sm approve-pop small text-success margin-right-5' data-forms-id='{{ $forms_id }}' data-form-owner='{{ $user_id }}' data-user-name='' data-user-id='{{ $approver_id }}' data-decission='1'><i class='fa fa-thumbs-o-up'></i> {{ lang('form_application_manage.approve') }}</button>
        <button type='button' class='btn btn-danger btn-sm decline-pop small text-danger' data-forms-id='{{ $forms_id }}' data-form-owner='{{ $user_id }}' data-user-name='' data-user-id='{{ $approver_id }}' data-decission='0'><i class='fa fa-thumbs-o-down' ></i> {{ lang('form_application_manage.decline') }}</button>
        <button type='button' class='btn btn-default btn-sm close-pop small text-muted'><i class='fa fa-long-arrow-right'></i> {{ lang('form_application_manage.close') }}</button>
    </div>
</div>