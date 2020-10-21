<html>
	<body>
		<div>
			<?php
				$co_sss = !empty($header->{'Co Sss'}) ? $header->{'Co Sss'} : "";
				$reg_company = get_registered_company();
				if(is_array($reg_company)) {
					$company = $reg_company['registered_company'];
				}else{
					$company = $header->{'Company'};
				}
				if ( count($query) > 0 ) { ?>
					<table>
						<tr><td width="100%" height="100px;">&nbsp;</td> </tr>
						<!-- HEADER COMPANY -->
						<tr>
							<td width="8%" align="center">&nbsp;</td> 
							<td width="20%" align="left"><?php echo $co_sss; ?></td> 
							<td width="12%" align="center">&nbsp;</td> 
							<td width="44%" align="left"><?php echo $company; ?></td> 
							<td width="10%" align="right">&nbsp;</td> 
						</tr>
						<tr><td width="100%" height="18px;">&nbsp;</td> </tr>
						<!-- HEADER TELEPHONE ADDRESS -->
						<tr>
							<td width="4%" align="left">&nbsp;</td> 
							<td width="9%" align="center">&nbsp;</td> 
							<td width="49%" align="left"><?php echo $header->{'Co Address'}; ?></td> 
							<td width="20%" align="left">&nbsp;</td> 
							<td width="16%" align="left"><?php echo $header->{'Zipcode'}; ?></td> <!--  Comapny Zip Code -->
						</tr>
						<tr><td width="100%" height="50px;" style="font-size:4;">&nbsp;</td> </tr>	
						<!-- Start of monthly -->
						<?php for ($i=1; $i <= 12 ; $i++) { ?>
							<tr>
								<td width="33%" align="left">&nbsp;</td> 
								<td width="6%" align="center"><?php echo $query[$i]['year']; ?></td> 
								<td width="5%" >&nbsp;</td>
								<td width="12%" align="right"><?php echo isset($query[$i]['ssc']) ? $query[$i]['ssc'] : '' ;?></td>
								<td width="17%" align="right"><?php echo isset($query[$i]['ec']) ? $query[$i]['ec'] : '';?></td>
								<td width="21%" align="right"><?php echo isset($query[$i]['total']) ? $query[$i]['total'] : '';?></td>
							</tr>
							<tr><td width="100%" height="3.5px;" style="font-size: 2px;">&nbsp;</td></tr>
						<?php }?>
						<tr><td width="100%" height="120px;">&nbsp;</td></tr>
						<tr>
							<td width="33%" align="left">&nbsp;</td> 
							<td width="6%" align="center">&nbsp;</td> 
							<td width="5%" >&nbsp;</td>
							<td width="12%" align="right"><?php echo $t_ssc; ?></td>
							<td width="17%" align="right"><?php echo $t_ec; ?></td>
							<td width="21%" align="right"><?php echo $t_total; ?></td>
						</tr>
	        		</table>    
		<?php 	} // end of if condition 
				else 
				{ ?>
					<table>
						<tr><td width="100%" height="110px;">&nbsp;</td> </tr>
							<!-- HEADER COMPANY -->
							<tr>
								<td width="100%" align="center">&nbsp;</td> 
							</tr>
							<tr><td width="100%" height="25px;">&nbsp;</td> </tr>
							<!-- HEADER TELEPHONE ADDRESS -->
							<tr>
								<td width="100%" align="left">&nbsp;</td> 
							</tr>
							<tr><td width="100%" height="76px;" style="font-size:4;">&nbsp;</td> </tr>

							<tr>
								<td width="100%" align="left"><?php echo "*** No Records Found ***"?></td> 
							</tr>
					</table>
		<?php 	} ?>
        </div>
	</body>
</html>