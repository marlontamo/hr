<tr id="sort-<?php echo $column;?>">
	<td>
		<?php echo $column;?>
		<input type="hidden" name="report_generator_sorting[column][]" value="<?php echo $column?>">
	</td>
	<td>
		<?php echo form_dropdown('report_generator_sorting[sorting][]', array("ASC" => "Ascending", "DESC" => "Descending"), $sorting, 'class="form-control select2me" data-placeholder="Select..."'); ?>
	</td>
	<td>
		<a href="javascript: void(0)" onclick="delete_row($(this))">
			<i class="fa fa-trash-o"></i>
			Delete
		</a>
	</td>
</td>