<?php
	//prep data
	$res = $result->row();
    $company = $res->{'Company'};
    $address = $res->{'Address'};
    $payroll_date = $res->{'Payroll Date'};
    $date_from = $res->{'Date From'};
    $date_to = $res->{'Date To'};
    
    $results = $result->result_array();
?>

<table>
    <tr>
        <td width="100%" style="text-align:center; font-size:10; "><strong><?php echo $company; ?></strong></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:center;"><?php echo $address; ?></td>
    </tr>
    <tr><td></td></tr>
    <tr>
        <td style=" width: 4%; text-align:left;"></td>
        <td style=" width:96%; text-align:left; font-size:11; "><i><strong>Journal Voucher</strong></i></td>
    </tr>
    <tr>
        <td style=" width: 4%; text-align:left;"></td>
        <td style=" width:96%; text-align:left;">Payroll Date: <?php echo date("m/d/Y",strtotime($payroll_date)); ?></td>
    </tr>
    <tr>
        <td style=" width: 4%; text-align:left;"></td>
        <td style=" width:96%; text-align:left;">Period Coverage : <?php echo date("m/d/Y",strtotime($date_from)).' - '.date("m/d/Y",strtotime($date_to)); ?></td>
    </tr>

    <?php 
    $total_debit = 0;
    $total_credit = 0;
    $sss_credit = 0;
    $phic_credit = 0;
    $hdmf_credit = 0;
    $line = 0;

    foreach($results as $dtl_res):

        $debit = $dtl_res['Debit Amount'];
        $credit = $dtl_res['Credit Amount'];

        if($line==0){
        ?>
        <tr>
            <td style=" width: 4%; text-align:left;"></td>
            <td style=" width:96%; text-align:left;">Branch : <?php echo $dtl_res['Branch']; ?></td>
        </tr>
        <tr>
            <td></td></tr>
        <tr>
            <td width="4%"></td>
            <td width="10%" style="text-align:left; border-bottom-width: 1px solid black;"><strong>Account</strong></td>
            <td width="3%"></td>
            <td width="40%" style="text-align:left; border-bottom-width: 1px solid black;"><strong>Description</strong></td>
            <td width="3%"></td>
            <td width="10%" style="text-align:left; border-bottom-width: 1px solid black;"><strong>Dept</strong></td>
            <td width="3%"></td>
            <td width="10%" style="text-align:right; border-bottom-width: 1px solid black;"><strong>Debit</strong></td>
            <td width="3%"></td>
            <td width="10%" style="text-align:right; border-bottom-width: 1px solid black;"><strong>Credit</strong></td>
        </tr>
        <tr> 
            <td width="100%" style="font-size:6;">&nbsp;</td>
        </tr>
        <?php } ?>

        <tr>
            <td width="4%"></td>
            <td width="10%" style="text-align:left;"><?php echo $dtl_res['Account']; ?></td>
            <td width="3%"></td>
            <td width="40%" style="text-align:left;"><?php echo $dtl_res['Description']; ?></td>
            <td width="3%"></td>
            <td width="10%" style="text-align:left;"><?php echo $dtl_res['Sub Account']; ?></td>
            <td width="3%"></td>

        <?php
        if( $debit > 0 ){ ?>
            <td width="10%" style="text-align:right;"><?php echo number_format( $debit,2,'.',','); ?></td>
            <td width="3%"></td>
            <td width="10%"></td>
            <?php    
        }
        else{ ?>
            <td width="10%"></td>
            <td width="3%"></td>
            <td width="10%" style="text-align:right;"><?php echo number_format( $credit,2,'.',','); ?></td>
            <?php
        } ?>
        </tr>

        <?php
        $line++;
        if( $line >= 50){
            ?>
            <tr><td></td></tr><tr>
            <tr><td></td></tr><tr>
            <tr><td></td></tr><tr>
            <tr><td></td></tr><tr>
            <tr><td></td></tr><tr>
            <tr><td></td></tr><tr>
            <tr><td></td></tr><tr>
            <tr><td></td></tr><tr>
            <tr><td></td></tr><tr>
            <tr><td></td></tr><tr>
            <tr><td></td></tr><tr>
            <tr><td></td></tr><tr>
            <tr><td></td></tr><tr>
            <tr><td></td></tr><tr>
            <?php
            $line = 0;
        }
        $total_debit += $debit;
        $total_credit += $credit;
    endforeach; ?>
    
    
    <tr>
        <td></td>
    </tr>
    <tr>
        <td width="4%"></td>
        <td width="10%"></td>
        <td width="3%"></td>
        <td width="40%"></td>
        <td width="3%"></td>
        <td width="10%"></td>
        <td width="3%"></td>
        <td width="10%" style="border-top:1px solid black;text-align:right;font-size:9;"><strong><?php echo number_format($total_debit,2,'.',','); ?></strong></td>
        <td width="3%"></td>
        <td width="10%" style="border-top:1px solid black;text-align:right;font-size:9;"><strong><?php echo number_format($total_credit,2,'.',','); ?></strong></td>
    </tr>
    <tr>
        <td width="4%"></td>
        <td width="10%"></td>
        <td width="3%"></td>
        <td width="40%"></td>
        <td width="3%"></td>
        <td width="10%"></td>
        <td width="3%"></td>
        <td width="10%" style="text-align:right; border-top-width: 1px solid black; font-size:2; "></td>
        <td width="3%"></td>
        <td width="10%" style="text-align:right; border-top-width: 1px solid black; font-size:2; "></td>
    </tr>

    <?php    
    if( $result->num_rows() < 40 ){
        for ($space=1; $space <= ( 40 - $result->num_rows() ); $space++) 
        { ?>
            <tr><td></td></tr>
        <?php
        } 
    }?>
</table>