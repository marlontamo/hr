<tr id="T0">
	<td>PRIMARY</td>
	<td>
		<input type="hidden" name="report_generator_table[table][]" value="<?php echo $table?>">
		<input type="hidden" name="report_generator_table[primary][]" value="1"> 
		<input type="hidden" name="report_generator_table[alias][]" value="T0"> 
		<input type="hidden" name="report_generator_table[join_type][]" value=""> 
		<input type="hidden" name="report_generator_table[join_from_column][]" value="">
		<input type="hidden" name="report_generator_table[on_operator][]" value="">
		<input type="hidden" name="report_generator_table[join_to_column][]" value=""> 
		<?php echo $table?><br/>
		<span class="text-muted">T0</span>
	</td>
	<td></td>
	<td>-</td>
	<td>-</td>
	<td>-</td>
	<td>
		<a href="javascript: delete_table('T0')">
			<i class="fa fa-trash-o"></i>
			Delete
		</a>
	</td>
</td>