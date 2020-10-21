<tr>
	<td>
		<?php echo $column;?>
		<input type="hidden" name="report_generator_columns[column][]" value="<?php echo $column?>">
	</td>
	<td>
		<input type="text" class="form-control" name="report_generator_columns[alias][]" value="<?php echo $alias?>">
	</td>
	<td>
		<?php echo form_dropdown('report_generator_columns[format_id][]', $formats, $format_id, 'class="form-control select2me" data-placeholder="Select..."'); ?>
	</td>
	<td>
		<a href="javascript: void(0)" onclick="delete_row($(this))">
			<i class="fa fa-trash-o"></i>
			Delete
		</a>
	</td>
</tr>