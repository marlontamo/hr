<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div class="">
        <button type="button" class="btn blue btn-sm" onclick="save_record( $(this).closest('form'), 1)"><i class="fa fa-check"></i>  {{ lang('common.save_draft') }}</button>
        <button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), 2)"><i class="fa fa-check"></i>  {{ lang('common.send_approval') }}</button>
        <a class="btn default btn-sm" href="{{ $mod->url }}"> {{ lang('common.back_to_list') }}</a>
      </div>
    </div>
  </div>
</div>