<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>
<?php
	//prep data
	$company = "Company";
	$full_name = "Full Name";
	$id_number = "ID Number";
	$date = "Date";
	$shift = "Shift";
	$time_from = "Time From";
	$time_to = "Time To";
	$actual = "Actual";
	$meal = "Meal";
	$transpo = "Transpo";

	$result = $result->result();
	foreach( $result as $row )
	{
		$com[$row->$company][$row->$id_number][] = $row; 
	}

?>
<table cellspacing="0" cellpadding="1" border="1">
	<tr>
		<td style="font-weight:bold; text-align:center">Name</td>
		<td style="font-weight:bold; text-align:center">ID Number</td>
		<td style="font-weight:bold; text-align:center">Date</td>
		<td style="font-weight:bold; text-align:center">Time In</td>
		<td style="font-weight:bold; text-align:center">Time Out</td>
		<td style="font-weight:bold; text-align:center">Actual</td>
		<td style="font-weight:bold; text-align:center">Meal</td>
		<td style="font-weight:bold; text-align:center">Transpo</td>
	</tr> <?php
	
	foreach( $com as $comp => $emp ): ?>
		<tr>
			<td colspan="7" style="font-weight:bold"><?php echo $comp?></td>
		</tr> <?php
		foreach( $emp as $idno => $rows ):
			$start = true;
			$actuals = 0;
			$meals = 0;
			$transpos = 0;
			foreach( $rows as $row ): 
				$actuals += $row->$actual;
				$meals += $row->$meal;
				$transpos += $row->$transpo; ?>
				<tr>
					<td><?php if( $start ) echo $row->$full_name?></td>
					<td><?php if( $start ) echo $row->$id_number?></td>
					<td style="text-align:center"><?php echo $row->$date?></td>
					<td style="text-align:center"><?php echo $row->$time_from?></td>
					<td style="text-align:center"><?php echo $row->$time_to?></td>
					<td style="text-align:right"><?php echo $row->$actual?></td>
					<td style="text-align:right"><?php echo $row->$meal?></td>
					<td style="text-align:right"><?php echo $row->$transpo?></td>
				</tr> <?php
				$start = false;
			endforeach; ?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td style="text-align:right; color:red"><?php if(floatval($actuals) != 0) echo $actuals; else echo '-';?></td> 
				<td style="text-align:right; color:red"><?php if(floatval($meals) != 0) echo $meals; else echo '-';?></td> 
				<td style="text-align:right; color:red"><?php if(floatval($transpos) != 0) echo $transpos; else echo '-';?></td> 
			</tr>
			<?php
		endforeach;
	endforeach; ?>
</table>
<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>