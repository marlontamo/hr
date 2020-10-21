<div>
    <div class='clearfix margin-top-10'>
        <label class='control-label col-md-3 text-muted text-left small'>{{ lang('movement_manage.remarks') }} ({{ lang('movement_manage.required_decline') }}):<span class='required'>*</span></label>
        <div class='col-md-9'>
            <textarea rows='4' id='comment-<?php echo $movement_id; ?>' class='form-control'></textarea>
        </div>
    </div>
    <hr class='margin-top-10 margin-bottom-10'>
    <div align='center'>
        @if (in_array($approver_status_id, array(2)))
            <button type='button' class='btn btn-success btn-xs approve-pop small text-success margin-right-10 margin-left-10' data-movement-id='{{ $movement_id }}' data-movement-owner='{{ $user_id }}' data-user-name='' data-user-id='{{ $approver_user_id }}' data-decission='3'><i class='fa fa-check'></i> {{ lang('movement_manage.approve') }}</button>
            <button type='button' class='btn btn-danger btn-xs decline-pop small text-danger margin-right-10' data-movement-id='{{ $movement_id }}' data-movement-owner='{{ $user_id }}' data-user-name='' data-user-id='{{ $approver_user_id }}' data-decission='4'><i class='fa fa-pencil' ></i> {{ lang('movement_manage.decline') }}</button>
        @elseif (in_array($approver_status_id, array(3)))       
            <button type='button' class='btn btn-danger btn-xs decline-pop small text-danger margin-right-10' data-movement-id='{{ $movement_id }}' data-movement-owner='{{ $user_id }}' data-user-name='' data-user-id='{{ $approver_user_id }}' data-decission='4'><i class='fa fa-pencil' ></i> {{ lang('movement_manage.decline') }}</button>     
        @endif
        <button type='button' class='btn btn-default btn-xs close-pop small text-muted'><i class='fa fa-times'></i> {{ lang('movement_manage.close') }}</button>
    </div>
</div>