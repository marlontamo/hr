<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>
<table cellspacing="0" cellpadding="1" border="1">
	<?php
	$result = $result->result();
	?>
	<tr><td></tr></tr>
	<tr>	
		<th colspan="7">Employee Training Database Report</th>
	</tr>
	<tr><td></tr></tr>
	<tr>
		<td>Employee</td>
		<td>Position</td>
		<td>Department</td>
		<td>Training Balance</td>
		<td>Training Course</td>
		<td>Start Date</td>
		<td>End Date</td>
	</tr>
	<?php
	foreach($result as $result): 
	?>
	<tr>
		<td><?php echo $result->training_employee_database_employee; ?></td>
		<td><?php echo $result->training_employee_database_position; ?></td>
		<td><?php echo $result->training_employee_database_department; ?></td>
		<td><?php echo $result->training_employee_database_training_balance; ?></td>
		<td><?php echo $result->training_employee_database_daily_training_cost; ?></td>
		<td><?php echo $result->training_employee_database_start_date; ?></td>
		<td><?php echo $result->training_employee_database_end_date; ?></td>
	</tr>
<?php endforeach; ?>
</table>
<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>