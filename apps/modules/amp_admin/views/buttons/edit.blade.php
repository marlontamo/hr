<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div class="col-md-offset-3 col-md-5">
        <button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), '')"><i class="fa fa-check"></i> Save</button>
        <button type="button" class="btn blue btn-sm" onclick="save_record( $(this).closest('form'), 'new')"> Save &amp; Add New</button>
        <a class="btn default btn-sm" href="{{ $mod->url }}">Back to list</a>
      <!-- </div> -->
    </div>
  </div>
</div>