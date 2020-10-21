
<?php
if( $page_count > 1 ){
	?>
	<!-- FOR PAGE BREAK -->
	<div style="page-break-before: always;">&nbsp;</div><?php
}else{
	?><div>&nbsp;</div><?php
}
?>

<table>
	<tr><td style="width: 100%; text-align: left ; font-size: 10;"><strong><?php echo $company; ?></strong></td></tr>
	<tr><td style="width: 100%; text-align: left ; font-size: 10;"><strong><?php echo $title; ?></strong></td></tr>
	<tr><td style="width: 100%; text-align: left ; font-size: 8;"><i>For the Year : <?php echo $year; ?></i></td></tr>
	<tr><td style="width: 100%; text-align: left ; font-size: 5;">&nbsp;</td></tr>
</table>

<table cellpadding="2">
	<tr>
		<td style="width:  7%; text-align: left ; " ><strong>Run Date :</strong></td>
		<td style="width:  8%; text-align: right; " ><?php echo date("m/d/Y"); ?></td>
		<td style="width:  5%; text-align: left ; " ><strong>Pay Type :</strong></td>
		<td style="width: 30%; text-align: left ; " ><?php echo $paytype; ?></td>
		<td style="width:  5%; text-align: left ; " ><strong>&nbsp;</strong></td>
		<td style="width: 25%; text-align: left ; " >&nbsp;</td>
		<td style="width: 12%; text-align: left ; " ><strong>Page No :</strong></td>
		<td style="width:  8%; text-align: left ; " ><?php echo $page_count; ?></td>
	</tr>
	<tr>
		<td style="width:  7%; text-align: left ; " ><strong>Employee No.:</strong></td>
		<td style="width:  8%; text-align: right; " ><?php echo $id_number; ?></td>
		<td style="width:  5%; text-align: left ; " ><strong>Name :</strong></td>
		<td style="width: 30%; text-align: left ; " ><?php echo $full_name; ?></td>
		<td style="width:  5%; text-align: left ; " ><strong>Tax Status</strong></td>
		<td style="width: 25%; text-align: left ; " ><?php echo $taxcode; ?></td>
		<td style="width: 12%; text-align: left ; " ><strong>No. of Dependent :</strong></td>
		<td style="width:  8%; text-align: left ; " ><?php echo $dependent; ?></td>
	</tr>
	<tr><td style="width: 100%; border-bottom: 1px solid black; font-size: 3">&nbsp;</td></tr>
	<tr><td style="width: 100%; font-size: 2">&nbsp;</td></tr>
	<tr>
		<td style="width: 13%; text-align: left  ;"><strong>DESCRIPTION</strong></td>
		<td style="width:6.5%; text-align: center;"><strong>JANUARY</strong></td>
		<td style="width:6.5%; text-align: center;"><strong>FEBRUARY</strong></td>
		<td style="width:6.5%; text-align: center;"><strong>MARCH</strong></td>
		<td style="width:6.5%; text-align: center;"><strong>APRIL</strong></td>
		<td style="width:6.5%; text-align: center;"><strong>MAY</strong></td>
		<td style="width:6.5%; text-align: center;"><strong>JUNE</strong></td>
		<td style="width:6.5%; text-align: center;"><strong>JULY</strong></td>
		<td style="width:6.5%; text-align: center;"><strong>AUGUST</strong></td>
		<td style="width:6.5%; text-align: center;"><strong>SEPTEMBER</strong></td>
		<td style="width:6.5%; text-align: center;"><strong>OCTOBER</strong></td>
		<td style="width:6.5%; text-align: center;"><strong>NOVEMBER</strong></td>
		<td style="width:6.5%; text-align: center;"><strong>DECEMBER</strong></td>
		<td style="width:  9%; text-align: right ;"><strong>TOTAL</strong></td>

	</tr>
	<tr><td style="width: 100%; font-size: 2">&nbsp;</td></tr>
	<tr><td style="width: 100%; border-top: 1px solid black; font-size: 3">&nbsp;</td></tr>	
</table>
<?php 
	$t_jan = 0;
	$t_feb = 0;
	$t_mar = 0;
	$t_apr = 0;
	$t_may = 0;
	$t_jun = 0;
	$t_jul = 0;
	$t_aug = 0;
	$t_sep = 0;
	$t_oct = 0;
	$t_nov = 0;
	$t_dec = 0;
	$t_tot = 0;
	// $row = $result->row();
	$category = '';
	foreach ($result as $value) {
		$l_total = $value->january + $value->february + $value->march + $value->april + $value->may + $value->june + $value->july + $value->august + $value->september + $value->october + $value->november + $value->december;
		if($category != $value->category && $category != '' ) {
			if( $value->category == 'Deductions' ){
				$label = "Total Earnings";
			} elseif( $value->category == 'Benefits' ){
				$label = "Total Deductions";
			} elseif( $value->category == 'ANetpay' ){
				$label = "Total Non Tax Income";
			}
			?>
			<table>
				<tr><td style="width: 100%; border-bottom: 1px solid black; font-size: 2">&nbsp;</td></tr>
				<tr><td style="width: 100%; font-size: 1">&nbsp;</td></tr>
				<tr>
					<td style="width: 13%; text-align: left ;"><strong><?php echo $label; ?></strong></td>
					<td style="width:6.5%; text-align: right;"><strong><?php echo $t_jan != 0 ? number_format( $t_jan , 2 ,'.',',' ) : "-"; ?></strong></td>
					<td style="width:6.5%; text-align: right;"><strong><?php echo $t_feb != 0 ? number_format( $t_feb , 2 ,'.',',' ) : "-"; ?></strong></td>
					<td style="width:6.5%; text-align: right;"><strong><?php echo $t_mar != 0 ? number_format( $t_mar , 2 ,'.',',' ) : "-"; ?></strong></td>
					<td style="width:6.5%; text-align: right;"><strong><?php echo $t_apr != 0 ? number_format( $t_apr , 2 ,'.',',' ) : "-"; ?></strong></td>
					<td style="width:6.5%; text-align: right;"><strong><?php echo $t_may != 0 ? number_format( $t_may , 2 ,'.',',' ) : "-"; ?></strong></td>
					<td style="width:6.5%; text-align: right;"><strong><?php echo $t_jun != 0 ? number_format( $t_jun , 2 ,'.',',' ) : "-"; ?></strong></td>
					<td style="width:6.5%; text-align: right;"><strong><?php echo $t_jul != 0 ? number_format( $t_jul , 2 ,'.',',' ) : "-"; ?></strong></td>
					<td style="width:6.5%; text-align: right;"><strong><?php echo $t_aug != 0 ? number_format( $t_aug , 2 ,'.',',' ) : "-"; ?></strong></td>
					<td style="width:6.5%; text-align: right;"><strong><?php echo $t_sep != 0 ? number_format( $t_sep , 2 ,'.',',' ) : "-"; ?></strong></td>
					<td style="width:6.5%; text-align: right;"><strong><?php echo $t_oct != 0 ? number_format( $t_oct , 2 ,'.',',' ) : "-"; ?></strong></td>
					<td style="width:6.5%; text-align: right;"><strong><?php echo $t_nov != 0 ? number_format( $t_nov , 2 ,'.',',' ) : "-"; ?></strong></td>
					<td style="width:6.5%; text-align: right;"><strong><?php echo $t_dec != 0 ? number_format( $t_dec , 2 ,'.',',' ) : "-"; ?></strong></td>
					<td style="width:  9%; text-align: right;"><strong><?php echo $t_tot != 0 ? number_format( $t_tot , 2 ,'.',',' ) : "-"; ?></strong></td>

				</tr>
				<tr><td style="width: 100%; font-size: 1">&nbsp;</td></tr>
				<tr><td style="width: 100%; border-top: 1px solid black; font-size: 2">&nbsp;</td></tr>	
			</table>
			<?php
			$t_jan = 0;
			$t_feb = 0;
			$t_mar = 0;
			$t_apr = 0;
			$t_may = 0;
			$t_jun = 0;
			$t_jul = 0;
			$t_aug = 0;
			$t_sep = 0;
			$t_oct = 0;
			$t_nov = 0;
			$t_dec = 0;
			$t_tot = 0;
		}?>
		<table>
			<tr>
				<td style="width: 13%; text-align: left ;"><?php echo $value->description; ?></td>
				<td style="width:6.5%; text-align: right;"><?php echo $value->january != 0 ? number_format( $value->january , 2 , '.',',' ): "-"; ?></td>
				<td style="width:6.5%; text-align: right;"><?php echo $value->february != 0 ? number_format( $value->february , 2 , '.',',' ): "-"; ?></td>
				<td style="width:6.5%; text-align: right;"><?php echo $value->march != 0 ? number_format( $value->march , 2 , '.',',' ): "-"; ?></td>
				<td style="width:6.5%; text-align: right;"><?php echo $value->april != 0 ? number_format( $value->april , 2 , '.',',' ): "-"; ?></td>
				<td style="width:6.5%; text-align: right;"><?php echo $value->may != 0 ? number_format( $value->may , 2 , '.',',' ): "-"; ?></td>
				<td style="width:6.5%; text-align: right;"><?php echo $value->june != 0 ? number_format( $value->june , 2 , '.',',' ): "-"; ?></td>
				<td style="width:6.5%; text-align: right;"><?php echo $value->july != 0 ? number_format( $value->july , 2 , '.',',' ): "-"; ?></td>
				<td style="width:6.5%; text-align: right;"><?php echo $value->august != 0 ? number_format( $value->august , 2 , '.',',' ): "-"; ?></td>
				<td style="width:6.5%; text-align: right;"><?php echo $value->september != 0 ? number_format( $value->september , 2 , '.',',' ): "-"; ?></td>
				<td style="width:6.5%; text-align: right;"><?php echo $value->october != 0 ? number_format( $value->october , 2 , '.',',' ): "-"; ?></td>
				<td style="width:6.5%; text-align: right;"><?php echo $value->november != 0 ? number_format( $value->november , 2 , '.',',' ): "-"; ?></td>
				<td style="width:6.5%; text-align: right;"><?php echo $value->december != 0 ? number_format( $value->december , 2 , '.',',' ): "-"; ?></td>
				<td style="width:  9%; text-align: right;"><?php echo $l_total != 0 ? number_format( $l_total , 2 , '.',',' ) : "-"; ?></td>

			</tr>
		</table><?php
		$t_jan += $value->january;
		$t_feb += $value->february;
		$t_mar += $value->march;
		$t_apr += $value->april;
		$t_may += $value->may;
		$t_jun += $value->june;
		$t_jul += $value->july;
		$t_aug += $value->august;
		$t_sep += $value->september;
		$t_oct += $value->october;
		$t_nov += $value->november;
		$t_dec += $value->december;
		$t_tot += $value->january + $value->february + $value->march + $value->april + $value->may + $value->june + $value->july + $value->august + $value->september + $value->october + $value->november + $value->december;
		$category = $value->category;
	}
?>


