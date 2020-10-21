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
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr>
							<td width="73%" align="left">&nbsp;</td> 
							<!-- MONTH -->
							<td width="15.5%" align="left"><?php echo date('F',strtotime($header->{'Payroll Date'})); ?></td>
							<!-- YEAR -->
							<td width="9%" align="right"><?php echo date('Y',strtotime($header->{'Payroll Date'})); ?></td>
							<td width="2.5%" align="right">&nbsp;</td>
						</tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr>
							<td width=" 2%" align="left">&nbsp;</td> 
							<!-- NAME OF EMPLOYER -->
							<td width="42%" align="left"><?php echo $company; ?></td> 
							<td width="10.5%" align="left">&nbsp;</td> 
							<!-- EMPLOYER SSS NO -->
							<td width="17.5%" align="center"><?php echo !empty($header->{'Sss No'}) ? $header->{'Sss No'} : ""; ?></td> 
							<td width="28%" align="left">&nbsp;</td>
						</tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:3;">&nbsp;</td> </tr>
						<tr>
							<td width=" 2%" align="left">&nbsp;</td> 
							<!-- ADDRESS -->
							<td width="42%" align="left" height="20"><p><?php echo !empty($header->{'Co Address'}) ? $header->{'Co Address'} : ""; ?></p></td> 
							<td width=" 1%" align="left">&nbsp;</td> 
							<!-- TIN -->
							<td width="22.5%" align="left"><?php echo !empty($header->{'Tin'}) ? $header->{'Tin'} : ""; ?></td> 
							<td width="1%" align="left">&nbsp;</td> 
							<!-- ZIP -->
							<td width="8.7%" align="left"><?php echo !empty($header->{'Zipcode'}) ? $header->{'Zipcode'} : ""; ?></td> 
							<td width="1%" align="left">&nbsp;</td> 
							<!-- TELEPHONE -->
							<td width="20%" align="left"><?php echo !empty($header->{'Contact No'}) ? $header->{'Contact No'} : ""; ?></td> 
							<td width="1%" align="left">&nbsp;</td> 
						</tr>
						<tr><td width="100%" style="font-size:5;">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:5;">&nbsp;</td> </tr>
					</table><?php 
				} 
				if ($cnt_page > 40 ) { ?>
					<table>
		            	<tr><td width="100%">&nbsp;</td></tr>
			            <tr>
		            		<td width="12%" align="right"  >&nbsp;</td>
		            		<!-- NO OF EMPLOYEES PER PAGE -->
							<td width="10%" align="right" ><?php echo $cnt_page - 1; ?></td>
							<!-- SPACE -->
							<td width="11.5%" align="right" >&nbsp;</td>
							<!-- TOTAL NO OF EMPLOYEES -->
							<td width="10%" align="right" >&nbsp;</td>
							<!-- SPACE -->
							<td width="21%" align="right" >&nbsp;</td>
							<!-- EMPLOYEE TOTAL -->
							<td width="10.5%" align="right" ><?php echo number_format( $t_e, 2, '.', ','); ?></td>
							<!-- SPACE -->
							<td width="1.5%" align="right" >&nbsp;</td>
							<!-- EMPLOYER TOTAL -->
							<td width="10.2%" align="right" ><?php echo number_format( $t_c, 2, '.', ','); ?></td>
							<!-- SPACE -->
							<td width="1.5%" align="right" >&nbsp;</td>
							<!-- TOTAL -->
							<td width="9.8%" align="right" ><?php echo number_format( $t_t, 2, '.', ','); ?></td>
							<td width=" 2%" align="right" >&nbsp;</td>
		                </tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr><td width="100%">&nbsp;</td></tr>
		                <tr>
		                	<td width="86%" align="right">&nbsp;</td>
		                	<td width="4%" align="right"><?php echo $page_cnt; ?></td>
		                	<td width="3%" align="right">&nbsp;</td>
		                	<td width="5%" align="right"><?php echo $no_page; ?></td>
		                	<td width="2%" align="right" >&nbsp;</td>
		                </tr>
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
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr>
							<td width="73%" align="left">&nbsp;</td> 
							<!-- MONTH -->
							<td width="15.5%" align="left"><?php echo date('F',strtotime($header->{'Payroll Date'})); ?></td>
							<!-- YEAR -->
							<td width="9%" align="right"><?php echo date('Y',strtotime($header->{'Payroll Date'})); ?></td>
							<td width="2.5%" align="right">&nbsp;</td>
						</tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr>
							<td width=" 2%" align="left">&nbsp;</td> 
							<!-- NAME OF EMPLOYER -->
							<td width="42%" align="left"><?php echo $company; ?></td> 
							<td width="10.5%" align="left">&nbsp;</td> 
							<!-- EMPLOYER SSS NO -->
							<td width="17.5%" align="center"><?php echo !empty($header->{'Sss No'}) ? $header->{'Sss No'} : ""; ?></td> 
							<td width="28%" align="left">&nbsp;</td>
						</tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:3;">&nbsp;</td> </tr>
						<tr>
							<td width=" 2%" align="left">&nbsp;</td> 
							<!-- ADDRESS -->
							<td width="42%" align="left" height="20"><p><?php echo !empty($header->{'Co Address'}) ? $header->{'Co Address'} : ""; ?></p></td> 
							<td width=" 1%" align="left">&nbsp;</td> 
							<!-- TIN -->
							<td width="22.5%" align="left"><?php echo !empty($header->{'Tin'}) ? $header->{'Tin'} : ""; ?></td> 
							<td width="1%" align="left">&nbsp;</td> 
							<!-- ZIP -->
							<td width="8.7%" align="left"><?php echo !empty($header->{'Zipcode'}) ? $header->{'Zipcode'} : ""; ?></td> 
							<td width="1%" align="left">&nbsp;</td> 
							<!-- TELEPHONE -->
							<td width="20%" align="left"><?php echo !empty($header->{'Contact No'}) ? $header->{'Contact No'} : ""; ?></td> 
							<td width="1%" align="left">&nbsp;</td> 
						</tr>
						<tr><td width="100%" style="font-size:5;">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:5;">&nbsp;</td> </tr>
					</table>
                    <?php 
				} ?>
				<table>
					<tr>
						<td width="1.5%" align="left"><?php $cnt++; ?></td>
						<td width="21.5%" align="center"><?php if(empty( $value->{'Hdmf No'}) ){ echo $value->{'Birth Date'}; }else{ echo $value->{'Hdmf No'}; } ; ?></td>
						<td width="3%" align="left">&nbsp;</td>
						<td width="37%" align="left"><?php echo $value->{'Full Name'}; ?></td>
						<td width="1%" align="left">&nbsp;</td>
						<td width="11%" align="right"><?php echo number_format( $value->{'Hdmf Emp'}, 2, '.', ',' ); ?></td>
						<td width="1%" align="right">&nbsp;</td>
						<td width="10.5%" align="right"><?php echo number_format( $value->{'Hdmf Com'}, 2, '.', ',' ); ?></td>
						<td width="1%" align="right">&nbsp;</td>
						<td width="10.5%" align="right"><?php echo number_format( $value->{'Hdmf Emp'} + $value->{'Hdmf Com'}, 2, '.', ',' ); ?></td>
						<td width="2%" align="right">&nbsp;</td>
					</tr>
				</table>
				<?php 
				switch ($cnt_page) {
					case 3:
					case 9:
					case 17:
					case 23:
					case 30:
						?><table><tr><td width="100%" align="center" style="font-size:2;">&nbsp;</td> </tr></table><?php
						break;
					
					default:
						?><table><tr><td width="100%" align="center" style="font-size:1;">&nbsp;</td> </tr></table><?php
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
			if($cnt_page < 40) {
                for ($i=$cnt_page; $i < 41; $i++) { 
                	switch ($i) {
						case 3:
						case 9:
						case 17:
						case 23:
						case 30:
							?>
							<table><tr><td width="100%" align="center">&nbsp;</td> </tr></table>
							<table><tr><td width="100%" align="center" style="font-size:2;">&nbsp;</td> </tr></table>
							<?php
							break;
						
						default:
							?>
							<table><tr><td width="100%" align="center">&nbsp;</td> </tr></table>
							<table><tr><td width="100%" align="center" style="font-size:1;">&nbsp;</td> </tr></table>
							<?php
							break;
					}                	
                }
            } ?>
            <table>
            	<tr><td width="100%">&nbsp;</td></tr>
	            <tr>
            		<td width="12%" align="right"  >&nbsp;</td>
            		<!-- NO OF EMPLOYEES PER PAGE -->
					<td width="10%" align="right" ><?php echo $cnt_page - 1; ?></td>
					<!-- SPACE -->
					<td width="11.5%" align="right" >&nbsp;</td>
					<!-- TOTAL NO OF EMPLOYEES -->
					<td width="10%" align="right" ><?php echo $no_row; ?></td>
					<!-- SPACE -->
					<td width="21%" align="right" >&nbsp;</td>
					<!-- EMPLOYEE TOTAL -->
					<td width="10.5%" align="right" ><?php echo number_format( $t_e, 2, '.', ','); ?></td>
					<!-- SPACE -->
					<td width="1.5%" align="right" >&nbsp;</td>
					<!-- EMPLOYER TOTAL -->
					<td width="10.2%" align="right" ><?php echo number_format( $t_c, 2, '.', ','); ?></td>
					<!-- SPACE -->
					<td width="1.5%" align="right" >&nbsp;</td>
					<!-- TOTAL -->
					<td width="9.8%" align="right" ><?php echo number_format( $t_t, 2, '.', ','); ?></td>
					<td width=" 2%" align="right" >&nbsp;</td>
                </tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr>
            		<td width="64.5%" align="right"  >&nbsp;</td>
            		<!-- EMPLOYEE TOTAL -->
					<td width="10.5%" align="right" ><?php echo number_format( $gt_e, 2, '.', ','); ?></td>
					<!-- SPACE -->
					<td width="1.5%" align="right" >&nbsp;</td>
					<!-- EMPLOYER TOTAL -->
					<td width="10.2%" align="right" ><?php echo number_format( $gt_c, 2, '.', ','); ?></td>
					<!-- SPACE -->
					<td width="1.5%" align="right" >&nbsp;</td>
					<!-- TOTAL -->
					<td width="9.8%" align="right" ><?php echo number_format( $gt_t, 2, '.', ','); ?></td>
					<td width="2%" align="right" >&nbsp;</td>
                </tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr><td width="100%">&nbsp;</td></tr>
                <tr>
                	<td width="86%" align="right">&nbsp;</td>
                	<td width="4%" align="right"><?php echo $page_cnt; ?></td>
                	<td width="3%" align="right">&nbsp;</td>
                	<td width="5%" align="right"><?php echo $no_page; ?></td>
                	<td width="2%" align="right" >&nbsp;</td>
                </tr>
            </table>
        </div>
	</body>
</html>