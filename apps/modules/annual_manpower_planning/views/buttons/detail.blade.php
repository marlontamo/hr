<div class="form-actions fluid">
  <div class="row" align="center">
    <div class="col-md-12">
      <div class="col-md-offset-3 col-md-5">
        @if( $is_approve )
        	<a type="button" class="approve_view btn btn-default btn-sm btn-success" href="javascript:void(0)" data-plan-id="{{ $record_id }}" data-decission="3"> {{ lang('common.approve') }}</a>
        @endif
        @if( $is_disapprove )
          <a type="button" class="disapprove_view btn btn-default btn-sm btn-success" href="javascript:void(0)" data-plan-id="{{ $record_id }}" data-decission="4"> {{ lang('common.disapprove') }}</a>
        @endif        
        <a class="btn default btn-sm" href="{{ $mod->url }}">{{ lang('common.back_to_list') }}</a>
      </div>
    </div>
  </div>
</div>