<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div>
        @if( isset($permission['edit']) && $permission['edit'] )
        	<!-- <a type="button" class="btn green btn-sm" href="{{ $mod->url . '/edit/' . $record_id }}"><i class="fa fa-check"></i> Edit</a> -->
        @endif
        @if( isset($permission['add']) && $permission['add'] )
        	<!-- <a type="button" class="btn blue btn-sm" href="{{ $mod->url . '/add' }}"> Add New</a> -->
        @endif
        <a class="btn btn-default btn-sm" href="{{ $mod->url }}">{{ lang('common.back_to_list') }}</a>
      </div>
    </div>
  </div>
</div>