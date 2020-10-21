<html>
	<body>
		<div>
			<?php
			switch($header->{'Period Month'}){
				case 1:
					if( !empty( $header->{'Hdmf E3'} ) ){
						$month = 'March';
					}
					elseif( !empty( $header->{'Hdmf E2'}) ) {
						$month = 'February';
					}
					else{
						$month = 'January';
					}
					break;
				case 2:
					if( !empty( $header->{'Hdmf E3'} ) ){
						$month = 'June';
					}
					elseif( !empty( $header->{'Hdmf E2'}) ) {
						$month = 'May';
					}
					else{
						$month = 'April';
					}
					break;
				case 3:
					if( !empty( $header->{'Hdmf E3'} ) ){
						$month = 'September';
					}
					elseif( !empty( $header->{'Hdmf E2'}) ) {
						$month = 'August';
					}
					else{
						$month = 'July';
					}
					break;
				case 4:
					if( !empty( $header->{'Hdmf E3'} ) ){
						$month = 'December';
					}
					elseif( !empty( $header->{'Hdmf E2'}) ) {
						$month = 'November';
					}
					else{
						$month = 'October';
					}
					break;
			}
            
            $t_ee1 = 0;
            $t_er1 = 0;
            $t_ee2 = 0;
            $t_er2 = 0;            
            $t_ee3 = 0;
            $t_er3 = 0;            
            $t_t   = 0; 

			$reg_company = get_registered_company();
			if(is_array($reg_company)) {
				$company = $reg_company['registered_company'];
			}else{
				$company = $header->{'Company'};
			}
			
			?>
			<table>
				<tr>
					<td colspan="11" style="width: 100%" align="center" font-size="12"><h3><?php echo $company; ?></h3></td>
				</tr>
				<tr>
					<td colspan="11" style="width: 100%" align="center" font-size="12"><h3>MEMBERSHIP REGISTRATION / REMITTANCE FORM</h3></td>
				</tr>
				<tr>
					<td colspan="11" style="width: 100%" align="center" font-size="12"><h3><?php echo $month.' '.$header->{'Year'} ; ?></h3></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td colspan="2" rowspan="2" width="33%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Name of Employee</td>
					<td colspan="2" rowspan="2" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">PagIbig Number</td>
					<td colspan="2" width="14%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">1st</td>
					<td colspan="2" width="14%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">2nd</td>
					<td colspan="2" width="14%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">3rd</td>
					<td width="10%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Total</td>
				</tr>
				<tr>
					<td width=" 7%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">EE</td>
					<td width=" 7%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">ER</td>
					<td width=" 7%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">EE</td>
					<td width=" 7%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">ER</td>
					<td width=" 7%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">EE</td>
					<td width=" 7%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">ER</td>
					<td width="10%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">&nbsp;</td>
				</tr>
	<?php	foreach ($result->result_array()as $value) { ?>
					<tr>
						<td colspan="2" width="28%" align="left"  ><?php echo $value['Full Name']; ?></td>
						<td colspan="2" width="15%" align="center"><?php if(empty( $value['Hdmf No']) ){ echo $value['Birth Date']; }else{ echo $value['Hdmf No']; } ; ?></td>
						<td width=" 7%" align="right" ><?php echo number_format( $value['Hdmf E1'] ,2,'.',','); ?></td>
						<td width=" 7%" align="right" ><?php echo number_format( $value['Hdmf C1'] ,2,'.',','); ?></td>
						<td width=" 7%" align="right" ><?php echo number_format( $value['Hdmf E2'] ,2,'.',','); ?></td>
						<td width=" 7%" align="right" ><?php echo number_format( $value['Hdmf C2'] ,2,'.',','); ?></td>
						<td width=" 7%" align="right" ><?php echo number_format( $value['Hdmf E3'] ,2,'.',','); ?></td>
						<td width=" 7%" align="right" ><?php echo number_format( $value['Hdmf C3'] ,2,'.',','); ?></td>
						<td width="10%" align="right" ><?php echo number_format( $value['Hdmf E1'] + $value['Hdmf E2'] + $value['Hdmf E3'] + $value['Hdmf C1'] + $value['Hdmf C2'] + $value['Hdmf C3'] ,2,'.',','); ?></td>
					</tr>
				<?php 
				$t_ee1 += $value['Hdmf E1'];
	            $t_er1 += $value['Hdmf C1'];
	            $t_ee2 += $value['Hdmf E2'];
	            $t_er2 += $value['Hdmf C2'];
	            $t_ee3 += $value['Hdmf E3'];
	            $t_er3 += $value['Hdmf C3'];
	            $t_t   += $value['Hdmf E1'] + $value['Hdmf E2'] + $value['Hdmf E3'] + $value['Hdmf C1'] + $value['Hdmf C2'] + $value['Hdmf C3'];
            } ?>
			</table>
            <table>
	            <tr>
            		<td colspan="3" width="48%" align="left"   style="background-color:#DDDDDD;"><strong>Grand Total :</strong></td>
            		<td>&nbsp;</td>
					<td width=" 7%" align="right"  style="background-color:#DDDDDD;"><strong><?php echo number_format($t_ee1,2,'.',','); ?></strong></td>
					<td width=" 7%" align="right"  style="background-color:#DDDDDD;"><strong><?php echo number_format($t_er1,2,'.',','); ?></strong></td>
					<td width=" 7%" align="right"  style="background-color:#DDDDDD;"><strong><?php echo number_format($t_ee2,2,'.',','); ?></strong></td>
					<td width=" 7%" align="right"  style="background-color:#DDDDDD;"><strong><?php echo number_format($t_er2,2,'.',','); ?></strong></td>
					<td width=" 7%" align="right"  style="background-color:#DDDDDD;"><strong><?php echo number_format($t_ee3,2,'.',','); ?></strong></td>
					<td width=" 7%" align="right"  style="background-color:#DDDDDD;"><strong><?php echo number_format($t_er3,2,'.',','); ?></strong></td>
					<td width="10%" align="right"  style="background-color:#DDDDDD;"><strong><?php echo number_format($t_t,2,'.',','); ?></strong></td>
                </tr>
            </table>
        </div>
	</body>
</html>