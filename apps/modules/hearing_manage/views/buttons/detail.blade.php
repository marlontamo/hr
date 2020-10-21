<div class="form-actions fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-offset-4 col-md-9">
          @if(in_array($record['incident_status_id'], array(9)))
            <button onclick="save_record( $(this).closest('form'), 10)" class="btn btn-info btn-sm" type="button"> {{ lang('common.submit') }} {{ lang('hearing_admin.hearing_sched') }}</button>
            <a href="<?php echo get_mod_route('disciplinary_admin', 'detail/'.$record_id) ?>" class="btn btn-warning btn-sm" type="button"> {{ lang('common.for_da') }}</a>
            <button onclick="save_record( $(this).closest('form'), 6)" class="btn btn-success btn-sm" type="button"> {{ lang('common.close_report') }}</button>
          @elseif(in_array($record['incident_status_id'], array(10)))  
            <a href="<?php echo get_mod_route('disciplinary_admin', 'detail/'.$record_id) ?>" class="btn btn-warning btn-sm" type="button"> {{ lang('common.for_da') }}</a>
            <button onclick="save_record( $(this).closest('form'), 6)" class="btn btn-success btn-sm" type="button"> {{ lang('common.close_report') }}</button>                    
          @endif
        <a class="btn btn-default btn-sm" href="{{ $mod->url }}">{{ lang('common.back_to_list') }}</a>
      </div>
    </div>
  </div>
</div>