<!-- <button type="button" class="btn blue btn-sm" onclick="change_status( $(this).closest('form'), '1')"> {{ lang('common.save_draft') }}</button> -->
@if($appraisee->status_id == 11)
<button type="button" class="btn yellow btn-sm" onclick="change_status( $(this).closest('form'), 2 )"><i class="fa fa-check"></i> {{ lang('appraisal_individual_planning.send_to_approver') }}</button>
@elseif($appraisee->status_id == 2 && (isset($approver) && $current_user_id == $approver->approver_id))
<button type="button" class="btn green btn-sm" onclick="change_status( $(this).closest('form'), 4 )"><i class="fa fa-check"></i> {{ lang('appraisal_individual_planning.approved') }}</button>
<button type="button" class="btn red btn-sm" onclick="change_status( $(this).closest('form'), 11 )"><i class="fa fa-check"></i> {{ lang('appraisal_individual_planning.disapprove') }}</button>
@endif
