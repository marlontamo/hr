<table>
	<tr>
		<td>SSS NO</td>
		<td>FIRST NAME</td>
		<td>MI</td>
		<td>LAST NAME</td>		
		<td>LOAN TYPE</td>
		<td>DATE GRANTED</td>
		<td>LOAN AMOUNT</td>
		<td>PENALTY AMOUNT</td>
		<td>AMOUNT PAID</td>
	</tr>
<?php
foreach ($result->result_array() as $value):
?>
	<tr>
		<td><?php echo $value['Sss No']; ?></td>
		<td><?php echo $value['Firstname']; ?></td>
		<td><?php echo substr($value['Middlename'],0,1); ?></td>
		<td><?php echo $value['Lastname']; ?></td>
		<td><?php echo $value['Loan Code']; ?></td>
		<td><?php echo $value['Release Date']; ?></td>
		<td><?php echo $value['Loan Principal']; ?></td>
		<td><?php echo $value['Overdue']; ?></td>
		<td><?php echo $value['Current']; ?></td>
	</tr>
<?php	
endforeach;
?>

</table>