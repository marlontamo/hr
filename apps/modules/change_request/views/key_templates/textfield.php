<div class="form-group">
    <label class="control-label col-md-3"><?php echo $key->key_label?></label>
    <div class="col-md-7">
    	<input type="text" class="form-control" name="key[<?php echo $key->key_class_id?>][<?php echo $key->key_id?>]" placeholder="Enter <?php echo $key->key_label?>" value="<?php echo $value?>">
    </div>
</div>