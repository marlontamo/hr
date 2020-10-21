<div class="form-actions fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-offset-4 col-md-8">
            	@if($sign['status_id'] != 4)
       				<button type="button" class="btn green btn-sm" onclick="save_record( $(this).closest('form'), 3)"><i class="fa fa-check"></i> {{ lang('common.submit') }}</button>
        		@endif
        <!-- <button type="button" class="btn blue btn-sm" onclick="save_record( $(this).closest('form'), 'new')"> Save &amp; Add New</button> -->
        <a class="btn default btn-sm" href="{{ $mod->url }}">Back to List</a>
      </div>
    </div>
  </div>
</div>