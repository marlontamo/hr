<div class="form-group">
    <label class="control-label col-md-3">{{ $key->key_label }}</label>
    <div class="col-md-7">
    	<input type="text" {{ $record['disabled'] }} value="<?php if(isset($key->key_value)) echo $key->key_value?>" name="key[{{ $key->key_id }}]" class="form-control">
    </div>
</div>