<div class="form-group">
	<?php
    	if($key->key_label == 'Course'):
			$label = lang('mrf_admin.course');
		else : 
			$label = lang('mrf_admin.years_exp');
		endif;
    ?>
    <label class="control-label col-md-3">{{ $label }}</label>
    <div class="col-md-7">
    	<input type="text" {{ $record['disabled'] }} value="<?php if(isset($key->key_value)) echo $key->key_value?>" name="key[{{ $key->key_id }}]" class="form-control">
    </div>
</div>