<html>
	<body>
		<div>
			<?php
			$ln_array = array();
			$ln_description = '';
			$t_loan = 0;
            $gt_loan = 0;
            $count = 0; 
            $cnt = 1;
            $page_cnt = 1;     
			$cnt_page = 1;
			$loan = '';
			$no_row = $query->num_rows();
			$no_page = ceil( $no_row / 70 );
			foreach ($query->result() as $key => $value) {
				if( $loan == '' || $loan != $value->{'Loan'}) 
				{ 
					if($loan == ''){?>
						<table>
							<tr>
								<td style="width: 50%" align="left" font-size="6">Rundate: <?php echo date('F d, Y')?></td>
								<td style="width: 50%" align="right" font-size="6">Page <?php echo $page_cnt; ?></td>
							</tr>
							<tr>
								<td style="width: 100%" align="center" font-size="12"><h3><?php echo $value->{'Company'}; ?></h3></td>
							</tr>
							<tr>
								<td style="width: 100%" align="center" font-size="12"><h3><?php echo $value->{'Description'}; ?></h3></td>
							</tr>
							<tr>
								<td style="width: 100%" align="center" font-size="12"><h3><?php echo date('F Y', strtotime($value->{'Year'}.'-'.$value->{'Month'}.'-01') ); ?></h3></td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">ID Number</td>
								<td width="25%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Name of Employee</td>
								<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">
									<?php 
									if($value->{'Category'} == 'SSS'){
										echo "SSS Number";
									}
									elseif($value->{'Category'} == 'HDMF'){
										echo "HDMF Number";
									}
									else{
										echo "";
									}
									?>
								</td>
								<td width="10%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Loan Principal</td>
								<td width="10%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Start Date</td>
								<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Running Balance</td>
								<td width="10%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Amount</td>
								
							</tr>
						</table><?php
					} 
					else {?>
			            <table>
	                    	<tr>
	                    		<td width="67%" align="left" style="background-color:#DDDDDD;"><strong>Page Total</strong></td>
			                    <td width="18%" align="right" style="background-color:#DDDDDD;"><strong></strong></td>
			                    <td width="15%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_loan,2,'.',','); ?></strong></td>
			                </tr>
			            </table><?php
						if($cnt_page < 70) {
			                for ($i=$cnt_page; $i < 71; $i++) { ?> 
			                    <table>        
			            	        <tr>
					                    <td width=" 5%" align="left"  ></td> 
					                    <td width="97%" align="right" >&nbsp;</td> 
			                  		</tr>
			                    </table><?php
			                    $cnt++; 
			                }
			            
			            }
			            $ln_array[$ln_description] = $t_loan;
			            $page_cnt = $page_cnt+1;     
			            $cnt_page = 1;
	                    $cnt = 1;
	                    $t_loan = 0;
			           	?>
						<table>
							<tr><td>&nbsp;</td></tr>
							<tr><td>&nbsp;</td></tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td style="width: 50%" align="left" font-size="6">Rundate: <?php echo date('F d, Y')?></td>
								<td style="width: 50%" align="right" font-size="6">Page <?php echo $page_cnt; ?></td>
							</tr>
							<tr>
								<td style="width: 100%" align="center" font-size="12"><h3><?php echo $value->{'Company'}; ?></h3></td>
							</tr>
							<tr>
								<td style="width: 100%" align="center" font-size="12"><h3><?php echo $value->{'Description'}; ?></h3></td>
							</tr>
							<tr>
								<td style="width: 100%" align="center" font-size="12"><h3><?php echo date('F Y', strtotime($value->{'Year'}.'-'.$value->{'Month'}.'-01') ); ?></h3></td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">ID Number</td>
								<td width="25%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Name of Employee</td>
								<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">
									<?php 
									if($value->{'Category'} == 'SSS'){
										echo "SSS Number";
									}
									elseif($value->{'Category'} == 'HDMF'){
										echo "HDMF Number";
									}
									else{
										echo "";
									}
									?>
								</td>
								<td width="10%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Loan Principal</td>
								<td width="10%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Start Date</td>
								<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Running Balance</td>
								<td width="10%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Amount</td>
								
							</tr>
						</table>
						<?php
					} 
				} 
				if ($cnt_page > 70 ) { ?>
					<table>
                    	<tr>
                    		<td width="67%" align="left" style="background-color:#DDDDDD;"><strong>Page Total</strong></td>
		                    <td width="18%" align="right" style="background-color:#DDDDDD;"><strong></strong></td>
		                    <td width="15%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_loan,2,'.',','); ?></strong></td>
		                </tr>
		            </table><?php 
		            $page_cnt = $page_cnt+1;     
		            // $t_loan = 0;
                    $cnt_page = 1; ?>
                    <table>
                    	<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td style="width: 50%" align="left" font-size="6">Rundate: <?php echo date('F d, Y')?></td>
							<td style="width: 50%" align="right" font-size="6">Page <?php echo $page_cnt; ?></td>
						</tr>
						<tr>
							<td style="width: 100%" align="center" font-size="12"><h3><?php echo $value->{'Company'}; ?></h3></td>
						</tr>
						<tr>
							<td style="width: 100%" align="center" font-size="12"><h3><?php echo $value->{'Description'}; ?></h3></td>
						</tr>
						<tr>
							<td style="width: 100%" align="center" font-size="12"><h3><?php echo date('F Y', strtotime($value->{'Year'}.'-'.$value->{'Month'}.'-01') ); ?></h3></td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">ID Number</td>
							<td width="25%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Name of Employee</td>
							<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">
								<?php 
								if($value->{'Category'} == 'SSS'){
									echo "SSS Number";
								}
								elseif($value->{'Category'} == 'HDMF'){
									echo "HDMF Number";
								}
								else{
									echo "";
								}
								?>
							</td>
							<td width="10%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Loan Principal</td>
							<td width="10%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Start Date</td>
							<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Running Balance</td>
							<td width="10%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Amount</td>
							
						</tr>
					</table>
                    <?php 
				} ?>
				<table>
					<tr>
						<td width=" 5%" align="left"  ><?php echo $cnt++; ?>.</td>
						<td width="10%" align="left"  ><?php echo $value->{'Id Number'}; ?></td>
						<td width="25%" align="left"  ><?php echo $value->{'Full Name'}; ?></td>
						<td width="15%" align="center">
							<?php 
								if($value->{'Category'} == 'SSS'){
									echo $value->{'Sss No'};
								}
								elseif($value->{'Category'} == 'HDMF'){
									echo $value->{'Hdmf No'};
								}
								else{
									echo "";
								}
							?>
						</td>
						<td width="10%" align="right" ><?php echo number_format( $value->{'Loan Principal'} ,2,'.',','); ?></td>
						<td width="10%" align="right" ><?php echo $value->{'Start Date'}; ?></td>
						<td width="15%" align="right" ><?php echo number_format( $value->{'Balance'} ,2,'.',','); ?></td>
						<td width="10%" align="right" ><?php echo number_format( $value->{'Amount'} ,2,'.',','); ?></td>
					</tr>
				</table>
				<?php 
                $t_loan  += $value->{'Amount'};
				$gt_loan += $value->{'Amount'};
                $loan = $value->{'Loan'};
                $ln_description = $value->{'Description'};
                $cnt_page++;
			}?>
			<table>
	            <tr>
            		<td width="67%" align="left" style="background-color:#DDDDDD;"><strong>Page Total</strong></td>
                    <td width="18%" align="right" style="background-color:#DDDDDD;"></td>
                    <td width="15%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($t_loan,2,'.',','); ?></strong></td>
                </tr>
            </table>
			<?php
			if($cnt_page < 70) {
                for ($i=$cnt_page; $i < 71; $i++) { ?> 
                    <table>        
            	        <tr>
		                    <td width=" 5%" align="left"  ></td> 
		                    <td width="97%" align="right" >&nbsp;</td> 
                  		</tr>
                    </table><?php
                    $cnt++;
                }
            } 

            $ln_array[$ln_description] = $t_loan;
            $page_cnt = $page_cnt + 1 ;
            ?>
            
            
            <table>
            	<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td style="width: 50%" align="left" font-size="6">Rundate: <?php echo date('F d, Y')?></td>
					<td style="width: 50%" align="right" font-size="6">Page <?php echo $page_cnt; ?></td>
				</tr>
				<tr>
					<td style="width: 100%" align="center" font-size="12"><h3><?php echo $value->{'Company'}; ?></h3></td>
				</tr>
				<tr>
					<td style="width: 100%" align="center" font-size="12"><h3>Summary Loan Report</h3></td>
				</tr>
				<tr>
					<td style="width: 100%" align="center" font-size="12"><h3><?php echo date('F Y', strtotime($value->{'Year'}.'-'.$value->{'Month'}.'-01') ); ?></h3></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td width="67%" align="left" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Loan Name</td>
					<td width="18%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;"></td>
					<td width="15%" align="center" font-size="10" style="background-color:#CCCCCC;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;">Amount</td>
					
				</tr>
			</table>
			<table>
				<?php foreach ($ln_array as $key => $value) {
					?>
					<tr>
            		<td width="67%" align="left" ><strong><?php echo $key;?></strong></td>
                    <td width="18%" align="right" ></td>
                    <td width="15%" align="right" ><strong><?php echo number_format($value,2,'.',','); ?></strong></td>
                </tr>
					<?php
				}?>
	            <tr>
            		<td width="67%" align="left" style="background-color:#DDDDDD;"><strong>Grand Total</strong></td>
                    <td width="18%" align="right" style="background-color:#DDDDDD;"></td>
                    <td width="15%" align="right" style="background-color:#DDDDDD;"><strong><?php echo number_format($gt_loan,2,'.',','); ?></strong></td>
                </tr>
            </table>
        </div>
	</body>
</html>