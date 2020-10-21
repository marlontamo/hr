<tr id="filter-<?php echo $column;?>">
	<td>
		<?php echo $column;?>
		<input type="hidden" name="report_generator_filters[column][]" value="<?php echo $column?>">
		<input type="hidden" name="report_generator_filters[type][]" value="<?php echo $type?>">
		<input type="hidden" name="report_generator_filters[table][]" value="<?php echo $table?>">
		<input type="hidden" name="report_generator_filters[value_column][]" value="<?php echo $value_column?>">
		<input type="hidden" name="report_generator_filters[label_column][]" value="<?php echo $label_column?>">
		<input type="hidden" name="report_generator_filters[uitype_id][]" value="<?php echo $uitype_id?>">
		<input type="hidden" name="report_generator_filters[required][]" value="<?php echo $required?>">
	</td>
	<td>
		<?php echo form_dropdown('report_generator_filters[operator][]', $operators, $operator, 'class="form-control select2me" data-placeholder="Select..."'); ?>
	</td>
	<td>
		<?php
			switch( $uitype_id )
			{
				case 1; //dropdown
					$this->db->where('deleted', 0);
					$this->db->order_by($label_column, 'ASC');
					$this->db->select($label_column.','.$value_column);
					$rows = $this->db->get( $table )->result();
					foreach( $rows as $row )
					{
						$options[$row->$value_column] = $row->$label_column;
					}
					echo form_dropdown('report_generator_filters[filter][]', $options, $filter, 'class="form-control select2me" data-placeholder="Select..."');
					break;
				case 2; //boolean
					$booleans = array(
						"1" => "YES",
						"0" => "NO"
					);
					echo form_dropdown('report_generator_filters[filter][]', $booleans, $filter, 'class="form-control select2me" data-placeholder="Select..."');
					break;
				case 3; //date ?>
					<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
						<input type="text" class="form-control" name="report_generator_filters[filter][]" value="<?php echo $filter?>" readonly>
						<span class="input-group-btn">
							<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
						</span>
					</div> <?php
					break;
				case 4; //date and time ?>
					<div class="input-group date form_datetime">                                       
						<input type="text" size="16" readonly class="form-control dtp" name="report_generator_filters[filter][]" value="<?php echo $filter?>" />
						<span class="input-group-btn">
							<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
						</span>
						<span class="input-group-btn">
							<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
						</span>
					</div> <?php
					break;
				case 5; //time ?>
					<div class="input-group bootstrap-timepicker">                                       
						<input type="text" class="form-control timepicker-default" name="report_generator_filters[filter][]" value="<?php echo $filter?>"/>
						<span class="input-group-btn">
							<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
						</span>
					</div> <?php
					break;
				case 9; //multi-select dropdown
					$this->db->where('deleted', 0);
					$this->db->order_by($label_column, 'ASC');
					$this->db->select($label_column.','.$value_column);
					$rows = $this->db->get( $table )->result();
					foreach( $rows as $row )
					{
						$options[$row->$value_column] = $row->$label_column;
					}
					echo form_dropdown('report_generator_filters[filter][]', $options, $filter, 'class="form-control multiple_dropdown" width="30px" multiple="multiple" data-placeholder="Select..."');
					break;
				default:?>
					<input type="text" class="form-control" name="report_generator_filters[filter][]" value="<?php echo $filter?>">
				<?php
			}
		?>
	</td>
	<td>
		<?php 
		$logical_operators = array(
			"" => "None",
			"AND" => "AND",
			"OR" => "OR"
		);
		echo form_dropdown('report_generator_filters[logical_operator][]', $logical_operators, $logical_operator, 'class="form-control select2me" data-placeholder="Select..."'); ?>
	</td>
	<td>
		<input type="text" class="form-control" name="report_generator_filters[bracket][]" value="<?php echo $bracket?>">
	</td>
	<td>
		<?php echo ($required == 1 ? 'Yes' : 'No') ?>
	</td>	
	<td>
		<input type="text" class="form-control" name="report_generator_filters[order_by][]" value="<?php echo $order_by?>">
	</td>		
	<td>
		<input type="text" class="form-control" name="report_generator_filters[filtering_only][]" value="<?php echo $filtering_only?>">
	</td>	
	<td>
		<a href="javascript: void(0)" onclick="delete_row($(this))">
			<i class="fa fa-trash-o"></i>
			Delete
		</a>
	</td>
</td>