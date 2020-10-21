<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>
<?php if( $result && $result->num_rows() > 0){
	$res = $result->row();
	$cnt = 0;
?> 

<!-- HEADER ROW's (2) -->
<table>
	<tr><td colspan="4"><?php echo $res->{'Company'}; ?></td></tr>
	<tr><td colspan="4"><?php echo "SCHEDULE OF TAXABLE INCOME"/*$report_name*/ ;?> </td>
	<tr><td><?php echo " For Year " . $res->{'Pay Year'}; ?></td></tr>
</table>
<table>
	<tr>
		<td rowspan="2">SQ.</td>
		<td rowspan="2">EMPLOYEE NAME</td>
		<td rowspan="2">TIN</td>
		<td>TAX</td>
		<td colspan="12" style="align: center;">TAXABLE INCOME</td>
		<td rowspan="2">TOTAL</td>
		<td>NONTax</td>
		<td>Addt'l Salaries</td>
		<td colspan="2">13th mo pay</td>
		<td colspan="2">sickleave</td>
		<td>Other NonTax</td>
		<td rowspan="2">COLA</td>
		<td colspan="2">CONTRIBUTIONS</td>
		<td colspan="3">FROM PREVIOUS EMPLOYER</td>
		<td>Taxable</td>
		<td rowspan="2">Exemptions</td>
		<td>Tax Due</td>
		<td colspan="2">Tax Withheld(JAN-NOV)</td>
		<td>Amt Withheld &</td>
		<td>Overwithheld/</td>
		<td>Amt of Tax Withheld</td>
		<td rowspan="2">DEC</td>
		<td rowspan="2">FROM PD</td>
		<td rowspan="2">TAX REFUND</td>
		<td rowspan="2">TAX DEFICIT</td>
	</tr>
	<tr>
		<td>CODE</td>
		<td>JAN</td>
		<td>FEB</td>
		<td>MAR</td>
		<td>APR</td>
		<td>MAY</td>
		<td>JUN</td>
		<td>JUL</td>
		<td>AUG</td>
		<td>SEP</td>
		<td>OCT</td>
		<td>NOV</td>
		<td>DEC</td>
		<td>MWEs</td>
		<td>(REsigned EE)</td>
		<td>non taxable</td>
		<td>taxable</td>
		<td>non taxable</td>
		<td>taxable</td>
		<td>(Staff Benefits)</td>
		<td>Present ER</td>
		<td>Previous ER</td>
		<td>13th mo</td>	
		<td>Non-Tax Icome</td>
		<td>Taxable Income</td>
		<td>Income</td>
		<td>Jan- Dec</td>
		<td>Present ER</td>
		<td>Prev ER</td>
		<td>paid on December</td>
		<td>Tax Refunded to EE</td>
		<td>as Adjusted</td>
	</tr>
	<?php 
		foreach ($result->result() as $key => $value) { 
			$wheld_refund = 0;
			$cnt++; 
	?>
		<tr>
			<td><?php echo $cnt;?></td>
			<td><?php echo !empty($value->{'Employee Name'}) ? $value->{'Employee Name'} : ""; ?></td>
			<td><?php echo !empty($value->{'Tin'}) ? "'" .  $value->{'Tin'} : ""; ?></td>
			<td><?php echo !empty($value->{'Tax Code'}) ? $value->{'Tax Code'} : ""; ?></td>
			<td><?php echo !empty($value->{'Jan'}) ? $value->{'Jan'} : "-"; ?></td><!-- jan -->
			<td><?php echo !empty($value->{'Feb'}) ? $value->{'Feb'} : "-"; ?></td><!-- feb -->
			<td><?php echo !empty($value->{'Mar'}) ? $value->{'Mar'} : "-"; ?></td><!-- mar -->
			<td><?php echo !empty($value->{'Apr'}) ? $value->{'Apr'} : "-"; ?></td><!-- apr -->
			<td><?php echo !empty($value->{'May'}) ? $value->{'May'} : "-"; ?></td><!-- may -->
			<td><?php echo !empty($value->{'Jun'}) ? $value->{'Jun'} : "-"; ?></td><!-- jun -->
			<td><?php echo !empty($value->{'Jul'}) ? $value->{'Jul'} : "-"; ?></td><!-- jul -->
			<td><?php echo !empty($value->{'Aug'}) ? $value->{'Aug'} : "-"; ?></td><!-- aug -->
			<td><?php echo !empty($value->{'Sep'}) ? $value->{'Sep'} : "-"; ?></td><!-- sep -->
			<td><?php echo !empty($value->{'Oct'}) ? $value->{'Oct'} : "-"; ?></td><!-- oct -->
			<td><?php echo !empty($value->{'Nov'}) ? $value->{'Nov'} : "-"; ?></td><!-- nov -->
			<td><?php echo !empty($value->{'Dec'}) ? $value->{'Dec'} : "-"; ?></td><!-- dec -->
			<?php 
				$total_icome = $value->{'Jan'} + $value->{'Feb'} + $value->{'Mar'} + $value->{'Apr'} + $value->{'May'} + $value->{'Jun'} + $value->{'Jul'} + $value->{'Aug'} + $value->{'Sep'} + $value->{'Oct'} + $value->{'Nov'} + $value->{'Dec'};
			?>
			<td><?php echo !empty($total_icome) || $total_income = 0 ? $total_icome : "-"; ?></td><!-- total -->
			<td><?php echo !empty($value->{'Active Non Taxable Mwe'}) ? $value->{'Active Non Taxable Mwe'} : "-"; ?></td>
			<td><?php echo !empty($value->{'Active Bonus Nt'}) ? $value->{'Active Bonus Nt'} : "-"; ?></td>
			<td><?php echo !empty($value->{'Active Bonus'}) ? $value->{'Active Bonus'} : "-"; ?></td>
			<td><?php echo ""/*!empty($value->{'Sl Non Tax'}) ? $value->{'Sl Non Tax'} : "-";*/ ?></td><!-- SL non tax -->
			<td><?php echo ""/*!empty($value->{'Sl Tax'}) ? $value->{'Sl Tax'} : "-";*/ ?></td><!-- SL tax -->
			<td><?php echo !empty($value->{'Other Nt Staffben'}) ? $value->{'Other Nt Staffben'} : "-"; ?></td>
			<td><?php echo !empty($value->{'Active Cola'}) ? $value->{'Active Cola'} : "-"; ?></td>
			<td><?php echo !empty($value->{'With Pres Contribution'}) ? $value->{'With Pres Contribution'} : "-"; ?></td>
			<td><?php echo !empty($value->{'With Prev Contribution'}) ? $value->{'With Prev Contribution'} : "-"; ?></td>
			<td><?php echo !empty($value->{'With Prev Bonus'}) ? $value->{'With Prev Bonus'} : "-"; ?></td>
			<td><?php echo !empty($value->{'With Prev Non Taxable Income'}) ? $value->{'With Prev Non Taxable Income'} : "-"; ?></td>
			<td><?php echo !empty($value->{'With Prev Taxable Income'}) ? $value->{'With Prev Taxable Income'} : "-"; ?></td>
			<td><?php echo !empty($value->{'Active Taxable Income'}) ? $value->{'Active Taxable Income'} : "-"; ?></td>
			<td><?php echo !empty($value->{'Exemptions'}) ? $value->{'Exemptions'} : "-"; ?></td>
			<td><?php echo !empty($value->{'Taxdue'}) ? $value->{'Taxdue'} : "-"; ?></td>
			<td><?php echo !empty($value->{'With Pres Wtax'}) ? $value->{'With Pres Wtax'} : "-"; ?></td>
			<td><?php echo !empty($value->{'With Prev Wtax'}) ? $value->{'With Prev Wtax'} : "-"; ?></td>
			<?php $tax_withheld = $value->{'Taxdue'} - $value->{'With Pres Wtax'}; 
					if($tax_withheld >= 1) { 
						$wheld_refund = $tax_withheld;
			?>	
						<td><?php echo $tax_withheld;?></td>
						<td></td>
			<?php 	} else { ?>	
						<td></td>
						<td><?php echo $tax_withheld;?></td>
			<?php 	} ?>
			<td><?php echo !empty($value->{'Taxdue'}) ? $value->{'Taxdue'} : "-"; ?></td>
			<td><?php echo !empty($value->{'Tax Dec'}) ? $value->{'Tax Dec'} : "-"; ?></td>
			<td><?php echo "";/*!empty($value->{'From Pd'}) ? $value->{'From Pd'} : "-";*/ ?></td> <!-- FROM PD -->
			<?php $tax_refund = $wheld_refund - $value->{'Tax Dec'} ?><!-- From PD is not yet deducted for discussion -->
			<!-- check if it is refund or deficit -->
			<?php if( $tax_refund < 0 ) { 
				//$tax_refund -=  $value->{'From Pd'};/* to deduct the From PD here*/
			?> <!-- if negative it is for refund -->
				<td><?php echo $tax_refund; ?></td>
				<td></td>
			<?php } else { ?> <!-- for deficit -->
				<td></td>
				<td><?php echo $tax_refund; ?></td>
			<?php }?>
		</tr>
	<?php }?>
</table>

	<?php
}?>
<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>