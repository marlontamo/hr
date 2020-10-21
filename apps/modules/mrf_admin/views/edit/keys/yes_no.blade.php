<div class="form-group">
	<?php
    	if($key->key_label == 'If Budgeted'):
			$label = lang('mrf_admin.budgeted');
		elseif($key->key_code == 'require_licensure') : 
			$label = lang('mrf_admin.req_licensure_cert');
		else:
			$label = $key->key_label;
		endif;
    ?>
    <label class="control-label col-md-3">{{ $label }}</label>
    <div class="col-md-5">
    	@if(!$record['disabled'])
    	<div class="make-switch" data-on-label="&nbsp;{{ lang('mrf_admin.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('mrf_admin.no') }}&nbsp;">
	    	<input type="checkbox" value="1" {{ ( isset($key->key_value ) ) ? ( $key->key_value ) ? 'checked="checked"' : '' : ''; }} class="dontserializeme toggle"/>
	    	<input type="hidden" name="key[{{$key->key_id}}]" value="{{ ( isset($key->key_value ) ) ? $key->key_value : '' }} " />
		</div>
		@else
			@if( isset($key->key_value) )
				@if($key->key_value)				
    			<input type="text" {{ $record['disabled'] }} value="Yes" name="key[{{ $key->key_id }}]" class="form-control">
				@else
    			<input type="text" {{ $record['disabled'] }} value="No" name="key[{{ $key->key_id }}]" class="form-control">
				@endif
			@endif
		@endif
    </div>
</div>