<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
        <!-- <span style="{{ ($is_assigned) ? 'display:none' : '' }}"> -->
        <?php 
        	switch( $record['recruitment_request.status_id'] ):
/*        		case '':
            case 2: ?>
                    <button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), '3')"><i class="fa fa-check"></i> {{ lang('mrf_admin.approved') }}</button>
                    @if( !empty( $record_id ) )
                      <button type="button" class="btn red btn-sm" onclick="save_record( $(this).closest('form'), '6')"> {{ lang('common.cancel') }}</button>
                    @endif <?php
                    break;*/
            case 3: ?>
              <button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), '7')"><i class="fa fa-check"></i> Validate Request</button>
        <?php
            break;
            case 7: //validated
        ?>
              <button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), '5')"><i class="fa fa-check"></i> Close Request</button>
        <?php
              break;
        	endswitch;
        ?>
        <!-- </span> -->
        <a class="btn default btn-sm" href="{{ $mod->url }}">{{ lang('common.back') }}</a>
    </div>
  </div>
</div>