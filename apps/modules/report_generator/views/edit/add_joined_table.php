<tr id="<?php echo $alias?>">
	<td>
		<?php 
			$joins = array(
				"LEFT JOIN" => "Left Join",
				"INNER JOIN" => "Inner Join",
				"RIGHT JOIN" => "Right Join"
			);
			echo form_dropdown('report_generator_table[join_type][]', $joins, $join_type, 'class="form-control select2me" data-placeholder="Select..."'); ?>
	</td>
	<td>
		<input type="hidden" name="report_generator_table[table][]" value="<?php echo $table?>">
		<input type="hidden" name="report_generator_table[primary][]" value="0"> 
		<input type="hidden" name="report_generator_table[alias][]" value="<?php echo $alias?>"> 
		<?php echo $table?>
		<br/>
		<span class="text-muted"><?php echo $alias?></span>
	</td>
	<td>ON</td>
	<td>
		<?php echo form_dropdown('report_generator_table[join_from_column][]', $join_from_columns, $join_from_column, 'class="form-control select2me" data-placeholder="Select..."'); ?>
	</td>
	<td>
		<?php 
			$on_operators = array(
				"=" => "=",
				"!=" => "!=",
				"<" => "<",
				"<=" => "<=",
				">" => ">",
				">=" => ">=",
			);
			echo form_dropdown('report_generator_table[on_operator][]', $on_operators, $on_operator, 'class="form-control select2me" data-placeholder="Select..."'); ?>
	</td>
	<td class="join_to_column">
		<?php echo form_dropdown('report_generator_table[join_to_column][]', $join_to_columns, $join_to_column, 'class="form-control select2me" data-placeholder="Select..."'); ?>
	</td>
	<td>
		<a href="javascript: delete_table('<?php echo $alias?>')">
			<i class="fa fa-trash-o"></i>
			Delete
		</a>
	</td>
</td>