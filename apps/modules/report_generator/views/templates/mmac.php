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
	$days = no_days_between_dates($date_from, $date_to);
	$days++;

	$first = $result->row();
?>
<table>
	<tr>
		<td colspan="3">MONTHLY MEAL ALLOWANCE CALCULATION</td>
	</tr>
	<tr>
		<td>PERIOD:</td>
		<td></td>
		<td><?php echo date('M d', strtotime($date_from)) ?> to <?php echo date('M d', strtotime($date_to)) ?></td>
	</tr>
	<tr>
		<td>COMPANY</td>
		<td  align="center">:</td>
		<td><?php echo $first->company?></td>
	</tr>
</table>
<table>
	<tr class="thead">
		<td rowspan="2"><h4>NO.</h4></td>
		<td rowspan="2"><h4>Employee Name</h4></td>
		<td colspan="<?php echo $days?>" ><h4>Dates</h4></td>
		<td rowspan="2"><h4>No. of Days</h4></td>
		<td rowspan="2"><h4>Amount<br/>(Rp.)</h4></td>
	</tr>
	<tr><?php
		$start = $date_from;
		while( $start <= $date_to ){
			echo "<td><h4>".date('j', strtotime($start))."</h4></td>";			
			$start = date('Y-m-d', strtotime('+1day', strtotime($start)));
		}
	?>
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
		$employee[$row->user_id]['amount'] = 0;
	}

	$ctr = 1;
	$total = 0;
	$total_days = 0;
	foreach($line as $user_id => $dates):?>
		<tr>
			<td><?php echo $ctr;?></td>
			<td><?php echo $employee[$user_id]['full_name'];?></td><?php
			$start = $date_from;
			while( $start <= $date_to ){
				if( isset( $line[$user_id][$start] ) )
				{
					echo "<td>1</td>";		
					$cell = $line[$user_id][$start];
					$employee[$user_id]['days']++;
					$employee[$user_id]['amount'] += $cell->amount;
					$total += $cell->amount;
					$total_days++;
				}
				else{
					echo "<td></td>";		
				}		
				$start = date('Y-m-d', strtotime('+1day', strtotime($start)));
			} ?>
			<td><?php echo $employee[$user_id]['days']?></td>
			<td><?php echo $employee[$user_id]['amount']?></td>
		</tr> <?php
		$ctr++;
	endforeach;
	?>
	<tr>
		<td></td>
		<td></td>
		<td style="text-align: right;" colspan="<?php echo $days?>">TOTAL</td>
		<td style="text-align: right;" ><?php echo $total_days?></td>
		<td style="text-align: right;" ><?php echo $total?></td>
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