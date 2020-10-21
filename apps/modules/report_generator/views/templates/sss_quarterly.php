<html>
	<body>
		<div>
			<?php
			switch($header->{'Period Month'}){
				case 1:
					if( !empty( $header->{'Sss 3'} ) ){
						$month = '03';
					}
					elseif( !empty( $header->{'Sss 2'}) ) {
						$month = '02';
					}
					else{
						$month = '01';
					}
					break;
				case 2:
					if( !empty( $header->{'Sss 3'} ) ){
						$month = '06';
					}
					elseif( !empty( $header->{'Sss 2'}) ) {
						$month = '05';
					}
					else{
						$month = '04';
					}
					break;
				case 3:
					if( !empty( $header->{'Sss 3'} ) ){
						$month = '09';
					}
					elseif( !empty( $header->{'Sss 2'}) ) {
						$month = '08';
					}
					else{
						$month = '07';
					}
					break;
				case 4:
					if( !empty( $header->{'Sss 3'} ) ){
						$month = '12';
					}
					elseif( !empty( $header->{'Sss 2'}) ) {
						$month = '11';
					}
					else{
						$month = '10';
					}
					break;
			}

			$qtr_ending = $month.$header->{'Year'};
			$co_sss = $header->{'Co Sss'};
			$gt_ee1 = 0;
            $gt_ec1 = 0;
            $gt_ee2 = 0;
            $gt_ec2 = 0;            
            $gt_ee3 = 0;
            $gt_ec3 = 0;            
            
            $t_ee1 = 0;
            $t_ec1 = 0;
            $t_ee2 = 0;
            $t_ec2 = 0;            
            $t_ee3 = 0;
            $t_ec3 = 0;            

            $count = 0; 
            $emp_cnt = 1;
            $cnt = 1;
            $page_cnt = 1;     
			$cnt_page = 1;
			$user_id = '';
			$no_row = $query->num_rows();
			$no_page = ceil( $no_row / 15 );

			$pages = str_pad($no_page, 3, " ", STR_PAD_LEFT);

			$reg_company = get_registered_company();
			if(is_array($reg_company)) {
				$company = $reg_company['registered_company'];
			}else{
				$company = $header->{'Company'};
			}

			foreach ($query->result() as $key => $value) {
				if($emp_cnt == 16) {
					?><table><tr><td width="100%" style="font-size:4;">&nbsp;</td></tr></table>
					<?php
					$emp_cnt = 1;
				}
				switch ($emp_cnt) {
					case 2:
					case 3:
					case 9:
						?><table><tr><td width="100%" style="font-size:4;">&nbsp;</td></tr></table>
						<?php 
						break;
					case 4:
					case 5:
					case 6:
					case 10:
					case 11:
					case 12:
					case 13:
					case 14:
						?><table><tr><td width="100%" style="font-size:6;">&nbsp;</td></tr></table>
						<?php 
						break;
					case 7:
					case 8:
					case 15:
						?><table><tr><td width="100%" style="font-size:5;">&nbsp;</td></tr></table>
						<?php 
						break;
					
				}
				if(empty($user_id)) 
				{ ?>
					<table>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<!-- HEADER COMPANY -->
						<tr>
							<td width=" 2%" align="left">&nbsp;</td> 
							<td width=" 1.6%" align="center"><?php echo substr($co_sss, 0, 1); ?></td> 
							<td width=" 1.5%" align="center"><?php echo substr($co_sss, 1, 1); ?></td> 
							<td width=" 1.6%" align="center"><?php echo substr($co_sss, 2, 1); ?></td> 
							<td width=" 1.6%" align="center"><?php echo substr($co_sss, 3, 1); ?></td> 
							<td width=" 1.5%" align="center"><?php echo substr($co_sss, 4, 1); ?></td> 
							<td width=" 1.5%" align="center"><?php echo substr($co_sss, 5, 1); ?></td> 
							<td width=" 1.4%" align="center"><?php echo substr($co_sss, 6, 1); ?></td> 
							<td width=" 1.4%" align="center"><?php echo substr($co_sss, 7, 1); ?></td> 
							<td width=" 1.6%" align="center"><?php echo substr($co_sss, 8, 1); ?></td> 
							<td width=" 1.5%" align="center"><?php echo substr($co_sss, 9, 1); ?></td> 
							<td width=" 1.5%" align="center"><?php echo substr($co_sss,10, 1); ?></td> 
							<td width=" 1.6%" align="center"><?php echo substr($co_sss,11, 1); ?></td> 
							<td width=" 1.7%" align="left">&nbsp;</td> 
							<td width="54%" align="center"><?php echo $company; ?></td> 
							<td width="13.1%" align="left">&nbsp;</td> 
							<td width="1.5%" align="center"><?php echo substr($qtr_ending, 0, 1); ?></td> 
							<td width="1.5%" align="center"><?php echo substr($qtr_ending, 1, 1); ?></td> 
							<td width="1.5%" align="center"><?php echo substr($qtr_ending, 2, 1); ?></td> 
							<td width="1.5%" align="center"><?php echo substr($qtr_ending, 3, 1); ?></td> 
							<td width="1.5%" align="center"><?php echo substr($qtr_ending, 4, 1); ?></td> 
							<td width="1.5%" align="center"><?php echo substr($qtr_ending, 5, 1); ?></td> 
							<td width="1.9%" align="left">&nbsp;</td> 
						</tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<!-- HEADER TELEPHONE ADDRESS -->
						<tr>
							<td width=" 2%" align="left">&nbsp;</td> 
							<td width="20%" align="center"><?php echo $header->{'Contact No'}; ?></td> 
							<td width="54%" align="center"><?php echo $header->{'Co Address'}; ?></td> 
							<td width="24%" align="left">&nbsp;</td> 
						</tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:4;">&nbsp;</td> </tr>
					</table>
				<?php 
				} 
				if ($cnt_page > 15 ) { 
					$te_1 = str_pad( $t_ee1, 5, " ", STR_PAD_LEFT );
					$te_2 = str_pad( $t_ee2, 5, " ", STR_PAD_LEFT );
					$te_3 = str_pad( $t_ee3, 5, " ", STR_PAD_LEFT );
					$tc_1 = str_pad( $t_ec1, 3, " ", STR_PAD_LEFT );
					$tc_2 = str_pad( $t_ec2, 3, " ", STR_PAD_LEFT );
					$tc_3 = str_pad( $t_ec3, 3, " ", STR_PAD_LEFT );

		            ?>
					<table>
						<tr>
							<!-- SPACE -->
							<td width="47%" align="left" >&nbsp;</td>
							<!-- 1st Month -->
							<td width="1.7%" align="center"><?php echo substr($te_1, 0,1) ?></td> 
							<td width="1.7%" align="center"><?php echo substr($te_1, 1,1) ?></td> 
							<td width="1.8%" align="center"><?php echo substr($te_1, 2,1) ?></td> 
							<td width="1.6%" align="center"><?php echo substr($te_1, 3,1) ?></td> 
							<td width="1.7%" align="center"><?php echo substr($te_1, 4,1) ?></td> 
							<!-- 2nd Month -->
							<td width="1.75%" align="center"><?php echo substr($te_2, 0,1) ?></td> 
							<td width="1.75%" align="center"><?php echo substr($te_2, 1,1) ?></td> 
							<td width="1.75%" align="center"><?php echo substr($te_2, 2,1) ?></td> 
							<td width="1.6%" align="center"><?php echo substr($te_2, 3,1) ?></td> 
							<td width="1.7%" align="center"><?php echo substr($te_2, 4,1) ?></td> 
							<!-- 3rd Month -->
							<td width="1.6%" align="center"><?php echo substr($te_3, 0,1) ?></td> 
							<td width="1.6%" align="center"><?php echo substr($te_3, 1,1) ?></td> 
							<td width="1.7%" align="center"><?php echo substr($te_3, 2,1) ?></td> 
							<td width="1.7%" align="center"><?php echo substr($te_3, 3,1) ?></td> 
							<td width="1.6%" align="center"><?php echo substr($te_3, 4,1) ?></td> 
							<!-- 1st EC -->
							<td width="1.65%" align="center"><?php echo substr($tc_1, 0,1) ?></td> 
							<td width="1.7%" align="center"><?php echo substr($tc_1, 1,1) ?></td> 
							<td width="1.6%" align="center"><?php echo substr($tc_1, 2,1) ?></td> 
							<!-- 2nd EC -->
							<td width="1.4%" align="center"><?php echo substr($tc_2, 0,1) ?></td> 
							<td width="1.5%" align="center"><?php echo substr($tc_2, 1,1) ?></td> 
							<td width="1.6%" align="center"><?php echo substr($tc_2, 2,1) ?></td> 
							<!-- 3rd EC -->
							<td width="1.45%" align="center"><?php echo substr($tc_3, 0,1) ?></td> 
							<td width="1.5%" align="center"><?php echo substr($tc_3, 1,1) ?></td> 
							<td width="1.6%" align="center"><?php echo substr($tc_3, 2,1) ?></td> 
							<!-- SPACE -->
							<td width="13.75%" align="left">&nbsp;</td> 
						</tr>
						<!-- <tr><td width="100%">&nbsp;</td> </tr> -->
		            </table>
		            <table>
		            	<tr><td width="70%">
			            	<table>
				           		<tr><td width="100%" style="font-size:6;">&nbsp;</td></tr>
								<tr><td width="100%">&nbsp;</td> </tr>
								<tr><td width="100%">&nbsp;</td> </tr>
								
								<tr>
									<td width="9%">&nbsp;</td> 
									<!-- GRAND TOTAL -->
									<td width="12.5%" align="right">&nbsp;</td> 
									<td width="0.5%">&nbsp;</td> 
									<td width="10.9%" align="right">&nbsp;</td> 
									<td width="0.5%">&nbsp;</td> 
									<td width="11.7%" align="right">&nbsp;</td> 
									<td width="0.5%">&nbsp;</td> 
									<!-- PAYMENT DETAILS -->
									<td width="13%">&nbsp;</td>
									<td width="10%">&nbsp;</td>  
									<td width="15.5%">&nbsp;</td>
									<td width="1%">&nbsp;</td>  
									<td width="14.9%">&nbsp;</td> 
								</tr>
								<tr><td width="100%" style="font-size:1;">&nbsp;</td></tr>
								<tr>
									<td width="9%">&nbsp;</td> 
									<!-- GRAND TOTAL -->
									<td width="12.5%" align="right">&nbsp;</td> 
									<td width="0.5%">&nbsp;</td> 
									<td width="10.9%" align="right">&nbsp;</td> 
									<td width="0.5%">&nbsp;</td> 
									<td width="11.7%" align="right">&nbsp;</td> 
									<td width="0.5%">&nbsp;</td>  
									<!-- PAYMENT DETAILS -->
									<td width="13%">&nbsp;</td>
									<td width="10%">&nbsp;</td>  
									<td width="15.5%">&nbsp;</td>
									<td width="1%">&nbsp;</td>  
									<td width="14.9%">&nbsp;</td> 
								</tr>
								<tr><td width="100%" style="font-size:1;">&nbsp;</td></tr>
								<tr>
									<td width="9%">&nbsp;</td> 
									<!-- GRAND TOTAL -->
									<td width="12.5%" align="right">&nbsp;</td> 
									<td width="0.5%">&nbsp;</td> 
									<td width="10.9%" align="right">&nbsp;</td> 
									<td width="0.5%">&nbsp;</td> 
									<td width="11.7%" align="right">&nbsp;</td> 
									<td width="0.5%">&nbsp;</td> 
									<!-- PAYMENT DETAILS -->
									<td width="13%">&nbsp;</td>
									<td width="10%">&nbsp;</td>  
									<td width="15.5%">&nbsp;</td>
									<td width="1%">&nbsp;</td>  
									<td width="14.9%">&nbsp;</td>  
								</tr>
								<tr><td width="100%">&nbsp;</td> </tr>
								<tr><td width="100%">&nbsp;</td> </tr>
				            </table>
				        </td>
				        <?php $page = str_pad($page_cnt, 3, " ", STR_PAD_LEFT); ?>
				        <td width="30%">
			            	<table>
				           		<tr><td width="100%" style="font-size:6;">&nbsp;</td></tr>
				           		<tr>
									<td width="71%">&nbsp;</td>
									<!-- CUURENT PAGES -->
									<td width="5%" align="center"><?php echo substr($page, 0, 1); ?></td>
									<td width="5%" align="center"><?php echo substr($page, 1, 1); ?></td>
									<td width="5%" align="center"><?php echo substr($page, 2, 1); ?></td>
									<td width="7%"align="left">&nbsp;</td>
								</tr>
								<tr><td width="100%">&nbsp;</td> </tr>
								<tr><td width="100%" style="font-size:4;">&nbsp;</td> </tr>
								<tr>
									<td width="71%">&nbsp;</td>
									<!-- TOTAL PAGES -->
									<td width="5%" align="center"><?php echo substr($pages, 0, 1); ?></td>
									<td width="5%" align="center"><?php echo substr($pages, 1, 1); ?></td>
									<td width="5%" align="center"><?php echo substr($pages, 2, 1); ?></td>
									<td width="7%"align="left">&nbsp;</td>
								</tr>
				            </table>
				        </td></tr>
                    </table>
                    <?php 
		            $page_cnt = $page_cnt+1;
		                
		            $t_ee1 = 0;
		            $t_ec1 = 0;
		            $t_ee2 = 0;
		            $t_ec2 = 0;            
		            $t_ee3 = 0;
		            $t_ec3 = 0;            
		            
                    $cnt_page = 1; ?>
                    
                    <table>
                    	<!-- SPACE -->
                    	<tr><td width="100%">&nbsp;</td> </tr>
                    	<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<!--  -->
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<!-- HEADER COMPANY -->
						<tr>
							<td width=" 2%" align="left">&nbsp;</td> 
							<td width=" 1.6%" align="center"><?php echo substr($co_sss, 0, 1); ?></td> 
							<td width=" 1.5%" align="center"><?php echo substr($co_sss, 1, 1); ?></td> 
							<td width=" 1.6%" align="center"><?php echo substr($co_sss, 2, 1); ?></td> 
							<td width=" 1.6%" align="center"><?php echo substr($co_sss, 3, 1); ?></td> 
							<td width=" 1.5%" align="center"><?php echo substr($co_sss, 4, 1); ?></td> 
							<td width=" 1.5%" align="center"><?php echo substr($co_sss, 5, 1); ?></td> 
							<td width=" 1.4%" align="center"><?php echo substr($co_sss, 6, 1); ?></td> 
							<td width=" 1.4%" align="center"><?php echo substr($co_sss, 7, 1); ?></td> 
							<td width=" 1.6%" align="center"><?php echo substr($co_sss, 8, 1); ?></td> 
							<td width=" 1.5%" align="center"><?php echo substr($co_sss, 9, 1); ?></td> 
							<td width=" 1.5%" align="center"><?php echo substr($co_sss,10, 1); ?></td> 
							<td width=" 1.6%" align="center"><?php echo substr($co_sss,11, 1); ?></td> 
							<td width=" 1.7%" align="left">&nbsp;</td> 
							<td width="54%" align="center"><?php echo $company; ?></td> 
							<td width="13.1%" align="left">&nbsp;</td> 
							<td width="1.5%" align="center"><?php echo substr($qtr_ending, 0, 1); ?></td> 
							<td width="1.5%" align="center"><?php echo substr($qtr_ending, 1, 1); ?></td> 
							<td width="1.5%" align="center"><?php echo substr($qtr_ending, 2, 1); ?></td> 
							<td width="1.5%" align="center"><?php echo substr($qtr_ending, 3, 1); ?></td> 
							<td width="1.5%" align="center"><?php echo substr($qtr_ending, 4, 1); ?></td> 
							<td width="1.5%" align="center"><?php echo substr($qtr_ending, 5, 1); ?></td> 
							<td width="1.9%" align="left">&nbsp;</td> 
						</tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<!-- HEADER TELEPHONE ADDRESS -->
						<tr>
							<td width=" 2%" align="left">&nbsp;</td> 
							<td width="20%" align="center"><?php echo $header->{'Contact No'}; ?></td> 
							<td width="54%" align="center"><?php echo $header->{'Co Address'}; ?></td> 
							<td width="24%" align="left">&nbsp;</td> 
						</tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:4;">&nbsp;</td> </tr>
					</table>
                    <?php 
				} ?>
				<?php $emp_cnt++; 
				$emp_sss_no = str_replace("-", "", $value->{'Sss No'});
				
				$s_1 = str_pad( $value->{'Sss 1'} > 0 ? $value->{'Sss 1'} : " " , 4, " ", STR_PAD_LEFT );
				$s_2 = str_pad( $value->{'Sss 2'} > 0 ? $value->{'Sss 2'} : " " , 4, " ", STR_PAD_LEFT );
				$s_3 = str_pad( $value->{'Sss 3'} > 0 ? $value->{'Sss 3'} : " " , 4, " ", STR_PAD_LEFT );

				$c_1 = str_pad( $value->{'Ec 1'} > 0 ? $value->{'Ec 1'} : " " , 2, " ", STR_PAD_LEFT );
				$c_2 = str_pad( $value->{'Ec 2'} > 0 ? $value->{'Ec 2'} : " " , 2, " ", STR_PAD_LEFT );
				$c_3 = str_pad( $value->{'Ec 3'} > 0 ? $value->{'Ec 3'} : " " , 2, " ", STR_PAD_LEFT );

				$sss_1 = str_pad( $s_1, 4, " ", STR_PAD_LEFT );
				$sss_2 = str_pad( $s_2, 4, " ", STR_PAD_LEFT );
				$sss_3 = str_pad( $s_3, 4, " ", STR_PAD_LEFT );

				$ec_1 = str_pad( $c_1, 2, " ", STR_PAD_LEFT );
				$ec_2 = str_pad( $c_2, 2, " ", STR_PAD_LEFT );
				$ec_3 = str_pad( $c_3, 2, " ", STR_PAD_LEFT );
				?>
				<table>
					<tr>
						<td width=" 1.8%" align="left">&nbsp;</td>
						<!-- EMPLOYEE SSS NO -->
						<td width="1.55%" align="center"><?php echo substr($emp_sss_no, 0,1) ?></td> 
						<td width="1.45%" align="center"><?php echo substr($emp_sss_no, 1,1) ?></td> 
						<td width="1.45%" align="center"><?php echo substr($emp_sss_no, 2,1) ?></td> 
						<td width="1.5%" align="center"><?php echo substr($emp_sss_no, 3,1) ?></td> 
						<td width="1.5%" align="center"><?php echo substr($emp_sss_no, 4,1) ?></td> 
						<td width="1.5%" align="center"><?php echo substr($emp_sss_no, 5,1) ?></td> 
						<td width="1.6%" align="center"><?php echo substr($emp_sss_no, 6,1) ?></td> 
						<td width="1.4%" align="center"><?php echo substr($emp_sss_no, 7,1) ?></td> 
						<td width="1.5%" align="center"><?php echo substr($emp_sss_no, 8,1) ?></td> 
						<td width="1.6%" align="center"><?php echo substr($emp_sss_no, 9,1) ?></td> 
						<td width="1.6%" align="left">&nbsp;</td> 
						<!-- EMPLOYEE NAME -->
						<td width="28.55%" align="left"><?php echo $value->{'Full Name'}; ?></td> 
						<!-- 1st Month -->
						<td width="1.7%" align="left">&nbsp;</td> 
						<td width="1.7%" align="center"><?php echo substr($sss_1, 0,1) ?></td> 
						<td width="1.8%" align="center"><?php echo substr($sss_1, 1,1) ?></td> 
						<td width="1.6%" align="center"><?php echo substr($sss_1, 2,1) ?></td> 
						<td width="1.7%" align="center"><?php echo substr($sss_1, 3,1) ?></td> 
						<!-- 2nd Month -->
						<td width="1.75%" align="left">&nbsp;</td> 
						<td width="1.75%" align="center"><?php echo substr($sss_2, 0,1) ?></td> 
						<td width="1.75%" align="center"><?php echo substr($sss_2, 1,1) ?></td> 
						<td width="1.6%" align="center"><?php echo substr($sss_2, 2,1) ?></td> 
						<td width="1.7%" align="center"><?php echo substr($sss_2, 3,1) ?></td> 
						<!-- 3rd Month -->
						<td width="1.6%" align="left">&nbsp;</td> 
						<td width="1.6%" align="center"><?php echo substr($sss_3, 0,1) ?></td> 
						<td width="1.7%" align="center"><?php echo substr($sss_3, 1,1) ?></td> 
						<td width="1.7%" align="center"><?php echo substr($sss_3, 2,1) ?></td> 
						<td width="1.6%" align="center"><?php echo substr($sss_3, 3,1) ?></td> 
						<!-- 1st EC -->
						<td width="1.65%" align="left">&nbsp;</td> 
						<td width="1.7%" align="center"><?php echo substr($ec_1, 0,1) ?></td> 
						<td width="1.6%" align="center"><?php echo substr($ec_1, 1,1) ?></td> 
						<!-- 2nd EC -->
						<td width="1.4%" align="left">&nbsp;</td> 
						<td width="1.5%" align="center"><?php echo substr($ec_2, 0,1) ?></td> 
						<td width="1.6%" align="center"><?php echo substr($ec_2, 1,1) ?></td> 
						<!-- 3rd EC -->
						<td width="1.45%" align="left">&nbsp;</td> 
						<td width="1.5%" align="center"><?php echo substr($ec_3, 0,1) ?></td> 
						<td width="1.6%" align="center"><?php echo substr($ec_3, 1,1) ?></td> 
						<!-- SEPARATION DATE -->
						<td width="13.75%" align="left">&nbsp;</td> 
					</tr>
				</table>
				<?php 
				$gt_ee1 += $value->{'Sss 1'};
	            $gt_ec1 += $value->{'Ec 1'};
	            $gt_ee2 += $value->{'Sss 2'};
	            $gt_ec2 += $value->{'Ec 2'};
	            $gt_ee3 += $value->{'Sss 3'};
	            $gt_ec3 += $value->{'Ec 3'};
	            
	            $t_ee1 += $value->{'Sss 1'};
	            $t_ec1 += $value->{'Ec 1'};
	            $t_ee2 += $value->{'Sss 2'};
	            $t_ec2 += $value->{'Ec 2'};
	            $t_ee3 += $value->{'Sss 3'};
	            $t_ec3 += $value->{'Ec 3'};

                $user_id = $value->{'User Id'};
                $cnt_page++;
			}
			if($cnt_page <= 15) {
                for ($i=$cnt_page; $i < 16; $i++) { 
                	switch ($i) {
						case 2:
						case 3:
						case 9:
							?><table>
								<tr><td width="100%" style="font-size:4;">&nbsp;</td></tr>
								<tr><td width="100%" >&nbsp;</td></tr>
							</table>
							<?php 
							break;
						case 4:
						case 5:
						case 6:
						case 10:
						case 11:
						case 12:
						case 13:
						case 14:
							?><table>
								<tr><td width="100%" style="font-size:6;">&nbsp;</td></tr>
								<tr><td width="100%" >&nbsp;</td></tr>
							</table>
							<?php 
							break;
						case 7:
						case 8:
							?><table>
								<tr><td width="100%" style="font-size:5;">&nbsp;</td></tr>
								<tr><td width="100%" >&nbsp;</td></tr>
							</table>
							<?php 
							break;
						case 15:
							?><table>
								<tr><td width="100%" style="font-size:5;">&nbsp;</td></tr>
								<tr><td width="100%" >&nbsp;</td></tr>
								<tr><td width="100%" style="font-size:4;">&nbsp;</td></tr>
							</table>
							<?php 
							break;
						
					}
                }
            } 

            $te_1 = str_pad( $t_ee1, 5, " ", STR_PAD_LEFT );
			$te_2 = str_pad( $t_ee2, 5, " ", STR_PAD_LEFT );
			$te_3 = str_pad( $t_ee3, 5, " ", STR_PAD_LEFT );
			$tc_1 = str_pad( $t_ec1, 3, " ", STR_PAD_LEFT );
			$tc_2 = str_pad( $t_ec2, 3, " ", STR_PAD_LEFT );
			$tc_3 = str_pad( $t_ec3, 3, " ", STR_PAD_LEFT );
            ?>
            <table>
	            <tr>
            		<!-- SPACE -->
					<td width="47%" align="left" >&nbsp;</td>
					<!-- 1st Month -->
					<td width="1.7%" align="center"><?php echo substr($te_1, 0,1) ?></td> 
					<td width="1.7%" align="center"><?php echo substr($te_1, 1,1) ?></td> 
					<td width="1.8%" align="center"><?php echo substr($te_1, 2,1) ?></td> 
					<td width="1.6%" align="center"><?php echo substr($te_1, 3,1) ?></td> 
					<td width="1.7%" align="center"><?php echo substr($te_1, 4,1) ?></td> 
					<!-- 2nd Month -->
					<td width="1.75%" align="center"><?php echo substr($te_2, 0,1) ?></td> 
					<td width="1.75%" align="center"><?php echo substr($te_2, 1,1) ?></td> 
					<td width="1.75%" align="center"><?php echo substr($te_2, 2,1) ?></td> 
					<td width="1.6%" align="center"><?php echo substr($te_2, 3,1) ?></td> 
					<td width="1.7%" align="center"><?php echo substr($te_2, 4,1) ?></td> 
					<!-- 3rd Month -->
					<td width="1.6%" align="center"><?php echo substr($te_3, 0,1) ?></td> 
					<td width="1.6%" align="center"><?php echo substr($te_3, 1,1) ?></td> 
					<td width="1.7%" align="center"><?php echo substr($te_3, 2,1) ?></td> 
					<td width="1.7%" align="center"><?php echo substr($te_3, 3,1) ?></td> 
					<td width="1.6%" align="center"><?php echo substr($te_3, 4,1) ?></td> 
					<!-- 1st EC -->
					<td width="1.65%" align="center"><?php echo substr($tc_1, 0,1) ?></td> 
					<td width="1.7%" align="center"><?php echo substr($tc_1, 1,1) ?></td> 
					<td width="1.6%" align="center"><?php echo substr($tc_1, 2,1) ?></td> 
					<!-- 2nd EC -->
					<td width="1.4%" align="center"><?php echo substr($tc_2, 0,1) ?></td> 
					<td width="1.5%" align="center"><?php echo substr($tc_2, 1,1) ?></td> 
					<td width="1.6%" align="center"><?php echo substr($tc_2, 2,1) ?></td> 
					<!-- 3rd EC -->
					<td width="1.45%" align="center"><?php echo substr($tc_3, 0,1) ?></td> 
					<td width="1.5%" align="center"><?php echo substr($tc_3, 1,1) ?></td> 
					<td width="1.6%" align="center"><?php echo substr($tc_3, 2,1) ?></td> 
					<!-- SPACE -->
					<td width="13.75%" align="left">&nbsp;</td> 
                </tr>
            </table>
            <table>
            	<tr><td width="70%">
	            	<table>
		           		<tr><td width="100%" style="font-size:6;">&nbsp;</td></tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						
						<tr>
							<td width="9%">&nbsp;</td> 
							<!-- GRAND TOTAL -->
							<td width="12.5%" align="right"><?php echo number_format( $gt_ee1,2,'.',','); ?></td> 
							<td width="0.5%">&nbsp;</td> 
							<td width="10.9%" align="right"><?php echo number_format( $gt_ec1,2,'.',','); ?></td> 
							<td width="0.5%">&nbsp;</td> 
							<td width="11.7%" align="right"><?php echo number_format( $gt_ee1 + $gt_ec1,2,'.',','); ?></td> 
							<td width="0.5%">&nbsp;</td> 
							<!-- PAYMENT DETAILS -->
							<td width="13%">&nbsp;</td>
							<td width="10%">&nbsp;</td>  
							<td width="15.5%">&nbsp;</td>
							<td width="1%">&nbsp;</td>  
							<td width="14.9%">&nbsp;</td> 
						</tr>
						<tr><td width="100%" style="font-size:1;">&nbsp;</td></tr>
						<tr>
							<td width="9%">&nbsp;</td> 
							<!-- GRAND TOTAL -->
							<td width="12.5%" align="right"><?php echo number_format( $gt_ee2,2,'.',','); ?></td> 
							<td width="0.5%">&nbsp;</td> 
							<td width="10.9%" align="right"><?php echo number_format( $gt_ec2,2,'.',','); ?></td> 
							<td width="0.5%">&nbsp;</td> 
							<td width="11.7%" align="right"><?php echo number_format( $gt_ee2 + $gt_ec2,2,'.',','); ?></td> 
							<td width="0.5%">&nbsp;</td>  
							<!-- PAYMENT DETAILS -->
							<td width="13%">&nbsp;</td>
							<td width="10%">&nbsp;</td>  
							<td width="15.5%">&nbsp;</td>
							<td width="1%">&nbsp;</td>  
							<td width="14.9%">&nbsp;</td> 
						</tr>
						<tr><td width="100%" style="font-size:1;">&nbsp;</td></tr>
						<tr>
							<td width="9%">&nbsp;</td> 
							<!-- GRAND TOTAL -->
							<td width="12.5%" align="right"><?php echo number_format( $gt_ee3,2,'.',','); ?></td> 
							<td width="0.5%">&nbsp;</td> 
							<td width="10.9%" align="right"><?php echo number_format( $gt_ec3,2,'.',','); ?></td> 
							<td width="0.5%">&nbsp;</td> 
							<td width="11.7%" align="right"><?php echo number_format( $gt_ee3 + $gt_ec3,2,'.',','); ?></td> 
							<td width="0.5%">&nbsp;</td> 
							<!-- PAYMENT DETAILS -->
							<td width="13%">&nbsp;</td>
							<td width="10%">&nbsp;</td>  
							<td width="15.5%">&nbsp;</td>
							<td width="1%">&nbsp;</td>  
							<td width="14.9%">&nbsp;</td>  
						</tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
		            </table>
		        </td>
		        <?php 
		        $page = str_pad($page_cnt, 3, " ", STR_PAD_LEFT);     
		        ?>
		        <td width="30%">
	            	<table>
		           		<tr><td width="100%" style="font-size:6;">&nbsp;</td></tr>
		           		<tr>
							<td width="71%">&nbsp;</td>
							<!-- CUURENT PAGES -->
							<td width="5%" align="center"><?php echo substr($page, 0, 1); ?></td>
							<td width="5%" align="center"><?php echo substr($page, 1, 1); ?></td>
							<td width="5%" align="center"><?php echo substr($page, 2, 1); ?></td>
							<td width="7%"align="left">&nbsp;</td>
						</tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:4;">&nbsp;</td> </tr>
						<tr>
							<td width="71%">&nbsp;</td>
							<!-- TOTAL PAGES -->
							<td width="5%" align="center"><?php echo substr($pages, 0, 1); ?></td>
							<td width="5%" align="center"><?php echo substr($pages, 1, 1); ?></td>
							<td width="5%" align="center"><?php echo substr($pages, 2, 1); ?></td>
							<td width="7%"align="left">&nbsp;</td>
						</tr>
		            </table>
		        </td></tr>
		    </table>
        </div>
	</body>
</html>