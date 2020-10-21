<div class="form-actions fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-offset-3 col-md-9">
      	@if(in_array($record['request_status_id'], array(2,3)))
        <button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), 4)"><i class="fa fa-check"></i>  {{ lang('common.submit_close_req') }}</button>
        <button type="button" class="btn blue btn-sm" onclick="save_record( $(this).closest('form'), 5)"> {{ lang('erequest_admin.return_partner') }}</button>
      	@endif
        <!-- <button type="button" class="btn blue btn-sm" onclick="save_record( $(this).closest('form'), 'new')"> Save &amp; Add New</button> -->
        <a class="btn btn-default btn-sm" href="{{ $mod->url }}">{{ lang('common.back_to_list') }}</a>
      </div>
    </div>
  </div>
</div>