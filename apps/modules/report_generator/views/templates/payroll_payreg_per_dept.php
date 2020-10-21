<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>
<?php
	//prep data
	$res = $result->row();
	$company = $res->{'Company'};
	$date_from = $res->{'Date From'};
	$date_to = $res->{'Date To'};

	$result = $result->result_array();
?>
<table>
    <?php 
    $gtBasic         = 0;
    $gtCola          = 0;
    $gtND            = 0;
    $gtOvertime      = 0;
    $gtOthIncTaxable = 0;
    $gtOthIncNontax  = 0;
    $gtAbsences      = 0;
    $gtGrossPay      = 0;
    $gtWhtax         = 0;
    $gtSSS           = 0;
    $gtSSSER         = 0;
    $gtPHIC          = 0;
    $gtPHICER        = 0;
    $gtHDMF          = 0;
    $gtHDMFADD       = 0;
    $gtHDMFER        = 0;
    $gtSSSLN         = 0;
    $gtHDMFLN        = 0;
    $gtOthDed        = 0;
    $gtNetpay        = 0;

    $tBasic         = 0;
    $tCola          = 0;
    $tND            = 0;
    $tOvertime      = 0;
    $tOthIncTaxable = 0;
    $tOthIncNontax  = 0;
    $tAbsences      = 0;
    $tGrossPay      = 0;
    $tWhtax         = 0;
    $tSSS           = 0;
    $tSSSER         = 0;
    $tPHIC          = 0;
    $tPHICER        = 0;
    $tHDMF          = 0;
    $tHDMFADD       = 0;
    $tHDMFER        = 0;
    $tSSSLN         = 0;
    $tHDMFLN        = 0;
    $tOthDed        = 0;
    $tNetpay        = 0;
    $count			= 0;
    $total_count	= 0;
    $row_count      = 0;
    $total_hc       = 0;
    foreach( $result as $value):
        $total_hc += $value{'Total Dept'};
        if($row_count > 32){?>
            <tr>
                <td style=" width:100% ; font-size:2 ; "></td>
            </tr>
            <tr>
                <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
            </tr>
            <tr>
                <td style=" width: 10% ; text-align:left  ; ">Total : <?php echo $count; ?></td>
                <td style=" width: 5% ; text-align:right"><?php echo number_format(  $tBasic ,2,'.',','); ?></td>
                <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tCola ,2,'.',','); ?></td>
                <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tND ,2,'.',','); ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tOvertime ,2,'.',','); ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tOthIncTaxable ,2,'.',','); ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tOthIncNontax ,2,'.',','); ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tAbsences ,2,'.',','); ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tGrossPay ,2,'.',','); ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tWhtax ,2,'.',','); ?></td>
                <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tSSS ,2,'.',','); ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tSSSER ,2,'.',','); ?></td>
                <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tPHIC ,2,'.',','); ?></td>
                <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tPHICER ,2,'.',','); ?></td>
                <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tHDMF ,2,'.',','); ?></td>
                <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tHDMFER ,2,'.',','); ?></td>
                <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tHDMFADD ,2,'.',','); ?></td>
                <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tSSSLN ,2,'.',','); ?></td>
                <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tHDMFLN ,2,'.',','); ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tOthDed ,2,'.',','); ?></td>
                <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tNetpay ,2,'.',','); ?></td>
            </tr>
            <tr>
                <td style=" width:100% ; font-size:2 ; "></td>
            </tr>
            <tr>
                <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
            </tr>
            <tr>
                <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
            </tr>
            </table>
            <div style="page-break-before: always;">&nbsp;</div>
            <table>
            <?php
            $tBasic         = 0;
            $tCola          = 0;
            $tND            = 0;
            $tOvertime      = 0;
            $tOthIncTaxable = 0;
            $tOthIncNontax  = 0;
            $tAbsences      = 0;
            $tGrossPay      = 0;
            $tWhtax         = 0;
            $tSSS           = 0;
            $tSSSER         = 0;
            $tPHIC          = 0;
            $tPHICER        = 0;
            $tHDMF          = 0;
            $tHDMFADD       = 0;
            $tHDMFER        = 0;
            $tSSSLN         = 0;
            $tHDMFLN        = 0;
            $tOthDed        = 0;
            $tNetpay        = 0;
            $count          = 0;
            $row_count      = 0;
        }
        if($row_count == 0 ){?>
            <tr>
                <td style=" width:100% ; text-align:center ; "><strong><?php echo $company; ?></strong></td>
            </tr>
            <tr>
                <td style=" width:100% ; text-align:center ; "><strong>PAYROLL SHEET</strong></td>
            </tr>
            <tr>
                <td style=" width:100% ; text-align:center ; "><strong>ATTENDANCE PERIOD : <?php echo date("m/d/Y",strtotime($date_from)).'  - '.date("m/d/Y",strtotime($date_to)); ?></strong></td>
            </tr>                                        
            <tr>
                <td style=" width:100% ; text-align:center ; "><strong>PAYROLL PERIOD : <?php echo date("m/d/Y",strtotime("+1month",strtotime($date_from))).'  - '.date("m/".date('t',strtotime("+1month",strtotime($date_from)))."/Y",strtotime("+1month",strtotime($date_from))); ?></strong></td>
            </tr>
            <tr>
                <td style=" width:100% ; text-align:left ; "></td>
            </tr>
            <tr> 
                <td style=" width: 10% ; text-align:left;"><strong>&nbsp;</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 1% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 9% ; text-align:center;"><strong>OTHER INCOME</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>GROSS</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
            </tr>
            <tr> 
                <td style=" width: 10% ; text-align:left;"><strong>Department</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>BASIC</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>COLA</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>NDIFF</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>OVERTIME</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>(TAXABLE)</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>(NON-TAX)</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>ABSENCES</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>PAY</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>WTAX</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>SSS</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>SSS ER</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>PHIC</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>PHIC ER</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>HDMF</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>HDMF ER</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>HDMF ADD</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>SSS LOAN</strong></td>
                <td style=" width: 4% ; text-align:right;"><strong>HDMF LOAN</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>COMPANY</strong></td>
                <td style=" width: 5% ; text-align:right;"><strong>NETPAY</strong></td>
            </tr>
            <tr>
                <td style=" width:100% ; font-size:2 ; "></td>
            </tr>
            <tr>
                <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
            </tr><?php
        }
        $row_count++;
		if($value{'Oth Inc Taxable'} == -0.00){
			$value{'Oth Inc Taxable'} = 0.00;
		}?>
		<tr>
	        <td style=" width: 10% ; text-align:left ; font-size: 6.5;"><?php echo $value{'Department'}; ?>  (HC - <?php echo $value{'Total Dept'}; ?>)</td>
	        <td style=" width: 5% ; text-align:right"><?php echo number_format($value{'Basic'},2,'.',','); ?></td>
	        <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Cola'},2,'.',','); ?></td>
            <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Nd'},2,'.',','); ?></td>
	        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Overtime'},2,'.',','); ?></td>
	        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Oth Inc Taxable'},2,'.',','); ?></td>
	        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Oth Inc Nontax'},2,'.',','); ?></td>
	        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Absences'},2,'.',','); ?></td>
	        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Gross Pay'},2,'.',','); ?></td>
	        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Whtax'},2,'.',','); ?></td>
	        <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Sss'},2,'.',','); ?></td>
            <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Ssser'},2,'.',','); ?></td>
	        <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Phic'},2,'.',','); ?></td>
            <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Phicer'},2,'.',','); ?></td>
	        <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Hdmf'},2,'.',','); ?></td>
            <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Hdmfer'},2,'.',','); ?></td>
            <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Hdmf Add'},2,'.',','); ?></td>
            <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Sss Loan'},2,'.',','); ?></td>
            <td style=" width: 4% ; text-align:right;"><?php echo number_format($value{'Hdmf Loan'},2,'.',','); ?></td>
	        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Oth Ded'},2,'.',','); ?></td>
	        <td style=" width: 5% ; text-align:right;"><?php echo number_format($value{'Netpay'},2,'.',','); ?></td>
	    </tr>
		<?php
        $tBasic         += $value{'Basic'};
        $tCola          += $value{'Cola'};
        $tND            += $value{'Nd'};
        $tOvertime      += $value{'Overtime'};
        $tOthIncTaxable += $value{'Oth Inc Taxable'};
        $tOthIncNontax  += $value{'Oth Inc Nontax'};
        $tAbsences      += $value{'Absences'};
        $tGrossPay      += $value{'Gross Pay'};
        $tWhtax         += $value{'Whtax'};
        $tSSS           += $value{'Sss'};
        $tSSSER         += $value{'Ssser'};
        $tPHIC          += $value{'Phic'};
        $tPHICER        += $value{'Phicer'};
        $tHDMF          += $value{'Hdmf'};
        $tHDMFER        += $value{'Hdmfer'};
        $tHDMFADD       += $value{'Hdmf Add'};
        $tSSSLN         += $value{'Sss Loan'};
        $tHDMFLN        += $value{'Hdmf Loan'};
        $tOthDed        += $value{'Oth Ded'};
        $tNetpay        += $value{'Netpay'};

        $gtBasic         += $value{'Basic'};
        $gtCola          += $value{'Cola'};
        $gtND            += $value{'Nd'};
        $gtOvertime      += $value{'Overtime'};
        $gtOthIncTaxable += $value{'Oth Inc Taxable'};
        $gtOthIncNontax  += $value{'Oth Inc Nontax'};
        $gtAbsences      += $value{'Absences'};
        $gtGrossPay      += $value{'Gross Pay'};
        $gtWhtax         += $value{'Whtax'};
        $gtSSS           += $value{'Sss'};
        $gtSSSER         += $value{'Ssser'};
        $gtPHIC          += $value{'Phic'};
        $gtPHICER        += $value{'Phicer'};
        $gtHDMF          += $value{'Hdmf'};
        $gtHDMFER        += $value{'Hdmfer'};
        $gtHDMFADD       += $value{'Hdmf Add'};
        $gtSSSLN         += $value{'Sss Loan'};
        $gtHDMFLN        += $value{'Hdmf Loan'};
        $gtOthDed        += $value{'Oth Ded'};
        $gtNetpay        += $value{'Netpay'};
        $count++;
        $total_count++;
	endforeach; ?>
	<tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr>
        <td style=" width: 10% ; text-align:left  ; ">Total : <?php echo $count; ?></td>
        <td style=" width: 5% ; text-align:right"><?php echo number_format(  $tBasic ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tCola ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tND ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tOvertime ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tOthIncTaxable ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tOthIncNontax ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tAbsences ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tGrossPay ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tWhtax ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tSSS ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tSSSER ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tPHIC ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tPHICER ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tHDMF ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tHDMFER ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tHDMFADD ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tSSSLN ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $tHDMFLN ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tOthDed ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $tNetpay ,2,'.',','); ?></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr><td></td></tr>
	<tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr>
        <td style=" width: 10% ; text-align:left  ; ">Grand Total : <?php echo $total_count; ?> <br /> (Head Count : <?php echo $total_hc ?>)</td>
        <td style=" width: 5% ; text-align:right"><?php echo number_format( $gtBasic ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtCola ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtND ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtOvertime ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtOthIncTaxable ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtOthIncNontax ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtAbsences ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtGrossPay ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtWhtax ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtSSS ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtSSSER ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtPHIC ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtPHICER ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtHDMF ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtHDMFER ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtHDMFADD ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtSSSLN ,2,'.',','); ?></td>
        <td style=" width: 4% ; text-align:right;"><?php echo number_format( $gtHDMFLN ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtOthDed ,2,'.',','); ?></td>
        <td style=" width: 5% ; text-align:right;"><?php echo number_format( $gtNetpay ,2,'.',','); ?></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
</table>
