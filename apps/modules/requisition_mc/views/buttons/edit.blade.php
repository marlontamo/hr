<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div class="">
        <button type="button" class="btn blue btn-sm" onclick="save_record( $(this).closest('form'), 0)"><i class="fa fa-check"></i>  {{ lang('common.save_draft') }}</button>
        <button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), 3)"><i class="fa fa-check"></i>  {{ lang('common.approve') }}</button>
    		<button type="button" class="btn red btn-sm" onclick="save_record( $(this).closest('form'), 6)"><i class="fa fa-times"></i>  {{ lang('common.disapprove') }}</button>
        <a class="btn default btn-sm" href="{{ $mod->url }}"> {{ lang('common.back_to_list') }}</a>
      </div>
    </div>
  </div>
</div>