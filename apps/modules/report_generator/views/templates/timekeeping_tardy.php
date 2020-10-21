<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>
<?php
	//prep data
	$payroll_date = "Payroll Date";
	$company = "Company";
	$full_name = "Full Name";
	$id_number = "ID Number";
	$date = "Date";
	$shift = "Shift";
	$time_from = "Time From";
	$time_to = "Time To";
	$late = "Late";
	$undertime = "Undertime";

	$result = $result->result();
	// debug($result); die();
	foreach( $result as $row )
	{
		$com[$row->$company][$row->$id_number][] = $row; 
	}

	if (isset($month)){
		$month_name = array(1 => 'January',2 => 'February',3 => 'March',4 => 'April',5 => 'May',6 => 'June',7 => 'July',8 => 'August',9 => 'September',10 => 'October',11 => 'November',12 => 'December');
		$month = $month_name[$month];
	}

	$result = $this->db->get('ww_time_record_tardiness_settings');
	$instance = 0;
	$minutes = 0;
	if ($result && $result->num_rows() > 0){
		$tardy_config = $result->row();
		$instance = $tardy_config->instances;
		$minutes = $tardy_config->minutes_tardy;		
	}
?>
<table cellspacing="0" cellpadding="1" border="1">
	<tr>
		<td colspan="9" style="font-weight:bold; text-align:center">Tardiness Report for the Month of <?php echo $month ?> <?php echo $year ?></td>
	</tr>
	<tr>
		<td style="font-weight:bold; text-align:center">ID Number</td>		
		<td style="font-weight:bold; text-align:center">Date</td>
		<td style="font-weight:bold; text-align:center">Shift</td>
		<td style="font-weight:bold; text-align:center">Time In</td>
		<td style="font-weight:bold; text-align:center">Time Out</td>		
		<td style="font-weight:bold; text-align:center">Late</td>
		<td style="font-weight:bold; text-align:center">Name</td>
		<td style="font-weight:bold; text-align:center">No. of Times</td>
		<td style="font-weight:bold; text-align:center">No. of Minutes</td>
	</tr> <?php
	
	foreach( $com as $comp => $emp ): ?>
		<tr>
			<td colspan="8" style="font-weight:bold"><?php echo $comp?></td>
		</tr> <?php
		foreach( $emp as $idno => $rows ):
			$start = true;
			$lates = 0;
			$undertimes = 0;
			$count = 0;
			foreach( $rows as $row ):
				$lates += empty($row->$late) ? 0 : intval($row->$late);
				$count ++;
				$undertimes += empty($row->$undertime) ? 0 : $row->$undertime; ?>
				<tr>
					<td><?php if( $start ) echo $row->$id_number?> </td>
					<td style="text-align:center"> <?php echo $row->$date?> </td>										
					<td style="text-align:center"> <?php echo $row->$shift?> </td>					
					<td style="text-align:center"> <?php echo $row->$time_from?> </td>
					<td style="text-align:center"> <?php echo $row->$time_to?> </td>					
					<td style="text-align:right"> <?php if($row->$late != '0.00') echo intval($row->$late)?> </td>					
					<td><?php if( $start ) echo $row->$full_name?></td>
					<td></td>
					<td></td>
				</tr> <?php
				$start = false;
			endforeach; ?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>				
				<td></td>
				<td style="text-align:right; <?php echo ($count > $instance ? 'color:red' : '' ) ?>"> <?php echo $count ?> </td>
				<td style="text-align:right; <?php echo ($lates > $minutes ? 'color:red' : '' ) ?>"> <?php if(!empty($lates)) echo intval($lates)?> </td>
			</tr> <?php
		endforeach;
	endforeach; ?>
</table>
<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>