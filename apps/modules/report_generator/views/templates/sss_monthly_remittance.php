<html>
	<body>
		<div>
			<?php

			$gt_sss_e = 0;
            $gt_sss_c = 0;
            $gt_sss_ec = 0;
            $gt_sss_t = 0;            

            $t_sss_e = 0;
            $t_sss_c = 0;
            $t_sss_ec = 0;
            $t_sss_t = 0;
            $count = 0; 
            $cnt = 1;
            $page_cnt = 1;     
			$cnt_page = 1;
			$user_id = '';
			$no_row = $result->num_rows();
			$no_page = ceil( $no_row / 70 );

			$reg_company = get_registered_company();
			if(is_array($reg_company)) {
				$company = $reg_company['registered_company'];
			}else{
				$company = $header->{'Company'};
			}

			foreach ($result->result() as $key => $value) {
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
							<td style="width: 100%" align="center" font-size="12"><h3>SSS PREMIUM CONTRIBUTION</h3></td>
						</tr>
						<tr>
							<td style="width: 100%" align="center" font-size="12"><h3><?php echo date('F Y', strtotime($header->{'Payroll Date'}) ); ?></h3></td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td width="34%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Name of Employee</td>
							<td width="18%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">SSS Number</td>
							<td width="13%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Employee</td>
							<td width="13%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Employer</td>
							<td width=" 7%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">EC</td>
							<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Total</td>
						</tr>
					</table><?php 
				} 
				if ($cnt_page > 70 ) { ?>
					<table>
                    	<tr>
                    		<td width="52%" align="left" style="background-color:#DDDDDD;"><strong>Page Total</strong></td>
		                    <td width="13%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_sss_e,2,'.',','); ?></strong></td>
		                    <td width="13%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_sss_c,2,'.',','); ?></strong></td>
		                    <td width=" 7%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_sss_ec,2,'.',','); ?></strong></td>
		                    <td width="15%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_sss_t,2,'.',','); ?></strong></td>
		                </tr>
		            </table><?php 
		            $page_cnt = $page_cnt+1;     
		            $t_sss_e = 0;
                    $t_sss_c = 0;
                    $t_sss_ec = 0;
                    $t_sss_t = 0;
                    $cnt_page = 1; ?>
                    <div style="page-break-before: always;">&nbsp;</div>
                    <table>
						<tr>
							<td width="50%" align="left" font-size="6">Rundate: <?php echo date('F d, Y')?></td>
							<td width="50%" align="right" font-size="6">Page: <?php echo $page_cnt; ?></td>
						</tr>
						<tr>
							<td width="100%" align="center" font-size="12"><h3><?php echo $company; ?></h3></td>
						</tr>
						<tr>
							<td width="100%" align="center" font-size="12"><h3>SSS PREMIUM CONTRIBUTION</h3></td>
						</tr>
						<tr>
							<td width="100%" align="center" font-size="12"><h3><?php echo date('F Y', strtotime($header->{'Payroll Date'}) ); ?></h3></td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td width="34%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Name of Employee</td>
							<td width="18%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">SSS Number</td>
							<td width="13%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Employee</td>
							<td width="13%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Employer</td>
							<td width=" 7%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">EC</td>
							<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Total</td>
						</tr>
					</table>
                    <?php 
				} ?>
				<table>
					<tr>
						<td width=" 5%" align="left"  ><?php echo $cnt++; ?>.</td>
						<td width="29%" align="left"  ><?php echo $value->{'Full Name'}; ?></td>
						<td width="18%" align="center"><?php echo $value->{'Sss No'}; ?></td>
						<td width="13%" align="right" ><?php echo number_format( $value->{'Sss Emp'} ,2,'.',','); ?></td>
						<td width="13%" align="right" ><?php echo number_format( $value->{'Sss Com'} ,2,'.',','); ?></td>
						<td width=" 7%" align="right" ><?php echo number_format( $value->{'Sss Ecc'} ,2,'.',','); ?></td>
						<td width="15%" align="right" ><?php echo number_format( $value->{'Sss Emp'} + $value->{'Sss Com'} + $value->{'Sss Ecc'} ,2,'.',','); ?></td>
					</tr>
				</table>
				<?php 
				$t_sss_e += $value->{'Sss Emp'};
                $t_sss_c += $value->{'Sss Com'};
                $t_sss_ec += $value->{'Sss Ecc'};
                $t_sss_t += $value->{'Sss Emp'} + $value->{'Sss Com'} + $value->{'Sss Ecc'};
                $gt_sss_e += $value->{'Sss Emp'};
                $gt_sss_c += $value->{'Sss Com'};
                $gt_sss_ec += $value->{'Sss Ecc'};
                $gt_sss_t += $value->{'Sss Emp'} + $value->{'Sss Com'} + $value->{'Sss Ecc'};
                $user_id = $value->{'User Id'};
                $cnt_page++;
			}
			if($cnt_page <= 70) {
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
            		<td width="52%" align="left" style="background-color:#DDDDDD;"><strong>Page Total</strong></td>
                    <td width="13%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_sss_e,2,'.',','); ?></strong></td>
                    <td width="13%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_sss_c,2,'.',','); ?></strong></td>
                    <td width=" 7%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_sss_ec,2,'.',','); ?></strong></td>
                    <td width="15%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_sss_t,2,'.',','); ?></strong></td>
                </tr>
	            <tr>
            		<td width="52%" align="left" style="background-color:#DDDDDD;"><strong>Grand Total</strong></td>
                    <td width="13%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($gt_sss_e,2,'.',','); ?></strong></td>
                    <td width="13%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($gt_sss_c,2,'.',','); ?></strong></td>
                    <td width=" 7%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($gt_sss_ec,2,'.',','); ?></strong></td>
                    <td width="15%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($gt_sss_t,2,'.',','); ?></strong></td>
                </tr>
            </table>
        </div>
	</body>
</html>