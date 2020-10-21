<div class="form-group">
    <label class="control-label col-md-3"><?php echo $key->key_label?></label>
    <div class="col-md-7">
        <div class="input-group" id="countryTags">
            <span class="input-group-addon">
                <i class="fa fa-map-marker"></i>
            </span>
            <input type="text" class="form-control tags" name="key[<?php echo $key->key_class_id ?>][<?php echo $key->key_id ?>]" id="country-tags" value="<?php echo $value ?>"/>
        </div>
    </div>
</div>
<script>
	init_country();
</script>