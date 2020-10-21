<html>
	<body>
		<div>
				<?php
				$co_phic = !empty($header->{'Co Phic'}) ? $header->{'Co Phic'} : "";
	            $count = 0; 
	            $emp_cnt = 0;
	            $cnt = 1;
	            $page_cnt = 0;     
				$cnt_page = 1;
				$user_id = '';
				$no_row = $query->num_rows();
				$no_page = ceil( $no_row / 21 );

				$pages = str_pad($no_page, 3, " ", STR_PAD_LEFT);
				$reg_company = get_registered_company();
				if(is_array($reg_company)) {
					$company = $reg_company['registered_company'];
				}else{
					$company = $header->{'Company'};
				}
				foreach ($query->result() as $key => $value) {
					$emp_cnt++; 
					if($emp_cnt == 22) {
						?><table><tr><td width="100%" height="81.75px;" style="font-size:5;">&nbsp;</td></tr></table>
						<?php
						$emp_cnt = 0;
						$user_id = "";
					}?>
					<table>
					<?php if(empty($user_id)) 
						{ 
				            $page_cnt = $page_cnt+1;
				    ?>
								<tr><td width="100%" height="95px;">&nbsp;</td> </tr>
								<!-- HEADER COMPANY -->
								<tr>
									<td width="4%" align="center">&nbsp;</td> 
									<td width="22%" align="center">&nbsp;</td> 
									<td width="44%" align="left"><?php echo $company; ?></td> 
									<td width="10%" align="right">&nbsp;</td> 
									<td width="20%" align="left"><?php echo $co_phic; ?></td> 
								</tr>
								<tr><td width="100%">&nbsp;</td> </tr>
								<!-- HEADER TELEPHONE ADDRESS -->
								<tr>
									<td width="4%" align="left">&nbsp;</td> 
									<td width="11%" align="center">&nbsp;</td> 
									<td width="49%" align="left"><?php echo $header->{'Co Address'}; ?></td> 
									<td width="2%" align="left">&nbsp;</td> 
									<td width="34%" align="left">&nbsp;</td> <!--  Comapny Email Address -->
								</tr>
								<tr><td width="100%" height="45px;" style="font-size:4;">&nbsp;</td> </tr>
						<?php 
						} 
						$emp_phic_no = !empty($value->{'Phic No'}) ? $value->{'Phic No'} : "";
						$hired_date = date('m/d/Y',strtotime($value->{'Effectivity Date'}));
						$salary = !empty($value->{'Salary'}) ? $value->{'Salary'} : '';
						if ($cnt_page <= 21 ) { 
				            ?>
								<tr>
									<td width="8%" align="left">&nbsp;</td> 
									<td width="9%" align="left"><?php echo $emp_phic_no; ?></td> 
									<td width="2%" align="left">&nbsp;</td> 
									<td width="20%" align="left"><?php echo $value->{'Full Name'}?></td> 
									<td width="13%" align="left"><?php echo strlen($value->{'Position'}) > 18 ? substr($value->{'Position'},0,18)."..." : $value->{'Position'}; ?></td> 
									<td width="7%" align="right"><?php echo $salary; ?></td> 
									<td width="2.3%" style="font-size:4;">&nbsp;</td>
									<td width="8%" align="left"><?php echo $hired_date;?></td>
									<td width="30.7%" style="font-size:4;">&nbsp;</td>
								</tr>
								<tr><td width="100%" style="font-size:4;">&nbsp;</td> </tr>
		                    <?php 
				                 
				            
		                    $cnt_page = 1; 
						} ?>
						<?php 
		                $user_id = $value->{'User Id'};
		                $cnt_page++; ?>
	        		  
		<?php } ?>
		
			<?php for ($i=0; $i < (22-$emp_cnt) ; $i++) { ?>
				<tr><td width="100%">&nbsp;</td></tr>
				<tr><td width="100%" style="font-size:4;">&nbsp;</td> </tr>
		<?php	  }  ?>
			<tr><td width="25%" height="45%" align="right"><b><?php echo  $emp_cnt; ?></b></td></tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr>
				<td width="47.5%">&nbsp;</td>
				<td width="5%" align="right"><b><?php echo $page_cnt; ?></b></td>
				<td width="4%" align="right"><b><?php echo $no_page; ?></b></td>
			</tr>
		</table>
        </div>
	</body>
</html>