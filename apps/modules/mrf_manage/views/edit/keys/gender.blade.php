<div class="form-group">
	<label class="control-label col-md-3">{{ $key->key_label }}</label>
	<div class="col-md-7">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
			<?php
				$option = array(
					'male' => lang('common.male').' Only',
					'female' => lang('common.female').' Only',
					'either' => 'Either '.lang('common.male').' or '.lang('common.female')
				);
				$value = isset( $key->key_value ) ? $key->key_value : 'either';
				echo form_dropdown('key['.$key->key_id.']', $option, $value, 'class="form-control select2me" data-placeholder="Select..." '.$record['disabled']);
			?>
		</div>	
	</div>
</div>