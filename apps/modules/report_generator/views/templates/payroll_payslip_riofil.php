<style type="text/css">
    .bb td, .bb th {
     border-bottom: solid 1px black;
    }
  </style>
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
        //debug($this->db->last_query()); die();
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
        <table width="100%" >
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
        <table style="height: 500px; page-break-after:always;" >
            <tr>
                <td style="width: 33%; height: 15px; vertical-align: middle;" align="center" font-size="9"></td>
                <td style="width: 33%; height: 15px; vertical-align: middle;" align="center" font-size="9"></td>
                <td style="width: 33%; height: 15px; vertical-align: middle;" align="center" font-size="9"></td>
            </tr>
            <tr>
                <td style="width: 33%; ">
                    <table>
                        <?php 
                        $e_count = 1;
                        $gross = 0;
                        $salary_amount = 0;
                        $ot_amount = 0;
                        $basic_pay = 0;
                        $gross_pay = 0;
                        $net_pay = 0;
                        if(isset($salary)){ 
                            if(empty($salary) || $salary == ''){ ?>
                            <tr>
                                <td style="width:  2%" align="left">&nbsp;</td>
                                <td style="width: 66%" align="left">Basic Salary </td>
                                <td style="width: 30%" align="right">0.00</td>
                                <td style="width:  2%" align="left">&nbsp;</td>
                            </tr>
                        <?php }
                        else{
                            foreach($salary as $transaction){ 
                                if( !empty($transaction->Amount) && $transaction->Amount != '0.00' ){
                                    $gross += $transaction->Amount;
                                    $salary_amount = $transaction->Amount;
                                    $e_count++;
                                }
                            }
                        } 
                        $basic_pay = $salary_amount - $value->{'Adjustment'} - $value->{'Absent Tardy'};
                        ?>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Basic Salary </td>
                            <td style="width: 30%" align="right"><?php echo number_format($basic_pay, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr> 

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Adjustment* </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Adjustment'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>
                        <tr class="bb">
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Absent/Tardy </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Absent Tardy'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Basic Pay </td>
                            <td style="width: 30%" align="right"><?php echo number_format($basic_pay, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>
                        <tr >
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left"><b>Supplementary: </b></td>
                            <td style="width: 30%" align="right"></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <?php
                        if(isset($overtime)){
                            
                            if(empty($overtime) || $overtime == ''){ ?>
                            <tr>
                                <td style="width:  2%" align="left">&nbsp;</td>
                                <td style="width: 66%" align="left">Overtime*</td>
                                <td style="width: 30%" align="right">0.00</td>
                                <td style="width:  2%" align="left">&nbsp;</td>
                            </tr>
                        <?php }
                        else {
                            foreach($overtime as $transaction){ 
                                if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                    $gross += $transaction->Amount;
                                    $ot_amount = $transaction->Amount;
                                ?>
                                <tr>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                    <td style="width: 66%" align="left">Overtime*
                                        <table><tr><td><i style="font-size:6;"><?php echo '( '.$transaction->{'Qty'}.' hr/s )' ;?></i></td></tr></table>
                                    </td>
                                    <td style="width: 30%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                </tr> <?php
                                $e_count++;
                            }
                        }

                        } 
                        $gross_pay = $basic_pay + $ot_amount + $value->{'Other Taxable'};

                        $ded_govt_amount = 0;
                        $ded_loan_amount = 0;
                        $ded_other_amount = 0;
                        ?>

                        <tr class="bb">
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Other Taxable* </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Other Taxable'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Gross Pay </td>
                            <td style="width: 30%" align="right"><?php echo number_format($gross_pay, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left"><b>Deductions: </b></td>
                            <td style="width: 30%" align="right"></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

<!--                         <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">SSS </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Sss'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Philhealth </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Philhealth'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Pag-ibig </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Pag Ibig'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr> -->
                        
                        <?php

                        if(isset($ded_govt)){ 

                            if(empty($ded_govt) || $ded_govt == ''){ ?>
                                <tr>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                    <td style="width: 66%" align="left">W/H Tax</td>
                                    <td style="width: 30%" align="right">0.00</td>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                </tr>
                            <?php }
                            else{
                                $ded_govt_amount = 0;
                                foreach($ded_govt as $transaction){ 
                                    if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                        //$total_deductions += $transaction->Amount;
                                        $ded_govt_amount += $transaction->Amount;
                                    ?>
                                    <tr>
                                        <td style="width:  2%" align="left">&nbsp;</td>
                                        <td style="width: 66%" align="left"><?php echo $transaction->{'Transaction Label'} ?></td>
                                        <td style="width: 30%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
                                        <td style="width:  2%" align="left">&nbsp;</td>
                                    </tr> <?php
                                   // $d_count++;
                                }
                            }
                        }
                            
                        if(isset($ded_loan)){ 
                            if(empty($ded_loan) || $ded_loan == ''){ ?>
                                <tr>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                    <td style="width: 66%" align="left">Loan Payments*</td>
                                    <td style="width: 30%" align="right">0.00</td>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                </tr>
                            <?php }
                            else{
                                foreach($ded_loan as $transaction){ 
                                    $loan_bal_amt = '';
                                    if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                        //$total_deductions += $transaction->Amount;
                                        $ded_loan_amount = $transaction->Amount;
                                        if( !empty($transaction->{'Record Id'}) || $transaction->{'Record Id'} != '' ){
                                            $loan_bal = $this->db->query("SELECT IFNULL( ROUND( SUM(AES_DECRYPT(`amount`,`encryption_key`() ) ), 2) ,0) as amount FROM {$this->db->dbprefix}payroll_partners_loan_payment
                                                              WHERE partner_loan_id = ".$transaction->{'Record Id'}." AND date_paid > '".$value->{'Payroll Date'}."' AND paid = 1")->row();
                                            $loan_bal_amt = $transaction->{'Running Balance'} + $loan_bal->amount;
                                            $loan_bal_amt = '( Running Bal.  '.number_format( $loan_bal_amt, 2, '.',',').' )';
                                        }
                                    ?>
                                    <tr>
                                        <td style="width:  2%" align="left">&nbsp;</td>
                                        <td style="width: 66%" align="left">Loan Payments*<br/>
                                            <table><tr><td><i style="font-size:6;"><?php echo $loan_bal_amt;?></i></td></tr></table>
                                        </td>
                                        <td style="width: 30%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
                                        <td style="width:  2%" align="left">&nbsp;</td>
                                    </tr> 
                                    <?php
                                    //$d_count++;
                                }
                            }
                        }

                        if(isset($ded_attnd)){ 
                            $ded_attnd_amount  = 0;
                            foreach($ded_attnd as $ded_attnd_row){ 
                                $ded_attnd_amount += $ded_attnd_row->Amount;
                            }
                        }                        

                        if(isset($ded_other)){ 
                            if(empty($ded_other) || $ded_other == ''){ ?>
                                <tr class="bb">
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                    <td style="width: 66%" align="left">Other Deductions </td>
                                    <td style="width: 30%" align="right"><?php echo number_format($ded_attnd_amount, 2, '.', ',')?></td>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                </tr>
                            <?php }
                            else{
                                foreach($ded_other as $transaction){ 
                                    if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                        $ded_other_amount += $transaction->Amount; 
                                }?>
                                <tr class="bb">
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                    <td style="width: 66%" align="left">Other Deductions </td>
                                    <td style="width: 30%" align="right"><?php echo number_format($ded_other_amount + $ded_attnd_amount, 2, '.', ',')?></td>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                </tr>
                        <?php
                            }
                        }

                        $total_ded = $ded_govt_amount + $ded_attnd_amount + $ded_loan_amount + $ded_other_amount; 
                        $netpay = ($gross_pay - $total_ded) + $value->{'Nontax Income'};
                        ?>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Total Deductions </td>
                            <td style="width: 30%" align="right"><?php echo number_format($total_ded, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left"><b>Add: </b></td>
                            <td style="width: 30%" align="right"></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>
                        <tr class="bb">
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Non-Tax Income* </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Nontax Income'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left"><b>NET PAY </b> </td>
                            <td style="width: 30%" align="right"><?php echo number_format($netpay, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>
                  

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">TAX STATUS </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Tax Status'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>




                 <?php     if(isset($earning)){ 
                            foreach($earning as $transaction){ 
                                if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                    $gross += $transaction->Amount;
                                ?>
                                <?php
                                $e_count++;
                            }
                        }
                        if(isset($bonus)){
                            foreach($bonus as $transaction){ 
                                if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                    $gross += $transaction->Amount;
                                ?>
                                 <?php
                                $e_count++;
                            }
                        } 
                        if(isset($benefits)){
                            foreach($benefits as $transaction){ 
                                if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                    $gross += $transaction->Amount;
                                ?>
                                 <?php
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
                    <?php $total_ot_amount=0; ?>
                        <tr class="bb">
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left"><b>*OVERTIME</b></td>
                            <td style="width: 19%" align="left"><b>OT/ND </b></td>
                            <td style="width: 22%" align="right"><b>Hrs </b></td>
                            <td style="width: 28%" align="right"><b>Amount</b></td>
                            <td style="width:  4%" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                            
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">ND </td>
                            <td style="width: 19%" align="left"><?php echo number_format($value->{'Nd Otnd'}, 2, '.', ',')?></td>
                            <td style="width: 22%" align="right"><?php echo number_format($value->{'Nd Hrs'}, 2, '.', ',')?></td>
                            <td style="width: 28%" align="right"><?php $total_ot_amount += $value->{'Nd'}; echo number_format($value->{'Nd'}, 2, '.', ',')?></td>
                            <td style="width:  4%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">REG </td>
                            <td style="width: 19%" align="left"><?php echo number_format($value->{'Reg Otnd'}, 2, '.', ',')?></td>
                            <td style="width: 22%" align="right"><?php echo number_format($value->{'Reg Hrs'}, 2, '.', ',')?></td>
                            <td style="width: 28%" align="right"><?php echo $total_ot_amount += $value->{'Reg'}; number_format($value->{'Reg'}, 2, '.', ',')?></td>
                            <td style="width:  4%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">REST </td>
                            <td style="width: 19%" align="left"><?php echo number_format($value->{'Rest Otnd'}, 2, '.', ',')?></td>
                            <td style="width: 22%" align="right"><?php echo number_format($value->{'Rest Hrs'}, 2, '.', ',')?></td>
                            <td style="width: 28%" align="right"><?php echo $total_ot_amount += $value->{'Rest'}; number_format($value->{'Rest'}, 2, '.', ',')?></td>
                            <td style="width:  4%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">REST X8 </td>
                            <td style="width: 19%" align="left"><?php echo number_format($value->{'Rest X8 Otnd'}, 2, '.', ',')?></td>
                            <td style="width: 22%" align="right"><?php echo number_format($value->{'Rest X8 Hrs'}, 2, '.', ',')?></td>
                            <td style="width: 28%" align="right"><?php echo $total_ot_amount += $value->{'Rest X8'}; number_format($value->{'Rest X8'}, 2, '.', ',')?></td>
                            <td style="width:  4%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">SP </td>
                            <td style="width: 19%" align="left"><?php echo number_format($value->{'Sp Otnd'}, 2, '.', ',')?></td>
                            <td style="width: 22%" align="right"><?php echo number_format($value->{'Sp Hrs'}, 2, '.', ',')?></td>
                            <td style="width: 28%" align="right"><?php echo $total_ot_amount += $value->{'Sp'}; number_format($value->{'Sp'}, 2, '.', ',')?></td>
                            <td style="width:  4%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">SP X8 </td>
                            <td style="width: 19%" align="left"><?php echo number_format($value->{'Sp X8 Otnd'}, 2, '.', ',')?></td>
                            <td style="width: 22%" align="right"><?php echo number_format($value->{'Sp X8 Hrs'}, 2, '.', ',')?></td>
                            <td style="width: 28%" align="right"><?php $total_ot_amount += $value->{'Sp X8'}; echo number_format($value->{'Sp X8'}, 2, '.', ',')?></td>
                            <td style="width:  4%" align="left">&nbsp;</td>
                        </tr>

                        <tr>

                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">REST/SP </td>
                            <td style="width: 19%" align="left"><?php echo number_format($value->{'Rest Sp Otnd'}, 2, '.', ',')?></td>
                            <td style="width: 22%" align="right"><?php echo number_format($value->{'Rest Sp Hrs'}, 2, '.', ',')?></td>
                            <td style="width: 28%" align="right"><?php $total_ot_amount += $value->{'Rest Sp'}; echo number_format($value->{'Rest Sp'}, 2, '.', ',')?></td>
                            <td style="width:  4%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">REST/SP X8 </td>
                            <td style="width: 19%" align="left"><?php echo number_format($value->{'Rest Sp X8 Otnd'}, 2, '.', ',')?></td>
                            <td style="width: 22%" align="right"><?php echo number_format($value->{'Rest Sp X8 Hrs'}, 2, '.', ',')?></td>
                            <td style="width: 28%" align="right"><?php  $total_ot_amount += $value->{'Rest Sp X8'}; echo number_format($value->{'Rest Sp X8'}, 2, '.', ',')?></td>
                            <td style="width:  4%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">LEGAL </td>
                            <td style="width: 19%" align="left"><?php echo number_format($value->{'Legal Otnd'}, 2, '.', ',')?></td>
                            <td style="width: 22%" align="right"><?php echo number_format($value->{'Legal Hrs'}, 2, '.', ',')?></td>
                            <td style="width: 28%" align="right"><?php  $total_ot_amount += $value->{'Legal'}; echo number_format($value->{'Legal'}, 2, '.', ',')?></td>
                            <td style="width:  4%" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">LEGAL X8 </td>
                            <td style="width: 19%" align="left"><?php echo number_format($value->{'Legal X8 Otnd'}, 2, '.', ',')?></td>
                            <td style="width: 22%" align="right"><?php echo number_format($value->{'Legal X8 Hrs'}, 2, '.', ',')?></td>
                            <td style="width: 28%" align="right"><?php $total_ot_amount += $value->{'Legal X8'}; echo number_format($value->{'Legal X8'}, 2, '.', ',')?></td>
                            <td style="width:  4%" align="left">&nbsp;</td>
                        </tr>

                        <tr>

                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">REST LEGAL </td>
                            <td style="width: 19%" align="left"><?php echo number_format($value->{'Rest Legal Otnd'}, 2, '.', ',')?></td>
                            <td style="width: 22%" align="right"><?php echo number_format($value->{'Rest Legal Hrs'}, 2, '.', ',')?></td>
                            <td style="width: 28%" align="right"><?php  $total_ot_amount += $value->{'Rest Legal'}; echo number_format($value->{'Rest Legal'}, 2, '.', ',')?></td>
                            <td style="width:  4%" align="left">&nbsp;</td>
                        </tr>

                        <tr class="bb">

                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">REST LEG X8 </td>
                            <td style="width: 19%" align="left"><?php echo number_format($value->{'Rest Leg X8 Otnd'}, 2, '.', ',')?></td>
                            <td style="width: 22%" align="right"><?php echo number_format($value->{'Rest Leg X8 Hrs'}, 2, '.', ',')?></td>
                            <td style="width: 28%" align="right"><?php  $total_ot_amount += $value->{'Rest Leg X8'}; echo number_format($value->{'Rest Leg X8'}, 2, '.', ',')?></td>
                            <td style="width:  4%" align="left">&nbsp;</td>
                        </tr>

                        <tr>

                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left"> </td>
                            <td style="width: 19%" align="left"></td>
                            <td style="width: 22%" align="right"></td>
                            <td style="width: 28%" align="right"><?php echo number_format($total_ot_amount, 2, '.', ',')?></td>
                            <td style="width:  4%" align="left">&nbsp;</td>
                        </tr>

                        <tr><td></td></tr>
                        <tr class="bb">
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left"><b>Year-To-Date Summaries </b> </td>
                            <td style="width: 30%" align="right">&nbsp;</td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">YTD Gross </td>
                            <td style="width: 30%" align="right"><?php echo number_format($ytd->ytd_gross, 2, '.', ','); ?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">YTD W/H Tax </td>
                            <td style="width: 30%" align="right"><?php echo number_format($ytd->ytd_tax, 2, '.', ','); ?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">YTD SSS </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Ytd Sss'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">YTD PhilHealth </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Ytd Philhealth'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>
                       
                       <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">YTD Pag-Ibig </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Ytd Pag Ibig'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <?php 
                        $d_count = 1;
                        $total_deductions = 0;
                        if(isset($ded_govt)){ 
                            foreach($ded_govt as $transaction){ 
                                if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                    $total_deductions += $transaction->Amount;
                                ?>
                                 <?php
                                $d_count++;
                            }
                        }
                        if(isset($ded_attnd)){ 
                            foreach($ded_attnd as $transaction){ 
                                if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                    $total_deductions += $transaction->Amount;
                                ?>
                                <?php
                                $d_count++;
                            }
                        }
                        if(isset($ded_other)){ 
                            foreach($ded_other as $transaction){ 
                                if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                    $total_deductions += $transaction->Amount;
                                ?> <?php
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
                <td style="width: 2%; "></td>
                <td style="width: 33%; ">
                    <table>
                        <tr class="bb">
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left"><b>LOAN</b></td>
                            <td style="width: 33%" align="left"><b>PAYMENTS </b></td>
                            <td style="width: 30%" align="right"><b>BALANCE </b></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr >
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">SSS Sal</td>
                            <td style="width: 33%" align="left"><?php echo number_format($value->{'Sss Sal Loan Payments'}, 2, '.', ',')?></td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Sss Sal Loan Balance'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr >
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">SSS Sal</td>
                            <td style="width: 33%" align="left"><?php echo number_format($value->{'Sss Cal Loan Payments'}, 2, '.', ',')?></td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Sss Cal Loan Balance'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr >
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">HDMF Sal</td>
                            <td style="width: 33%" align="left"><?php echo number_format($value->{'Hdmf Sal Loan Payments'}, 2, '.', ',')?></td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Hdmf Sal Loan Balance'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr >
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">HDMF Cal</td>
                            <td style="width: 33%" align="left"><?php echo number_format($value->{'Hdmf Cal Loan Payments'}, 2, '.', ',')?></td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Hdmf Cal Loan Balance'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr >
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width:  33%" align="left">Company</td>
                            <td style="width: 33%" align="left">&nbsp;</td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Company Loan Payments'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Health Card </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Health Card'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>
                        <tr><td></td></tr>
                        <?php
                        if(isset($ded_other)){ 
                            if(empty($ded_other) || $ded_other == ''){ ?>
                            <tr>
                                <td style="width:  2%" align="left">&nbsp;</td>
                                <td style="width: 66%" align="left">Other Deductions </td>
                                <td style="width: 30%" align="right">0.00</td>
                                <td style="width:  2%" align="left">&nbsp;</td>
                            </tr>
                        <?php }
                        else{
                            foreach($ded_other as $transaction){ 
                                if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                ?>
                                <tr>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                    <td style="width: 66%" align="left">Other Deductions <br/></td>
                                    <td style="width: 30%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                </tr>  <?php
                                //$d_count++;
                            }
                        }
                        }?>
                        <tr><td></td></tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Other 1 </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Other Deduction One'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Other 2 </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Other Deduction Two'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Other 3 </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Other Deduction Three'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Adjustment* : </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Adjustment'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Non-Tax Income* : </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Nontax Income'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Other Taxable* : </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Other Taxable'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Loan Payments </td>
                            <td style="width: 30%" align="right">&nbsp;</td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">SSS Sal Loan </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Sss Sal Loan Payments'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">SSS Cal Loan </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Sss Cal Loan Payments'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">HDMF Sal Loan </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Hdmf Sal Loan Payments'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">HDMF Cal Loan </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Hdmf Cal Loan Payments'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="width:  2%" align="left">&nbsp;</td>
                            <td style="width: 66%" align="left">Company Loan </td>
                            <td style="width: 30%" align="right"><?php echo number_format($value->{'Company Loan Payments'}, 2, '.', ',')?></td>
                            <td style="width:  2%" align="left">&nbsp;</td>
                        </tr>


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
            </tr>
            
        </table>
    <?php
    endforeach; 
?>