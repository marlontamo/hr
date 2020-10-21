payroll_cash_payment
<?php
	$res = $result->row();
	$result = $result->result_array();
?>
<table>
	<tr><td><?php echo $res->{'Company Name'}; ?></td></tr>
	<tr><td>SUMMARY OF MONTHLY AND DAILY PAYROLL FOR <?php echo date("F d, Y",strtotime($res->{'Payroll Date'})); ?></td></tr>
	<tr><td></td></tr>
</table>

<table>
<?php 
$rate_type  = '';
$project 	= '';
$emp 		= 1;
$emp_tot	= 0;
$netpay		= 0;
$gnetpay	= 0;
foreach($result as $value ): 
	if( $rate_type == '' || $rate_type != $value['Rate Type']) {
		if($rate_type == ''){
		?>
			<tr><td></td></tr>
			<tr>
				<td><?php echo $value['Payroll Rate Type']; ?></td>
			</tr>
			<tr>
				<td><?php echo $value['Project Name']; ?></td>
			</tr>
		<?php 
		} else { 
		?>	
			<tr>
				<td></td>
				<td>SUB TOTAL : </td>
				<td><?php echo number_format( $netpay , 2,'.',''); ?></td>
				<td></td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td><?php echo $value['Payroll Rate Type']; ?></td>
			</tr>
			<tr>
				<td><?php echo $value['Project Name']; ?></td>
			</tr>
		<?php
			$emp 	= 1;
			$netpay	= 0;
		}
	} else {
		if($project != $value['Project']){
		?>
			<tr>
				<td></td>
				<td>SUB TOTAL : </td>
				<td><?php echo number_format( $netpay , 2,'.',''); ?></td>
				<td></td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td><?php echo $value['Project Name']; ?></td>
			</tr>
		<?php	
			$emp 	= 1;
			$netpay	= 0;
		}
	} ?>
	<tr>
		<td><?php echo $emp; ?></td>
		<td><?php echo $value['Full Name']; ?></td>
		<td><?php echo number_format( $value['Netpay'] , 2,'.',''); ?></td>
		<td><?php echo $value['Project Code']; ?></td>
	</tr>
	<?php
	$netpay 	+= $value['Netpay'];
	$gnetpay	+= $value['Netpay'];
	$emp++;
	$emp_tot++;
	$rate_type 	= $value['Rate Type'];
	$project 	= $value['Project'];
endforeach;
?>
	<tr>
		<td></td>
		<td>SUB TOTAL : </td>
		<td><?php echo number_format( $netpay , 2,'.',''); ?></td>
		<td></td>
	</tr>
	<tr><td></td></tr>
	<tr>
		<td></td>
		<td>GRAND TOTAL &nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $emp_tot;?></td>
		<td><?php echo number_format( $gnetpay , 2,'.',''); ?></td>
		<td></td>
	</tr>
</table>