<div class="form-group">
    <label class="control-label col-md-3"><?php echo $key->key_label?></label>
    <div class="col-md-7">
		<textarea class="form-control" name="key[<?php echo $key->key_class_id?>][<?php echo $key->key_id?>]" placeholder="<?=lang('my_change_request.enter')?> <?php echo $key->key_label?>" rows="4"><?php echo $value?></textarea>    
    </div>
</div>