<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div class="col-md-offset-4 col-md-9">
        @if($record['approver_status_id'] == 2)
          @if($record['incident_status_id'] == 2)
            {{-- <button type="button" onclick="save_record( $(this).closest('form'), 3)" class="btn btn-warning btn-sm"> {{ lang('common.review') }}</button> --}}

          @endif
          @if(in_array($record['incident_status_id'], array(2,3)))
            <button onclick="save_record( $(this).closest('form'), 4)" class="btn blue btn-sm" type="button"> {{ lang('incident_manage.forward_hr') }}</button>
            {{-- <a href="<?php echo get_mod_route('disciplinary_manage', 'detail/'.$record_id) ?>" class="btn btn-warning btn-sm" type="button"> {{ lang('common.for_da') }}</a> --}}
            <button onclick="cancel_report_form( $(this).closest('form'), 6)" class="btn green btn-sm" type="button"> {{ lang('common.close_report') }}</button>

          @endif
        @endif
        <a class="btn btn-default btn-sm" href="{{ $mod->url }}">{{ lang('common.back_to_list') }}</a>
                                                                                     
      </div>
    </div>
  </div>
</div>