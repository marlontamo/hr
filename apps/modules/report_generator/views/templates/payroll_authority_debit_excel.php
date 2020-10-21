<?php
	$count = 1;
	$row = $result->row();
	$gtAmount = 0;
?>

<table>
	<tr><td><?php echo date("d-M-y"); ?></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td>RIZAL COMMERCIAL BANKING CORP.</td></tr>
	<tr><td>ST. FRANCIS SQUARE</td></tr>
	<tr><td>MANDALUYON CITY</td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td colspan="8">Attention: MR. HARI S. SANTIAGO</td></tr>
	<tr><td colspan="8">CUSTOMER SERVICE HEAD</td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td colspan="8">Please debit <?php echo $row->{'Bank Type Name'}; ?> ACCOUNT number <?php echo $row->{'Bank Account No'} ;?> of <?php echo $row->{'Company'}; ?> and credit accounts of the following employees upon receipt hereof for the payroll pay date of <?php echo date("F m, Y", strtotime($row->{'Payroll Date'} )); ?>.</td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr>
		<td></td>
		<td></td>
		<td colspan="2">BANK ACCT#</td>
		<td colspan="2">AMOUNT</td>
		<td></td>
		<td></td>
	</tr>
<?php 
	foreach($result->result_array() as $value ):?>
	<tr>
		<td></td>
		<td><?php echo $count; ?>.</td>
		<td colspan="2"><?php echo $value['Bank Account']; ?></td>
		<td colspan="2"><?php echo $value['Amount']; ?></td>
		<td></td>
		<td></td>
	</tr>

<?php
	$gtAmount += $value['Amount'];
	$count++;
endforeach;
?>
	<tr>
		<td></td>
		<td colspan="3">GRAND TOTAL :</td>
		<td colspan="2"><?php echo $gtAmount; ?></td>
		<td></td>
		<td></td>
	</tr>
</table>