<html>
	<body>
		<div>
			<?php
			$gt_e = 0;
			$gt_c = 0;
			$gt_t = 0;

			$t_e = 0;
			$t_c = 0;
			$t_t = 0;

            $count = 0; 
            $cnt = 1;
            $page_cnt = 1;     
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
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:6;">&nbsp;</td> </tr>
						<tr>
							<td width="67.5%" align="left">&nbsp;</td> 
							<!-- EMPLOYERS HDMF NO -->
							<td width="28.5%" align="left"><?php echo $header->{'Co Hdmf'}; ?></td>
							<td width="4%" align="left">&nbsp;</td>
						</tr>
						<tr><td width="100%" style="font-size:4;">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr>
							<td width=" 6%" align="left">&nbsp;</td> 
							<!-- NAME OF EMPLOYER -->
							<td width="90%" align="left"><?php echo $company; ?></td> 
							<td width=" 4%" align="left">&nbsp;</td> 
						</tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:5;">&nbsp;</td> </tr>
						<tr>
							<td width=" 6%" align="left">&nbsp;</td> 
							<!-- ADDRESS -->
							<td width="90%" align="left" height="20"><p><?php echo $header->{'Co Address'}; ?></p></td> 
							<td width=" 4%" align="left">&nbsp;</td> 
						</tr>
						<tr><td width="100%" style="font-size:5;">&nbsp;</td> </tr>
						<tr>
							<td width="86%" align="left"></td> 
							<!-- ZIP -->
							<td width="10%" align="left" height="20"><p><?php echo $header->{'Zipcode'}; ?></p></td> 
							<td width=" 4%" align="left">&nbsp;</td> 
						</tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:7;">&nbsp;</td> </tr>
					</table><?php 
				} 
				if ($cnt_page > 30 ) { ?>
					<table>
						<tr><td width="100%" align="left"   style="font-size:2;"></td></tr>
		            	<tr>
		            		<!-- SPACE -->
							<td width="74.3%" align="right" style="font-size:6;">&nbsp;</td>
							<!-- EE -->
							<td width=" 5%" align="right"   style="font-size:6;"><?php echo number_format( $t_e, 2, '.', ',' ); ?></td>
							<!-- ER -->
							<td width=" 5.3%" align="right"   style="font-size:6;"><?php echo number_format( $t_c, 2, '.', ',' ); ?></td>
							<!-- TOTAL -->
							<td width="11%" align="right"   style="font-size:6;"><?php echo number_format( $t_t, 2, '.', ',' ); ?></td>
							<td width="4.4%" align="left"   style="font-size:6;">&nbsp;</td>
		                </tr>
		                <tr><td width="100%" style="font-size:5;">&nbsp;</td></tr>
		                <tr><td width="100%" style="font-size:6;">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		            </table><?php 
		            $page_cnt = $page_cnt+1;     
		            $t_e = 0;
		            $t_c = 0;
		            $t_t = 0;
                    $cnt_page = 1; ?>
                    <table>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:6;">&nbsp;</td> </tr>
						<tr>
							<td width="67.5%" align="left">&nbsp;</td> 
							<!-- EMPLOYERS HDMF NO -->
							<td width="28.5%" align="left"><?php echo $header->{'Co Hdmf'}; ?></td>
							<td width="4%" align="left">&nbsp;</td>
						</tr>
						<tr><td width="100%" style="font-size:4;">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr>
							<td width=" 6%" align="left">&nbsp;</td> 
							<!-- NAME OF EMPLOYER -->
							<td width="90%" align="left"><?php echo $company; ?></td> 
							<td width=" 4%" align="left">&nbsp;</td> 
						</tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:5;">&nbsp;</td> </tr>
						<tr>
							<td width=" 6%" align="left">&nbsp;</td> 
							<!-- ADDRESS -->
							<td width="90%" align="left" height="20"><p><?php echo $header->{'Co Address'}; ?></p></td> 
							<td width=" 4%" align="left">&nbsp;</td> 
						</tr>
						<tr><td width="100%" style="font-size:5;">&nbsp;</td> </tr>
						<tr>
							<td width="86%" align="left"></td> 
							<!-- ZIP -->
							<td width="10%" align="left" height="20"><p><?php echo $header->{'Zipcode'}; ?></p></td> 
							<td width=" 4%" align="left">&nbsp;</td> 
						</tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:7;">&nbsp;</td> </tr>
					</table>
                    <?php 
				} ?>
				<table>
					<table>
					<tr>
						<td width="100%" align="left"   style="font-size:1;"></td>
					</tr>
					<tr>
						<td width="4.5%" align="left"   style="font-size:5;"></td>
						<!-- HDMF NO / BIRTH DATE -->
						<td width="7%" align="center" style="font-size:5; "><?php 
							if(empty( $value->{'Hdmf No'}) )
								{ echo $value->{'Birth Date'}; }
							else{ echo substr(str_replace(" ", "", $value->{'Hdmf No'} ),0,12); } ; 
						?></td>
						<!-- SPACE} -->
						<td width="14%" align="left"   style="font-size:5;"></td>
						<td width=" .3%" align="left"   style="font-size:5;">&nbsp;</td>
						<!-- LASTNAME -->
					<?php if( strlen( $value->{'Lastname'} ) > 16 ) { ?>
						<td width="10.7%" align="left"   style="font-size:4.5;"><?php echo substr($value->{'Lastname'}, 0, 21 ); ?></td>
					<?php } else { ?>
						<td width="10.7%" align="left"   style="font-size:5;"><?php echo substr($value->{'Lastname'}, 0, 21 ); ?></td>
					<?php } ?>
						<td width=" .3%" align="left"   style="font-size:5;">&nbsp;</td>
						<!-- FIRSTNAME -->
					<?php if( strlen( $value->{'Firstname'} ) > 15 ) { ?>
						<td width="10%" align="left"   style="font-size:4.5;"><?php echo substr($value->{'Firstname'}, 0, 18 ); ?></td>
					<?php } else { ?>
						<td width="10%" align="left"   style="font-size:5;"><?php echo substr($value->{'Firstname'}, 0, 18 ); ?></td>
					<?php } ?>
						<td width=" .3%" align="left"   style="font-size:5;">&nbsp;</td>
						<!-- SUFFIX -->
						<td width=" 5%" align="left"   style="font-size:5;"><?php echo $value->{'Suffix'}; ?></td>
						<td width=" .3%" align="left"   style="font-size:5;">&nbsp;</td>
						<!-- MIDDLE NAME -->
						<td width=" 7%" align="left"   style="font-size:5;"><?php echo substr($value->{'Middlename'}, 0, 13 ); ?></td>
						<!-- PERIOD COVERED -->
						<td width=" 6.2%" align="center"   style="font-size:5;"><?php echo date('Ym',strtotime($value->{'Payroll Date'}) ); ?></td>
						<!-- MONTHLY COMP -->
						<td width=" 8.7%" align="left"   style="font-size:5;">&nbsp;</td>
						<!-- EE -->
						<td width=" 5%" align="right"   style="font-size:5;"><?php echo number_format( $value->{'Hdmf Emp'}, 2, '.', ',' ); ?></td>
						<!-- ER -->
						<td width=" 5.3%" align="right"   style="font-size:5;"><?php echo number_format( $value->{'Hdmf Com'}, 2, '.', ',' ); ?></td>
						<!-- TOTAL -->
						<td width=" 5.2%" align="right"   style="font-size:5;"><?php echo number_format( $value->{'Hdmf Emp'} + $value->{'Hdmf Com'}, 2, '.', ',' ); ?></td>
						<td width="10.2%" align="left"   style="font-size:5;">&nbsp;</td>
					</tr>
				</table>
				</table>
				<?php 
				switch ($cnt_page) {
					case 3:
						?><table><tr><td width="100%" align="center" style="font-size:3.5;">&nbsp;</td> </tr></table><?php
						break;
					default:
						?><table><tr><td width="100%" align="center" style="font-size:4;">&nbsp;</td> </tr></table><?php
						break;
				}

				$gt_e += $value->{'Hdmf Emp'};
				$gt_c += $value->{'Hdmf Com'};
				$gt_t += $value->{'Hdmf Emp'} + $value->{'Hdmf Com'};

				$t_e += $value->{'Hdmf Emp'};
				$t_c += $value->{'Hdmf Com'};
				$t_t += $value->{'Hdmf Emp'} + $value->{'Hdmf Com'};
				
                $user_id = $value->{'User Id'};
                $cnt_page++;
			}
			if($cnt_page <= 30) {
                for ($i=$cnt_page; $i < 31; $i++) { 
                	switch ($i) {
						case 3:
							?>
							<table><tr><td width="100%" align="center">&nbsp;</td> </tr></table>
							<table><tr><td width="100%" align="center" style="font-size:1.5;">&nbsp;</td> </tr></table>
							<?php
							break;
						
						default:
							?>
							<table><tr><td width="100%" align="center">&nbsp;</td> </tr></table>
							<table><tr><td width="100%" align="center" style="font-size:2;">&nbsp;</td> </tr></table>
							<?php
							break;
					}                	
                }
            } ?>
            <table>
            	<tr><td width="100%" align="left"   style="font-size:2;"></td></tr>
	            <tr>
            		<!-- SPACE -->
					<td width="74.3%" align="right" style="font-size:6;">&nbsp;</td>
					<!-- EE -->
					<td width=" 5%" align="right"   style="font-size:6;"><?php echo number_format( $t_e, 2, '.', ',' ); ?></td>
					<!-- ER -->
					<td width=" 5.3%" align="right"   style="font-size:6;"><?php echo number_format( $t_c, 2, '.', ',' ); ?></td>
					<!-- TOTAL -->
					<td width="11%" align="right"   style="font-size:6;"><?php echo number_format( $t_t, 2, '.', ',' ); ?></td>
					<td width="4.4%" align="left"   style="font-size:6;">&nbsp;</td>
                </tr>
                <tr><td width="100%" style="font-size:5;">&nbsp;</td></tr>
                <tr>
                	<!-- SPACE -->
            		<td width="74.3%" align="right" style="font-size:6;">&nbsp;</td>
            		<!-- EE -->
					<td width=" 5%" align="right"   style="font-size:6;"><?php echo number_format( $gt_e, 2, '.', ',' ); ?></td>
					<!-- ER -->
					<td width=" 5.3%" align="right"   style="font-size:6;"><?php echo number_format( $gt_c, 2, '.', ',' ); ?></td>
					<!-- TOTAL -->
					<td width="11%" align="right"   style="font-size:6;"><?php echo number_format( $gt_t, 2, '.', ',' ); ?></td>
					<td width="4.4%" align="left"   style="font-size:6;">&nbsp;</td>
                </tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr><td width="100%">&nbsp;</td></tr>
            </table>
        </div>
	</body>
</html>