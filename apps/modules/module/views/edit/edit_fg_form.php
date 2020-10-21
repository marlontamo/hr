<form action="<?php echo $fg->url?>/save" class="form-horizontal" name="edit-fg-form" id="edit-fg-form">
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12">
				<input type="hidden" name="mod_id" value="<?php echo $mod_id?>">
	            <input type="hidden" name="fg_id" value="<?php echo $fg_id?>">
	            <div class="form-body">
	                <h4 class="form-section">Basic Information</h4>
	                <div class="form-group">
	                    <label class="control-label col-md-3">Label</label>
	                    <div class="col-md-8">
	                        <input type="text" class="form-control" name="label" id="label" placeholder="Label" value="<?php echo $label?>">
	                        <small class="help-block">
	                        Enter Field Group Label. 
	                        </small>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="control-label col-md-3">Description</label>
	                    <div class="col-md-8">
	                        <textarea class="form-control" name="description" placeholder="Description"><?php echo $description?></textarea>
	                        <small class="help-block">
	                        Enter Description. 
	                        </small>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="control-label col-md-3">Display</label>
	                    <div class="col-md-8">
	                        <div class="input-group">
	                            <?php
	                            	$options = array(
	                            		3 => 'Both',
	                            		1 => 'Detail Only',
	                            		2 => 'Edit Only',
	                            		4 => 'None'
	                            	);
	                            	echo form_dropdown('display_id',$options,$display_id, 'class="form-control select2me" data-placeholder="Select..."');
	                            ?>
	                        </div>
	                        <!-- /input-group -->
	                        <small class="help-block">
	                            Select where to display. 
	                        </small>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="control-label col-md-3">Sequence</label>
	                    <div class="col-md-8">
	                        <input type="number" class="form-control" step="1" min="0" name="sequence" id="sequence" placeholder="1" value="<?php echo $sequence?>" />
	                        <small class="help-block">
	                        Enter sequence. 
	                        </small>
	                    </div>
	                </div>

	                <div class="form-group">
                        <label class="control-label col-md-3">Status</label>
                        <div class="col-md-7">
                            <div class="make-switch switch-small" data-on-label="&nbsp;Enable&nbsp;" data-off-label="&nbsp;Disable&nbsp;">
                                <input type="checkbox" value="1" <?php if($active) echo 'checked="checked"' ?> name="active-temp" id="active-temp" class="dontserializeme toggle"/>
                                <input type="hidden" value="<?php echo $active?>" name="active" id="active"/>
                            </div>
                            <small class="help-block">Select wether to enable or disable</small>
                        </div>
                    </div>
	            </div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn default" data-dismiss="modal">Close</button>
		<button type="button" class="btn blue" onclick="save_mod_fg( $(this).parents('form') )">Save</button>
	</div>
</form>

<script>
	$(document).ready(function(){
		$('#active-temp').change(function(){
			if( $(this).is(':checked') )
				$('#active').val('1');
			else
				$('#active').val('0');
		});
	});
</script>