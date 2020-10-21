<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div class="">
        @if (in_array($record['approver_movement_status_id'], array(2)) && $record['partners_movement_created_by'] != $user_id)
        <button class="btn green btn-sm approve" type="button" data-movement-id='{{ $movement_main_details["movement_id"] }}' data-movement-owner='{{ $movement_main_details["created_by"] }}' data-user-name='' data-user-id='{{ $movement_main_details["approver_user_id"] }}' data-decission='3'><i class="fa fa-edit"></i> Approve</button>
        <button class="btn red btn-sm decline" type="button" data-movement-id='{{ $movement_main_details["movement_id"] }}' data-movement-owner='{{ $movement_main_details["created_by"] }}' data-user-name='' data-user-id='{{ $movement_main_details["approver_user_id"] }}' data-decission='4'><i class="fa fa-undo"></i> Decline</button>
        @elseif (in_array($record['approver_movement_status_id'], array(2)) && $record['partners_movement_created_by'] != $user_id) 
        <button class="btn red btn-sm decline" type="button" data-movement-id='{{ $movement_main_details["movement_id"] }}' data-movement-owner='{{ $movement_main_details["created_by"] }}' data-user-name='' data-user-id='{{ $movement_main_details["approver_user_id"] }}' data-decission='4'><i class="fa fa-undo"></i> Decline</button>
        @endif
        <a class="btn default btn-sm" href="{{ $mod->url }}"> {{ lang('common.back_to_list') }}</a>
      </div>
    </div>
  </div>
</div>