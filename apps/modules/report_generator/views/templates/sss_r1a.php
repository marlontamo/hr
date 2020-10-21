<html>
	<body>
		<div>

			<table>
				<?php
				$co_sss = str_split(str_replace("-", "", $header->{'Co Sss'}));
				$co_tin = str_split(str_replace("-", "", $header->{'Co Tin'}));
	            $count = 0; 
	            $emp_cnt = 0;
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
					$emp_cnt++;
					if($emp_cnt == 16) {
						?><table><tr><td width="100%" height="164px;" style="font-size:5;">&nbsp;</td></tr></table>
						<?php
						$emp_cnt = 1;
						$user_id = '';
					}

					if(empty($user_id)) 
					{ ?>
							<tr><td width="100%" height="110px;">&nbsp;</td> </tr>
							<!-- HEADER COMPANY -->
							<tr>
								<td width="4%" align="center">&nbsp;</td> 
								<?php foreach ($co_sss as $key_c => $val_c) { ?>
									<td width=".7%" align="left"><?php echo $val_c; ?></td> 
									<td width=".5%" align="left">&nbsp;</td> 
								<?php }?>
								<td width="55%" align="center"><?php echo $company; ?></td> 
								<td width="10.2%" align="right">&nbsp;</td> <!-- type of employer -->
								<td width="15.3%" align="left">&nbsp;</td> <!-- type of report -->
							</tr>
							<tr><td width="100%">&nbsp;</td> </tr>
							<!-- HEADER TELEPHONE ADDRESS -->
							<tr>
								<td width="4%" align="left">&nbsp;</td> 
								<td width="87%" align="center"><?php echo $header->{'Co Address'}; ?></td> 
								<td width="9%" align="left">&nbsp;</td> 
							</tr>
							<tr><td width="100%" height="20px;">&nbsp;</td> </tr>
							<tr>
								<td width="4%" align="left">&nbsp;</td> 
								<td width="11.7%" align="left">&nbsp;</td> <!-- company tel number -->
								<td width="13.6%" align="left">&nbsp;</td> <!-- company mobile number -->
								<td width="18.6%" align="center">&nbsp;</td> <!-- company email address -->
								<td width="33%" align="center">&nbsp;</td> <!-- company website -->
								<td width="1%" align="left">&nbsp;</td> 
								<?php foreach ($co_tin as $key_t => $val_t) { ?>
									<td width=".7%" align="left"><?php echo $val_t; ?></td> 
									<td width=".5%" align="left">&nbsp;</td> 
								<?php }?>
							</tr>	
							<tr><td width="100%" height="24px;" style="font-size:4;">&nbsp;</td> </tr>
					<?php 
					} 
					 
					$emp_sss_no = !empty($value->{'Sss No'}) ? str_split(str_replace("-", "", $value->{'Sss No'})) : '';
					$emp_sss_len = strlen(str_replace("-", "", $value->{'Sss No'}));
					$bdate = !empty($value->{'Birth Date'}) ? str_split(date('mdY',strtotime($value->{'Birth Date'}))) : '';
					$hired_date = !empty($value->{'Effectivity Date'}) ? str_split(date('mdY',strtotime($value->{'Effectivity Date'}))) : '';
					$res_date = !empty($value->{'Resigned Date'}) && ($value->{'Resigned Date'}) != '0000-00-00'  ? str_split(date('mdY',strtotime($value->{'Resigned Date'}))) : '';
					$salary = !empty($value->{'Salary'}) ? $value->{'Salary'} : '';
					if ($emp_cnt <= 15 ) { 
			            ?>
							<tr>
								<td width="4%" align="left">&nbsp;</td> 
								<?php if(!empty($emp_sss_no) && $emp_sss_len == 10) {
										foreach ($emp_sss_no as $key_e => $val_e) { ?>
											<td width=".7%" align="left"><?php echo $val_e; ?></td> 
											<td width=".5%" align="left">&nbsp;</td> 
								<?php 	}
									  }else{ 
									  	?>
									  		<td width="11.85%" align="left">&nbsp;</td> 
								<?php } ?>	  
								<td width="1.5%" align="left">&nbsp;</td> 
								<td width="24.5%" align="left"><?php echo $value->{'Full Name'}?></td> 
								<?php if(!empty($bdate)) {
										foreach ($bdate as $key_b => $val_b) { ?>
											<td width=".7%" align="right"><?php echo $val_b;?></td> 
											<td width=".5%" align="left">&nbsp;</td> 
								<?php 	}
									  }else{ ?>
									  		<td width="9.1%" align="left">&nbsp;</td> 
								<?php } ?>
								<?php if(!empty($bdate)) {
										foreach ($hired_date as $key_h => $val_h) { ?>
											<td width=".7%" align="right"><?php echo $val_h;?></td> 
											<td width=".55%" align="left">&nbsp;</td> 
								<?php 	}
									  }else{ ?>
									  		<td width="9.35%" align="left">&nbsp;</td> 
								<?php } ?>
								<?php if(!empty($res_date)) {
									foreach ($res_date as $key_h => $val_h) { ?>
										<td width=".7%" align="right"><?php echo $val_h;?></td> 
										<td width=".55%" align="left">&nbsp;</td> 
								<?php }
									} else { ?>
										<td width="9.35%" align="right">&nbsp;</td> 
								<?php }?>
								<td width="6.8%" align="right"><?php echo $salary; ?></td> 
								<td width=".8%" align="right">&nbsp;</td> 
								<td width="8.2%" align="left"><?php echo strlen($value->{'Position'}) > 12 ? substr($value->{'Position'},0,12)."..." : $value->{'Position'}; ?></td> 
							</tr>
							<tr><td width="100%" style="font-size:4;">&nbsp;</td> </tr>
	                    <?php 
			            $page_cnt = $page_cnt+1;
					} ?>
					<?php 
	                $user_id = $value->{'User Id'};
	                $cnt_page++;
				}
				 
	            ?>
	        </table>    
        </div>
	</body>
</html>