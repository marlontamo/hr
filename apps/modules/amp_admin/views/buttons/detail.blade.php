<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div class="col-md-offset-3 col-md-5">
        @if( isset($permission['edit']) && $permission['edit'] )
        	<a type="button" class="btn green btn-sm" href="{{ $mod->url . '/edit/' . $record_id }}"><i class="fa fa-check"></i> {{ lang('common.edit') }}</a>
        @endif
        @if( isset($permission['add']) && $permission['add'] )
        	<a type="button" class="btn blue btn-sm" href="{{ $mod->url . '/add' }}"> {{ lang('common.add_new') }}</a>
        @endif
        <a class="btn default btn-sm" href="{{ $mod->url }}">{{ lang('common.back_to_list') }}</a>
      </div>
    </div>
  </div>
</div>