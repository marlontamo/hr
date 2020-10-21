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
	    <td colspan="22" width="100%" style="text-align:center; font-size:10; "><strong><?php echo strtoupper($company); ?></strong></td>
	</tr>
	<tr>
        <td colspan="22" width="100%" style="font-size:10;">SALARY DISTRIBUTION TYPE: <?php echo $payroll_rate_type; ?></td>
    </tr>
    <tr>
	    <td colspan="22" width="100%" style="font-size:10;">PAY DATE: <?php echo date("m/d/Y", strtotime($payroll_date)); ?></td>
	</tr>
    <tr>
        <td width="100%" style="font-size:10;"></td>
    </tr>
	<tr>

	    <td>EMPLOYEE</br> ID.</td>
	    <td>EMPLOYEE NAME</td>
	    <td>BASIC SALARY</td>
	    <td>TARDY /ABSENT</td>
        <td>OVERTIME</td>
        <td>OTHER TAX INCOME</td>
        <td>ADJUSTMENT</td>
        <td>GROSS INC.</td>
        <td>W/H TAX</td>
        <td>OTHER NON-</br>TAX INCOME</td>
        <td>SSS EE</td>
        <td>SSS ER</td>
        <td>MCR ER</td>
        <td>HDMF ER</td>
        <td>MEAL</td>
        <td>TRANSPO</td>
        <td>HARDSHIP</td>
        <td>LOAN PAYMENTS</td>
        <td>DEDUCTION PAYMENTS</td>
        <td>NET SALARY</td>
        <td>NET SALARY (ORIGINAL)</td>
	    <td>% ALLOCATION</td>
	</tr>
	<?php
    $cost_center_lbl = '';
    $count = 0;
    $tot_amount = 0;
    $total_line = 0;
    $gtot_amount = 0;
    $gtot_adv_amt = 0;
    
    $count_emp = 0;
    $total_count_emp = 0;

    
    $tot_basic = 0;
    $tot_misc = 0;
    $tot_ot = 0;
    $tot_other_tax = 0;
    $tot_adjustment = 0;
    $tot_gross = 0;
    $tot_tax = 0;
    $tot_other_nontax = 0;
    $tot_sss_ee = 0;
    $tot_sss_er = 0;
    $tot_mcr_er = 0;
    $tot_hdmf_er = 0;
    $tot_meal = 0;
    $tot_transpo = 0;
    $tot_hardship = 0;
    $tot_loan = 0;
    $tot_deduction = 0;
    $tot_net = 0;
    $tot_net_orig = 0;
    $tot_percent_allocation = 0;

    $gtot_basic = 0;
    $gtot_misc = 0;
    $gtot_ot = 0;
    $gtot_other_tax = 0;
    $gtot_adjustment = 0;
    $gtot_gross = 0;
    $gtot_tax = 0;
    $gtot_other_nontax = 0;
    $gtot_sss_ee = 0;
    $gtot_sss_er = 0;
    $gtot_mcr_er = 0;
    $gtot_hdmf_er = 0;
    $gtot_meal = 0;
    $gtot_transpo = 0;
    $gtot_hardship = 0;
    $gtot_loan = 0;
    $gtot_deduction = 0;
    $gtot_net = 0;
    $gtot_net_orig = 0;
    $gtot_percent_allocation = 0;


    foreach ($results as $dtl_res) {
    
     



        if( $cost_center_lbl == '' || $cost_center_lbl != $dtl_res['Cost Center'] ) {
            if($cost_center_lbl == '') { ?>
                <tr>
                    <td colspan="22"></td>
                </tr>
                <tr>
                    <td colspan="22" width="100%"><strong><?php echo 'COST CENTER: '.$dtl_res['Project Code']." - ".$dtl_res['Cost Center']; ?></strong></td>
                </tr><?php
                $total_line++;
            } else { ?>
                <tr>
                    <td colspan="2" width="50%"  style="text-align:right; background-color: gray;"><strong>EMP Per Cost Center: <?php echo $count_emp; ?></strong></td>
                    <td><?php echo number_format($tot_basic,2,".",","); ?></td>
                    <td><?php echo number_format($tot_misc,2,".",","); ?></td>
                    <td><?php echo number_format($tot_ot,2,".",","); ?></td>
                    <td><?php echo number_format($tot_other_tax,2,".",","); ?></td>
                    <td><?php echo number_format($tot_adjustment,2,".",","); ?></td>
                    <td><?php echo number_format($tot_gross,2,".",","); ?></td>
                    <td><?php echo number_format($tot_tax,2,".",","); ?></td>
                    <td><?php echo number_format($tot_other_nontax,2,".",","); ?></td>
                    <td><?php echo number_format($tot_sss_ee,2,".",","); ?></td>
                    <td><?php echo number_format($tot_sss_er,2,".",","); ?></td>
                    <td><?php echo number_format($tot_mcr_er,2,".",","); ?></td>
                    <td><?php echo number_format($tot_hdmf_er,2,".",","); ?></td>
                    <td><?php echo number_format($tot_meal,2,".",","); ?></td>
                    <td><?php echo number_format($tot_transpo,2,".",","); ?></td>
                    <td><?php echo number_format($tot_hardship,2,".",","); ?></td>
                    <td><?php echo number_format($tot_loan,2,".",","); ?></td>
                    <td><?php echo number_format($tot_deduction,2,".",","); ?></td>
                    <td><?php echo number_format($tot_net,2,".",","); ?></td>
                    <td><?php echo number_format($tot_net_orig,2,".",","); ?></td>
                    <td><?php echo number_format($tot_percent_allocation,2,".",","); ?></td>
                </tr>
                <tr>
                    <td colspan="22"></td>
                </tr>

                <tr>
                    <td colspan="22" width="50%"  style="text-align:right; background-color: gray;"><strong><?php echo $label; ?></strong></td>
                </tr>
                <?php 
                $count++;
                $total_line++;
                $count_emp = 0;

                $tot_basic = 0;
                $tot_misc = 0;
                $tot_ot = 0;
                $tot_other_tax = 0;
                $tot_adjustment = 0;
                $tot_gross = 0;
                $tot_tax = 0;
                $tot_other_nontax = 0;
                $tot_sss_ee = 0;
                $tot_sss_er = 0;
                $tot_mcr_er = 0;
                $tot_hdmf_er = 0;
                $tot_meal = 0;
                $tot_transpo = 0;
                $tot_hardship = 0;
                $tot_loan = 0;
                $tot_deduction = 0;
                $tot_net = 0;
                $tot_net_orig = 0;
                $tot_percent_allocation = 0;
            }
        } ?>
                <tr>
                    <td><?php echo $dtl_res['Id Number']; ?></td>
                    <td><?php echo $dtl_res['Full Name']; ?></td>
                    <td><?php echo number_format($dtl_res['Total Basic'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Misc'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Overtime'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Other Tax'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Adjustment'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Gross'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Tax'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Other Nontax'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Sss Ee'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Sss Er'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Phic Er'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Hdmf Er'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Meal'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Transpo'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Hardship'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Loan'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Deduction'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Net Amount'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Net Orig'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Percent Allocation'],2,".",",") ; ?></td>

                </tr><?php
        $cost_center_lbl = $dtl_res['Cost Center'];
        $label = 'COST CENTER: '.$dtl_res['Project Code']." - ".$dtl_res['Cost Center'];
        $count++;
        $count_emp++;
        $total_line++;
        $total_count_emp++;

        $tot_basic += $dtl_res['Total Basic'];
        $tot_misc += $dtl_res['Misc'];
        $tot_ot += $dtl_res['Overtime'];
        $tot_other_tax += $dtl_res['Other Tax'];
        $tot_adjustment += $dtl_res['Adjustment'];
        $tot_gross += $dtl_res['Gross'];
        $tot_tax += $dtl_res['Tax'];
        $tot_other_nontax += $dtl_res['Other Nontax'];
        $tot_sss_ee += $dtl_res['Sss Ee'];
        $tot_sss_er += $dtl_res['Sss Er'];
        $tot_mcr_er += $dtl_res['Phic Er'];
        $tot_hdmf_er += $dtl_res['Hdmf Er'];
        $tot_meal += $dtl_res['Meal'];
        $tot_transpo += $dtl_res['Transpo'];
        $tot_hardship += $dtl_res['Hardship'];
        $tot_loan += $dtl_res['Loan'];
        $tot_deduction += $dtl_res['Deduction'];
        $tot_net += $dtl_res['Net Amount'];
        $tot_net_orig += $dtl_res['Net Orig'];
        $tot_percent_allocation += $dtl_res['Percent Allocation'];

        $gtot_basic += $dtl_res['Total Basic'];
        $gtot_misc += $dtl_res['Misc'];
        $gtot_ot += $dtl_res['Overtime'];
        $gtot_other_tax += $dtl_res['Other Tax'];
        $gtot_adjustment += $dtl_res['Adjustment'];
        $gtot_gross += $dtl_res['Gross'];
        $gtot_tax += $dtl_res['Tax'];
        $gtot_other_nontax += $dtl_res['Other Nontax'];
        $gtot_sss_ee += $dtl_res['Sss Ee'];
        $gtot_sss_er += $dtl_res['Sss Er'];
        $gtot_mcr_er += $dtl_res['Phic Er'];
        $gtot_hdmf_er += $dtl_res['Hdmf Er'];
        $gtot_meal += $dtl_res['Meal'];
        $gtot_transpo += $dtl_res['Transpo'];
        $gtot_hardship += $dtl_res['Hardship'];
        $gtot_loan += $dtl_res['Loan'];
        $gtot_deduction += $dtl_res['Deduction'];
        $gtot_net += $dtl_res['Net Amount'];
        $gtot_net_orig += $dtl_res['Net Orig'];
        $gtot_percent_allocation += $dtl_res['Percent Allocation'];
    } ?>
    <tr>
        <td colspan="2" width="50%"  style="text-align:right;"><strong>EMP Per Cost Center: <?php echo $count_emp; ?></strong></td>
        <td><?php echo number_format($tot_basic,2,".",","); ?></td>
        <td><?php echo number_format($tot_misc,2,".",","); ?></td>
        <td><?php echo number_format($tot_ot,2,".",","); ?></td>
        <td><?php echo number_format($tot_other_tax,2,".",","); ?></td>
        <td><?php echo number_format($tot_adjustment,2,".",","); ?></td>
        <td><?php echo number_format($tot_gross,2,".",","); ?></td>
        <td><?php echo number_format($tot_tax,2,".",","); ?></td>
        <td><?php echo number_format($tot_other_nontax,2,".",","); ?></td>
        <td><?php echo number_format($tot_sss_ee,2,".",","); ?></td>
        <td><?php echo number_format($tot_sss_er,2,".",","); ?></td>
        <td><?php echo number_format($tot_mcr_er,2,".",","); ?></td>
        <td><?php echo number_format($tot_hdmf_er,2,".",","); ?></td>
        <td><?php echo number_format($tot_meal,2,".",","); ?></td>
        <td><?php echo number_format($tot_transpo,2,".",","); ?></td>
        <td><?php echo number_format($tot_hardship,2,".",","); ?></td>
        <td><?php echo number_format($tot_loan,2,".",","); ?></td>
        <td><?php echo number_format($tot_deduction,2,".",","); ?></td>
        <td><?php echo number_format($tot_net,2,".",","); ?></td>
        <td><?php echo number_format($tot_net_orig,2,".",","); ?></td>
        <td><?php echo number_format($tot_percent_allocation,2,".",","); ?></td>
    </tr>

    <tr>
        <td></td>
        <td colspan="21"></td>
    </tr>
    
    <tr>
        <td width="50%"  style="text-align:right;"><strong></strong></td>
        <td width="50%"  style="text-align:right;"><strong>GRAND TOTAL:</strong></td>
        <td ><?php echo number_format($gtot_basic,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_misc,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_ot,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_other_tax,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_adjustment,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_gross,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_tax,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_other_nontax,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_sss_ee,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_sss_er,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_mcr_er,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_hdmf_er,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_meal,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_transpo,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_hardship,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_loan,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_deduction,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_net,2,".",","); ?></td>
        <td ></td>
        <td ></td>
    </tr>

    <tr>
        <td></td>
        <td colspan="21"></td>
    </tr>

    <tr>
        <td width="50%"  style="text-align:right;"><strong></strong></td>
        <td width="50%"  style="text-align:right;"><strong>PAYREG:</strong></td>
        <td ><?php echo number_format($gtot_basic,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_misc,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_ot,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_other_tax,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_adjustment,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_gross,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_tax,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_other_nontax,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_sss_ee,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_sss_er,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_mcr_er,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_hdmf_er,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_meal,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_transpo,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_hardship,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_loan,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_deduction,2,".",","); ?></td>
        <td ><?php echo number_format($gtot_net,2,".",","); ?></td>
        <td ></td>
        <td ></td>
    </tr>

</table>