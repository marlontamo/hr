<?php
// change $this->db to $db for multidb config
	foreach ($result as $value):
		$salary = $db->query($query." AND `group` = 'Earnings' AND `type` = 'salary' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $overtime = $db->query($query." AND `group` = 'Earnings' AND `type` = 'overtime' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $bonus = $db->query($query." AND `group` = 'Earnings' AND `type` = 'bonus' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $benefits = $db->query($query." AND `group` = 'Earnings' AND `type` = 'benefits' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $earning = $db->query($query." AND `group` = 'Earnings' AND `type` = 'Earnings' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
		$ded_govt = $db->query($query." AND `group` = 'Deductions' AND `type` = 'government' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label DESC, transaction_class_code DESC' )->result();
        $ded_attnd = $db->query($query." AND `group` = 'Deductions' AND `type` = 'attnd_ded' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $ded_other = $db->query($query." AND `group` = 'Deductions' AND `type` = 'Oth_ded' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $ded_loan = $db->query($query." AND `group` = 'Deductions' AND `type` = 'Loan' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
		// $result = $value;
        ?>
    	<table width="100%">
			<?php

				$logo = $db->get_where('users_company', array('company_id' => $value->{'Company Id'}))->row();
				$ytd = $db->query("SELECT IFNULL( ROUND( sum( (	case 
														when ( `group` = 'earnings' and transaction_type_id = 1 ) then 1 
														when ( `group` = 'deductions' and transaction_type_id = 5 ) then -1 
													else 0 end ) * amount ),2),0) as gross,
												IFNULL( ROUND( sum( (  case when transaction_code = 'whtax' then 1 else 0 end ) * amount ),2),0) as whtax
											FROM payroll_payslip
											WHERE user_id = ".$value->{'User Id'}." AND payroll_date <= '".$value->{'Payroll Date'}."' AND YEAR(payroll_date) = ".date("Y",strtotime($value->{'Payroll Date'})) )->row();
			?>
			<tr>
				<td width="25%" align="left"><img src="<?php echo $logo->print_logo;?>" alt="<?php echo $logo->company_code;?>" style=" height:40px;" /></td>
				<td width="50%" >
					<table>
						<tr><td style="font-size: 5.4;">&nbsp;</td></tr>
						<tr>
							<td align="center" style="font-size: 10;">&nbsp;&nbsp;<b><?php echo $value->Company;?></b></td>
						</tr>
					</table>
				</td>
				<td width="25%" >&nbsp;</td>
			</tr>
		</table>
		<table>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="width:  14%" align="left" font-size:"10" >Dept Code :</td>
				<td style="width:  20%" align="left" font-size:"10" ><?php echo $value->{'Department Code'}?></td>
				<td style="width:   2%" align="left" font-size:"10" >&nbsp;</td>
				<td style="width:  10%" align="left" font-size:"10" >TIN :</td>
				<td style="width:  20%" align="left" font-size:"10" ><?php echo $value->Tin?></td>
				<td style="width:   2%" align="left" font-size:"10" >&nbsp;</td>
				<td style="width:  12%" align="left" font-size:"10" >Pay Date :</td>
				<td style="width:  20%" align="right" font-size:"10" ><?php echo date( 'm/d/y', strtotime($value->{'Payroll Date'}))?></td>
			</tr>
			<tr>
				<td style="width:  14%" align="left" font-size:"10" >Employee # :</td>
				<td style="width:  20%" align="left" font-size:"10" ><?php echo $value->{'Id Number'}?></td>
				<td style="width:   2%" align="left" font-size:"10" >&nbsp;</td>
				<td style="width:  30%" align="left" font-size:"10" >Pay Period Coverage :</td>
				<td style="width:   2%" align="left" font-size:"10" >&nbsp;</td>
				<td style="width:  32%" align="left" font-size:"10" ><?php echo date( 'm/d/y', strtotime($value->{'Date From'}))?> to <?php echo date( 'm/d/y', strtotime($value->{'Date To'}))?></td>
			</tr>
			<tr>
				<td style="width:  14%" align="left" font-size:"10" >Name :</td>
				<td style="width:  52%" align="left" font-size:"10" ><?php echo $value->{'Full Name'} ?></td>
				<td style="width:   2%" align="left" font-size:"10" >&nbsp;</td>
				<td style="width:  12%" align="left" font-size:"10" >Pay Period :</td>
				<td style="width:  20%" align="right" font-size:"10" ><?php echo date( 'm/d/y', strtotime($value->{'Payroll Date'}))?></td>
			</tr>
		</table>
		<table style="border-top: solid 1px black;">
			<tr><td></td></tr>
		</table>
		<table>
			<tr>
				<td style="width: 50%; " align="center" font-size="9"><h4>Earnings</h4></td>
				<td style="width: 50%; " align="center" font-size="9"><h4>Deductions</h4></td>
			</tr>
			<tr>
				<td style="width: 50%; ">
					<table style="border: 1px solid black;" >
						<?php 
						$e_count = 1;
						$gross = 0;
						if(isset($salary)){ 
							foreach($salary as $transaction){ 
								if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
									$gross += $transaction->Amount;
								?>
								<tr>
									<td style="width:  2%" align="left">&nbsp;</td>
									<td style="width: 66%" align="left"><?php echo $transaction->{'Transaction Label'}.' ';?></td>
									<td style="width: 30%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
									<td style="width:  2%" align="left">&nbsp;</td>
								</tr> <?php
								$e_count++;
							}
						} 	
						if(isset($overtime)){
							foreach($overtime as $transaction){ 
								if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
									$gross += $transaction->Amount;
								?>
								<tr>
									<td style="width:  2%" align="left">&nbsp;</td>
									<td style="width: 66%" align="left"><?php echo $transaction->{'Transaction Label'}.' ';?>
										<table><tr><td><i style="font-size:6;"><?php echo '( '.$transaction->{'Qty'}.' hr/s )' ;?></i></td></tr></table>
									</td>
									<td style="width: 30%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
									<td style="width:  2%" align="left">&nbsp;</td>
								</tr> <?php
								$e_count++;
							}
						} 
						if(isset($earning)){ 
							foreach($earning as $transaction){ 
								if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
									$gross += $transaction->Amount;
								?>
								<tr>
									<td style="width:  2%" align="left">&nbsp;</td>
									<td style="width: 66%" align="left"><?php echo $transaction->{'Transaction Label'}.' ';?></td>
									<td style="width: 30%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
									<td style="width:  2%" align="left">&nbsp;</td>
								</tr> <?php
								$e_count++;
							}
						}
						if(isset($bonus)){
							foreach($bonus as $transaction){ 
								if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
									$gross += $transaction->Amount;
								?>
								<tr>
									<td style="width:  2%" align="left">&nbsp;</td>
									<td style="width: 66%" align="left"><?php echo $transaction->{'Transaction Label'}.' ';?></td>
									<td style="width: 30%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
									<td style="width:  2%" align="left">&nbsp;</td>
								</tr> <?php
								$e_count++;
							}
						} 
						if(isset($benefits)){
							foreach($benefits as $transaction){ 
								if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
									$gross += $transaction->Amount;
								?>
								<tr>
									<td style="width:  2%" align="left">&nbsp;</td>
									<td style="width: 66%" align="left"><?php echo $transaction->{'Transaction Label'}.' ';?></td>
									<td style="width: 30%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
									<td style="width:  2%" align="left">&nbsp;</td>
								</tr> <?php
								$e_count++;
							}	
						} 
						if($e_count != 20){
							for ($space=1; $space <= (20 - $e_count); $space++) 
		                    {?>
		                        <tr><td>&nbsp;</td></tr>
		                  	<?php
		                	}
						} ?>
					</table>
					<table>
						<tr>
							<td style="width:  2%" align="left">&nbsp;</td>
							<td style="width: 64%" align="left" font-size:"9"><h3>Total Earnings:</h3></td>
							<td style="width: 32%" align="right" font-size:"9"><h3><?php echo number_format($gross , 2, '.', ',')?></h3></td>
							<td style="width:  2%" align="left">&nbsp;</td>
						</tr>
						<tr>
							<td style="width:  2%" align="left" font-size:"2" >&nbsp;</td>
							<td style="width: 64%; " align="left" font-size:"2" >&nbsp;</td>
							<td style="width: 32%; border-top-width: solid 1px black; " align="right" font-size:"2" >&nbsp;</td>
							<td style="width:  2%" align="left" font-size:"2" >&nbsp;</td>
						</tr>
						<tr><td></td></tr>
						<tr>
							<td style="width:  2%" align="left">&nbsp;</td>
							<td style="width: 64%" align="left"><h2>Net Pay : </h2></td>
							<td style="width: 32%" align="right"><h2><?php echo number_format($value->Amount , 2, '.', ',')?></h2></td>
							<td style="width:  2%" align="left">&nbsp;</td>
						</tr>
						<tr>
							<td style="width:  2%" align="left">&nbsp;</td>
							<td style="width: 64%; " align="left" font-size:"4" >&nbsp;</td>
							<td style="width: 32%; border-top-width: solid 2px black; " align="right" font-size:"4" >&nbsp;</td>
							<td style="width:  2%" align="left" font-size:"4" >&nbsp;</td>
						</tr>
					</table>
				</td>
				<td style="width: 50%; ">
					<table style="border: 1px solid black; " >
						<?php 
						$d_count = 1;
						$total_deductions = 0;
						if(isset($ded_govt)){ 
							foreach($ded_govt as $transaction){ 
								if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
									$total_deductions += $transaction->Amount;
								?>
								<tr>
									<td style="width:  2%" align="left">&nbsp;</td>
									<td style="width: 66%" align="left"><?php echo $transaction->{'Transaction Label'}.' ';?></td>
									<td style="width: 30%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
									<td style="width:  2%" align="left">&nbsp;</td>
								</tr> <?php
								$d_count++;
							}
						}
						if(isset($ded_attnd)){ 
							foreach($ded_attnd as $transaction){ 
								if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
									$total_deductions += $transaction->Amount;
								?>
								<tr>
									<td style="width:  2%" align="left">&nbsp;</td>
									<td style="width: 66%" align="left"><?php echo $transaction->{'Transaction Label'}.' ';?>
										<table><tr><td><i style="font-size:6;"><?php echo '( '.$transaction->{'Qty'}.' hr/s )' ;?></i></td></tr></table>
									</td>
									<td style="width: 30%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
									<td style="width:  2%" align="left">&nbsp;</td>
								</tr> <?php
								$d_count++;
							}
						}
						if(isset($ded_other)){ 
							foreach($ded_other as $transaction){ 
								if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
									$total_deductions += $transaction->Amount;
								?>
								<tr>
									<td style="width:  2%" align="left">&nbsp;</td>
									<td style="width: 66%" align="left"><?php echo $transaction->{'Transaction Label'}.' ';?></td>
									<td style="width: 30%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
									<td style="width:  2%" align="left">&nbsp;</td>
								</tr> <?php
								$d_count++;
							}
						}
						if(isset($ded_loan)){ 
							foreach($ded_loan as $transaction){ 
								$loan_bal_amt = '';
								if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
									$total_deductions += $transaction->Amount;
									if( !empty($transaction->{'Record Id'}) || $transaction->{'Record Id'} != '' ){
										$loan_bal = $db->query("SELECT IFNULL( ROUND( SUM(AES_DECRYPT(`amount`,`encryption_key`() ) ), 2) ,0) as amount FROM {$db->dbprefix}payroll_partners_loan_payment
														  WHERE partner_loan_id = ".$transaction->{'Record Id'}." AND date_paid > '".$value->{'Payroll Date'}."' AND paid = 1")->row();
										$loan_bal_amt = $transaction->{'Running Balance'} + $loan_bal->amount;
										$loan_bal_amt = '( Running Bal.  '.number_format( $loan_bal_amt, 2, '.',',').' )';
									}
								?>
								<tr>
									<td style="width:  2%" align="left">&nbsp;</td>
									<td style="width: 66%" align="left"><?php echo $transaction->{'Transaction Label'}.' ';?>
										<table><tr><td><i style="font-size:6;"><?php echo $loan_bal_amt;?></i></td></tr></table>
									</td>
									<td style="width: 30%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
									<td style="width:  2%" align="left">&nbsp;</td>
								</tr> <?php
								$d_count++;
							}
						}
						if($d_count != 20){
							for ($space=1; $space <= (20 - $d_count); $space++) 
		                    {?>
		                        <tr><td>&nbsp;</td></tr>
		                  	<?php
		                	}
						} ?>
					</table>
					<table>
						<tr>
							<td style="width:  2%" align="left">&nbsp;</td>
							<td style="width: 64%" align="left" font-size:"9" ><h3>Total Deductions :</h3></td>
							<td style="width: 32%" align="right" font-size:"9" ><h3><?php echo number_format($total_deductions , 2, '.', ',')?></h3></td>
							<td style="width:  2%" align="left">&nbsp;</td>
						</tr>
						<tr>
							<td style="width:  2%" align="left">&nbsp;</td>
							<td style="width: 64%; " align="left" font-size:"2" >&nbsp;</td>
							<td style="width: 32%; border-top-width: solid 1px black; " align="right" font-size:"2" >&nbsp;</td>
							<td style="width:  2%" align="left" font-size:"2" >&nbsp;</td>
						</tr>
						<tr><td></td></tr>
						<tr>
							<td style="width: 10%" align="left">&nbsp;</td>
							<td style="width: 56%" align="left"><b>Year To Date:</b></td>
							<td style="width: 32%" align="right">&nbsp;</td>
							<td style="width:  2%" align="left">&nbsp;</td>
						</tr>
						<tr>
							<td style="width: 14%" align="left">&nbsp;</td>
							<td style="width: 52%" align="left">Total Income Gross</td>
							<td style="width: 32%" align="right"><?php echo number_format($ytd->gross, 2, '.', ','); ?></td>
							<td style="width:  2%" align="left">&nbsp;</td>
						</tr>
						<tr>
							<td style="width: 14%" align="left">&nbsp;</td>
							<td style="width: 52%" align="left">Total WithHolding Tax</td>
							<td style="width: 32%" align="right"><?php echo number_format($ytd->whtax, 2, '.', ','); ?></td>
							<td style="width:  2%" align="left">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
    <?php
	endforeach; 
?>