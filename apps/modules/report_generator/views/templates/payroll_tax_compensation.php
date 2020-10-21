<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>
<?php
	//prep data
	$res = $result->row();
	$company = $res->{'Company Name'};
	$year = $res->{'Year'};

	$result = $result->result_array();
	$headers = array();
	$template = '';
	
?>
<table>
    <tr><td>MONTHLY INCOME - <?php echo $year;?></td></tr>
    <tr><td>TAXES ON COMPENSATION</td></tr>
    <tr>
        <td></td>
        <td colspan="7">TOTAL AMOUNT OF COMPENSATION</td>
        <td colspan="10">NON-TAXABLE</td>
        <td></td>
    </tr>
    
    <tr>
        <td>MONTH</td>
        <td>MONTHLY BASIC</td>
        <td>MONTHLY OT</td>
        <td>DAILY BASIC</td>
        <td>DAILY OT</td>
        <td>13TH MONTH / BONUS / RET</td>
        <td>SIL / VL / SL</td>
        <td>TOTAL</td>
        <td>MONTHLY BASIC</td>
        <td>MONTHLY OT</td>
        <td>DAILY BASIC</td>
        <td>DAILY OT</td>
        <td>13TH MONTH / BONUS / RET</td>
        <td>SIL / VL / SL/td>
        <td>SSS</td>
        <td>HDMF</td>
        <td>PHILHEALTH</td>
        <td>TOTAL</td>
        <td>NET (TAXABLE COMPENSATION)</td>
        <td>W/TAX</td>
    </tr>
   <!-- TOTAL AMOUNT OF COMPENSATION == NON-TAXABLE -->
<!-- </table> -->
<?php 
    $gtotal_month_name          = 0;
    $gtotal_monthly_basic_tax   = 0;
    $gtotal_monthly_ot_tax      = 0;
    $gtotal_daily_basic_tax     = 0;
    $gtotal_daily_ot_tax        = 0;
    $gtotal_bonus_tax           = 0;
    $gtotal_sil_tax             = 0;
    $gtotal_tax                 = 0;
    $gtotal_monthly_basic_nt    = 0;
    $gtotal_monthly_ot_nt       = 0;
    $gtotal_daily_basic_nt      = 0;
    $gtotal_daily_ot_nt         = 0;
    $gtotal_bonus_nt            = 0;
    $gtotal_sil_nt              = 0;
    $gtotal_nt                  = 0;
    $gtotal_sss                 = 0;
    $gtotal_hdmf                = 0;
    $gtotal_phic                = 0;
    $gtotal_nettaxable          = 0;
    $gtotal_wtax                = 0;    
    foreach($result as $value) :
        $total_tax = 0;
        $total_nt  = 0;
        $nettaxable = 0;
        $total_tax = $value{'Monthly Basic Tax'} + $value{'Monthly Ot Tax'} + $value{'Daily Basic Tax'} + $value{'Daily Ot Tax'} + $value{'Bonus Tax'} + $value{'Sil Tax'};
        $total_nt  = $value{'Monthly Basic Nt'} + $value{'Monthly Ot Nt'} + $value{'Daily Basic Nt'} + $value{'Daily Ot Nt'} + $value{'Bonus Nt'} + $value{'Sil Nt'};
        $nettaxable = $total_tax - $total_nt;
        ?>
    <!-- <table> -->
        <tr>
            <td><?php echo $value{'Month Name'};?></td>
            <td><?php echo number_format( $value{'Monthly Basic Tax'} , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Monthly Ot Tax'} , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Daily Basic Tax'} , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Daily Ot Tax'} , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Bonus Tax'} , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Sil Tax'} , 2, '.','');?></td>
            <td><?php echo number_format( $total_tax , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Monthly Basic Nt'} , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Monthly Ot Nt'} , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Daily Basic Nt'} , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Daily Ot Nt'} , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Bonus Nt'} , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Sil Nt'} , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Sss'} , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Hdmf'} , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Phic'} , 2, '.','');?></td>
            <td><?php echo number_format( $total_nt , 2, '.','');?></td>
            <td><?php echo number_format( $nettaxable , 2, '.','');?></td>
            <td><?php echo number_format( $value{'Wtax'} , 2, '.','');?></td>
        </tr>
    <!-- </table> -->
<?php
    $gtotal_monthly_basic_tax   += $value{'Monthly Basic Tax'};
    $gtotal_monthly_ot_tax      += $value{'Monthly Ot Tax'};
    $gtotal_daily_basic_tax     += $value{'Daily Basic Tax'};
    $gtotal_daily_ot_tax        += $value{'Daily Ot Tax'};
    $gtotal_bonus_tax           += $value{'Bonus Tax'};
    $gtotal_sil_tax             += $value{'Sil Tax'};
    $gtotal_tax                 += $total_tax;
    $gtotal_monthly_basic_nt    += $value{'Monthly Basic Nt'};
    $gtotal_monthly_ot_nt       += $value{'Monthly Ot Nt'};
    $gtotal_daily_basic_nt      += $value{'Daily Basic Nt'};
    $gtotal_daily_ot_nt         += $value{'Daily Ot Nt'};
    $gtotal_bonus_nt            += $value{'Bonus Nt'};
    $gtotal_sil_nt              += $value{'Sil Nt'};
    $gtotal_sss                 += $value{'Sss'};
    $gtotal_hdmf                += $value{'Hdmf'};
    $gtotal_phic                += $value{'Phic'};
    $gtotal_nt                  += $total_nt;
    $gtotal_nettaxable          += $nettaxable;
    $gtotal_wtax                += $value{'Wtax'};        
        
    endforeach; ?>
<!-- <table> -->
    <tr>
        <td>TOTAL</td>
        <td><?php echo number_format( $gtotal_monthly_basic_tax , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_monthly_ot_tax , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_daily_basic_tax , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_daily_ot_tax , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_bonus_tax , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_sil_tax , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_tax , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_monthly_basic_nt , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_monthly_ot_nt , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_daily_basic_nt , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_daily_ot_nt , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_bonus_nt , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_sil_nt , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_sss , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_hdmf , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_phic , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_nt , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_nettaxable , 2, '.','');?></td>
        <td><?php echo number_format( $gtotal_wtax , 2, '.','');?></td>
    </tr>
</table>




















