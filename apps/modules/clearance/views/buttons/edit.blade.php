<form>
<div class="form-actions fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-offset-4 col-md-8">
            @if($record['status_id'] == 3)
        	<button type="button" class="btn green btn-sm" onclick="send_sign( $(this).closest('form'), 4)"><i class="fa fa-check"></i> Cleared</button>
        	@endif
        <!-- <button type="button" class="btn blue btn-sm" onclick="save_record( $(this).closest('form'), 'new')"> Save &amp; Add New</button> -->
        <a class="btn default btn-sm" href="{{ $mod->url }}">Back to list</a>
      </div>
    </div>
  </div>
</div>
</form>