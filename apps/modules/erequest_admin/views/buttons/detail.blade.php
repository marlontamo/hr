<div class="form-actions fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-offset-4 col-md-6">
        @if( isset($permission['edit']) && $permission['edit'] )
          @if(in_array($record['request_status_id'], array(1,2,5)))
        	 <a type="button" class="btn green btn-sm" href="{{ $mod->url . '/edit/' . $record_id }}"><i class="fa fa-check"></i> {{ lang('common.edit') }}</a>
          @endif
        @endif
        <a class="btn default btn-sm" href="{{ $mod->url }}">{{ lang('common.back') }}</a>
      </div>
    </div>
  </div>
</div>