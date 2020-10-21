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

        $overtime = 0;
        $userID = $value->{'User Id'};
        $salary = $this->db->query($query." AND `group` = 'Earnings' AND `type` = 'salary' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        //debug($this->db->last_query()); die();
        $overtime_qry = $this->db->query($query." AND `group` = 'Earnings' AND `type` = 'overtime' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' );
        if ($overtime_qry && $overtime_qry->num_rows() > 0){
            $overtime = $overtime_qry->result();
        }
        $bonus = $this->db->query($query." AND `group` = 'Earnings' AND `type` = 'bonus' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $benefits = $this->db->query($query." AND `group` = 'Earnings' AND `type` = 'benefits' AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
        $earning = $this->db->query($query." AND `group` = 'Earnings' AND (`type` = 'Earnings' OR `type` = 'Bonus') AND user_id = ".$value->{'User Id'}.' ORDER BY transaction_label, transaction_class_code' )->result();
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

        $adjustment = 0;
        $adjustment_result = $this->db->query($query);

/*        debug($this->db->last_query());
        die();
*/
        if ($adjustment_result && $adjustment_result->num_rows() > 0){
            foreach ($adjustment_result->result() as $row) {
                $adjustment += $row->Adjustment;
            } 
        }

        if(isset($ded_attnd)){ 
            $absent_tardy_amount = 0;
            $absent_tardy_hrs = 0;
            foreach($ded_attnd as $ded_attnd_row){ 
                if( !empty($ded_attnd_row->Amount) && $ded_attnd_row->Amount != '0.00' ){
                    $absent_tardy_amount += $ded_attnd_row->Amount;
                    $absent_tardy_hrs += $ded_attnd_row->Qty;
                }
            }
        }        
        ?>
        <table width="100%" >
            <?php

                $logo = $this->db->get_where('users_company', array('company_id' => $value->{'Company Id'}))->row();
                $ytd = $this->db->query("SELECT IFNULL( ROUND( SUM( (   CASE 
                                                WHEN ( `group` = 'earnings' AND transaction_type_id = 1 ) THEN 1 
                                                WHEN ( `group` = 'deductions' AND transaction_type_id = 5 ) THEN -1 
                                                ELSE 0 END ) * amount ),2),0) AS ytd_gross,
                                            IFNULL( ROUND( SUM( (  CASE WHEN transaction_code = 'salary' THEN 1 ELSE 0 END ) * amount ),2),0) AS ytd_basic_pay,
                                            IFNULL( ROUND( SUM( (  CASE WHEN transaction_code = 'whtax' THEN 1 ELSE 0 END ) * amount ),2),0) AS ytd_tax,
                                            IFNULL( ROUND( SUM( (  CASE WHEN `type` = 'netpay' THEN 1 ELSE 0 END ) * amount ),2),0) AS ytd_net,
                                            IFNULL( ROUND( SUM( (  CASE WHEN ( `group` = 'earnings' AND transaction_type_id = 1 ) THEN 1 ELSE 0 END ) * amount ),2),0) AS ytd_earning,
                                            IFNULL( ROUND( SUM( (  CASE WHEN ( `group` = 'deductions' AND `type` != 'government' ) THEN 1 ELSE 0 END ) * amount ),2),0) AS ytd_deduction,
                                            IFNULL( ROUND( SUM( (  CASE WHEN ( `group` = 'deductions' AND `type` = 'government' AND transaction_code != 'whtax') THEN 1 ELSE 0 END ) * amount ),2),0) AS ytd_contri
                                        FROM payroll_payslip_riofil
                                        WHERE user_id = ".$value->{'User Id'}." AND payroll_date <= '".$value->{'Payroll Date'}."' AND YEAR(payroll_date) = ".date("Y",strtotime($value->{'Payroll Date'})) )->row();

                $ytd_time_record_summary = $this->db->query("SELECT
                                            IFNULL( ROUND( SUM( (  CASE WHEN day_type = 'regular' THEN 1 ELSE 0 END ) * hrs_actual ),2),0) AS ytd_hours_work
                                        FROM time_record_summary
                                        WHERE user_id = ".$value->{'User Id'}." AND payroll_date <= '".$value->{'Payroll Date'}."' AND YEAR(payroll_date) = ".date("Y",strtotime($value->{'Payroll Date'})) )->row();

                $lip_balance_result = $this->db->query("SELECT balance FROM time_form_balance WHERE user_id = ".$value->{'User Id'}." AND year = ".date("Y",strtotime($value->{'Payroll Date'}))."");
                $lip_balance = 0;
                if ($lip_balance_result && $lip_balance_result->num_rows() > 0){
                    $lip_balance = $lip_balance_result->row()->balance;
                }
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
                <td style="width:  53%" align="left" font-size:"10">&nbsp;&nbsp;&nbsp;&nbsp;<b>EMPLOYEE Number: <?php echo $value->{'Id Number'}?></b></td>                
                <td style="width:  47%" align="left" font-size:"10" ><b>Tax Code : <?php echo $value->{'Taxcode'} ?></b></td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Employee Name: <?php echo $value->{'Full Name'}?></b></td>                
                <td><b>Payroll Period: <?php echo date( 'm/d/y', strtotime($value->{'Date From Applicable'}))?> - <?php echo date( 'm/d/y', strtotime($value->{'Date To Applicable'}))?></b></td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Status : <?php echo $value->Status ?></b></td>
                <td><b>Position: <?php echo $value->Position ?></b></td>                
            </tr>
        </table>
        <table style="border-bottom: solid 1px black;">
            <tr><td></td></tr>
        </table>        
        <table style="height: 500px" >
            <tr>
                <td style="width: 50%; height: 10px; vertical-align: middle;" align="center" font-size="9"></td>
                <td style="width: 50%; height: 10px; vertical-align: middle;" align="center" font-size="9"></td>
            </tr>
            <tr>
                <td style="width: 50%; ">
                    <table>
                        <tr>
                            <td style="width: 100%" align="center"><b>EARNINGS</b></td>
                        </tr>                        
                        <?php 
                        $e_count = 1;
                        $gross = 0;
                        $salary_amount = 0;
                        $ot_amount = 0;
                        $total_ot_amount = 0;
                        $basic_pay = 0;
                        $gross_pay = 0;
                        $net_pay = 0;
                        $total_benefits = 0;
                        $total_earning = 0;
                        $ded_govt_amount = 0;
                        $ded_loan_amount = 0;
                        $ded_other_amount = 0;
                        $basic_rate = 0;

                        if(isset($salary)){ 
                            if(empty($salary) || $salary == ''){ ?>
                                <tr>
                                    <td style="width: 1%" align="left">&nbsp;</td>
                                    <td style="width: 51%" align="left">Basic Pay </td>
                                    <td style="width: 23%" align="right">0.00</td>
                                    <td style="width: 23%" align="right">0.00</td>
                                    <td style="width: 2%" align="left">&nbsp;</td>
                                </tr>
                        <?php }
                            else{
                                foreach($salary as $transaction){ 
                                    if( !empty($transaction->Amount) && $transaction->Amount != '0.00' ){
                                        $gross += $transaction->Amount;
                                        $salary_amount = $transaction->Amount;
                                        $basic_rate = $salary_amount;
                                        $basic_pay = $salary_amount - $value->{'Adjustment'} - $absent_tardy_amount;
                                    }
                                }
                            }
                        } 
                        ?>

                        <tr>
                            <td style="width: 1%" align="left">&nbsp;</td>
                            <td style="width: 51%" align="left">Basic Pay </td>
                            <td style="width: 23%" align="right">0.00</td>
                            <td style="width: 23%" align="right"><?php echo number_format($basic_rate, 2, '.', ',')?></td>
                            <td style="width: 2%" align="left">&nbsp;</td>
                        </tr> 

                        <tr>
                            <td style="width: 1%" align="left">&nbsp;</td>
                            <td style="width: 51%" align="left">Adjustment * </td>
                            <td style="width: 23%" align="right">0.00</td>
                            <td style="width: 23%" align="right"><?php echo number_format($adjustment, 2, '.', ',')?></td>
                            <td style="width: 2%" align="left">&nbsp;</td>
                        </tr>
                        <?php
                        if(isset($ded_attnd)){ 
                            foreach($ded_attnd as $ded){ 
                                if ($ded->{'Absent Hours'} > 0){
                        ?>
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">Absent </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ded->{'Absent Hours'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ded->{'Absent'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>                        
                        <?php
                                }
                                if ($ded->{'Lwop Hours'} > 0){ 
                        ?>
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">LWOP </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ded->{'Lwop Hours'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ded->{'Lwop'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>                                                
                        <?php
                                }
                                if ($ded->{'Late Hours'} > 0){
                        ?>
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">Late </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ded->{'Late Hours'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ded->{'Late'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>                                                                        
                        <?php
                                }    
                                if ($ded->{'Undertime Hours'} > 0){
                        ?>
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">Late </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ded->{'Undertime Hours'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ded->{'Undertime'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>                                                                                                
                        <?php
                                }       
                            }
                        }

                        if(isset($overtime) && $overtime > 0){
                            foreach($overtime as $ot){ 
                                if ($ot->{'Nd Hrs'} > 0){
                        ?>
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT ND </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Nd Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php $total_ot_amount += $ot->{'Reg Otnd'}; echo number_format($ot->{'Reg Otnd'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Reg Hrs'} > 0) { ?>
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT REG FIRST 8</td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Reg Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php $total_ot_amount += $ot->{'Reg'}; echo number_format($ot->{'Reg'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Rest Hrs'} > 0) { ?>
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT REST FIRST 8</td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Rest Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php $total_ot_amount += $ot->{'Rest'}; echo number_format($ot->{'Rest'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Rest X8 Hrs'} > 0) { ?>
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT REST NEXT 8 </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Rest X8 Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php $total_ot_amount += $ot->{'Rest X8'}; echo number_format($ot->{'Rest X8'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Sp Hrs'} > 0) { ?>
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT SPECIAL FIRST 8 </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Sp Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php $total_ot_amount += $ot->{'Sp'}; echo number_format($ot->{'Sp'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Sp X8 Hrs'} > 0) { ?>                        
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT SPECIAL NEXT 8 </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Sp X8 Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php $total_ot_amount += $ot->{'Sp X8'}; echo number_format($ot->{'Sp X8'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Rest Sp Hrs'} > 0) { ?>  
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT REST/SPECIAL FIRST 8 </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Rest Sp Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php $total_ot_amount += $ot->{'Rest Sp'}; echo number_format($ot->{'Rest Sp'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Rest Sp X8 Hrs'} > 0) { ?>  
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT REST/SP NEXT 8 </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Rest Sp X8 Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php  $total_ot_amount += $ot->{'Rest Sp X8'}; echo number_format($ot->{'Rest Sp X8'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Legal Hrs'} > 0) { ?>  
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT LEGAL FIRST 8</td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Legal Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php  $total_ot_amount += $ot->{'Legal'}; echo number_format($ot->{'Legal'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Legal X8 Hrs'} > 0) { ?>  
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT LEGAL NEXT 8 </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Legal X8 Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php $total_ot_amount += $ot->{'Legal X8'}; echo number_format($ot->{'Legal X8'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Rest Legal Hrs'} > 0) { ?>                          
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT REST LEGAL FIRST 8</td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Rest Legal Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php  $total_ot_amount += $ot->{'Rest Legal'}; echo number_format($ot->{'Rest Legal'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Rest Leg X8 Hrs'} > 0) { ?>                          
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT REST LEG NEXT 8 </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Rest Leg X8 Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php  $total_ot_amount += $ot->{'Rest Leg X8'}; echo number_format($ot->{'Rest Leg X8'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Doff Hrs'} > 0) { ?>  
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT DOFF FIRST 8</td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Doff Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php  $total_ot_amount += $ot->{'Doff'}; echo number_format($ot->{'Doff'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Doff X8 Hrs'} > 0) { ?>  
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT DOFF NEXT 8 </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Doff X8 Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php $total_ot_amount += $ot->{'Doff X8'}; echo number_format($ot->{'Doff X8'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>

                                <?php if ($ot->{'Dobot Hrs'} > 0) { ?>  
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT DOUBLE HOLIDAY FIRST 8</td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Dobot Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php  $total_ot_amount += $ot->{'Dobot'}; echo number_format($ot->{'Dobot'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Dobot X8 Hrs'} > 0) { ?>  
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT DOUBLE HOLIDAY NEXT 8 </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Dobot X8 Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php $total_ot_amount += $ot->{'Dobot X8'}; echo number_format($ot->{'Dobot X8'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Rest Dobot Hrs'} > 0) { ?>                          
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT REST DOUBLE HOLIDAY FIRST 8</td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Rest Dobot Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php  $total_ot_amount += $ot->{'Rest Dobot'}; echo number_format($ot->{'Rest Dobot'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($ot->{'Rest Dobot X8 Hrs'} > 0) { ?>                          
                                    <tr>
                                        <td style="width: 1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left">OT REST DOUBLE HOLIDAY NEXT 8 </td>
                                        <td style="width: 23%" align="right"><?php echo number_format($ot->{'Rest Dobot X8 Hrs'}, 2, '.', ',')?></td>
                                        <td style="width: 23%" align="right"><?php  $total_ot_amount += $ot->{'Rest Dobot X8'}; echo number_format($ot->{'Rest Dobot X8'}, 2, '.', ',')?></td>
                                        <td style="width: 2%" align="left">&nbsp;</td>
                                    </tr>                                    
                        <?php
                                }
                            }
        
                        }                                               
                        ?>

                        <?php
                        if(isset($benefits)){ 
                            foreach($benefits as $transaction){ 
                                if( !empty($transaction->Amount) && $transaction->Amount != '0.00' ){
                                    $total_benefits += $transaction->Amount;
                                    $qty = 0.00;
                                    if ($transaction->{'Transaction Label'} == 'Leave Conversion Non-Taxable' || $transaction->{'Transaction Label'} == 'Leave Conversion Taxable'){
                                        $qty = $transaction->Qty;
                                    }                                    
                        ?>
                                    <tr>
                                        <td style="width:  1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left"><?php echo $transaction->{'Transaction Label'} ?></td>
                                        <td style="width: 23%" align="right"><?php echo $qty ?></td>
                                        <td style="width: 23%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
                                        <td style="width:  2%" align="left">&nbsp;</td>
                                    </tr>
                        <?php
                                }
                            }
        
                        }  

                        if(isset($earning)){ 
                            foreach($earning as $earning){ 
                                if( !empty($earning->Amount) && $earning->Amount != '0.00' ){
                                    $total_earning += $earning->Amount;
                        ?>
                                    <tr>
                                        <td style="width:  1%" align="left">&nbsp;</td>
                                        <td style="width: 51%" align="left"><?php echo $earning->{'Transaction Label'} ?></td>
                                        <td style="width: 23%" align="right">0.00</td>
                                        <td style="width: 23%" align="right"><?php echo number_format($earning->Amount, 2, '.', ',')?></td>
                                        <td style="width:  2%" align="left">&nbsp;</td>
                                    </tr>
                        <?php
                                }
                            }
        
                        }  

                        $gross_pay = $basic_pay + $total_earning + $total_ot_amount + $value->{'Other Taxable'} + $total_benefits;

                        ?>                                           
                    </table>
                </td>
                <td style="width: 1%; "></td>
                <td style="width: 50%; ">
                    <table>
                        <tr>
                            <td style="width: 100%" align="center"><b>DEDUCTIONS</b></td>
                        </tr>                        
                        <?php
                        $total_deductions = 0;
                        if(isset($ded_govt)){ 
                            $ded_govt_amount = 0;
                            foreach($ded_govt as $transaction){ 
                                if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                    $ded_govt_amount += $transaction->Amount;
                                    $total_deductions += $transaction->Amount;
                                ?>
                                <tr>
                                    <td style="width: 1%" align="left">&nbsp;</td>
                                    <td style="width: 51%" align="left"><?php echo $transaction->{'Transaction Label'} ?></td>
                                    <td style="width: 23%" align="right">&nbsp;</td>
                                    <td style="width: 23%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
                                    <td style="width: 2%" align="left">&nbsp;</td>
                                </tr> <?php
                            }
                        }
                        if(isset($ded_other)){ 
                            $ded_other_amount = 0;
                            foreach($ded_other as $transaction){ 
                                if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                    $ded_other_amount += $transaction->Amount; 
                                    $total_deductions += $transaction->Amount;
                                ?>
                                <tr>
                                    <td style="width:  1%" align="left">&nbsp;</td>
                                    <td style="width: 51%" align="left"><?php echo $transaction->{'Transaction Label'}.' ';?></td>
                                    <td style="width: 23%" align="right">&nbsp;</td>
                                    <td style="width: 23%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                </tr> <?php
                            }
                        }
                        if(isset($ded_loan)){ 
                            $ded_loan_amount = 0;
                            foreach($ded_loan as $transaction){ 
                                $loan_bal_amt = '';
                                if( !empty($transaction->Amount) && $transaction->Amount != '0.00' )
                                    $ded_loan_amount += $transaction->Amount;
                                    $total_deductions += $transaction->Amount;
                                    if( !empty($transaction->{'Record Id'}) || $transaction->{'Record Id'} != '' ){
                                        $loan_bal = $this->db->query("SELECT IFNULL( ROUND( SUM(AES_DECRYPT(`amount`,`encryption_key`() ) ), 2) ,0) as amount FROM {$this->db->dbprefix}payroll_partners_loan_payment
                                                          WHERE partner_loan_id = ".$transaction->{'Record Id'}." AND date_paid > '".$value->{'Payroll Date'}."' AND paid = 1")->row();
                                        $loan_bal_amt = $transaction->{'Running Balance'} + $loan_bal->amount;
                                        $loan_bal_amt = '( Running Bal.  '.number_format( $loan_bal_amt, 2, '.',',').' )';
                                    }
                                ?>
                                <tr>
                                    <td style="width:  1%" align="left">&nbsp;</td>
                                    <td style="width: 51%" align="left"><?php echo $transaction->{'Transaction Label'}.' ';?><br/>
                                        <table><tr><td><i style="font-size:6;"><?php echo $loan_bal_amt;?></i></td></tr></table>
                                    </td>
                                    <td style="width: 23%" align="right">&nbsp;</td>
                                    <td style="width: 23%" align="right"><?php echo number_format($transaction->Amount, 2, '.', ',')?></td>
                                    <td style="width:  2%" align="left">&nbsp;</td>
                                </tr> 
                                <?php
                            }
                        }
                        
                        //$netpay = ($gross_pay - $total_deductions) + $value->{'Nontax Income'};
                        $netpay = $value->{'Amount'}; 

                        ?>                      
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width: 100%">&nbsp;</td>
            </tr>  
            <tr>
                <td style="width: 50%; ">
                    <table>                                               
                        <tr>
                            <td style="width: 1%" align="left">&nbsp;</td>
                            <td style="width: 51%" align="left">TOTAL EARNINGS</td>
                            <td style="width: 23%" align="right">&nbsp;</td>
                            <td style="width: 23%" align="right"><?php echo number_format($gross_pay, 2, '.', ',')?></td>
                            <td style="width: 2%" align="left">&nbsp;</td>
                        </tr>                                           
                    </table>
                </td>
                <td style="width: 1%; "></td>
                <td style="width: 50%; ">
                    <table>
                        <tr>
                            <td style="width: 1%" align="left">&nbsp;</td>
                            <td style="width: 51%" align="left">TOTAL DEDUCTIONS</td>
                            <td style="width: 23%" align="right">&nbsp;</td>
                            <td style="width: 23%" align="right"><?php echo number_format($total_deductions, 2, '.', ',')?></td>
                            <td style="width: 2%" align="left">&nbsp;</td>
                        </tr>                          
                    </table>
                </td>
            </tr>
        </table>
        <br /><br />
        <table style="width: 100%; border-top: solid 1px black;border-bottom: solid 1px black;">
            <tr>
                <td style="width: 100%">&nbsp;</td>
            </tr>   
            <tr>
                <td style="width: 1%"></td>
                <td style="width: 24%" align="left"><b>YTD GROSS</b></td>
                <td style="width: 25%" align="right"><b><?php echo number_format($ytd->ytd_gross, 2, '.', ','); ?></b></td>
                <td style="width: 1%"></td>
                <td style="width: 24%" align="left"><b>NET PAY</b></td>
                <td style="width: 25%" align="right"><b><?php echo number_format($netpay, 2, '.', ','); ?></b></td>
            </tr>
            <tr>
                <td style="width: 1%"></td>
                <td style="width: 24%" align="left"><b>YTD TAX</b></td>
                <td style="width: 25%" align="right"><b><?php echo number_format($ytd->ytd_tax, 2, '.', ','); ?></b></td>
                <td style="width: 1%"></td>
                <td style="width: 24%" align="left"><b>BASIC RATE</b></td>
                <td style="width: 25%" align="right"><b><?php echo number_format($basic_rate, 2, '.', ','); ?></b></td>                
            </tr>     
            <tr>
                <td style="width: 1%"></td>
                <td style="width: 24%" align="left"><b>YTD BASIC</b></td>
                <td style="width: 25%" align="right"><b><?php echo number_format($ytd->ytd_basic_pay, 2, '.', ','); ?></b></td>                
                <td style="width: 1%"></td>
                <td style="width: 24%" align="left"><b>HOURLY RATE</b></td>
                <td style="width: 25%" align="right"><b><?php echo $value->{'Hourly Rate'} ?></b></td>                          
            </tr>    
            <tr>
                <td style="width: 1%"></td>
                <td style="width: 24%" align="left"><b>YTD HW</b></td>
                <td style="width: 25%" align="right"><b><?php echo number_format($ytd_time_record_summary->ytd_hours_work, 2, '.', ','); ?></b></td>                
                <td style="width: 1%"></td>
                <td style="width: 24%" align="left"><b>LIP BALANCE</b></td>
                <td style="width: 25%" align="right"><b><?php echo number_format($lip_balance, 2, '.', ',') ?></b></td>                          
            </tr> 
            <tr>
                <td style="width: 100%">&nbsp;</td>
            </tr>                                            
        </table>
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%">&nbsp;</td>
                <td style="width: 50%">
                    <i style="text-align:justify;display: block;text-indent:0">Bring all the tithes (the whole tenth of your income) into the storehouse, that there may be food in My house, and prove Me now by it, says the Lord of hosts, If I will not open the windows of heaven for you and pour you out a blessing, that there shall not be room enough to receive it.
                    </i>
                    <br /><br />
                    <i style="text-align:justify;display: block;text-indent:0">Malachi 3:10 (The Amplified Bible)
                    </i>                    
                </td>
            </tr>
        </table>
    <?php
    endforeach; 
?>
