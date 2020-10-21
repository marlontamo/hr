<div class="form-group">
    <label class="control-label col-md-3">{{ $key->key_label }}</label>
    <div class="col-md-5">
        <?php
            $db->select($key->key_field_id.','.$key->key_field);
            $db->order_by($key->key_field, '0');
            $db->where('deleted', '0');
            $options = $db->get($key->key_table);
            $recruitment_request_assignment_id_options = array('' => 'Select...');
            foreach($options->result() as $option)
            {
                $recruitment_request_assignment_id_options[$option->assignment_id] = $option->assignment;
            } 
            $value = isset( $key->key_value ) ? $key->key_value : '';
        ?>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-list-ul"></i>
            </span>
            {{  form_dropdown('key['.$key->key_id.']',$recruitment_request_assignment_id_options, $value, 'class="form-control select2me" data-placeholder="Select..." id="recruitment_request-assignment_id" '.$record['disabled']) }}
        </div>
    </div>  
</div>