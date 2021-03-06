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
	$particulars = "Particulars";
	$deduction = "Deduction";
	
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
		<td style="font-weight:bold; text-align:center">Shift</td>
		<td style="font-weight:bold; text-align:center">Time In</td>
		<td style="font-weight:bold; text-align:center">Time Out</td>
		<td style="font-weight:bold; text-align:center">Particulars</td>
		<td style="font-weight:bold; text-align:center">Deduction</td>
	</tr> <?php
	
	foreach( $com as $comp => $emp ): ?>
		<tr>
			<td colspan="7" style="font-weight:bold"><?php echo $comp?></td>
		</tr> <?php
		foreach( $emp as $idno => $rows ):
			$start = true;
			foreach( $rows as $row ): ?>
				<tr>
					<td><?php if( $start ) echo $row->$full_name?></td>
					<td><?php if( $start ) echo $row->$id_number?></td>
					<td style="text-align:center"><?php echo $row->$date?></td>
					<td style="text-align:center"><?php echo $row->$shift?></td>
					<td style="text-align:center"><?php echo $row->$time_from?></td>
					<td style="text-align:center"><?php echo $row->$time_to?></td>
					<td style="text-align:center"><?php echo $row->$particulars?></td>
					<td style="text-align:center"><?php echo $row->$deduction?></td>
				</tr> <?php
				$start = false;
			endforeach; 
		endforeach;
	endforeach; ?>
</table>
<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>