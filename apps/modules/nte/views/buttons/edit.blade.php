<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div class="col-md-offset-3 col-md-9">
        <button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), 2)"><i class="fa fa-check"></i> Submit</button>
        @if($record['incident_status_id'] > 1 && $record_id)
          <button type="button" class="btn red btn-sm" onclick="save_record( $(this).closest('form'), 7)"> Cancel this report</button>
        @else          
          <button type="button" class="btn blue btn-sm" onclick="save_record( $(this).closest('form'), 1)"> Save as draft</button>
        @endif
        <!-- <button type="button" class="btn blue btn-sm" onclick="save_record( $(this).closest('form'), 'new')"> Save &amp; Add New</button> -->
        <a class="btn default btn-sm" href="{{ $mod->url }}">Back</a>
      </div>
    </div>
  </div>
</div>