<div class="form-group">
    <label class="control-label col-md-3"><?php echo $key->key_label?></label>
    <div class="col-md-7">
        <div class="input-group">
            <span class="input-group-addon">
	        	<i class="fa fa-user"></i>
	        </span>
            <?php
            	$status = array();
            	$statuses = $this->db->get_where('partners_civil_status', array('deleted' => 0));
            	foreach( $statuses->result() as $row )
            	{
            		$status[$row->civil_status_id] = $row->civil_status;
            	}
            	echo form_dropdown('key['.$key->key_class_id.']['.$key->key_id.']',$status, $value, 'class="form-control select2me" data-placeholder="Select..."');
            ?>
        </div>
    </div>
</div>