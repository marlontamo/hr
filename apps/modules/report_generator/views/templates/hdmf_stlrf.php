<html>
	<body>
		<div>
			<?php 
			$gt_amt = 0;
			$t_amt = 0;

            $count = 0; 
            $cnt = 0;
            $cnt_emp = 0;
            $page_cnt = 0;     
			$cnt_page = 1;
			$user_id = '';
			$no_row = $query->num_rows();
			$no_page = ceil( $no_row / 30 );

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
						<tr><td width="100%" style="font-size:35">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td></tr>
						<tr><td width="100%">&nbsp;</td></tr>
						
						<tr><td width="100%" style="font-size:15;">&nbsp;</td> </tr>
						<tr>
							<!-- EMPLOYERS HDMF NO -->
							<td width="65.5%" align="left">&nbsp;</td>
							<td width="30%" align="center"><?php echo $header->{'Co Hdmf'}; ?></td>
							<td width="4.5%" align="left">&nbsp;</td>
						</tr>
						<tr><td width="100%">&nbsp;</td></tr>
						<tr><td width="100%">&nbsp;</td></tr>
						<tr><td width="100%">&nbsp;</td></tr>
						<tr><td width="100%">&nbsp;</td></tr>
						<tr>
							<td width="4.5%" align="left">&nbsp;</td> 
							<td width=" 91%" align="left"><?php echo $company; ?></td> 
							<td width="4.5%" align="left">&nbsp;</td> 
						</tr>
						<tr><td width="100%" style="font-size:14">&nbsp;</td> </tr>
						<tr>
							<td width="4.5%" align="left">&nbsp;</td> 
							<td width="65.5%" align="left"><?php echo $header->{'Co Address'}?></td> 
							
							<td width="30%" style="text-align: center;"> <?php echo date('F Y', strtotime($header->{'Year'}.'-'.$header->{'Month'}.'-01') ); ?></td>
						</tr>
						<tr><td width="100%" style="font-size:10;">&nbsp;</td> </tr>
						<tr>
							<td width="4.5%" align="left">&nbsp;</td> 
							<td width="63.5%" align="left"></td> 
							<td width="10%" align="center"><?php echo $header->{'Zipcode'}; ?></td>	
							<td width="20%" style="text-align: center;"> <?php echo $header->{'Contact No'}; ?></td>
						</tr>
						<tr><td width="100%" style="font-size:27;"></td> </tr>
					</table><?php 
				} 
				if ($cnt_page > 30){
		            $page_cnt = $page_cnt+1;     ?>
		            <table>
		            	<tr>
                     		<td width="25%" align="right" style="font-size:6;"></td>
                     		<td width="55.5%" align="left" style="font-size:8;"><?php echo $cnt;?></td>
							<td width="15%" align="right"   style="font-size:8;"><strong><?php echo number_format( $t_amt, 2, '.', ',' ); ?></strong></td>
							<td width="4.5%" align="left"   style="font-size:6;">&nbsp;</td>
                     	</tr>
					</table><?php
					$cnt = 0;
		            $t_amt = 0;
                    $cnt_page = 1; ?>
                    
					<div style="page-break-before: always;">&nbsp;</div>
                    <table>
						<tr><td width="100%" style="font-size:35">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td></tr>
						<tr><td width="100%">&nbsp;</td></tr>
						
						<tr><td width="100%" style="font-size:15;">&nbsp;</td> </tr>
						<tr>
							<!-- EMPLOYERS HDMF NO -->
							<td width="65.5%" align="left">&nbsp;</td>
							<td width="30%" align="center"><?php echo $header->{'Co Hdmf'}; ?></td>
							<td width="4.5%" align="left">&nbsp;</td>
						</tr>
						<tr><td width="100%">&nbsp;</td></tr>
						<tr><td width="100%">&nbsp;</td></tr>
						<tr><td width="100%">&nbsp;</td></tr>
						<tr><td width="100%">&nbsp;</td></tr>
						<tr>
							<td width="4.5%" align="left">&nbsp;</td> 
							<td width=" 91%" align="left"><?php echo $company; ?></td> 
							<td width="4.5%" align="left">&nbsp;</td> 
						</tr>
						<tr><td width="100%" style="font-size:14">&nbsp;</td> </tr>
						<tr>
							<td width="4.5%" align="left">&nbsp;</td> 
							<td width="65.5%" align="left"><?php echo $header->{'Co Address'}?></td> 
							
							<td width="30%" style="text-align: center;"> <?php echo date('F Y', strtotime($header->{'Year'}.'-'.$header->{'Month'}.'-01') ); ?></td>
						</tr>
						<tr><td width="100%" style="font-size:10;">&nbsp;</td> </tr>
						<tr>
							<td width="4.5%" align="left">&nbsp;</td> 
							<td width="63.5%" align="left"></td> 
							<td width="10%" align="center"><?php echo $header->{'Zipcode'}; ?></td>	
							<td width="20%" style="text-align: center;"> <?php echo $header->{'Contact No'}; ?></td>
						</tr>
						<tr><td width="100%" style="font-size:27;"></td> </tr>
					</table><?php
				}
				?>
				<table>
					<tr>
						<td width="	  4%" align="left"  style="font-size:6;"></td>
						<td width="	 10%" align="center" style="font-size:6; "><?php echo $value->{'Hdmf No'}; ?></td>
						<td width="13.5%" align="center" style="font-size:6; "></td>
						<td width="10.5%" align="left"   style="font-size:6; "><?php echo $value->{'Lastname'}; ?></td>
						<td width="  11%" align="left"   style="font-size:6; "><?php echo $value->{'Firstname'};?></td>
						<td width="  10%" align="left"   style="font-size:6; "><?php echo $value->{'Suffix'};?></td>
						<td width="  11%" align="left"   style="font-size:6; "><?php echo $value->{'Middlename'};?></td>
						<td width=" 8.5%" align="center"   style="font-size:6; "><?php echo $value->{'Loan Code'};?></td>
						<td width="   9%" align="right"  style="font-size:6;"><?php echo number_format($value->{'Amount'},2,'.',','); ?></td>
						<td width="16.3%" align="left"   style="font-size:6;">&nbsp;</td>
					</tr>
				</table>

				<?php 
					switch ($cnt_page) {
						case '11':
						case '19':
						case '24': ?>
							<table><tr><td width="100%" style="font-size:4;"></td></tr></table>
							<?php
							break;
						default: ?>
							<table><tr><td width="100%" style="font-size:3;"></td></tr></table>
							<?php
							break;
					}
				$t_amt += $value->{'Amount'};
				$gt_amt += $value->{'Amount'};
                $user_id = $value->{'User Id'};
                $cnt_page++;		
                $cnt++;				
                $cnt_emp++;
			}
			if($cnt_page < 30) {
                for ($i=$cnt_page; $i < 30; $i++) { 
                	switch ($i) {
						case '11':
						case '19':
						case '24':
							?>
							<table><tr><td width="100%" align="center" style="font-size:6;">&nbsp;</td></tr></table>
							<table><tr><td width="100%" align="center" style="font-size:4;">&nbsp;</td> </tr></table>
							<?php
							break;
						
						default:
							?>
							<table><tr><td width="100%" align="center" style="font-size:6;">&nbsp;</td> </tr></table>
							<table><tr><td width="100%" align="center" style="font-size:3;">&nbsp;</td> </tr></table>
							<?php
							break;
					}                	
                }
            } ?>
            <table>
            	<tr><td width="100%" align="left"   style="font-size:10;">&nbsp;</td></tr>
	            <tr>
					<td width="25%" align="right" style="font-size:6;"></td>
             		<td width="55.5%" align="left" style="font-size:8;"><?php echo $cnt;?></td>
					<td width="15%" align="right"   style="font-size:8;"><strong><?php echo number_format( $t_amt, 2, '.', ',' ); ?></strong></td>
					<td width="4.5%" align="left"   style="font-size:6;">&nbsp;</td>
                </tr>

                <tr><td width="100%" align="left"   style="font-size:2;">&nbsp;</td></tr>
                <tr>
                	<td width="25%" align="right" style="font-size:6;"></td>
             		<td width="55.5%" align="left" style="font-size:8;"><?php echo $cnt_emp;?></td>
					<td width="15%" align="right"   style="font-size:8;"><strong><?php echo number_format( $gt_amt, 2, '.', ',' ); ?></strong></td>
					<td width="4.5%" align="left"   style="font-size:6;">&nbsp;</td>
                </tr>
                
            </table>
        </div>
	</body>
</html>