<?php $res = $result->row(); 
	// debug($res);die();
?>
<!-- TITLE -->
<table>
	<tr><td><?php echo $res->{'Company'}; ?></td></tr>
	<tr><td>SUMMARY OF ALPHALIST <?php echo $res->{'Pay Year'}; ?></td></tr>
</table>
<table>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr>
		<td></td>
		<td></td>
		<td>Gross Taxable</td>
		<td>Taxable Income</td>
		<td>Non Taxable MWE</td>
		<td>Non-Taxable Income</td>
		<td>W/holding Tax</td>
		<td>13th Month</td>
		<td>Contributions</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>Income</td>
		<td></td>
		<td></td>
		<td>SL/SIL/COLA/Staff Benefits</td>
		<td>Jan - Nov</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="2">Active Employees</td>
		<td></td>
		<td><?php echo $res->{'Active Taxable Income'}; ?></td>
		<td><?php echo $res->{'Active Non Taxable Mwe'}; ?></td>
		<td><?php echo $res->{'Active Non Taxable Income'}; ?></td>
		<td><?php echo $res->{'Active Wtax'}; ?></td>
		<td><?php echo $res->{'Active Bonus'}; ?></td>
		<td><?php echo $res->{'Active Contribution'}; ?></td>
	</tr>
	<tr>
		<td colspan="2">Resigned Employees</td>
		<td></td>
		<td><?php echo $res->{'Resigned Taxable Income'}; ?></td>
		<td><?php echo $res->{'Resigned Non Taxable Mwe'}; ?></td>
		<td><?php echo $res->{'Resigned Non Taxable Income'}; ?></td>
		<td><?php echo $res->{'Resigned Wtax'}; ?></td>
		<td><?php echo $res->{'Resigned Bonus'}; ?></td>
		<td><?php echo $res->{'Resigned Contribution'}; ?></td>
	</tr>
	<tr>
		<td colspan="2">W/ Previous Employer</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>Previous Employer</td>
		<td></td>
		<td><?php echo $res->{'With Prev Taxable Income'}; ?></td>
		<td><?php echo $res->{'With Prev Non Taxable Mwe'}; ?></td>
		<td><?php echo $res->{'With Prev Non Taxable Income'}; ?></td>
		<td><?php echo $res->{'With Prev Wtax'}; ?></td>
		<td><?php echo $res->{'With Prev Bonus'}; ?></td>
		<td><?php echo $res->{'With Prev Contribution'}; ?></td>
	</tr>
	<tr>
		<td></td>
		<td>Present Employer</td>
		<td></td>
		<td><?php echo $res->{'With Pres Taxable Income'}; ?></td>
		<td><?php echo $res->{'With Pres Non Taxable Mwe'}; ?></td>
		<td><?php echo $res->{'With Pres Non Taxable Income'}; ?></td>
		<td><?php echo $res->{'With Pres Wtax'}; ?></td>
		<td><?php echo $res->{'With Pres Bonus'}; ?></td>
		<td><?php echo $res->{'With Pres Contribution'}; ?></td>
	</tr>
	<tr>
		<td colspan="2">Minimum Wage Earners</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>Present Employer</td>
		<td></td>
		<td><?php echo $res->{'Mwe Taxable Income'}; ?></td>
		<td><?php echo $res->{'Mwe Non Taxable Mwe'}; ?></td>
		<td><?php echo $res->{'Mwe Non Taxable Income'}; ?></td>
		<td><?php echo $res->{'Mwe Wtax'}; ?></td>
		<td><?php echo $res->{'Mwe Bonus'}; ?></td>
		<td><?php echo $res->{'Mwe Contribution'}; ?></td>
	</tr>
	<tr>
		<td></td>
		<td>Previous Employer</td>
		<td></td>
		<td><?php echo $res->{'Mwe Prev Taxable Income'}; ?></td>
		<td><?php echo $res->{'Mwe Prev Non Taxable Mwe'}; ?></td>
		<td><?php echo $res->{'Mwe Prev Non Taxable Income'}; ?></td>
		<td><?php echo $res->{'Mwe Prev Wtax'}; ?></td>
		<td><?php echo $res->{'Mwe Prev Bonus'}; ?></td>
		<td><?php echo $res->{'Mwe Prev Contribution'}; ?></td
	</tr>
	<tr>
		<td colspan="2">Taxable Sick Leave</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="2">Taxable 13th Month</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><?php echo $res->{'Taxable Bonus'}; ?></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>W/ Previous ER</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><?php echo $res->{'With Prev Taxable Bonus'}; ?></td>
		<td></td>
	</tr>
</table>