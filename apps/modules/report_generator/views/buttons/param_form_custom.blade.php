<div class="form-actions fluid">
    <div class="col-md-12 text-center">
      <!-- div class="col-md-offset-3 col-md-9" -->
        @if($button['xls'] == 0)
        <button type="button" class="btn btn-sm btn-primary" onclick="ajax_export_custom( $(this).closest('form'), 'excel')">Excel</button>
        @endif
        @if($button['csv'] == 0)
        <button type="button" class="btn btn-sm btn-danger" onclick="ajax_export_custom( $(this).closest('form'), 'csv')">CSV</button>
        @endif
        @if($button['pdf'] == 0)
        <button type="button" class="btn green btn-sm" onclick="ajax_export_custom( $(this).closest('form'), 'pdf')">PDF</button>
        @endif
        @if($button['txt'] == 0)
        <button type="button" class="btn green btn-sm" onclick="ajax_export_custom( $(this).closest('form'), 'txt')">TXT</button>
        @endif
        <a class="btn default btn-sm" data-dismiss="modal">Close</a>
      <!-- /div -->
    </div>
</div>
