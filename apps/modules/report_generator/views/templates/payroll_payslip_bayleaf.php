<?php
    $userID = '';
    foreach ($result as $value):
        if($userID == ''){?>
            <div>&nbsp;</div>
        <?php
        }else{?>
            <div style="page-break-before: always;">&nbsp;</div>
        <?php
        }

        $userID = $value->{'User Id'};
        $salary = $this->db->query($query." AND `group` = 'Earnings' AND `type` = 'salary' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $overtime = $this->db->query($query." AND `group` = 'Earnings' AND `type` = 'overtime' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $bonus = $this->db->query($query." AND `group` = 'Earnings' AND `type` = 'bonus' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $benefits = $this->db->query($query." AND `group` = 'Earnings' AND `type` = 'benefits' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $earning = $this->db->query($query." AND `group` = 'Earnings' AND `type` = 'Earnings' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $ded_govt = $this->db->query($query." AND `group` = 'Deductions' AND `type` = 'government' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label DESC, transaction_class_code DESC' )->result();
        $ded_attnd = $this->db->query($query." AND `group` = 'Deductions' AND `type` = 'attnd_ded' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $ded_other = $this->db->query($query." AND `group` = 'Deductions' AND `type` = 'Oth_ded' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $ded_loan = $this->db->query($query." AND `group` = 'Deductions' AND `type` = 'Loan' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        // $result = $value;
        $cnt_ded = count($ded_govt) + count($ded_attnd) + count($ded_other) + count($ded_loan);
        $cnt_loan = count($ded_loan);
        $cnt_earn = count($salary) + count($overtime) + count($bonus) + count($benefits) + count($earning);
        $sp_cnt = $cnt_earn > $cnt_ded ? $cnt_earn : $cnt_ded > $cnt_loan ? $cnt_ded : $cnt_loan;
        $cnt = $sp_cnt > 3 ? (20 - $sp_cnt) : 20;
        ?>
        <br />
        <table width="100%">
            <?php

                $logo = $this->db->get_where('users_company', array('company_id' => $value->{'Company Id'}))->row();
                $ytd = $this->db->query("SELECT IFNULL( ROUND( SUM( (   CASE 
                                                WHEN ( `group` = 'earnings' AND transaction_type_id = 1 ) THEN 1 
                                                WHEN ( `group` = 'deductions' AND transaction_type_id = 5 ) THEN -1 
                                                ELSE 0 END ) * amount ),2),0) AS ytd_gross,
                                            IFNULL( ROUND( SUM( (  CASE WHEN transaction_code = 'whtax' THEN 1 ELSE 0 END ) * amount ),2),0) AS ytd_tax,
                                            IFNULL( ROUND( SUM( (  CASE WHEN `type` = 'netpay' THEN 1 ELSE 0 END ) * amount ),2),0) AS ytd_net,
                                            IFNULL( ROUND( SUM( (  CASE WHEN ( `group` = 'earnings' AND transaction_type_id = 1 ) THEN 1 ELSE 0 END ) * amount ),2),0) AS ytd_earning,
                                            IFNULL( ROUND( SUM( (  CASE WHEN ( `group` = 'deductions' AND `type` != 'government' ) THEN 1 ELSE 0 END ) * amount ),2),0) AS ytd_deduction,
                                            IFNULL( ROUND( SUM( (  CASE WHEN ( `group` = 'deductions' AND `type` = 'government' AND transaction_code != 'whtax') THEN 1 ELSE 0 END ) * amount ),2),0) AS ytd_contri
                                        FROM payroll_payslip
                                        WHERE user_id = ".$value->{'User Id'}." AND payroll_date <= '".$value->{'Payroll Date'}."' AND YEAR(payroll_date) = ".date("Y",strtotime($value->{'Payroll Date'})) )->row();
            ?>
            <tr>
                <td width="100%" >
                    <table>
                        <tr><td style="font-size: 5.4;">&nbsp;</td></tr>
                        <tr>
                            <td align="left" style="font-size: 10;">&nbsp;&nbsp;<b><?php echo $value->Company;?></b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" >
                    <table>
                        <tr>
                            <td align="left" style="font-size: 10;">&nbsp;&nbsp;<?php echo $value->Address;?>, <?php echo $value->City;?></td>
                            <td align="right" style="font-size: 10;">&nbsp;&nbsp;<b>EMPLOYEE CODE: <?php echo $value->{'Id Number'}?></b></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table style="border-top: solid 1px black;">
            <tr><td></td></tr>
        </table>
        <table>
            <tr>
                <td style="width:  50%" align="left" font-size:"10" ><b>Employee Name: <?php echo $value->{'Full Name'}?></b></td>
                <td style="width:  50%" align="left" font-size:"10" ><b>Tax Code : <?php echo $value->{'Taxcode'} ?></b></td>
            </tr>
            <tr>
                <td><b>Cost Center : </b></td>
                <td><b>Period Covered : <?php echo date( 'm/d/y', strtotime($value->{'Date From'}))?> - <?php echo date( 'm/d/y', strtotime($value->{'Date To'}))?></b></td>
            </tr>

        </table>
        <table border="1" style="height: 500px;">
            <tr>
                <td style="width: 33%; height: 15px; vertical-align: middle;" align="center" font-size="9"><h4>Earnings</h4></td>
                <td style="width: 33%; height: 15px; vertical-align: middle;" align="center" font-size="9"><h4>Deductions</h4></td>
                <td style="width: 33%; height: 15px; vertical-align: middle;" align="left" font-size="9"><h4>&nbsp;&nbsp;&nbsp;&nbsp;Type of Loan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payment&nbsp;&nbsp;&nbsp;&nbsp;Balance</h4></td>
            </tr>
            <tr>
                <td style="width: 33%; ">
                    <table>
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
                        if($e_count != $cnt){
                            for ($space=1; $space <= ($cnt - $e_count); $space++) 
                            {?>
                                <tr><td>&nbsp;</td></tr>
                            <?php
                            }
                        } ?>
                    </table>
                    
                </td>
                <td style="width: 33%; ">
                    <table>
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
                                    <td style="width: 66%" align="left"><?php echo $transaction->{'Transaction Label'}.' ';?><br/>
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
                                        $loan_bal = $this->db->query("SELECT IFNULL( ROUND( SUM(AES_DECRYPT(`amount`,`encryption_key`() ) ), 2) ,0) as amount FROM {$this->db->dbprefix}payroll_partners_loan_payment
                                                          WHERE partner_loan_id = ".$transaction->{'Record Id'}." AND date_paid > '".$value->{'Payroll Date'}."' AND paid = 1")->row();
                                        $loan_bal_amt = $transaction->{'Running Balance'} + $loan_bal->amount;
                                        $loan_bal_amt = '( Running Bal.  '.number_format( $loan_bal_amt, 2, '.',',').' )';
                                    }
                                ?>
                                <tr>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                    <td style="width: 66%" align="left"><?php echo $transaction->{'Transaction Label'}.' ';?><br/>
                                        <table><tr><td><i style="font-size:6;"><?php echo $loan_bal_amt;?></i></td></tr></table>
                                    </td>
                                    <td style="width: 30%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                </tr> 
                                <?php
                                $d_count++;
                            }
                        }
                        if($d_count != $cnt){
                            for ($space=1; $space <= ($cnt - $d_count); $space++) 
                            {?>
                                <tr><td>&nbsp;</td></tr>
                            <?php
                            }
                        } ?>
                    </table>                  
                </td>
                <td style="width: 33%; ">
                    <table>
                        <?php
                        if(isset($ded_loan)){ 
                            foreach($ded_loan as $transaction){ 
                                $loan_bal_amt = '';
                                if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                    $total_deductions += $transaction->Amount;
                                    if( !empty($transaction->{'Record Id'}) || $transaction->{'Record Id'} != '' ){
                                        $loan_bal = $this->db->query("SELECT IFNULL( ROUND( SUM(AES_DECRYPT(`amount`,`encryption_key`() ) ), 2) ,0) as amount FROM {$this->db->dbprefix}payroll_partners_loan_payment
                                                          WHERE partner_loan_id = ".$transaction->{'Record Id'}." AND date_paid > '".$value->{'Payroll Date'}."' AND paid = 1")->row();
                                        $loan_bal_amt = $transaction->{'Running Balance'} + $loan_bal->amount;
                                        $loan_bal_amt = number_format( $loan_bal_amt, 2, '.',',');
                                    }
                                ?>
                                <tr>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                    <td style="width: 50%" align="left"><?php echo $transaction->{'Transaction Label'}.' ';?>
                                    </td>
                                    <td style="width: 23%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
                                    <td style="width: 23%" align="right"><?php echo $loan_bal_amt;?></td>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                </tr> <?php
                                $d_count++;
                            }
                        }
                        if($d_count != $cnt){
                            for ($space=1; $space <= ($cnt - $d_count); $space++) 
                            {?>
                                <tr><td>&nbsp;</td></tr>
                            <?php
                            }
                        } ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width: 33%;" >
                    <table>
                        <tr>
                            <td  align="left" font-size:"9">Gross Earnings : <b><?php echo number_format($gross , 2, '.', ',')?></b></td>
                        </tr>
                        <tr>
                            <td  align="left" font-size:"9">YTD Gross: <b><?php echo number_format($ytd->ytd_gross, 2, '.', ','); ?></b></td>
                        </tr>
                        <tr>
                            <td  align="left" font-size:"9">YTD Net: <b><?php echo number_format($ytd->ytd_net, 2, '.', ','); ?></b></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 33%; ">
                    <table>
                        <tr>
                            <td align="left" font-size:"9" >Total Deductions : <b><?php echo number_format($total_deductions , 2, '.', ',')?></b></td>
                        </tr>
                        <tr>
                            <td  align="left" font-size:"9">YTD Earnings: <b><?php echo number_format($ytd->ytd_earning, 2, '.', ','); ?></b></td>
                        </tr>
                        <tr>
                            <td align="left" font-size:"9">YTD Deductions: <b><?php echo number_format($ytd->ytd_deduction, 2, '.', ','); ?></b></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 33%; ">
                    <table>
                        <tr>
                            <td align="left">Net Pay : <b><?php echo number_format($value->Amount , 2, '.', ',')?></b></td>
                        </tr>
                        <tr>
                            <td align="left" font-size:"9">YTD Contri: <b><?php echo number_format($ytd->ytd_contri, 2, '.', ','); ?></b></td>
                        </tr>
                        <tr>
                            <td align="left" font-size:"9">YTD Tax: <b><?php echo number_format($ytd->ytd_tax, 2, '.', ','); ?></b></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    <?php
    endforeach; 
?>