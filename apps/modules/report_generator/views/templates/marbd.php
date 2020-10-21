<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}

	$from_to = array();
	foreach($_POST['filter'] as $var => $val )
	{
		$date = date_parse($val);
		if ($date["error_count"] == 0 && checkdate($date["month"], $date["day"], $date["year"]))
			$from_to[] = date('Y-m-d', strtotime($val));		
	}

	if( sizeof($from_to) > 0 )
	{
		sort($from_to);	
	}
	$date_from = $from_to[0];
	$date_to = $from_to[1];
	$first = $result->row();
?>
<table>
	<tr>
		<td colspan="6">MEAL ALLOWANCE RECAP BY DEPARTMENT</td>
	</tr>
	<tr>
		<td>Period</td>
		<td><?php echo date('M d', strtotime($date_from)) ?> to <?php echo date('M d', strtotime($date_to)) ?></td>
		<td colspan="4"></td>
	</tr>
	<tr>
		<td>Company</td>
		<td><?php echo $first->company?></td>
		<td colspan="4"></td>
	</tr>
	<tr>
		<td>Payment On</td>
		<td>:</td>
		<td colspan="4"></td>
	</tr>
	<tr>
		<td colspan="6"></td>
	</tr>
	<tr>
		<td><h4>NO.</h4></td>
		<td><h4>Employee Name</h4></td>
		<td><h4>Department</h4></td>
		<td><h4>No. of Days</h4></td>
		<td><h4>Amount</h4></td>
		<td><h4>Total</h4></td>
		</tr>
	<?php
	$result = $result->result();
	$line = array();
	$employee = array();
	$dept = array();
	foreach( $result as $row )
	{
		$line[$row->department_id][$row->user_id][] = $row;
		$employee[$row->user_id]['full_name'] = $row->full_name;
		$employee[$row->user_id]['days'] = 0;
		$employee[$row->user_id]['amount'] = 0;
		$dept[$row->department_id]['dept'] = $row->department;
		$dept[$row->department_id]['total'] = 0;
		$dept[$row->department_id]['size'] = 0;
	}

	$ctr = 1;
	$total = 0;
	$total_days = 0;
	foreach($line as $department_id => $emp):
		foreach($emp as $user_id => $rows)
		{
			foreach( $rows as $row )
			{
				$dept[$department_id]['total'] += $row->meal;
				$dept[$department_id]['size']++;
				$employee[$user_id]['days']++;
				$employee[$user_id]['amount'] += $row->meal;
			}
		}

		$empno = 1;
		foreach($emp as $user_id => $row)
		{ ?>
			<tr>
				<td><?php echo $ctr?></td>
				<td><?php echo $employee[$user_id]['full_name']?></td> <?php
				if( $empno == 1 ) echo '<td rowspan="'.$dept[$department_id]['size'].'">'.$dept[$department_id]['dept'].'</td>'; ?>
				<td><?php echo $employee[$user_id]['days']?></td>
				<td><?php echo $employee[$user_id]['amount']?></td> <?php
				if( $empno == 1 ) echo '<td rowspan="'.$dept[$department_id]['size'].'">'.$dept[$department_id]['total'].'</td>'; ?>
			</tr> <?php
			$ctr++;
			$empno++;
			$total_days += $employee[$user_id]['days'];
			$total += $employee[$user_id]['amount'];
		}
	endforeach; ?>
	<tr>
		<td></td>
		<td></td>
		<td style="text-align: right;">TOTAL</td>
		<td style="text-align: right;"><?php echo $total_days?></td>
		<td></td>
		<td style="text-align: right;"><?php echo $total?></td>
	</tr>
</table>
<table>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td>Prepared date : <?php echo date('d M Y')?></td></tr>
	<tr>
		<td>Prepared by,</td>
		<td></td>
		<td>Acknowledged by,</td>
	</tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr>
		<td>Nur Afridela Z.</td>
		<td></td>
		<td>Anggraeny C. (Agy)</td>
	</tr>
	<tr>
		<td>HR STAFF</td>
		<td></td>
		<td>HR MANAGER</td>
	</tr>
</table>

<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>