
<?php
	$res = $result->row();
	$result = $result->result_array();
?>
<table>
	<tr><td><?php echo $res->{'Company Name'}; ?></td></tr>
	<tr><td>SUMMARY OF MONTHLY AND DAILY PAYROLL FOR <?php echo date("F d, Y",strtotime($res->{'Payroll Date'})); ?></td></tr>
</table>

<table>
<?php 
$rate_type = '';
$atm 	= 0;
$cash 	= 0;
$total 	= 0;
$gatm 	= 0;
$gcash 	= 0;
$gtotal	= 0;
foreach($result as $value ): 
	if( $rate_type == '' || $rate_type != $value['Rate Type']) {
		if($rate_type == ''){
		?>
			<tr><td></td></tr>
			<tr>
				<td><?php echo $value['Payroll Rate Type']; ?></td>
			</tr>
			<tr>
				<td>PRN</td>
				<td>ATM</td>
				<td>CASH</td>
				<td>TOTAL</td>
			</tr>
		<?php 
		} else { 
		?>	
			<tr>
				<td>TOTAL : </td>
				<td><?php echo number_format( $atm , 2,'.',''); ?></td>
				<td><?php echo number_format( $cash , 2,'.',''); ?></td>
				<td><?php echo number_format( $total , 2,'.',''); ?></td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td><?php echo $value['Payroll Rate Type']; ?></td>
			</tr>
			<tr>
				<td>PRN</td>
				<td>ATM</td>
				<td>CASH</td>
				<td>TOTAL</td>
			</tr>
		<?php
			$atm 	= 0;
			$cash 	= 0;
			$total 	= 0;
		}
	} ?>
	<tr>
		<td><?php echo $value['Project Name']; ?></td>
		<td><?php echo number_format( $value['Atm'] , 2,'.',''); ?></td>
		<td><?php echo number_format( $value['Cash'] , 2,'.',''); ?></td>
		<td><?php echo number_format( $value['Total'] , 2,'.',''); ?></td>
	</tr>
	<?php
	$atm 	+= $value['Atm'];
	$cash 	+= $value['Cash'];
	$total 	+= $value['Total'];
	$gatm 	+= $value['Atm'];
	$gcash 	+= $value['Cash'];
	$gtotal	+= $value['Total'];
	$rate_type = $value['Rate Type'];
endforeach;
?>
	<tr>
		<td>TOTAL : </td>
		<td><?php echo number_format( $atm , 2,'.',''); ?></td>
		<td><?php echo number_format( $cash , 2,'.',''); ?></td>
		<td><?php echo number_format( $total , 2,'.',''); ?></td>
	</tr>
	<tr><td></td></tr>
	<tr>
		<td>GRAND TOTAL : </td>
		<td><?php echo number_format( $gatm , 2,'.',''); ?></td>
		<td><?php echo number_format( $gcash , 2,'.',''); ?></td>
		<td><?php echo number_format( $gtotal , 2,'.',''); ?></td>
	</tr>
</table>