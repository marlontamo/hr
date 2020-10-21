<div class="form-group">
	<label class="control-label col-md-3">
		<span class="required"></span><?php echo $record->category ?>
	</label>
	<div class="col-md-7">
        <div class="input-group">
			<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
            <select name="roles[category][<?php echo $record->primary_key ?>][]" class="select2me form-control" id="<?php echo $record->primary_key ?>" multiple>
            <?php
				$db->select("{$record->field_label} as label, {$record->primary_key} as value");
				$result = $db->get_where($record->table_name,array('deleted' => 0));   
                if ($result && $result->num_rows() > 0){
                	foreach ($result->result() as $row) {
						print '<option value="'. $row->value .'">'.$row->label.'</option>';
                	}
                }
            ?>
            </select>
			<span class="input-group-btn">
				<button type="button" class="btn btn-default" onclick="remove_category('<?php echo $record->primary_key ?>',<?php echo $record->category_id ?>,'<?php echo $record->category ?>')"><i class="fa fa-minus"></i></button>
			</span>                     
        </div>
    </div>	
</div>