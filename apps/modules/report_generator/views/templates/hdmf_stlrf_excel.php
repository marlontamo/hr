<table>
	<tr>
		<td>PAGIBIG NO</td>
		<td>ID NUMBER</td>
		<td>LAST NAME</td>
		<td>FIRST NAME</td>
		<td>MIDDLE NAME</td>
		<td>EE AMT</td>
		<td>ER AMT</td>
		<td>TIN</td>
		<td>BIRTHDATE</td>
	</tr>
<?php
foreach ($result->result_array() as $value):
?>
	<tr>
		<td><?php echo $value['Hdmf No']; ?></td>
		<td><?php echo $value['Id Number']; ?></td>
		<td><?php echo $value['Lastname']; ?></td>
		<td><?php echo $value['Firstname']; ?></td>
		<td><?php echo $value['Middlename']; ?></td>
		<td><?php echo $value['Amount']; ?></td>
		<td></td>
		<td><?php echo $value['Tin']; ?></td>
		<td><?php echo $value['Birth Date']; ?></td>
	</tr>
<?php	
endforeach;
?>

</table>