<html>
	<body>
		<div>
			<?php

			$gt_phic_e = 0;
            $gt_phic_c = 0;
            $gt_phic_t = 0;            

            $t_phic_e = 0;
            $t_phic_c = 0;
            $t_phic_t = 0;

            $count = 0; 
            $cnt = 1;
            $page_cnt = 1;     
			$cnt_page = 1;
			$user_id = '';
			$no_row = $query->num_rows();
			$no_page = ceil( $no_row / 70 );

			$reg_company = get_registered_company();
			if(is_array($reg_company)) {
				$company = $reg_company['registered_company'];
			}else{
				$company = $header->{'Company'};
			}

			foreach ($query->result() as $key => $value) {
				if(empty($user_id)) 
				{ ?>
					<table>
						<tr>
							<td style="width: 50%" align="left" font-size="6">Rundate: <?php echo date('F d, Y')?></td>
							<td style="width: 50%" align="right" font-size="6">Page <?php echo $page_cnt; ?> of <?php echo $no_page; ?></td>
						</tr>
						<tr>
							<td style="width: 100%" align="center" font-size="12"><h3><?php echo $company; ?></h3></td>
						</tr>
						<tr>
							<td style="width: 100%" align="center" font-size="12"><h3>PHILHEALTH PREMIUM CONTRIBUTION</h3></td>
						</tr>
						<tr>
							<td style="width: 100%" align="center" font-size="12"><h3><?php echo date('F Y', strtotime($header->{'Payroll Date'}) ); ?></h3></td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td width="35%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Name of Employee</td>
							<td width="18%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">PhilHealth Number</td>
							<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Employee</td>
							<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Employer</td>
							<td width="17%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Total</td>
						</tr>
					</table><?php 
				} 
				if ($cnt_page > 70 ) { ?>
					<table>
                    	<tr>
                    		<td width="53%" align="left" style="background-color:#DDDDDD;"><strong>Page Total</strong></td>
		                    <td width="15%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_phic_e,2,'.',','); ?></strong></td>
		                    <td width="15%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_phic_c,2,'.',','); ?></strong></td>
		                    <td width="17%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_phic_t,2,'.',','); ?></strong></td>
		                </tr>
		            </table><?php 
		            $page_cnt = $page_cnt+1;     
		            $t_phic_e = 0;
                    $t_phic_c = 0;
                    $t_phic_t = 0;
                    $cnt_page = 1; ?>            
		            <div style="page-break-before: always;">&nbsp;</div>
                    <table>
                    	<tr>
							<td width="50%" align="left" font-size="6">Rundate: <?php echo date('F d, Y')?></td>
							<td width="50%" align="right" font-size="6">Page: <?php echo $page_cnt; ?></td>
						</tr>
						<tr>
							<td style="width: 100%" align="center" font-size="12"><h3><?php echo $company; ?></h3></td>
						</tr>
						<tr>
							<td width="100%" align="center" font-size="12"><h3>PHILHEALTH PREMIUM CONTRIBUTION</h3></td>
						</tr>
						<tr>
							<td width="100%" align="center" font-size="12"><h3><?php echo date('F Y', strtotime($header->{'Payroll Date'}) ); ?></h3></td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td width="35%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Name of Employee</td>
							<td width="18%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">PhilHealth Number</td>
							<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Employee</td>
							<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Employer</td>
							<td width="17%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Total</td>
						</tr>
					</table>
                    <?php 
				} ?>
				<table>
					<tr>
						<td width=" 5%" align="left"  ><?php echo $cnt++; ?>.</td>
						<td width="30%" align="left"  ><?php echo $value->{'Full Name'}; ?></td>
						<td width="18%" align="center"><?php echo $value->{'Phic No'}; ?></td>
						<td width="15%" align="right" ><?php echo number_format( $value->{'Phic Emp'} ,2,'.',','); ?></td>
						<td width="15%" align="right" ><?php echo number_format( $value->{'Phic Com'} ,2,'.',','); ?></td>
						<td width="17%" align="right" ><?php echo number_format( $value->{'Phic Emp'} + $value->{'Phic Com'} ,2,'.',','); ?></td>
					</tr>
				</table>
				<?php 
				$t_phic_e += $value->{'Phic Emp'};
                $t_phic_c += $value->{'Phic Com'};
                $t_phic_t += $value->{'Phic Emp'} + $value->{'Phic Com'};

                $gt_phic_e += $value->{'Phic Emp'};
                $gt_phic_c += $value->{'Phic Com'};
                $gt_phic_t += $value->{'Phic Emp'} + $value->{'Phic Com'};

                $user_id = $value->{'User Id'};
                $cnt_page++;
			}
			if($cnt_page < 70) {
                for ($i=$cnt_page; $i < 71; $i++) { ?> 
                    <table>        
            	        <tr>
		                    <td width=" 5%" align="left"  ></td> 
		                    <td width="97%" align="right" >&nbsp;</td> 
                  		</tr>
                    </table><?php
                    
                }
            } ?>
            <table>
	            <tr>
            		<td width="53%" align="left" style="background-color:#DDDDDD;"><strong>Page Total</strong></td>
                    <td width="15%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_phic_e,2,'.',','); ?></strong></td>
                    <td width="15%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_phic_c,2,'.',','); ?></strong></td>
                    <td width="17%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_phic_t,2,'.',','); ?></strong></td>
                </tr>
	            <tr>
            		<td width="53%" align="left" style="background-color:#DDDDDD;"><strong>Grand Total</strong></td>
                    <td width="15%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($gt_phic_e,2,'.',','); ?></strong></td>
                    <td width="15%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($gt_phic_c,2,'.',','); ?></strong></td>
                    <td width="17%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($gt_phic_t,2,'.',','); ?></strong></td>
                </tr>
            </table>
        </div>
	</body>
</html>