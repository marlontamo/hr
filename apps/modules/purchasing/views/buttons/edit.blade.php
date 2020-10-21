<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div class="">
        <button type="button" class="btn default btn-sm" onclick="save_record( $(this).closest('form'), 3)">Save Draft</button>
        @if( $record['requisition.status_id'] == 3 || $record['requisition.status_id'] == 11 )
          <button type="button" class="btn yellow btn-sm" onclick="save_record( $(this).closest('form'), 4)"><i class="fa fa-check"></i>  For Re-approval</button>
        @endif
        <button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), 10)"><i class="fa fa-check"></i>  PR Process</button>
        <a class="btn default btn-sm" href="{{ $mod->url }}"> {{ lang('common.back_to_list') }}</a>
      </div>
    </div>
  </div>
</div>