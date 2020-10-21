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
			$no_page = ceil( $no_row / 40 );

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
						<tr>
							<td width="22.5%">&nbsp;</td>
							<td width="78%">X</td>
						</tr>
						<tr>
							<td width="70%">&nbsp;</td> 
							<td width="30%" style="text-align: center;"> <?php echo date('F Y', strtotime($header->{'Year'}.'-'.$header->{'Month'}.'-01') ); ?></td>
						</tr>
						<tr><td width="100%" style="font-size:15;">&nbsp;</td> </tr>
						<tr>
							<td width="3.5%" align="left">&nbsp;</td> 
							<td width="45%" align="left"><?php echo $company; ?></td> 
							<td width="12%" align="left">&nbsp;</td> 
							<!-- EMPLOYERS HDMF NO -->
							<td width="12%" align="center"><?php echo $header->{'Co Sss'}; ?></td>
							<td width="27.5%" align="left">&nbsp;</td>
						</tr>
						<tr><td width="100%" style="font-size:17;">&nbsp;</td> </tr>
						<tr>
							<td width="3.5%" align="left">&nbsp;</td> 
							<td width="57%" align="left"><?php echo $header->{'Co Address'}?></td> 
							<!-- EMPLOYERS HDMF NO -->
							<td width="12%" align="center"><?php echo $header->{'Zipcode'}; ?></td>
							<td width="27.5%" align="left">&nbsp;</td>
						</tr>
						<tr><td width="100%" style="font-size:27;"></td> </tr>
					</table><?php 
				} 
				if ($cnt_page > 40){
		            $page_cnt = $page_cnt+1;     ?>
		            <table>
		            	<tr><td style="font-size:2"></td></tr>
                     	<tr>
                     		<td width="15%" align="right" style="font-size:6;"></td>
                     		<td width="58.5%" align="left" style="font-size:8;"><?php echo $cnt;?></td>
							<td width="9.2%" align="right"   style="font-size:8;"><strong><?php echo number_format( $t_amt, 2, '.', ',' ); ?></strong></td>
							<td width="17.3%" align="left"   style="font-size:6;">&nbsp;</td>
                     	</tr>
                     	<tr><td></td></tr>
                     	<tr><td></td></tr>
                     	<tr><td></td></tr>
                     	<tr><td></td></tr>
                     	<tr><td></td></tr>
                     	<tr><td style="font-size:10"></td></tr>
                     	
						<tr>
							<td style="width: 80%" align="left"></td>
							<td style="width: 10%" align="center"><?php echo $page_cnt; ?></td>
							<td style="width: 10%" align="left"><?php echo $no_page; ?></td>
						</tr>
					</table><?php
					$cnt = 0;
		            $t_amt = 0;
                    $cnt_page = 1; ?>
                    
					<div style="page-break-before: always;">&nbsp;</div>
                    <table>
						<tr><td width="100%" style="font-size:35">&nbsp;</td> </tr>
						<tr>
							<td width="22.5%">&nbsp;</td>
							<td width="78%">X</td>
						</tr>
						<tr>
							<td width="70%">&nbsp;</td> 
							<td width="30%" style="text-align: center;"> <?php echo date('F Y', strtotime($header->{'Year'}.'-'.$header->{'Month'}.'-01') ); ?></td>
						</tr>
						<tr><td width="100%" style="font-size:15;">&nbsp;</td> </tr>
						<tr>
							<td width="3.5%" align="left">&nbsp;</td> 
							<td width="45%" align="left"><?php echo $company; ?></td> 
							<td width="12%" align="left">&nbsp;</td> 
							<!-- EMPLOYERS HDMF NO -->
							<td width="12%" align="center"><?php echo $header->{'Co Sss'}; ?></td>
							<td width="27.5%" align="left">&nbsp;</td>
						</tr>
						<tr><td width="100%" style="font-size:17;">&nbsp;</td> </tr>
						<tr>
							<td width="3.5%" align="left">&nbsp;</td> 
							<td width="57%" align="left"><?php echo $header->{'Co Address'}?></td> 
							<!-- EMPLOYERS HDMF NO -->
							<td width="12%" align="center"><?php echo $header->{'Zipcode'}; ?></td>
							<td width="27.5%" align="left">&nbsp;</td>
						</tr>
						<tr><td width="100%" style="font-size:27;"></td> </tr>
					</table><?php
				}
				?>
				<table>
					<tr>
						<td width="3.5%" align="left"  style="font-size:8;"></td>
						<td width="10%" align="center" style="font-size:8; "><?php echo $value->{'Tin'}; ?></td>
						<td width="10%" align="center" style="font-size:8; "><?php echo $value->{'Birth Date'}; ?></td>
						<td width="3%" align="left"   style="font-size:6;">&nbsp;</td>
						<td width="47%" align="left"   style="font-size:8; "><?php echo $value->{'Lastname'}.", ".$value->{'Firstname'}." ".$value->{'Middlename'};?></td>
						<td width="9.2%" align="right"  style="font-size:8;"><?php echo number_format($value->{'Amount'},2,'.',','); ?></td>
						<td width="17.3%" align="left"   style="font-size:6;">&nbsp;</td>
					</tr>
				</table>

				<?php 
					switch ($cnt_page) {
						case '1': ?>
							<table><tr><td width="100%" style="font-size:2;"></td></tr></table>
							<?php
							break;
						default: ?>
							<table><tr><td width="100%" style="font-size:1.7;"></td></tr></table>
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
			if($cnt_page < 40) {
                for ($i=$cnt_page; $i < 40; $i++) { 
                	switch ($i) {
						case '1':
							?>
							<table><tr><td width="100%" align="center" style="font-size:8;">&nbsp;</td></tr></table>
							<table><tr><td width="100%" align="center" style="font-size:1.5;">&nbsp;</td> </tr></table>
							<?php
							break;
						
						default:
							?>
							<table><tr><td width="100%" align="center" style="font-size:8;">&nbsp;</td> </tr></table>
							<table><tr><td width="100%" align="center" style="font-size:1.7;">&nbsp;</td> </tr></table>
							<?php
							break;
					}                	
                }
            } ?>
            <table>
            	<tr><td width="100%" align="left"   style="font-size:12;">&nbsp;</td></tr>
	            <tr>
					<td width="15%" align="right" style="font-size:6;"></td>
             		<td width="18.5%" align="left" style="font-size:8;"><?php echo $cnt;?></td>
             		<td width="40%" align="left" style="font-size:8;"><?php echo $cnt_emp;?></td>
					<td width="9.2%" align="right"   style="font-size:8;"><strong><?php echo number_format( $t_amt, 2, '.', ',' ); ?></strong></td>
					<td width="17.3%" align="left"   style="font-size:6;">&nbsp;</td>
                </tr>
                <tr><td width="100%" style="font-size:9;">&nbsp;</td></tr>
                <tr>
                	<td width="73.5%" align="right" style="font-size:6;">&nbsp;</td>
					<td width="9.2%" align="right"   style="font-size:8;"><strong><?php echo number_format( $gt_amt, 2, '.', ',' ); ?></strong></td>
					<td width="17.3%" align="left"   style="font-size:6;">&nbsp;</td>
                </tr>
                <tr><td width="100%">&nbsp;</td></tr>
             	<tr><td></td></tr>
             	<tr><td></td></tr>
             	<tr><td style="font-size:9"></td></tr>
             	
				<tr>
					<td style="width: 80%" align="left"></td>
					<td style="width: 10%" align="center"><?php echo $page_cnt+1; ?></td>
					<td style="width: 10%" align="left"><?php echo $no_page; ?></td>
				</tr>
            </table>
        </div>
	</body>
</html>