<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div class="">
        <button type="button" class="btn default btn-sm" onclick="save_record( $(this).closest('form'), 0)">Save Draft</button>
        @if( $record['requisition.status_id'] == 12 )
          <button type="button" class="btn yellow btn-sm" onclick="save_record( $(this).closest('form'), 13)"><i class="fa fa-check"></i>  For Confirmation</button>
        @endif
        <a class="btn default btn-sm" href="{{ $mod->url }}"> {{ lang('common.back_to_list') }}</a>
      </div>
    </div>
  </div>
</div>