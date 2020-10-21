<div class="form-group">
    <label class="control-label col-md-3">{{ $key->key_label }}</label>
    <div class="col-md-5">
    	@if(!$record['disabled'])
    	<div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;<?=lang('mrf.yes')?>&nbsp;" data-off-label="&nbsp;<?=lang('mrf.no')?>&nbsp;">
	    	<input type="checkbox" value="1" <?php if( isset($key->key_value) ) {if( $key->key_value ) echo 'checked="checked"';}?> class="dontserializeme toggle"/>
	    	<input type="hidden" name="key[{{$key->key_id}}]" value="@if( isset($key->key_value) ){{$key->key_value}}@endif"/>
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