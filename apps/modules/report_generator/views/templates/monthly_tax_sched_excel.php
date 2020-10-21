<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>
<?php if( $result && $result->num_rows() > 0){
	$res = $result->row();
	$sub_total_nt = 0;
	$sub_total_tax = 0;
?> 

<!-- HEADER ROW's (2) -->
<table>
	<tr><td colspan="4"><?php echo $res->{'Company'}; ?></td></tr>
	<tr><td colspan="4"><?php echo $report_name ." for " . $res->{'Month Name'} . " " . $res->{'Year'};?></td></tr>
</table>
<table>
	<tr>
		<td colspan="4"></td>
		<td><u><b>Total</b></u></td>
	</tr>
	<tr>
		<td colspan="5"><b>COMPENSATION & COMMISSION</b></td>
	</tr>
	<tr><td></td></tr>
	<?php $sub_total_tax = $res->{'Active Salaries'} + $res->{'Active Commission'} + $res->{'Active Leave Conversion'} + $res->{'Active Bonus Incentive Plan'} + $res->{'Res Salaries'} + $res->{'Res 13th Month'} + $res->{'Res Incentive'}; ?> <!-- compute the total compensations -->
	<tr>
		<td colspan="4">Salaries</td>
		<td><?php echo ($res->{'Active Salaries'} != 0) ? $res->{'Active Salaries'} : "-"; ?></td>
	</tr>
	<tr>
		<td colspan="4">Commision</td>
		<td><?php echo ($res->{'Active Commission'} != 0) ? $res->{'Active Commission'} : "-"; ?></td>
	</tr>
	<tr>
		<td colspan="4">Leave Conversion</td>
		<td><?php echo ($res->{'Active Leave Conversion'} != 0) ? $res->{'Active Leave Conversion'} : "-"; ?></td>
	</tr>
	<tr>
		<td colspan="4">Bonus Incentive Plan</td>
		<td><?php echo ($res->{'Active Bonus Incentive Plan'} != 0) ? $res->{'Active Bonus Incentive Plan'} : "-"; ?></td>
	</tr>
	<tr>
		<td colspan="4">Resigned Employees</td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Salaries</td>
		<td><?php echo ($res->{'Res Salaries'} != 0) ? $res->{'Res Salaries'} : "-"; ?></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;13th Month</td>
		<td><?php echo ($res->{'Res 13th Month'} != 0) ? $res->{'Res 13th Month'} : "-"; ?></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sick Leave/ SIL/ BIP</td>
		<td><?php echo ($res->{'Res Incentive'} != 0) ? $res->{'Res Incentive'} : "-"; ?></td>
	</tr>
	<!-- for sub total -->
	<tr>
		<td colspan="4">SUB TOTAL</td>
		<td><?php echo $sub_total_tax;?></td>
	</tr>
	<tr> <td></td></tr>
	<tr>
		<td colspan="5"><i><b>LESS: NON-TAX</b></i></td>
	</tr>
	<?php $sub_total_nt = $res->{'Sss'} + $res->{'Pagibig'} + $res->{'Philhealth'} + $res->{'Cola'} + $res->{'Leave Conversion Non Tax'} + $res->{'Mwe'} + $res->{'Res 13th Month Non Tax'}; ?> <!-- compute the total non tax -->
	<tr>
		<td colspan="4">SSS</td>
		<td><?php echo ($res->{'Sss'} != 0) ? $res->{'Sss'} : "-"; ?></td>
	</tr>
	<tr>
		<td colspan="4">Pag-Ibig</td>
		<td><?php echo ($res->{'Pagibig'} != 0) ? $res->{'Pagibig'} : "-"; ?></td>
	</tr>
	<tr>
		<td colspan="4">Philhealth</td>
		<td><?php echo ($res->{'Philhealth'} != 0) ? $res->{'Philhealth'} : "-"; ?></td>
	</tr>
	<tr>
		<td colspan="4">COLA</td>
		<td><?php echo ($res->{'Cola'} != 0) ? $res->{'Cola'} : "-"; ?></td>
	</tr>
	<!-- 5 days service incentive leave non tax -->
	<tr>
		<td colspan="4">Non Tax Leave Conversion</td>
		<td><?php echo ($res->{'Leave Conversion Non Tax'} != 0) ? $res->{'Leave Conversion Non Tax'} : "-"; ?></td>
	</tr>
	<!-- bonus incentive plan non tax -->
	<tr>
		<td colspan="4">Bonus Incentive Plan</td>
		<td><?php echo "";/*($res->{'Leave Conversion Non Tax'} != 0) ? $res->{'Leave Conversion Non Tax'} : "-"; */?></td>
	</tr>
	<tr>
		<td colspan="4">Minimum Wage Earners</td>
		<td><?php echo ($res->{'Mwe'} != 0) ? $res->{'Mwe'} : "-" ?></td>
	</tr>
	<tr>
		<td colspan="4">Resigned Employees</td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;13th Month</td>
		<td><?php echo ($res->{'Res 13th Month Non Tax'} != 0) ? $res->{'Res 13th Month Non Tax'} : "-"; ?></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sick Leave/ SIL/ BIP</td>
		<td><?php echo "";/*($res->{'Res Incentive Non Tax'} != 0) ? $res->{'Res Incentive Non Tax'} : "-"*/ ?></td>
	</tr>
	<!--  sub total -->
	<tr>
		<td colspan="4">SUB TOTAL</td>
		<td><?php echo $sub_total_nt;?></td>
	</tr>
	<tr><td></td></tr>
	<tr>
		<td colspan="4">TAXABLE COMPENSATION</td>
		<td><?php $tax_compen = $sub_total_tax - $sub_total_nt;
				echo $tax_compen;
			 ?></td>
	</tr>
	<tr><td></td></tr>
	<tr>
		<td colspan="4"><b>WITHHOLDING TAX</b></td>
		<td><?php echo ($res->{'Wtax'} != 0) ? $res->{'Wtax'} : "-"; ?></td>
	</tr>
	<tr><td></td></tr>

	<tr>
		<td colspan="4">Salaries</td>
		<td><?php echo ($res->{'Salaries'} != 0) ? $res->{'Salaries'} : "-"; ?></td>
	</tr>
	<tr>
		<td colspan="4">Tax Adjustment</td>
		<td><?php echo "";/*($res->{'Salaries'} != 0) ? $res->{'Salaries'} : "-";*/ ?></td>
	</tr>
	<tr>
		<td colspan="4">Commission</td>
		<td><?php echo ($res->{'Commission'} != 0) ? $res->{'Commission'} : "-"; ?></td>
	</tr>
	<?php $total = $res->{'Salaries'} + $res->{'Commission'}; ?>
	<tr>
		<td colspan="4"><b>TOTAL</b></td>
		<td><?php echo ($total != 0) ? $total : "-"; ?></td>
	</tr>
</table>

	<?php
}?>
<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>