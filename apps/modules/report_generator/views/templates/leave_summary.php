<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>
<?php
	//prep data
	$form_status = "Form Status";
	$form_code = "Form Code";
	$user_id = "User Id";
	$full_name = "Full Name";
	$day = "Day";
	$date_from = "Date From";
	$date_to = "Date To";
	$reason = "Reason";
	$id_number = "Id Number";
	$company_id = "Company Id";
	$company = "Company";

	$result = $result->result();
	// debug($result); die();
	foreach( $result as $row )
	{
		$data[$row->$id_number][$row->$full_name][] = $row; 
	}

	// debug($data); die();

?>
<table cellspacing="0" cellpadding="1" border="1">
	<tr>
		<td style="font-weight:bold; text-align:center">From</td>
		<td style="font-weight:bold; text-align:center">To</td>
		<td style="font-weight:bold; text-align:center">Day/s</td>
		<td style="font-weight:bold; text-align:center">Reason</td>
		<td style="font-weight:bold; text-align:center">Approval</td>
		<td style="font-weight:bold; text-align:center">Pay</td>
	</tr> <?php
	
	foreach( $data as $id => $emp ): 
		// debug(key($emp));die();
	?>
		<tr>
			<td colspan="8" style="font-weight:bold"><?php echo $id.' '.key($emp); ?></td>
		</tr> <?php
		foreach( $emp as $idno => $rows ):
			$start = true;
			$lates = 0;
			$undertimes = 0;
			foreach( $rows as $row ):
			 ?>
				<?php if( $start ){ ?>
				<tr>
					<td> <?php echo $row->$form_code; ?> </td>
				</tr>
				<?php } ?>
				<tr>
					<td style="text-align:center"><?php echo $row->$date_from?></td>
					<td style="text-align:center"><?php echo $row->$date_to?></td>
					<td style="text-align:center"><?php echo $row->$day?></td>
					<td style="text-align:center"><?php echo $row->$reason?></td>
					<td style="text-align:center"><?php echo $row->$form_status?></td>
					<td style="text-align:right"><?php echo ($row->$form_code == 'VL' || $row->$form_code == 'SL') ? 'W/ Pay' : 'W/out Pay'?></td>
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
			</tr> 
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
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