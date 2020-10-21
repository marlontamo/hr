<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div class="">
        <button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), '')"><i class="fa fa-check"></i>  {{ lang('common.save') }}</button>
        <button type="button" class="btn blue btn-sm" onclick="save_record( $(this).closest('form'), 'new')">  {{ lang('common.save_new') }}</button>
        <a class="btn default btn-sm" href="{{ $mod->url }}"> {{ lang('common.back_to_list') }}</a>
      </div>
    </div>
  </div>
</div>