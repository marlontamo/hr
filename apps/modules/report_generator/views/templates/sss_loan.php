<?php 
	$employer = $header->{'Company'};
	$employer_id = $header->{'Sss'};
	$month = $header->{'Month'};
	$year = $header->{'Year'};

	$t_cur = 0;
	$t_ovr = 0;
	$t_due = 0;
	$page_count = 1;
	$header = 1;
	$row = 0;
	foreach ($result as $value) {

		if($row > 15){
			$page_count  = $page_count + 1 ;	
			$header = 1;
		}
		if( $page_count > 1 && $row > 15 ){?>
			<!-- FOR PAGE BREAK -->
			<div style="page-break-before: always;">&nbsp;</div><?php
		}else{
			?><div>&nbsp;</div><?php
		}
		if( $header == 1 ){
			$header = 0;
			$row = 0;
			?>
			<table>
				<tr><td style="width: 100%; text-align: center; font-size: 9;"><strong>Republic of the Philippines</strong></td></tr>
				<tr><td style="width: 100%; text-align: center; font-size: 11;"><strong>S O C I A L &nbsp; S E C U R I T Y &nbsp; S Y S T E M</strong></td></tr>
				<tr><td style="width: 100%; text-align: center; font-size: 20;">&nbsp;</td></tr>
				<tr><td style="width: 100%; text-align: center; font-size: 10;"><strong>SALARY/CALAMITY/EDUCATION/EMERGENCY LOAN</strong></td></tr>
				<tr><td style="width: 100%; text-align: center; font-size: 10;"><strong>COLLECTION LIST</strong></td></tr>
				<tr><td style="width: 100%; text-align: center; font-size:  8;">As of <?php echo $month." ".$year; ?></td></tr>
			</table>
			<table cellpadding="2">
				<tr>
					<td style="width: 15%; text-align: left  ; " ><strong>Name of Employer :</strong></td>
					<td style="width: 60%; text-align: left  ; " ><?php echo $employer; ?></td>
					<td style="width: 15%; text-align: right ; " ><strong>Page No :</strong></td>
					<td style="width: 10%; text-align: center; " ><?php echo $page_count; ?></td>
				</tr>
				<tr>
					<td style="width: 15%; text-align: left  ; " ><strong>ER ID No. of Employer :</strong></td>
					<td style="width: 60%; text-align: left  ; " ><?php echo $employer_id; ?></td>
					<td style="width: 15%; text-align: right ; " ><strong>Applicable Month:</strong></td>
					<td style="width: 10%; text-align: center; " ><?php echo $month." ".$year; ?></td>
				</tr>
			</table>
			<table border="1px">
				<table cellpadding="2">
					<tr>
						<td style="width:  7%; text-align: center; " ><strong>SS Number</strong></td>
						<td style="width: 26%; text-align: left  ; " ><strong>Name of Borrower</strong></td>
						<td style="width:  3%; text-align: center; " ><strong>Loan</strong></td>
						<td style="width:  8%; text-align: center; " ><strong>Date</strong></td>
						<td style="width: 11%; text-align: center; " ><strong>Amount of</strong></td>
						<td style="width: 20%; text-align: center; " ><strong>Amount Due</strong></td>
						<td style="width: 11%; text-align: center; " ><strong>Total Amount Due</strong></td>
						<td style="width:  6%; text-align: center; " ><strong>Remarks</strong></td>
						<td style="width:  8%; text-align: center; " ><strong>Date</strong></td>
					</tr>
					<tr>
						<td style="width:  7%; text-align: center; " ><strong>&nbsp;</strong></td>
						<td style="width: 26%; text-align: left  ; " ><strong>&nbsp;</strong></td>
						<td style="width:  3%; text-align: center; " ><strong>Type</strong></td>
						<td style="width:  8%; text-align: center; " ><strong>Granted</strong></td>
						<td style="width: 11%; text-align: center; " ><strong>Loan</strong></td>
						<td style="width: 10%; text-align: center; " ><strong>Current</strong></td>
						<td style="width: 10%; text-align: center; " ><strong>OverDue</strong></td>
						<td style="width: 11%; text-align: center; " ><strong>&nbsp;</strong></td>
						<td style="width:  6%; text-align: center; " ><strong>&nbsp;</strong></td>
						<td style="width:  8%; text-align: center; " ><strong>Resigned</strong></td>
					</tr>
				</table>
			</table>
			<table><tr><td></td></tr></table><?php
		}?>
		<table>
			<tr>
				<td style="width:  7%; text-align: center; " ><?php echo $value->{'Sss No'};?></td>
				<td style="width: 26%; text-align: left  ; " ><?php echo $value->{'Employee Name'};?></td>
				<td style="width:  3%; text-align: center; " ><?php echo $value->{'Loan Code'};?></td>
				<td style="width:  8%; text-align: center; " ><?php echo $value->{'Release Date'};?></td>
				<td style="width: 11%; text-align: center; " ><?php echo number_format( str_replace(",", "", $value->{'Loan Principal'} ), 2, '.',',');?></td>
				<td style="width: 10%; text-align: center; " ><?php echo number_format( str_replace(",", "", $value->{'Current'} ), 2, '.',',');?></td>
				<td style="width: 10%; text-align: center; " ><?php echo number_format( str_replace(",", "", $value->{'Overdue'} ), 2, '.',',');?></td>
				<td style="width: 11%; text-align: center; " ><?php echo number_format( str_replace(",", "", $value->{'Due'} ), 2, '.',',');?></td>
				<td style="width:  6%; text-align: center; " ><?php echo $value->{'Remarks'};?></td>
				<td style="width:  8%; text-align: center; " ><?php echo $value->{'Resigned Date'};?></td>
			</tr>
		</table><?php
		$t_cur += $value->{'Current'};
		$t_ovr += $value->{'Overdue'};
		$t_due += $value->{'Due'};
		$row++;
	}
?>
	<table>
		<tr><td style="width: 100%; border-bottom: 1px solid black; font-size: 2;">&nbsp;</td></tr>
		<tr><td style="width: 100%; font-size: 1;">&nbsp;</td></tr>
		<tr>
			<td style="width:  7%; text-align: center; " >&nbsp;</td>
			<td style="width: 26%; text-align: left  ; " >&nbsp;</td>
			<td style="width:  3%; text-align: center; " >&nbsp;</td>
			<td style="width:  8%; text-align: center; " >&nbsp;</td>
			<td style="width: 11%; text-align: center; " >&nbsp;</td>
			<td style="width: 10%; text-align: center; " ><?php echo number_format( $t_cur , 2, '.',',');?></td>
			<td style="width: 10%; text-align: center; " ><?php echo number_format( $t_ovr , 2, '.',',');?></td>
			<td style="width: 11%; text-align: center; " ><?php echo number_format( $t_due , 2, '.',',');?></td>
			<td style="width:  6%; text-align: center; " >&nbsp;</td>
			<td style="width:  8%; text-align: center; " >&nbsp;</td>
		</tr>
	</table>

