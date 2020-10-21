<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, false);
    }
    //prep data
    $res = $result->row();
    $company = $res->{'Company'};
    $period = $res->{'Date From'}.' to '.$res->{'Date To'};

    $results = $result->result_array();
    $total_debit = 0;
    $total_credit = 0;
    $cnt = 0;
    foreach($results as $dtl_res):
        if($cnt == 35 ){
            $cnt = 0 ;?>
            </table>
            <div style="page-break-before: always;">&nbsp;</div>
            <table>
                <tr>
                    <td width="100%" style="text-align:left; font-size:10; "><strong><?php echo $company; ?></strong></td>
                </tr>
                <tr>
                    <td width="100%" style="text-align:left; font-size:10; "><strong>Journal Voucher</strong></td>
                </tr>
                <tr>
                    <td width="100%" style="text-align:left; font-size:8; ">For the Payroll Period <?php echo $period; ?></td>
                </tr>
                <tr>
                    <td width:"100%" style="font-size:10;"></td>
                </tr>
                <tr>
                    <td width="13%" style="text-align:left; border-bottom-width: 1px solid black; "><strong>Account Number</strong></td>
                    <td width="25%" style="text-align:left; border-bottom-width: 1px solid black; "><strong>Account Title</strong></td>
                    <td width="12%" style="text-align:left; border-bottom-width: 1px solid black; "><strong>Dept</strong></td>
                    <td width="20%" style="text-align:left; border-bottom-width: 1px solid black; "><strong>Particulars</strong></td>
                    <td width="15%" style="text-align:right; border-bottom-width: 1px solid black; "><strong>Debit</strong></td>
                    <td width="15%" style="text-align:right; border-bottom-width: 1px solid black; "><strong>Credit</strong></td>
                </tr>
                <tr> 
                    <td width="100%" style="font-size:6;">&nbsp;</td>
                </tr><?php
        }else{
            if($cnt == 0){?>  
            <div>&nbsp;</div>
            <table>
                <tr>
                    <td width="100%" style="text-align:left; font-size:10; "><strong><?php echo $company; ?></strong></td>
                </tr>
                <tr>
                    <td width="100%" style="text-align:left; font-size:10; "><strong>Journal Voucher</strong></td>
                </tr>
                <tr>
                    <td width="100%" style="text-align:left; font-size:8; ">For the Payroll Period <?php echo $period; ?></td>
                </tr>
                <tr>
                    <td width:"100%" style="font-size:10;"></td>
                </tr>
                <tr>
                    <td width="13%" style="text-align:left; border-bottom-width: 1px solid black; "><strong>Account Number</strong></td>
                    <td width="25%" style="text-align:left; border-bottom-width: 1px solid black; "><strong>Account Title</strong></td>
                    <td width="12%" style="text-align:left; border-bottom-width: 1px solid black; "><strong>Dept</strong></td>
                    <td width="20%" style="text-align:left; border-bottom-width: 1px solid black; "><strong>Particulars</strong></td>
                    <td width="15%" style="text-align:right; border-bottom-width: 1px solid black; "><strong>Debit</strong></td>
                    <td width="15%" style="text-align:right; border-bottom-width: 1px solid black; "><strong>Credit</strong></td>
                </tr>
                <tr> 
                    <td width="100%" style="font-size:6;">&nbsp;</td>
                </tr><?php
            }
        }    ?>
                <tr>
                    <td width="13%" style="text-align:left;"><?php echo $dtl_res['Account Number']; ?></td>
                    <td width="25%" style="text-align:left;"><?php echo $dtl_res['Account Title']; ?></td>
                    <td width="12%" style="text-align:left;"><?php echo $dtl_res['Dept']; ?></td>
                    <td width="20%" style="text-align:left;"><?php echo $dtl_res['Particulars']; ?></td>
                    <td width="15%" style="text-align:right;"><?php echo $dtl_res{'Dr'} != 0 ? number_format( $dtl_res{'Dr'},2,'.',',') : ''; ?></td>
                    <td width="15%" style="text-align:right;"><?php echo $dtl_res{'Cr'} != 0 ? number_format( $dtl_res{'Cr'},2,'.',',') : ''; ?></td>
                </tr><?php
        $total_debit += $dtl_res{'Dr'};
        $total_credit += $dtl_res{'Cr'};
        $cnt++;
    endforeach; ?>
</table>
<table>
    <tr>
        <td width="72%" style="text-align:left;">&nbsp;</td>
        <td width="13%" style="text-align:right; border-bottom-width: 1px solid black; font-size:4; ">&nbsp;</td>
        <td width="2%" style="text-align:left;">&nbsp;</td>
        <td width="13%" style="text-align:right; border-bottom-width: 1px solid black; font-size:4; ">&nbsp;</td>
    </tr>
    <tr>
        <td width="70%" style="text-align:left;">&nbsp;</td>
        <td width="15%" style="text-align:right;font-size:9;"><strong><?php echo number_format($total_debit,2,'.',','); ?></strong></td>
        <td width="15%" style="text-align:right;font-size:9;"><strong><?php echo number_format($total_credit,2,'.',','); ?></strong></td>
    </tr>
    <tr>
        <td width="72%" style="text-align:left; font-size:2;"></td>
        <td width="13%" style="text-align:right; border-top-width: 1px solid black; font-size:2; "></td>
        <td width="2%" style="text-align:left; font-size:2;"></td>
        <td width="13%" style="text-align:right; border-top-width: 1px solid black; font-size:2; "></td>
    </tr>
    <tr>
        <td width="72%" style="text-align:left; font-size:2;"></td>
        <td width="13%" style="text-align:right; border-top-width: 1px solid black; font-size:2; "></td>
        <td width="2%" style="text-align:left; font-size:2;"></td>
        <td width="13%" style="text-align:right; border-top-width: 1px solid black; font-size:2; "></td>
    </tr>
</table>