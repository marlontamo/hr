<div class="form-group">
	<label class="control-label col-md-3">{{ lang('mrf_admin.pref_gender') }}</label>
	<div class="col-md-7">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
			<?php
				$option = array(
					'male' => lang('mrf_admin.male_only'),
					'female' => lang('mrf_admin.female_only'),
					'either' => lang('mrf_admin.either')
				);
				$value = isset( $key->key_value ) ? $key->key_value : 'either';
				echo form_dropdown('key['.$key->key_id.']', $option, $value, 'class="form-control select2me" data-placeholder="Select..." '.$record['disabled']);
			?>
		</div>	
	</div>
</div>