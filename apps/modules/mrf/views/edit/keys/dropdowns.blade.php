<div class="form-group">
	<label class="control-label col-md-3">{{ $key->key_label }}</label>
	<div class="col-md-5">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
			<?php
				$table_details = $db->get_where($key->key_table, array('deleted' => 0));
				$option = array();
				foreach( $table_details->result_array() as $tbl )
				{
					$option[ $tbl[$key->key_field_id] ] = $tbl[$key->key_field];
				}
				$value = isset( $key->key_value ) ? $key->key_value : '';

				if($key->key_code == 'sourcing_tools'){
					$value = ($value != '') ? unserialize($value) : $value;
					
					echo form_dropdown('key['.$key->key_id.'][]', $option, $value, 'class="form-control select2me" multiple data-placeholder="Select..." '.$record['disabled']);
				}else{
					echo form_dropdown('key['.$key->key_id.']', $option, $value, 'class="form-control select2me"  data-placeholder="Select..." '.$record['disabled']);
				}
			?>
		</div>	
	</div>
</div>