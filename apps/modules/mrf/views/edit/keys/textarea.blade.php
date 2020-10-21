<div class="form-group">
    <label class="control-label col-md-3">{{ $key->key_label }}</label>
    <div class="col-md-5">
        <textarea {{ $record['disabled'] }} class="form-control" rows="4" name="key[{{ $key->key_id }}]"><?php if(isset($key->key_value)) echo $key->key_value?></textarea>
    	<div class="help-block small">
    	{{ $key->help_block }}
    	</div>
    </div>
</div>