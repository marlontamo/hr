
<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>
<?php
	$row = $result->row();
	$company = $row->{'Company'};
	$result = $result->result_array();
?>
<table>
	<tr>
		<td colspan="9"><?php echo $company; ?></td>
	</tr>
<?php 
$loan = '';
foreach($result as $key => $value){
	// INSERT HEADER
	if( $loan == '' || $loan != $value['Loan']) 
	{?>
		
		<tr><td></td></tr>
		<tr><td><?php echo $value['Description']; ?></td></tr>
	<?php 
	switch ($value['Category']) {
			case 'SSS': ?>
				<tr>
					<td>PRN</td>
					<td>EMPLOYEE NO</td>
					<td>LAST NAME</td>
					<td>FIRST NAME</td>
					<td>SSS NUMBER</td>
					<td>LOAN PRINCIPAL</td>
					<td>AMOUNT</td>
					<td>START DATE</td>
					<td>RUNNING BALANCE</td>
				</tr><?php
				break;
			case 'HDMF': ?>
				<tr>
					<td>PRN</td>
					<td>EMPLOYEE NO</td>
					<td>LAST NAME</td>
					<td>FIRST NAME</td>
					<td>HDMF NUMBER</td>
					<td>LOAN PRINCIPAL</td>
					<td>AMOUNT</td>
					<td>START DATE</td>
					<td>RUNNING BALANCE</td>
				</tr><?php
				break;
			
			default: ?>
				<tr>
					<td>PRN</td>
					<td>EMPLOYEE NO</td>
					<td>LAST NAME</td>
					<td>FIRST NAME</td>
					<td></td>
					<td>LOAN PRINCIPAL</td>
					<td>AMOUNT</td>
					<td>START DATE</td>
					<td>RUNNING BALANCE</td>
					<td></td>
				</tr><?php
				break;
		}?>
		<?php
	}
	// INSERT DETAIL
	switch ($value['Category']) {
		case 'SSS': ?>		
				<tr>
					<td><?php echo $value['PRN']; ?></td>
					<td><?php echo $value['Id Number']; ?></td>
					<td><?php echo $value['Lastname']; ?></td>
					<td><?php echo $value['Firstname']; ?></td>
					<td><?php echo $value['Sss No']; ?></td>
					<td><?php echo $value['Loan Principal']; ?></td>
					<td><?php echo $value['Amount']; ?></td>
					<td><?php echo $value['Start Date']; ?></td>
					<td><?php echo $value['Balance']; ?></td>
				</tr>
			<?php
			break;
		case 'HDMF': ?>
				<tr>
					<td><?php echo $value['PRN']; ?></td>
					<td><?php echo $value['Id Number']; ?></td>
					<td><?php echo $value['Lastname']; ?></td>
					<td><?php echo $value['Firstname']; ?></td>
					<td><?php echo $value['Hdmf No']; ?></td>
					<td><?php echo $value['Loan Principal']; ?></td>
					<td><?php echo $value['Amount']; ?></td>
					<td><?php echo $value['Start Date']; ?></td>
					<td><?php echo $value['Balance']; ?></td>
				</tr>
			<?php
			break;
		
		default: ?>
				<tr>
					<td><?php echo $value['PRN']; ?></td>
					<td><?php echo $value['Id Number']; ?></td>
					<td><?php echo $value['Lastname']; ?></td>
					<td><?php echo $value['Firstname']; ?></td>
					<td></td>
					<td><?php echo $value['Loan Principal']; ?></td>
					<td><?php echo $value['Amount']; ?></td>
					<td><?php echo $value['Start Date']; ?></td>
					<td><?php echo $value['Balance']; ?></td>
				</tr>
			<?php
			break;
	}?>
	
<?php
	$loan = $value['Loan'];
}
?>
</table>