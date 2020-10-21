<div class="form-group">
    <label class="control-label col-md-3"><?php echo $key->key_label?></label>
    <div class="col-md-7">
        <div class="input-group">
            <span class="input-group-addon">
	        	<i class="fa fa-user"></i>
	        </span>
            <?php
            	$options = array(
                    'male' => lang('common.male'),
                    'female' => lang('common.female')
                );
                echo form_dropdown('key['.$key->key_class_id.']['.$key->key_id.']',$options, $value, 'class="form-control select2me select2mecity" data-placeholder="Select..."');
            ?>
        </div>
    </div>
</div>
<script>
	init_city();
</script>