<div class="form-actions fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-offset-3 col-md-9">
        <button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), 'after_save')"><i class="fa fa-check"></i> Save</button>
        @if(!$record_id)
        <button type="button" class="btn blue btn-sm addnew" onclick="save_record( $(this).closest('form'), 'new')"> Save &amp; Add New</button>
        @else
        <a class="btn blue btn-sm previewbutton" href="{{ $mod->url }}/preview_template/{{$record_id}}" target="_blank"> Preview</a>
        <!-- <button type="button" class="btn blue btn-sm previewbutton" href="{{base_url()}}" target="_blank"> Preview</button> -->
        @endif
        <a class="btn default btn-sm" href="{{ $mod->url }}">Back</a>
      </div>
    </div>
  </div>
</div>