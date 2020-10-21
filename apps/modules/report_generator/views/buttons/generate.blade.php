<div class="form-actions fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-offset-3 col-md-9">
        <button type="button" class="btn btn-sm btn-primary" onclick="export_to( $(this).closest('form'), 'excel')">Excel</button>
        <button type="button" class="btn btn-sm btn-danger" onclick="export_to( $(this).closest('form'), 'csv')">CSV</button>
        <button type="button" class="btn green btn-sm" onclick="export_to( $(this).closest('form'), 'pdf')">PDF</button>
        <a class="btn default btn-sm" href="{{ $mod->url }}">Back</a>
      </div>
    </div>
  </div>
</div>