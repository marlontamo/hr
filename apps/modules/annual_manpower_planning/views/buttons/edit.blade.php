<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div class="col-md-offset-3 col-md-5">
        <button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), '', '', 1)"><i class="fa fa-check"></i> {{ lang('common.save') }}</button>
        <button type="button" class="btn blue btn-sm btn-savenew" onclick="save_record( $(this).closest('form'), 'new', '', 1)"> {{ lang('common.save_new') }}</button>
        @if ($record['recruitment_manpower_plan.manpower_plan_status_id'] != 2 && (isset($record['record_id']) && $record['record_id'] >= 1))
          <button type="button" class="btn green btn-sm btn-send" onclick="save_record( $(this).closest('form'), 'back', '', 2)"> {{ lang('common.send_approval') }}</button>
        @endif
        <a class="btn default btn-sm" href="{{ $mod->url }}">{{ lang('common.back_to_list') }}</a>
      </div>
    </div>
  </div>
</div>