<div class="form-actions fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-offset-4 col-md-9">
         <!--  @if(in_array($record['nte_status_id'], array(0,1)))
            <button onclick="save_record( $(this).closest('form'), 1)" class="btn btn-info btn-sm" type="button"> Save a Draft</button>
            <button onclick="save_record( $(this).closest('form'), 2)" class="btn btn-success btn-sm" type="button"> Submit to HR</button>
          @endif -->
        <a class="btn btn-default btn-sm" href="{{ $mod->url }}">{{ lang('common.back_to_list') }}</a>
      </div>
    </div>
  </div>
</div>