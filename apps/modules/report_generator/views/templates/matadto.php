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
?>
<table>
	<tr>
		<td colspan="7">MEAL &amp; TRANSPORT ALLOWANCE DUE TO OVERTIME</td>
	</tr>
	<tr>
		<td colspan="7"></td>
	</tr>
	<tr>
		<td colspan="7">To: Accounting</td>
	</tr>
	<tr>
		<td colspan="7">KINDLY PROVIDE THE MEAL &amp; TRANSPORT ALLOWANCE DUE TO OVERTIME FOR THE PERIOD OF <?php echo date('d-M', strtotime($date_from))?> TO <?php echo date('d-M', strtotime($date_to))?> AS FOLLOWS:</td>
	</tr>
	<tr>
		<td><h4>NO.</h4></td>
		<td><h4>Employee Name</h4></td>
		<td><h4>No. of Days</h4></td>
		<td><h4>Overtime Meal Allw.</h4></td>
		<td><h4>Overtime Transport Allw.</h4></td>
		<td><h4>Total</h4></td>
		<td><h4>Remarks</h4></td>
	</tr>
	<?php
	$result = $result->result();
	$line = array();
	$employee = array();
	foreach( $result as $row )
	{
		$line[$row->user_id][$row->date] = $row;
		$employee[$row->user_id]['full_name'] = $row->full_name;
		$employee[$row->user_id]['days'] = 0;
		$employee[$row->user_id]['meal'] = 0;
		$employee[$row->user_id]['transpo'] = 0;
	}

	$ctr = 1;
	$total = 0;
	$totalm = 0;
	$totalt = 0;
	$total_days = 0;
	foreach($line as $user_id => $dates):?>
		<tr>
			<td><?php echo $ctr;?></td>
			<td><?php echo $employee[$user_id]['full_name'];?></td><?php
			$start = $date_from;
			$remarks_date = array();
			while( $start <= $date_to ){
				if( isset( $line[$user_id][$start] ) )
				{
					$remarks_date[] = date('M d', strtotime($start));
					$cell = $line[$user_id][$start];
					if( !empty($cell->meal) || !empty($cell->transpo) )
					{
						if( !empty($cell->meal) )
						{
							$employee[$user_id]['meal'] += $cell->meal;
							$total += $cell->meal;
							$totalm += $cell->meal;
						}

						if( !empty($cell->transpo) )
						{
							$employee[$user_id]['transpo'] += $cell->transpo;
							$total += $cell->transpo;
							$totalt += $cell->transpo;
						}
						$employee[$user_id]['days']++;
					}					
				}		
				$start = date('Y-m-d', strtotime('+1day', strtotime($start)));
			} ?>
			<td><?php echo $employee[$user_id]['days']?></td>
			<td><?php echo $employee[$user_id]['meal']?></td>
			<td><?php echo $employee[$user_id]['transpo']?></td>
			<td><?php echo ($employee[$user_id]['meal']+$employee[$user_id]['transpo'])?></td>
			<td>
				Running bonus on <?php
				$dates = array();
				echo implode(' ,', $remarks_date);
				?>
			</td>
		</tr> <?php
		$ctr++;
	endforeach; ?>
	<tr>
		<td></td>
		<td style="text-align: right;">TOTAL</td>
		<td></td>
		<td style="text-align: right;"><?php echo $totalm?></td>
		<td style="text-align: right;"><?php echo $totalt?></td>
		<td style="text-align: right;"><?php echo $total?></td>
		<td></td>
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