<html>
	<body>
		<div>
			<?php
			$co_phic = str_replace('-', '', $header->{'Co Phic'} );
			$co_tin = str_replace('-', '', $header->{'Tin'} );
			
			$t_emp = 0;
			$t_com = 0;

			$gt_emp = 0;
			$gt_com = 0;

            $count = 0; 
            $emp_cnt = 1;
            $cnt = 1;
            $page_cnt = 1;     
			$cnt_page = 1;
			$user_id = '';
			$no_row = $query->num_rows();
			$no_page = ceil( $no_row / 10 );

			$reg_company = get_registered_company();
			if(is_array($reg_company)) {
				$company = $reg_company['registered_company'];
			}else{
				$company = $header->{'Company'};
			}
			
			foreach ($query->result() as $key => $value) {
				if($emp_cnt == 11) {
					?><table><tr><td width="100%" style="font-size:4;">&nbsp;</td></tr></table>
					<?php
					$emp_cnt = 1;
				}
				switch ($emp_cnt) {
					case 2:
					case 4:
					case 6:
					case 8:
					case 10:
						?><table><tr><td width="100%" style="font-size:9;">&nbsp;</td></tr></table>
						<?php 
						break;
					case 3:
					case 5:
					case 7:
					case 9:
						?><table><tr><td width="100%" style="font-size:11;">&nbsp;</td></tr></table>
						<?php 
						break;
				}
				if(empty($user_id)) 
				{ ?>
					<table>
						<tr><td width="100%" style="font-size:5;">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr>
							<td width="16.5%">&nbsp;</td>
							<td width="2.5%" align="center"><?php echo substr($co_phic, 0, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 1, 1); ?></td> 
							<td width=".8%" align="center">&nbsp;</td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 2, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 3, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 4, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 5, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 6, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 7, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 8, 1); ?></td>
							<td width="2.3%" align="center"><?php echo substr($co_phic, 9, 1); ?></td>
							<td width="2.3%" align="center"><?php echo substr($co_phic, 10, 1); ?></td>
							<td width=".7%" align="center">&nbsp;</td> 
							<td width="2.2%" align="center"><?php echo substr($co_phic, 11, 1); ?></td>
							<td width="54.3%">&nbsp;</td>
						</tr>
						<tr><td width="100%" style="font-size:3;">&nbsp;</td> </tr>
						<tr>
							<td width="16.5%">&nbsp;</td>
							<td width="2.5%" align="center"><?php echo substr($co_tin, 0, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_tin, 1, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_tin, 2, 1); ?></td> 
							<td width=".9%" align="center">&nbsp;</td> 
							<td width="2.3%" align="center"><?php echo substr($co_tin, 3, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_tin, 4, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_tin, 5, 1); ?></td> 
							<td width=".9%" align="center">&nbsp;</td> 
							<td width="2.3%" align="center"><?php echo substr($co_tin, 6, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_tin, 7, 1); ?></td>
							<td width="2.3%" align="center"><?php echo substr($co_tin, 8, 1); ?></td>
							<td width="60.8%">&nbsp;</td>
						</tr>
						<tr><td width="100%" style="font-size:7.5;">&nbsp;</td> </tr>
						<tr>
							<td width="18%">&nbsp;</td>
							<td width="82%"><?php echo $company; ?></td>
						</tr>
						<tr><td width="100%" style="font-size:1;">&nbsp;</td> </tr>
						<tr>
							<td width="18%" >&nbsp;</td>
							<td width="34%" height="20" valign="center"><?php echo $header->{'Co Address'}; ?></td>
							<td width="48%">&nbsp;</td>
						</tr>
						<tr><td width="100%" style="font-size:2.5;">&nbsp;</td> </tr>
						<tr>
								<td width="18%" >&nbsp;</td>
							<td width="82%"><?php echo $header->{'Contact No'}; ?></td>
						</tr>
						<tr><td width="100%" style="font-size:6;">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
					</table>
				<?php 
				} 
				if ($cnt_page > 10 ) { 
		            ?>
					<table>
						<tr><td width="100%">&nbsp;</td></tr>
		            	<tr>
		            		<td width="74.74%" align="right"></td>  
		            		<td width="5%" align="center"><?php echo number_format($t_emp, 2,'.',','); ?></td>  
							<td width="5%" align="center"><?php echo number_format($t_com, 2,'.',','); ?></td>  
							<td width="15.26%" align="left">&nbsp;</td> 
		            	</tr>
		            	<tr><td width="100%" style="font-size:5;">&nbsp;</td></tr>
		            	<tr>
		            		<td width="4%" align="left">&nbsp;</td>  
		            		<td width="9%" align="center"><?php echo $cnt_page - 1; ?></td>  
		            		<td width="61.74%" align="left">&nbsp;</td>  
		            		<td width="10%" align="center"><?php echo number_format($t_emp + $t_com, 2,'.',','); ?></td>  
							<td width="15.26%" align="left">&nbsp;</td> 
		            	</tr>
		            	<tr><td width="100%">&nbsp;</td> </tr>
		            	<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:6;">&nbsp;</td> </tr>
						<tr>
							<td width="85.5%">&nbsp;</td>
							<td width="2.5%" align="center"><?php echo $page_cnt; ?></td>
							<td width="1.6%">&nbsp;</td>
							<td width="2.5%" align="center"><?php echo $no_page; ?></td>
							<td width="7.9%">&nbsp;</td>
						</tr>
                    </table>
                    <?php 
		            $page_cnt = $page_cnt+1;
					
		            $t_emp = 0;          
					$t_com = 0;

                    $cnt_page = 1; ?>
                    
                    <table>
                    	<tr><td width="100%">&nbsp;</td> </tr>
                    	<tr><td width="100%">&nbsp;</td> </tr>
                    	<tr><td width="100%">&nbsp;</td> </tr>
                    	<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%" style="font-size:5;">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr>
							<td width="16.5%">&nbsp;</td>
							<td width="2.5%" align="center"><?php echo substr($co_phic, 0, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 1, 1); ?></td> 
							<td width=".8%" align="center">&nbsp;</td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 2, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 3, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 4, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 5, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 6, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 7, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_phic, 8, 1); ?></td>
							<td width="2.3%" align="center"><?php echo substr($co_phic, 9, 1); ?></td>
							<td width="2.3%" align="center"><?php echo substr($co_phic, 10, 1); ?></td>
							<td width=".7%" align="center">&nbsp;</td> 
							<td width="2.2%" align="center"><?php echo substr($co_phic, 11, 1); ?></td>
							<td width="54.3%">&nbsp;</td>
						</tr>
						<tr><td width="100%" style="font-size:3;">&nbsp;</td> </tr>
						<tr>
							<td width="16.5%">&nbsp;</td>
							<td width="2.5%" align="center"><?php echo substr($co_tin, 0, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_tin, 1, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_tin, 2, 1); ?></td> 
							<td width=".9%" align="center">&nbsp;</td> 
							<td width="2.3%" align="center"><?php echo substr($co_tin, 3, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_tin, 4, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_tin, 5, 1); ?></td> 
							<td width=".9%" align="center">&nbsp;</td> 
							<td width="2.3%" align="center"><?php echo substr($co_tin, 6, 1); ?></td> 
							<td width="2.3%" align="center"><?php echo substr($co_tin, 7, 1); ?></td>
							<td width="2.3%" align="center"><?php echo substr($co_tin, 8, 1); ?></td>
							<td width="60.8%">&nbsp;</td>
						</tr>
						<tr><td width="100%" style="font-size:7.5;">&nbsp;</td> </tr>
						<tr>
							<td width="18%">&nbsp;</td>
							<td width="82%"><?php echo $company; ?></td>
						</tr>
						<tr><td width="100%" style="font-size:1;">&nbsp;</td> </tr>
						<tr>
							<td width="18%" >&nbsp;</td>
							<td width="34%" height="20" valign="center"><?php echo $header->{'Co Address'}; ?></td>
							<td width="48%">&nbsp;</td>
						</tr>
						<tr><td width="100%" style="font-size:2.5;">&nbsp;</td> </tr>
						<tr>
								<td width="18%" >&nbsp;</td>
							<td width="82%"><?php echo $header->{'Contact No'}; ?></td>
						</tr>
						<tr><td width="100%" style="font-size:6;">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
						<tr><td width="100%">&nbsp;</td> </tr>
					</table>
                    <?php 
				} ?>
				<?php $emp_cnt++; 
				$emp_phic_no = str_replace("-", "", $value->{'Phic No'});
				?>
				<table>
					<tr>
						<td width=" 5.7%" align="left">&nbsp;</td>
						<!-- EMPLOYEE PHILHEALTH NO -->
						<td width="1.35%" align="center"><?php echo substr($emp_phic_no, 0,1); ?></td> 
						<td width="1.35%" align="center"><?php echo substr($emp_phic_no, 1,1); ?></td> 
						<td width=".3%" align="left"></td> 
						<td width="1.35%" align="center"><?php echo substr($emp_phic_no, 2,1); ?></td> 
						<td width="1.31%" align="center"><?php echo substr($emp_phic_no, 3,1); ?></td> 
						<td width="1.31%" align="center"><?php echo substr($emp_phic_no, 4,1); ?></td> 
						<td width="1.31%" align="center"><?php echo substr($emp_phic_no, 5,1); ?></td> 
						<td width="1.31%" align="center"><?php echo substr($emp_phic_no, 6,1); ?></td> 
						<td width="1.31%" align="center"><?php echo substr($emp_phic_no, 7,1); ?></td> 
						<td width="1.31%" align="center"><?php echo substr($emp_phic_no, 8,1); ?></td> 
						<td width="1.31%" align="center"><?php echo substr($emp_phic_no, 9,1); ?></td> 
						<td width="1.31%" align="center"><?php echo substr($emp_phic_no, 10,1); ?></td> 
						<td width=".31%" align="left"></td>  
						<td width="1.4%" align="center"><?php echo substr($emp_phic_no, 11,1); ?></td> 
						<td width=".8%" align="left"></td> 
						<!-- EMPLOYEE NAME -->
						<td width="11.5%" align="left"><?php echo $value->{'Lastname'}; ?></td> 
						<td width=".6%" align="left"></td> 
						<td width="11.9%" align="left"><?php echo $value->{'Firstname'}; ?></td>
						<td width="3.6%" align="left"><?php echo $value->{'Suffix'}; ?></td> 
						<td width=".2%" align="left"></td>
						<td width="11.2%" align="left"><?php echo $value->{'Middlename'}; ?></td>  
						<!-- BIRTH DATE -->
						<td width="1.8%" align="left">&nbsp;</td> 
						<td width="1.8%" align="left">&nbsp;</td> 
						<td width="3.8%" align="left">&nbsp;</td> 
						<!-- GENDER -->
						<td width="2.4%" align="left">&nbsp;</td> 
						<!-- MSB  -->
						<td width="2.9%" align="left">&nbsp;</td> 
						<!-- EMPLOYEE -->
						<td width="5%" align="center"><?php echo number_format($value->{'Phic Emp'}, 2,'.',','); ?></td>  
						<!-- EMPLOYER -->
						<td width="5%" align="center"><?php echo number_format($value->{'Phic Com'}, 2,'.',','); ?></td>  
						<td width="15.26%" align="left">&nbsp;</td> 
					</tr>
				</table>
				<?php 

				$t_emp += $value->{'Phic Emp'};
				$t_com += $value->{'Phic Com'};

				$gt_emp += $value->{'Phic Emp'};
				$gt_com += $value->{'Phic Com'};

                $user_id = $value->{'User Id'};
                $cnt_page++;
			}
			if($cnt_page <= 10) {
                for ($i=$cnt_page; $i < 11; $i++) { 
                	switch ($i) {
						case 2:
						case 4:
						case 6:
						case 8:
						case 10:
							?><table>
								<tr><td width="100%">&nbsp;</td></tr>
								<tr><td width="100%" style="font-size:9;">&nbsp;</td></tr>
							</table>
							<?php 
							break;
						case 3:
						case 5:
						case 7:
						case 9:
							?><table>
								<tr><td width="100%">&nbsp;</td></tr>
								<tr><td width="100%" style="font-size:11;">&nbsp;</td></tr>
							</table>
							<?php 
							break;
					}
                }
            } 
            ?>
            <table>
            	<tr><td width="100%">&nbsp;</td></tr>
				<tr><td width="100%" style="font-size:4;">&nbsp;</td> </tr>
				<tr>
            		<td width="74.74%" align="right"></td>  
            		<td width="5%" align="center"><?php echo number_format($t_emp, 2,'.',','); ?></td>  
					<td width="5%" align="center"><?php echo number_format($t_com, 2,'.',','); ?></td>  
					<td width="15.26%" align="left">&nbsp;</td> 
            	</tr>
            	<tr><td width="100%" style="font-size:5;">&nbsp;</td></tr>
            	<tr>
            		<td width="4%" align="left">&nbsp;</td>  
            		<td width="9%" align="center"><?php echo $cnt_page - 1; ?></td>  
            		<td width="61.74%" align="left">&nbsp;</td>  
            		<td width="10%" align="center"><?php echo number_format($t_emp + $t_com, 2,'.',','); ?></td>  
					<td width="15.26%" align="left">&nbsp;</td> 
            	</tr>
            	<tr><td width="100%" style="font-size:5;">&nbsp;</td></tr>
            	<tr>
            		<td width="74.74%" align="right"></td>  
            		<td width="5%" align="center"><?php echo number_format($gt_emp, 2,'.',','); ?></td>  
					<td width="5%" align="center"><?php echo number_format($gt_com, 2,'.',','); ?></td>  
					<td width="15.26%" align="left">&nbsp;</td> 
            	</tr>
            	<tr><td width="100%" style="font-size:3;">&nbsp;</td></tr>
            	<tr>
            		<td width="4%" align="left">&nbsp;</td>  
            		<td width="9%" align="center">&nbsp;</td>  
            		<td width="61.74%" align="left">&nbsp;</td>  
            		<td width="10%" align="center"><?php echo number_format($gt_emp + $gt_com, 2,'.',','); ?></td>  
					<td width="15.26%" align="left">&nbsp;</td> 
            	</tr>
            	<tr><td width="100%">&nbsp;</td> </tr>
				<tr><td width="100%">&nbsp;</td> </tr>
				<tr><td width="100%">&nbsp;</td> </tr>
				<tr><td width="100%">&nbsp;</td> </tr>
				<tr><td width="100%" style="font-size:6;">&nbsp;</td> </tr>
				<tr>
					<td width="85.5%">&nbsp;</td>
					<td width="2.5%" align="center"><?php echo $page_cnt; ?></td>
					<td width="1.6%">&nbsp;</td>
					<td width="2.5%" align="center"><?php echo $no_page; ?></td>
					<td width="7.9%">&nbsp;</td>
				</tr>
            </table>
        </div>
	</body>
</html>