<html>
	<body>
		<div>
			<?php

            $count = 0; 
            $cnt = 1;
            $page_cnt = 1;     
			$cnt_page = 1;
			$user_id = '';
			$space = 0;
			$no_row = $query->num_rows();
			$no_page = ceil( $no_row / 65 );
			foreach ($query->result() as $key => $value) {
				if( $user_id == $value->{'Id Number'} ){
					$id_number = '';
					$full_name = '';
					$space = 0;
				} else {
					$id_number = $value->{'Id Number'};
					$full_name = $value->{'Full Name'};
				}
				if(empty($user_id)) 
				{ ?>
					<table>
						<!-- <tr><td>&nbsp;</td></tr> -->
						<tr>
		            		<td width="2%">&nbsp;</td>
							<td style="width: 48%" align="left" font-size="6">Rundate: <?php echo date('F d, Y')?></td>
							<td style="width: 48%" align="right" font-size="6">Page <?php echo $page_cnt; ?> of <?php echo $no_page; ?></td>
							<td width="2%">&nbsp;</td>
						</tr>
						<tr>
							<td style="width: 100%" align="center" font-size="12"><h3><?php echo $value->{'Company'}; ?></h3></td>
						</tr>
						<tr>
							<td style="width: 100%" align="center" font-size="10"><h3>PAYROLL ATTENDANCE ADJUSTMENT</h3></td>
						</tr>
						<tr>
							<td style="width: 100%" align="center" font-size="9"><h3><?php echo date('F d, Y', strtotime($value->{'Payroll Date'}) ); ?></h3></td>
						</tr>
						<tr><td>&nbsp;</td></tr>
					</table>
					<table>
		            	<tr>
		            		<td width="2%">&nbsp;</td>
		            		<td width="8%" align="left"><b>ID Number</b></td>
		            		<td width="25%" align="left"><b>Employee</b></td>
		            		<td width="27%" align="left"><b>Transaction</b></td>
		            		<td width="11.5%" align="center"><b>Date Affected</b></td>
		            		<td width="11.5%" align="center"><b>Org. Pay Date</b></td>
		            		<td width="10%" align="right"><b>Qty.</b></td>
		            	</tr>
		            	<tr><td width="100%" style="border-bottom: 1px solid black; font-size:2">&nbsp;</td></tr>
		            	<tr><td width="100%" style="font-size:2">&nbsp;</td></tr>
		            </table>
					<?php 
				} 
				if ($cnt_page > 65 ) { ?>
					<?php 
		            $page_cnt = $page_cnt+1;     
                    $cnt_page = 1; ?>
                    <table>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;</td></tr>
						
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;</td></tr>
						
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
		            		<td width="2%">&nbsp;</td>
							<td style="width: 48%" align="left" font-size="6">Rundate: <?php echo date('F d, Y')?></td>
							<td style="width: 48%" align="right" font-size="6">Page <?php echo $page_cnt; ?> of <?php echo $no_page; ?></td>
		            		<td width="2%">&nbsp;</td>
						</tr>
						<tr>
							<td style="width: 100%" align="center" font-size="12"><h3><?php echo $value->{'Company'}; ?></h3></td>
						</tr>
						<tr>
							<td style="width: 100%" align="center" font-size="10"><h3>PAYROLL ATTENDANCE ADJUSTMENT</h3></td>
						</tr>
						<tr>
							<td style="width: 100%" align="center" font-size="9"><h3><?php echo date('F d, Y', strtotime($value->{'Payroll Date'}) ); ?></h3></td>
						</tr>
						<tr><td>&nbsp;</td></tr>
					</table>
					<table>
		            	<tr>
		            		<td width="2%">&nbsp;</td>
		            		<td width="8%" align="left"><b>ID Number</b></td>
		            		<td width="25%" align="left"><b>Employee</b></td>
		            		<td width="27%" align="left"><b>Transaction</b></td>
		            		<td width="11.5%" align="center"><b>Date Affected</b></td>
		            		<td width="11.5%" align="center"><b>Org. Pay Date</b></td>
		            		<td width="10%" align="right"><b>Qty.</b></td>
		            	</tr>
		            	<tr><td width="100%" style="border-bottom: 1px solid black; font-size:2">&nbsp;</td></tr>
		            	<tr><td width="100%" style="font-size:2">&nbsp;</td></tr>
		            </table>
                    <?php 
				} ?>
				<?php if($space == 1){ ?>
					<hr>
				<?php } ?>
				<table>
					<tr>
		            	<td width="2%">&nbsp;</td>
						<td width="8%" align="left"  ><?php echo $id_number; ?></td>
						<td width="25%" align="left"  ><?php echo $full_name; ?></td>
						<td width="27%" align="left"><?php echo $value->{'Transaction Label'}; ?></td>
						<td width="11.5%" align="center" ><?php echo date("Y-m-d", strtotime( $value->{'Date'} ) ); ?></td>
						<td width="11.5%" align="center" ><?php echo date("Y-m-d", strtotime( $value->{'Original Payroll Date'} ) ); ?></td>
						<td width="10%" align="right" ><?php echo $value->{'Quantity'}; ?></td>
					</tr>
				</table>
				<?php 
                $user_id = $value->{'Id Number'};
                $space = 1;
                $cnt_page++;
			}?>
        </div>
	</body>
</html>