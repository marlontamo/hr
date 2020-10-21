<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>

<table cellspacing="0" cellpadding="1" border="1">
	<tr>
		<th colspan="16" style="font-weight:bold;">Incident Report</th>
	</tr>	
	<tr>
		<th colspan="2" style="font-weight:bold;">Period From - To</th>
		<th colspan="14" style="font-weight:bold;"><?php echo (isset($filter['2668']) && $filter['2668'] != '1970-01-01' ? date('M d, Y',strtotime($filter['2668'])) : '') ?> to <?php echo (isset($filter['2669']) && $filter['2669'] != '1970-01-01' ? date('M d, Y',strtotime($filter['2669'])) : '') ?></th>
	</tr>	
	<tr>
		<th colspan="16"></th>
	</tr>			
	<tr>
		<td style="font-weight:bold; text-align:center">Name</td>
		<td style="font-weight:bold; text-align:center">Position</td>
		<td style="font-weight:bold; text-align:center">Company</td>
		<td style="font-weight:bold; text-align:center">Dept</td>
		<td style="font-weight:bold; text-align:center">Frequency</td>
		<td style="font-weight:bold; text-align:center">Penalty</td>
		<td style="font-weight:bold; text-align:center">Payment</td>
		<td style="font-weight:bold; text-align:center">From</td>
		<td style="font-weight:bold; text-align:center">To</td>
		<td style="font-weight:bold; text-align:center">Date fo Offense</td>
		<td style="font-weight:bold; text-align:center">Date Served</td>
		<td style="font-weight:bold; text-align:center">DA Remarks</td>
		<td style="font-weight:bold; text-align:center">IR Closed Date</td>
		<td style="font-weight:bold; text-align:center">Superior</td>
		<td style="font-weight:bold; text-align:center">Offense</td>
		<td style="font-weight:bold; text-align:center">Details of Violation</td>
	</tr> <?php

	if ($result && $result->num_rows() > 0){
		foreach ($result->result_array() as $row) {
	?>
			<tr>
				<td><?php echo $row['Name'] ?></td>
				<td><?php echo $row['Position'] ?></td>
				<td style="text-align:center"><?php echo $row['Company'] ?></td>
				<td style="text-align:center"><?php echo $row['Department'] ?></td>
				<td style="text-align:center"><?php echo $row['Frequency'] ?></td>
				<td style="text-align:center"><?php echo $row['Penalty'] ?></td>
				<td style="text-align:center"><?php echo $row['Payment'] ?></td>
				<td style="text-align:center"><?php echo ($row['From'] != '1970-01-01' && $row['From'] != '') ? date('M d Y',strtotime($row['From'])) : '' ?></td>
				<td style="text-align:center"><?php echo ($row['To'] != '1970-01-01' && $row['To'] != '') ? date('M d Y',strtotime($row['To'])) : '' ?></td>
				<td style="text-align:center"><?php echo ($row['Date Of Offense'] != '1970-01-01' && $row['Date Of Offense'] != '') ? date('M d Y',strtotime($row['Date Of Offense'])) : '' ?></td>
				<td style="text-align:center"><?php echo ($row['Date Serve'] != '1970-01-01' && $row['Date Serve'] != '' && $row['Date Serve'] != '0000-00-00 00:00:00') ? date('M d Y',strtotime($row['Date Serve'])) : '' ?></td>
				<td style="text-align:center"><?php echo $row['Remarks'] ?></td>
				<td style="text-align:center"><?php echo ($row['Ir Closed Date'] != '1970-01-01' && $row['Ir Closed Date'] != '') ? date('M d Y',strtotime($row['Ir Closed Date'])) : '' ?></td>
				<td style="text-align:center"><?php echo $row['Superior'] ?></td>
				<td style="text-align:center"><?php echo $row['Offense'] ?></td>
				<td style="text-align:center"><?php echo $row['Details Of Violations'] ?></td>
			</tr>	
	<?php	
		}	
	}
	?>
</table>
<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>