<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div>
        <?php
        	switch( $record['recruitment_request.status_id'] ):
        		case '':
        		case '0':
        		case '1':
                case '8': ?>
        			<button type="button" class="btn blue btn-sm" onclick="save_record( $(this).closest('form'), '1', 'save')"> {{ lang('common.save_draft') }}</button>
        			<button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), '2', 'submit')"><i class="fa fa-check"></i> {{ lang('common.submit') }} Request</button> <?php
        			break;
        		case '3':
        		case '2': 
                    $count = 0;
                    foreach($approver as $approvers) {
                        if($approvers['status_id'] == 3) {
                            $count = 1;
                            ?>
                             
                    <?php 
                        }
                    }
                    
                    if($count != 1) { ?> 
                        <button type="button" class="btn red btn-sm" onclick="save_record( $(this).closest('form'), '6', 'cancel')"> {{ lang('common.cancel') }}</button>
        			<?php
                    }
                    break;

        	endswitch;
        ?>
        <a class="btn default btn-sm" href="{{ $mod->url }}">{{ lang('common.back') }}</a>
      </div>
    </div>
  </div>
</div>