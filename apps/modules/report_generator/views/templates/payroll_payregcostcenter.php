<?php
    $res = $result->row();
    $date_from = $res->{'Date From'};
    $date_to = $res->{'Date To'};
    $company = $res->{'Company'};
    $result = $result->result_array();
    $headers = array();
    $template = '';
    $allowed_per_page = 45; // includes row for spaces and department
    $result_cnt = count($result); 
    $cnt = 0;

    $gtBasic            = 0;
    $gtAut              = 0;
    $gtOt               = 0;
    $gtNd               = 0;
    $gtHoliday          = 0;
    $gtOtherEarnings    = 0;
    $gtGross            = 0;
    $gtSSS              = 0;
    $gtPHIC             = 0;
    $gtHDMF             = 0;
    $gtTax              = 0;
    $gtLoan             = 0;
    $gtEmployeeLedger   = 0;
    $gtOtherDeduction   = 0;
    $gtDeduction        = 0;
    $gtNetAmount        = 0;
?>
<table>
    <?php foreach ($result as $key => $value): 
            $cnt++;
            if($cnt == 1){ ?>
                <tr>
                    <td style=" width:100% ; text-align:center ; "><strong><?php echo $company; ?></strong></td>
                </tr>
                <tr>
                    <td style=" width:100% ; text-align:center ; "><strong>PAYROLL REGISTER (Cost Center)</strong></td>
                </tr>
                <tr>
                    <td style=" width:100% ; text-align:center ; "><strong>PAYROLL PERIOD : <?php echo date("F d, Y",strtotime($date_from)).'  - '.date("F d, Y",strtotime($date_to)); ?></strong></td>
                </tr>
                <tr>
                    <td style=" width:100% ; text-align:left ; "></td>
                </tr>
                <tr>
                    <td style=" width:100% ; font-size:2 ; "></td>
                </tr>

                <tr style="background-color:grey;"> 
                    <td style=" width: 14% ; text-align:left;"><strong>Department Name</strong></td>
                    <td style=" width: 6% ; text-align:right;"><strong>BASIC</strong></td>
                    <td style=" width: 5% ; text-align:right;"><strong>AUT</strong></td>
                    <td style=" width: 5% ; text-align:right;"><strong>OT</strong></td>
                    <td style=" width: 4% ; text-align:right;"><strong>ND</strong></td>
                    <td style=" width: 5% ; text-align:right;"><strong>Holiday</strong></td>
                    <td style=" width: 6% ; text-align:right;"><strong>Other Earning</strong></td>
                    <td style=" width: 5% ; text-align:right;"><strong>Gross</strong></td>
                    <td style=" width: 5% ; text-align:right;"><strong>SSS</strong></td>
                    <td style=" width: 5% ; text-align:right;"><strong>PHIC</strong></td>
                    <td style=" width: 4% ; text-align:right;"><strong>HDMF</strong></td>
                    <td style=" width: 5% ; text-align:right;"><strong>Tax</strong></td>
                    <td style=" width: 5% ; text-align:right;"><strong>Loan</strong></td>
                    <td style=" width: 7% ; text-align:right;"><strong>Employee Ledger</strong></td>
                    <td style=" width: 7% ; text-align:right;"><strong>Other Deduction</strong></td>
                    <td style=" width: 6% ; text-align:right;"><strong>Deduction</strong></td>
                    <td style=" width: 6% ; text-align:right;"><strong>Net Amt</strong></td>
                </tr>
    <?php   } ?> 
            <?php if($cnt <= $allowed_per_page) { 
                    $gtBasic         += $value{'Basic'};
                    $gtAut           += $value{'Aut'};
                    $gtOt            += $value{'Ot'};
                    $gtNd            += $value{'Nd'};
                    $gtHoliday       += $value{'Holiday'};
                    $gtOtherEarnings += $value{'Other Earnings'};
                    $gtGross         += $value{'Gross'};
                    $gtSSS           += $value{'Sss'};
                    $gtPHIC          += $value{'Phic'};
                    $gtHDMF          += $value{'Hdmf'};
                    $gtTax           += $value{'Tax'};
                    $gtLoan          += $value{'Loan'};
                    $gtEmployeeLedger+= $value{'Employee Ledger'};
                    $gtOtherDeduction+= $value{'Other Deduction'};
                    $gtDeduction     += $value{'Deduction'};
                    $gtNetAmount     += $value{'Net Amount'}; ?>
                    <tr>
                        <td style=" width: 14% ; text-align:left"><?php echo $value{'Department'}; ?></td>
                        <td style=" width: 6% ; text-align:right"><?php echo number_format($value{'Basic'},2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Aut'},2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Ot'},2,'.',','); ?></td>
                        <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Nd'},2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Holiday'},2,'.',','); ?></td>
                        <td style=" width: 6% ; text-align:right;"><?php echo number_format($value{'Other Earnings'},2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Gross'},2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Sss'},2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Phic'},2,'.',','); ?></td>
                        <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Hdmf'},2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Tax'},2,'.',','); ?></td>
                        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Loan'},2,'.',','); ?></td>
                        <td style=" width: 7% ; text-align:right;"><?php echo number_format($value{'Employee Ledger'},2,'.',','); ?></td>
                        <td style=" width: 7% ; text-align:right;"><?php echo number_format($value{'Other Deduction'},2,'.',','); ?></td>
                        <td style=" width: 6% ; text-align:right;"><?php echo number_format($value{'Deduction'},2,'.',','); ?></td>
                        <td style=" width: 6% ; text-align:right;"><?php echo number_format($value{'Net Amount'},2,'.',','); ?></td>
                    </tr>
            <?php } 
                  if($cnt == $allowed_per_page) $cnt = 1; ?>       
    <?php endforeach;?>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr style="background-color: gray;">
        <td style=" width: 9% ; text-align:left  ; ">Grand Total : </td>
        <td style=" width: 5% ; text-align:left  ; "></td>
        <td style=" width: 6% ; text-align:right"><?php echo number_format( $gtBasic ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtAut ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtOt ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtNd ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtHoliday ,2,'.',','); ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $gtOtherEarnings ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtGross ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtSSS ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtPHIC ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtHDMF ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtTax ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtLoan ,2,'.',','); ?></td>
        <td style=" width: 7% ; text-align:right;"><?php echo number_format( $gtEmployeeLedger ,2,'.',','); ?></td>
        <td style=" width: 7% ; text-align:right;"><?php echo number_format( $gtOtherDeduction ,2,'.',','); ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $gtDeduction ,2,'.',','); ?></td>
        <td style=" width: 6% ; text-align:right;"><?php echo number_format( $gtNetAmount ,2,'.',','); ?></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
</table>
<table>
    <tr>
        <td style=" width: 30%; text-align:left  ; font-size: 7; ">Prepared By: </td>
        <td style=" width:  3%; text-align:center; font-size: 7; "></td>
        <td style=" width: 30%; text-align:left  ; font-size: 7; ">Checked By: </td>
        <td style=" width:  3%; text-align:center; font-size: 7; "></td>
        <td style=" width: 30%; text-align:left  ; font-size: 7; ">Approved By:</td>
        <td style=" width:  3%; text-align:center; font-size: 7; "></td>
    </tr>
    <tr><td></td></tr><tr><td></td></tr>
    <tr>
        <td style=" width: 30%; text-align:left; border-top: 1px solid black ; font-size: 7; "></td>
        <td style=" width:  3%; text-align:right; font-size: 7; "></td>
        <td style=" width: 30%; text-align:left; border-top: 1px solid black ; font-size: 7; "></td>
        <td style=" width:  3%; text-align:right;"></td>
        <td style=" width: 30%; text-align:left; border-top: 1px solid black ; font-size: 7; "></td>
        <td style=" width:  3%; text-align:right; font-size: 7; "></td>                                    
    </tr>
    <tr><td style=" width: 100%; font-size: 15; border-bottom: 1px solid black; "></td></tr>
    <tr>
        <td style=" width: 50%; text-align:   left; font-size: 6; ">Run Date :<?php echo date('h:m:sa, m/d/Y'); ?></td>
        <td style=" width: 50%; text-align:  right; font-size: 6; "><!-- Page --> : <?php echo ''; ?></td>
    </tr>
</table>