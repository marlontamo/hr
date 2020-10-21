<div class="form-actions fluid">
  <div class="row">
    <div class="col-md-12" align="center">
      <div class="col-md-offset-3 col-md-9">
        <button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), 2)"><i class="fa fa-check"></i> {{ lang('common.submit') }}</button>
        @if($record['incident_status_id'] > 1 && $record_id)
          <button type="button" class="btn red btn-sm" onclick="save_record( $(this).closest('form'), 7)"> {{ lang('common.clse_rep') }}</button>
        @else          
          <button type="button" class="btn blue btn-sm" onclick="save_record( $(this).closest('form'), 1)"> {{ lang('common.save_draft') }}</button>
        @endif
        <!-- <button type="button" class="btn blue btn-sm" onclick="save_record( $(this).closest('form'), 'new')"> Save &amp; Add New</button> -->
        <a class="btn default btn-sm" href="{{ $mod->url }}">{{ lang('common.back') }}</a>
      </div>
    </div>
  </div>
</div>