<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div>
        <?php
        	switch( $record['recruitment_request.status_id'] ):
        		case '2':
                    foreach ($approver as $approvers) {
                       if( $approvers['approver_id'] == $user_id && $approvers['status_id'] == 2 )
                        { ?>
                            <button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), '3', 'approve')"><i class="fa fa-check"></i> {{ lang('mrf_manage.approved') }}</button>
                            <button type="button" class="btn red btn-sm" onclick="save_record( $(this).closest('form'), '8', 'disapprove')">{{ lang('mrf_manage.disapproved') }}</button><?php
                        }
                    }
                    
        			break;
        		case '3':
        		case '4': ?>
        			<!-- <button type="button" class="btn red btn-sm" onclick="save_record( $(this).closest('form'), '6')">{{ lang('mrf_manage.cancel') }}</button> --> <?php
        			break;
        	endswitch;
        ?>
        <a class="btn default btn-sm" href="{{ $mod->url }}">{{ lang('common.back') }}</a>
      </div>
    </div>
  </div>
</div>