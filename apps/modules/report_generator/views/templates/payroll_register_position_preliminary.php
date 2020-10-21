<?php
    //prep data
    $res = $result->row();
    $company = $res->{'Company'};
    //$payroll_rate_type = $res->{'Payroll Rate Type'};
    $payroll_date = $res->{'Payroll Date'};
    $results = $result->result_array();

    

        if($r_payroll_rate_type == 'all') {
            $payroll_rate_type = ucfirst($r_payroll_rate_type);
        } else {
            $payroll_rate_type = $res->{'Payroll Rate Type'};
        }
    
?>
<table>
    <tr>
        <td colspan="16" width="100%" style="text-align:center; font-size:10; "><strong><?php echo strtoupper($company); ?></strong></td>
    </tr>
    <tr>
        <td colspan="16" width="100%" style="font-size:10;">PAYROLL TYPE: <?php echo $payroll_rate_type; ?></td>
    </tr>
    <tr>
        <td colspan="16" width="100%" style="font-size:10;">PAY DATE: <?php echo date("m/d/Y", strtotime($payroll_date)); ?></td>
    </tr>
    <tr>
        <td width="100%" style="font-size:10;"></td>
    </tr>
    <tr>
        <td>POSITION</td>
        <td>BASIC SALARY</td>
        <td>MISC. </br>AMOUNT</td>
        <td>OVERTIME</td>
        <td>OT %</td>
        <td>OTHER TAX INCOME</td>
        <td>ADJUSTMENT</td>
        <td>GROSS INC.</td>
        <td>W/H</td>
        <td>SSS EE</td>
        <td>MCR EE</td>
        <td>HDMF EE</td>
        <td>OTHER <br/>NON TAX</td>
        <td>LOAN </br>PAYMENTS</td>
        <td>DEDUCTION </br>PAYMENTS</td>
        <td>NET </br>SALARY</td>
    </tr>
    <?php
    $cost_center_lbl = '';
    $count = 0;
    $tot_amount = 0;
    $total_line = 0;

    $tot_basic   = 0;    
    $tot_misc = 0;
    $tot_ot = 0;
    $tot_ot_percent = 0;
    $tot_other_tax = 0;
    $tot_adjustment = 0;
    $tot_gross = 0;
    $tot_tax = 0;
    $tot_sss_ee = 0;
    $tot_phic_ee = 0;
    $tot_hdmf_ee = 0;
    $tot_other_nontax = 0;
    $tot_loan = 0;
    $tot_deduction = 0;
    $tot_net_amount = 0;

    foreach ($results as $dtl_res) {
    
     



        if( $cost_center_lbl == '' || $cost_center_lbl != $dtl_res['Project'] ) {
            if($cost_center_lbl == '') { ?>
                <tr>
                    <td colspan="11"></td>
                </tr>
                <tr>
                    <td colspan="11" width="100%"><strong><?php echo 'COST CENTER: '.$dtl_res['Project Code']." - ".$dtl_res['Project']; ?></strong></td>
                </tr><?php
                $total_line++;
            } else { ?>
                <tr>
                    <td width="50%"  style="text-align:right; background-color: gray;"><strong>TOTAL: </strong></td>
                    <td><?php echo number_format($tot_basic ,2,".",","); ?></td>   
                    <td><?php echo number_format($tot_misc ,2,".",","); ?></td>
                    <td><?php echo number_format($tot_ot ,2,".",","); ?></td>
                    <td><?php echo number_format($tot_ot_percent ,2,".",","); ?></td>
                    <td><?php echo number_format($tot_other_tax ,2,".",","); ?></td>
                    <td><?php echo number_format($tot_adjustment ,2,".",","); ?></td>
                    <td><?php echo number_format($tot_gross ,2,".",","); ?></td>
                    <td><?php echo number_format($tot_tax ,2,".",","); ?></td>
                    <td><?php echo number_format($tot_sss_ee ,2,".",","); ?></td>
                    <td><?php echo number_format($tot_phic_ee ,2,".",","); ?></td>
                    <td><?php echo number_format($tot_hdmf_ee ,2,".",","); ?></td>
                    <td><?php echo number_format($tot_other_nontax ,2,".",","); ?></td>
                    <td><?php echo number_format($tot_loan ,2,".",","); ?></td>
                    <td><?php echo number_format($tot_deduction ,2,".",","); ?></td>
                    <td><?php echo number_format($tot_net_amount ,2,".",","); ?></td>

                </tr>
                <tr>
                    <td colspan="11"></td>
                </tr>

                <tr>
                    <td colspan="11" width="50%"  style="text-align:right; background-color: gray;"><strong><?php echo $label; ?></strong></td>
                </tr>
                <?php 
                $count++;
                $total_line++;

                $tot_basic   = 0;    
                $tot_misc = 0;
                $tot_ot = 0;
                $tot_ot_percent = 0;
                $tot_other_tax = 0;
                $tot_adjustment = 0;
                $tot_gross = 0;
                $tot_tax = 0;
                $tot_sss_ee = 0;
                $tot_phic_ee = 0;
                $tot_hdmf_ee = 0;
                $tot_other_nontax = 0;
                $tot_loan = 0;
                $tot_deduction = 0;
                $tot_net_amount = 0;
            }
        } ?>
                <tr>
                    <td><?php echo $dtl_res['Position']; ?></td>
                    <td><?php echo number_format($dtl_res['Basic'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Misc'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Ot'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Ot Percent'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Other Tax'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Adjustment'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Gross'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Tax'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Sss Ee'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Phic Ee'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Hdmf Ee'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Other Nontax'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Loan'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Deduction'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Net Amount'],2,".",",") ; ?></td>
                    
                </tr><?php
        //$tot_amount += $dtl_res['Amount'];
       // $gtot_amount += $dtl_res['Amount'];
        $cost_center_lbl = $dtl_res['Project'];
        $label = 'COST CENTER: '.$dtl_res['Project Code']." - ".$dtl_res['Project'];
        $count++;
        $total_line++;

        $tot_basic   += $dtl_res['Basic'];    
        $tot_misc += $dtl_res['Misc'];
        $tot_ot += $dtl_res['Ot'];
        $tot_ot_percent += $dtl_res['Ot Percent'];
        $tot_other_tax += $dtl_res['Other Tax'];
        $tot_adjustment += $dtl_res['Adjustment'];
        $tot_gross += $dtl_res['Gross'];
        $tot_tax += $dtl_res['Tax'];
        $tot_sss_ee += $dtl_res['Sss Ee'];
        $tot_phic_ee += $dtl_res['Phic Ee'];
        $tot_hdmf_ee += $dtl_res['Hdmf Ee'];
        $tot_other_nontax += $dtl_res['Other Nontax'];
        $tot_loan += $dtl_res['Loan'];
        $tot_deduction += $dtl_res['Deduction'];
        $tot_net_amount += $dtl_res['Net Amount'];
    } ?>

    <tr>
        <td width="50%"  style="text-align:right;"><strong>TOTAL: </strong></td>
        <td><?php echo number_format($tot_basic ,2,".",","); ?></td>   
        <td><?php echo number_format($tot_misc ,2,".",","); ?></td>
        <td><?php echo number_format($tot_ot ,2,".",","); ?></td>
        <td><?php echo number_format($tot_ot_percent ,2,".",","); ?></td>
        <td><?php echo number_format($tot_other_tax ,2,".",","); ?></td>
        <td><?php echo number_format($tot_adjustment ,2,".",","); ?></td>
        <td><?php echo number_format($tot_gross ,2,".",","); ?></td>
        <td><?php echo number_format($tot_tax ,2,".",","); ?></td>
        <td><?php echo number_format($tot_sss_ee ,2,".",","); ?></td>
        <td><?php echo number_format($tot_phic_ee ,2,".",","); ?></td>
        <td><?php echo number_format($tot_hdmf_ee ,2,".",","); ?></td>
        <td><?php echo number_format($tot_other_nontax ,2,".",","); ?></td>
        <td><?php echo number_format($tot_loan ,2,".",","); ?></td>
        <td><?php echo number_format($tot_deduction ,2,".",","); ?></td>
        <td><?php echo number_format($tot_net_amount ,2,".",","); ?></td>

    </tr>



</table>