<div class="form-group">
	<label class="control-label col-md-3">{{ lang('mrf.nature_req') }}</label>
	<div class="col-md-5">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
			<?php
				$natures = $db->get_where('recruitment_request_nature', array('deleted' => 0));
				$option = array();
				foreach( $natures->result() as $nature )
				{
					$option[$nature->nature_id] = $nature->nature;
				}
				$value = isset( $key->key_value ) ? $key->key_value : '';
				echo form_dropdown('key['.$key->key_id.']', $option, $value, 'class="form-control select2me" data-placeholder="Select..." '.$record['disabled']);
			?>
		</div>	
	</div>
</div>