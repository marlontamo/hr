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
	    <td colspan="11" width="100%" style="text-align:center; font-size:10; "><strong><?php echo strtoupper($company); ?></strong></td>
	</tr>
	<tr>
        <td colspan="11" width="100%" style="font-size:10;">SALARY DISTRIBUTION TYPE: <?php echo $payroll_rate_type; ?></td>
    </tr>
    <tr>
	    <td colspan="11" width="100%" style="font-size:10;">PAY DATE: <?php echo date("m/d/Y", strtotime($payroll_date)); ?></td>
	</tr>
    <tr>
        <td width="100%" style="font-size:10;"></td>
    </tr>
	<tr>
	    <td>EMPLOYEE</br> NO.</td>
	    <td>EMPLOYEE NAME</td>
	    <td>POSITION</td>
	    <td>TOTAL BASIC</td>
        <td>TOTAL</br> OVERTIME</td>
        <td>OTHER NON-</br>TAX INCOME</td>
        <td>SSS ER</td>
        <td>SSS EC</td>
        <td>HDMF ER</td>
        <td>PHIC ER</td>
	    <td>TOTAL COST<br/> PER<br/> EMPLOYEE</td>
	</tr>
	<?php
    $cost_center_lbl = '';
    $count = 0;
    $tot_amount = 0;
    $total_line = 0;
    $gtot_amount = 0;
    $gtot_adv_amt = 0;
    $tot_basic = 0;
    $gtot_basic = 0;
    $tot_ot = 0;
    $gtot_ot = 0;

    $tot_on = 0;
    $gtot_on = 0;
    $tot_sss_er = 0;
    $gtot_sss_er = 0;
    $tot_sss_ec = 0;
    $gtot_sss_ec = 0;
    $tot_hdmf_er = 0;
    $gtot_hdmf_er = 0;
    $tot_phic_er = 0;
    $gtot_phic_er = 0;
    $count_emp = 0;
    $total_count_emp = 0;
    foreach ($results as $dtl_res) {
    
     



        if( $cost_center_lbl == '' || $cost_center_lbl != $dtl_res['Cost Center'] ) {
            if($cost_center_lbl == '') { ?>
                <tr>
                    <td colspan="11"></td>
                </tr>
                <tr>
                    <td colspan="11" width="100%"><strong><?php echo 'COST CENTER: '.$dtl_res['Project Code']." - ".$dtl_res['Cost Center']; ?></strong></td>
                </tr><?php
                $total_line++;
            } else { ?>
                <tr>
                    <td colspan="2" width="50%"  style="text-align:right; background-color: gray;"><strong>EMP Per Cost Center: <?php echo $count_emp; ?></strong></td>
                    <td width=" 4%"  style="text-align:Left;"></td>
                    <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_basic,2,".",","); ?></strong></td>
                    <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_ot,2,".",","); ?></strong></td>
                    <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_on,2,".",","); ?></strong></td>
                    <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_sss_er,2,".",","); ?></strong></td>
                    <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_sss_ec,2,".",","); ?></strong></td>
                    <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_hdmf_er,2,".",","); ?></strong></td>
                    <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_phic_er,2,".",","); ?></strong></td>
                    <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_basic + $tot_ot + $tot_on + $tot_sss_er + $tot_sss_ec + $tot_hdmf_er + $tot_phic_er ,2,".",","); ?></strong></td>
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
                $tot_amount = 0;
                $tot_basic = 0;
                $tot_ot = 0;
                $tot_on = 0;
                $tot_sss_er = 0;
                $tot_sss_ec = 0;
                $tot_hdmf_er = 0;
                $tot_phic_er = 0;
                $count_emp = 0;
            }
        } ?>
                <tr>
                    <td><?php echo $dtl_res['Id Number']; ?></td>
                    <td><?php echo $dtl_res['Full Name']; ?></td>
                    <td><?php echo $dtl_res['Position']; ?></td>
                    <td><?php echo number_format($dtl_res['Total Basic'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Overtime'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Other Nontax'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Sss Er'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Sss Ec'],2,".",","); ?></td>
                    <td><?php echo number_format($dtl_res['Hdmf Er'],2,".",",") ; ?></td>
                    <td><?php echo number_format($dtl_res['Phic Er'],2,".",","); ?></td>
                    <td><?php 
                    $total =
                    $dtl_res['Total Basic'] + 
                    $dtl_res['Overtime'] + 
                    $dtl_res['Other Nontax'] + 
                    $dtl_res['Sss Er'] + 
                    $dtl_res['Sss Ec'] +
                    $dtl_res['Hdmf Er'] +
                    $dtl_res['Phic Er']; 
                    echo number_format($total,2,".",",");
                    ?></td>
                </tr><?php
        //$tot_amount += $dtl_res['Amount'];
       // $gtot_amount += $dtl_res['Amount'];
        $tot_basic += $dtl_res['Total Basic']; 
        $gtot_basic += $dtl_res['Total Basic']; 
        $tot_ot += $dtl_res['Overtime']; 
        $gtot_ot += $dtl_res['Overtime']; 
        $cost_center_lbl = $dtl_res['Cost Center'];
        $label = 'COST CENTER: '.$dtl_res['Project Code']." - ".$dtl_res['Cost Center'];
        $count++;
        $count_emp++;
        $total_line++;
        $total_count_emp++;


        $tot_on += $dtl_res['Other Nontax'];
        $gtot_on += $dtl_res['Other Nontax'];
        $tot_sss_er += $dtl_res['Sss Er'];
        $gtot_sss_er += $dtl_res['Sss Er'];
        $tot_sss_ec += $dtl_res['Sss Ec'];
        $gtot_sss_ec += $dtl_res['Sss Ec'];
        $tot_hdmf_er += $dtl_res['Hdmf Er'];
        $gtot_hdmf_er += $dtl_res['Hdmf Er'];
        $tot_phic_er += $dtl_res['Phic Er'];
        $gtot_phic_er += $dtl_res['Phic Er'];
    } ?>

    <tr>
        <td colspan="2" width="50%"  style="text-align:right;"><strong>EMP Per Cost Center: <?php echo $count_emp; ?></strong></td>
        <td width=" 4%"  style="text-align:Left;"></td>
        <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_basic,2,".",","); ?></strong></td>
        <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_ot,2,".",","); ?></strong></td>
        <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_on,2,".",","); ?></strong></td>
        <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_sss_er,2,".",","); ?></strong></td>
        <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_sss_ec,2,".",","); ?></strong></td>
        <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_hdmf_er,2,".",","); ?></strong></td>
        <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_phic_er,2,".",","); ?></strong></td>
        <td width="17%"  style="text-align:right;"><strong><?php echo number_format($tot_basic + $tot_ot + $tot_on + $tot_sss_er + $tot_sss_ec + $tot_hdmf_er + $tot_phic_er ,2,".",","); ?></strong></td>
    </tr>

    <tr>
        <td rowspan="2" colspan="2" width="50%"  style="text-align:right;"><strong>TOTAL EMP: <?php echo $total_count_emp; ?></strong></td>
        <td rowspan="2" width=" 4%"  style="text-align:Left;"></td>
        <td rowspan="2" width="17%"  style="text-align:right;"><strong><?php echo number_format($gtot_basic,2,".",","); ?></strong></td>
        <td rowspan="2" width="17%"  style="text-align:right;"><strong><?php echo number_format($gtot_ot,2,".",","); ?></strong></td>
        <td rowspan="2" width="17%"  style="text-align:right;"><strong><?php echo number_format($gtot_on,2,".",","); ?></strong></td>
        <td rowspan="2" width="17%"  style="text-align:right;"><strong><?php echo number_format($gtot_sss_er,2,".",","); ?></strong></td>
        <td rowspan="2" width="17%"  style="text-align:right;"><strong><?php echo number_format($gtot_sss_ec,2,".",","); ?></strong></td>
        <td rowspan="2" width="17%"  style="text-align:right;"><strong><?php echo number_format($gtot_hdmf_er,2,".",","); ?></strong></td>
        <td rowspan="2" width="17%"  style="text-align:right;"><strong><?php echo number_format($gtot_phic_er,2,".",","); ?></strong></td>
        <td rowspan="2" width="17%"  style="text-align:right;"><strong><?php echo number_format($gtot_basic + $gtot_ot + $gtot_on + $gtot_sss_er + $gtot_sss_ec + $gtot_hdmf_er + $gtot_phic_er ,2,".",","); ?></strong></td>
    </tr>

</table>