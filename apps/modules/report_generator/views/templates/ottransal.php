<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}

	$first = $result->row();
?>
<table cellspacing="0" cellpadding="1" border="0">
	<tr>
		<td colspan="3">OVERTIME TRANSPORT ALLOWANCE (ABOVE 10 PM)</td>
	</tr>
	<tr>
		<td>PERIOD:</td>
		<td></td>
		<td><?php echo date('M d', strtotime($first->date_from)) ?> to <?php echo date('M d', strtotime($first->date_to)) ?></td>
	</tr>
	<tr>
		<td>COMPANY</td>
		<td  align="center">:</td>
		<td><?php echo $first->company?></td>
	</tr>
</table>
<table cellspacing="0" cellpadding="1" border="1">
	<tr>
		<th>NO.</th>
		<th>Employee Name</th>
		<th>Amount (Rp.)</th>
		<th>BCA Acct. No</th>
	</tr><?php
	$result = $result->result();
	$ctr = 1;
	$total = 0;
	foreach( $result as $row ) : ?>
		<tr>
			<td><?php echo $ctr?></td>
			<td><?php echo $row->full_name?></td>
			<td align="right"><?php echo $row->amount?></td>
			<td><?php echo $row->key?></td>
		</tr> <?php
		$total += $row->amount;
		$ctr++;
	endforeach; ?>
	<tr>
		<td></td>
		<td>TOTAL</td>
		<td align="right"><?php echo $total?></td>
		<td></td>
	</tr>
</table>
<table>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td>Prepared date : <?php echo date('d M Y')?></td></tr>
	<tr>
		<td>Prepared by,</td>
		<td></td>
		<td>Acknowledged by,</td>
	</tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr>
		<td>Nur Afridela Z.</td>
		<td></td>
		<td>Anggraeny C. (Agy)</td>
	</tr>
	<tr>
		<td>HR STAFF</td>
		<td></td>
		<td>HR MANAGER</td>
	</tr>
</table>

<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>