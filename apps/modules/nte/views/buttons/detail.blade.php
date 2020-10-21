<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div>
          @if(in_array($record['nte_status_id'], array(0,1)) && $record['incident_status_id'] != 6)
            <button onclick="save_record( $(this).closest('form'), 1)" class="btn btn-info btn-sm" type="button"> {{ lang('common.save_draft') }}</button>
            <button onclick="save_record( $(this).closest('form'), 2)" class="btn btn-success btn-sm" type="button"> {{ lang('nte.submit_hr') }}</button>
          @endif
        <a class="btn btn-default btn-sm" href="{{ $mod->url }}">{{ lang('common.back_to_list') }}</a>
      </div>
    </div>
  </div>
</div>