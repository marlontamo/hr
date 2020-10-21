<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div>
          @if(in_array($record['incident_status_id'], array(4,5)))
            <button onclick="save_record( $(this).closest('form'), 9)" class="btn blue btn-sm" type="button"> {{ lang('common.nte') }}</button>
            <button onclick="save_record( $(this).closest('form'), 6)" class="btn green btn-sm" type="button"> {{ lang('common.close_report') }}</button>
          @endif
        <a class="btn btn-default btn-sm" href="{{ $mod->url }}">{{ lang('common.back_to_list') }}</a>
                                                                                     
      </div>
    </div>
  </div>
</div>