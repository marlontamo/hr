<div class="form-group">
    <div class="col-md-10">
		@if($record['disabled'])
			<div contentEditable="true">{{ $key->key_value }}
			</div>    
		@else
    	<textarea class=" wysihtml5 form-control" name="key[{{ $key->key_id }}]" placeholder="Enter {{ $key->key_label }}" rows="6"><?php if(isset($key->key_value)) echo $key->key_value; ?></textarea>
		@endif
    </div>
</div>