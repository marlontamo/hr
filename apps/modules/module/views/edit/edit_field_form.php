<form action="<?php echo $field->url?>/save" class="form-horizontal" name="edit-field-form" id="edit-field-form">
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12">
				<input type="hidden" name="mod_id" value="<?php echo $mod_id?>">
	            <input type="hidden" name="f_id" value="<?php echo $f_id?>">
	            <div class="form-body">
	                <h4 class="form-section">Presentation</h4>
	                <div class="form-group">
	                    <label class="control-label col-md-3">Field Group</label>
	                    <div class="col-md-8">
	                        <div class="input-group">
	                            <?php echo form_dropdown('fg_id',$fg_options,$fg_id, 'class="form-control select2me" data-placeholder="Select..."');?>
	                        </div>
	                        <!-- /input-group -->
	                        <small class="help-block">
	                            Select field group. 
	                        </small>
	                    </div>
	                </div>
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

	                <h4 class="form-section">Field Configuration</h4>
	                <div class="form-group">
	                    <label class="control-label col-md-3">Table</label>
	                    <div class="col-md-8">
	                        <input type="text" class="form-control" name="table" id="table" placeholder="table" value="<?php echo $table?>">
	                        <small class="help-block">
	                        Enter Field Table. 
	                        </small>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="control-label col-md-3">Column</label>
	                    <div class="col-md-8">
	                        <input type="text" class="form-control" name="column" id="column" placeholder="column" value="<?php echo $column?>">
	                        <small class="help-block">
	                        Enter Field Column. 
	                        </small>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="control-label col-md-3">UI Type</label>
	                    <div class="col-md-8">
	                        <div class="input-group">
	                            <?php echo form_dropdown('uitype_id',$uitype_options,$uitype_id, 'class="form-control select2me" data-placeholder="Select..."');?>
	                        </div>
	                        <!-- /input-group -->
	                        <small class="help-block">
	                            Select field uitype. 
	                        </small>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="control-label col-md-3">Data Type</label>
	                    <div class="col-md-8">
	                        <input type="text" class="form-control" name="datatype" id="datatype" placeholder="Label" value="<?php echo $datatype?>">
	                        <small class="help-block">
	                        Enter Data type for field validations. 
	                        </small>
	                    </div>
	                </div>
	                <div class="form-group">
                        <label class="control-label col-md-3">Quick Edit</label>
                        <div class="col-md-7">
                            <div class="make-switch switch-small" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                <input type="checkbox" value="1" <?php if($quick_edit) echo 'checked="checked"' ?> name="quick_edit-temp" id="quick_edit-temp" class="dontserializeme toggle"/>
                                <input type="hidden" value="<?php echo $quick_edit?>" name="quick_edit" id="quick_edit"/>
                            </div>
                            <small class="help-block">Select wether to include in quick_edit or not</small>
                        </div>
                    </div>
	                <div class="form-group">
                        <label class="control-label col-md-3">Encrypt</label>
                        <div class="col-md-7">
                            <div class="make-switch switch-small" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                <input type="checkbox" value="1" <?php if($encrypt) echo 'checked="checked"' ?> name="encrypt-temp" id="encrypt-temp" class="dontserializeme toggle"/>
                                <input type="hidden" value="<?php echo $encrypt?>" name="encrypt" id="encrypt"/>
                            </div>
                            <small class="help-block">Select wether to encrypt or not</small>
                        </div>
                    </div>
	            </div>

	            <div class="form-body field-uitype-4 <?php echo $uitype_id == 4 || $uitype_id == 10 ? '' : 'hidden'?>">
	                <h4 class="form-section">Dropdown Options</h4>
	                <div class="form-group">
	                    <label class="control-label col-md-3">Type</label>
	                    <div class="col-md-8">
	                        <div class="input-group">
	                            <?php echo form_dropdown('searchable_type_id',$s_type_options,$searchable_type_id, 'class="form-control select2me" data-placeholder="Select..."');?>
	                        </div>
	                        <!-- /input-group -->
	                        <small class="help-block">
	                            Select searchable field type. 
	                        </small>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="control-label col-md-3">Table, Query, OR Function</label>
	                    <div class="col-md-8">
	                        <textarea class="form-control" name="searchable_table" placeholder="searchable_table"><?php echo $searchable_table?></textarea>
	                        <small class="help-block">Enter table or query.</small>
	                    </div>
	                </div>

	                <div class="form-group">
                        <label class="control-label col-md-3">Multiple</label>
                        <div class="col-md-7">
                            <div class="make-switch switch-small" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                <input type="checkbox" value="1" <?php if($multiple) echo 'checked="checked"' ?> name="multiple-temp" id="multiple-temp" class="dontserializeme toggle"/>
                                <input type="hidden" value="<?php echo $multiple?>" name="multiple" id="multiple"/>
                            </div>
                            <small class="help-block">Select wether multiple select or not</small>
                        </div>
                    </div>

                    <div class="form-group">
	                    <label class="control-label col-md-3">Group By</label>
	                    <div class="col-md-8">
	                        <input type="text" class="form-control" name="group_by" id="group_by" placeholder="group_by" value="<?php echo $group_by?>">
	                        <small class="help-block">Enter how to group the dropdown. </small>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="control-label col-md-3">Column To Use As Label</label>
	                    <div class="col-md-8">
	                        <input type="text" class="form-control" name="searchable_label" id="searchable_label" placeholder="searchable_label" value="<?php echo $searchable_label?>">
	                        <small class="help-block">Enter column to use as label.</small>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="control-label col-md-3">Value</label>
	                    <div class="col-md-8">
	                        <textarea class="form-control" name="value" placeholder="value"><?php echo $value?></textarea>
	                        <small class="help-block">Enter value column.</small>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="control-label col-md-3">Textual Value Column (if any)</label>
	                    <div class="col-md-8">
	                        <textarea class="form-control" name="textual_value_column" placeholder="textual_value_column"><?php echo $textual_value_column?></textarea>
	                        <small class="help-block">Enter textual value column.</small>
	                    </div>
	                </div>
	            </div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn default" data-dismiss="modal">Close</button>
		<button type="button" class="btn blue" onclick="save_mod_field( $(this).parents('form') )">Save</button>
	</div>
</form>

<script>
	$(document).ready(function(){
		$('#quick_edit-temp').change(function(){
			if( $(this).is(':checked') )
				$('#quick_edit').val('1');
			else
				$('#quick_edit').val('0');
		});

		$('#encrypt-temp').change(function(){
			if( $(this).is(':checked') )
				$('#encrypt').val('1');
			else
				$('#encrypt').val('0');
		});

		$('#active-temp').change(function(){
			if( $(this).is(':checked') )
				$('#active').val('1');
			else
				$('#active').val('0');
		});

		$('#multiple-temp').change(function(){
			if( $(this).is(':checked') )
				$('#multiple').val('1');
			else
				$('#multiple').val('0');
		});

		$('select[name="uitype_id"]').change(function(){
			$('div.field-uitype-4').removeClass('hidden');
			if( $(this).val() == 4 ||  $(this).val() == 10)
			{
				$('div.field-uitype-4').show();
			}
			else{
				$('div.field-uitype-4').hide();
			}
		});
	});
</script>