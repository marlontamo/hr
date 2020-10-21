<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>
<?php 
    $res = $result->row();
    $reg_company = get_registered_company();
    if(is_array($reg_company)) {
        $company = $reg_company['registered_company'];
	}else{
		$company = $res->{'Company'};
    }
    $month = date("F", mktime(0, 0, 0,  $res->{'Month'}, 15));
    $year = $res->{'Year'};
    $allow_cnt = 40;
    $page_no = 0;
?>
    
<table>
    <?php 
    $result = $result->result_array();
    $count = 1;
    $ctr = 0;
    $whtax = 0;
    $gross_pay = 0;
    $gross1 = 0;
    $gross2 = 0;
    $wtax1 = 0;
    $wtax2 = 0;
    $g_gross1 = 0;
    $g_gross2 = 0;
    $g_wtax1 = 0;
    $g_wtax2 = 0;
    $res_cnt = count($result);
    foreach ($result as $row):
        $ctr++;
        if($ctr == 1){
            $page_no++;
    ?>
            <tr>
                <td style=" width:100% ; text-align:center ; "><strong><?php echo $company; ?></strong></td>
            </tr>
            <tr>
                <td style=" width:100% ; text-align:center ; "><strong>TAX CONTRIBUTION</strong></td>
            </tr>
            <tr>
                <td style=" width:100% ; text-align:center ; ">For the Month of <?php echo $month . " " . $year; ?></td>
            </tr>
            <tr>
                <td style=" width:100% ; text-align:center ; ">&nbsp;</td>
            </tr>
            <tr>
                <td style=" width:2%"></td>
                <td style=" width:44% ; text-align:left ; ">Print Date: <?php echo date('m d, Y'); ?></td>
                <td style=" width:44% ; text-align:right ; ">Page No: <?php $page_no; ?></td>
            </tr>
                <tr>
                <td style=" width:2%"></td>
                <td style=" width:88% ; text-align:left ; ">Print Time: <?php echo date('g:i a'); ?></td>
            </tr>
            <tr>
                <td style=" width:100% ; text-align:left ; "></td>
            </tr>
            <tr>
                <td style="width: 5%; text-align:center; background-color: gray; "><strong></strong></td>
                <td style="width: 8%; text-align:center; background-color: gray; "><strong>Employee</strong></td>
                <td style="width: 25%; text-align:center; background-color: gray; "><strong></strong></td>
                <td style="width: 11%; text-align:center; background-color: gray; "><strong></strong></td>
                <td style="width: 17%; text-align:center; background-color: gray; "><strong>First Half</strong></td>
                <td style="width: 17%; text-align:center; background-color: gray; "><strong>Second Half</strong></td>
                <td style="width: 17%; text-align:center; background-color: gray; "><strong>Total</strong></td>
            </tr>
            <tr>
                <td style="width: 5%; text-align:center; background-color: gray; "><strong></strong></td>
                <td style="width: 8%; text-align:center; background-color: gray; "><strong>Code</strong></td>
                <td style="width: 25%; text-align:center; background-color: gray; "><strong>Employee</strong></td>
                <td style="width: 11%; text-align:center; background-color: gray; "><strong>Tin</strong></td>
                <td style="width: 9%; text-align:center; background-color: gray; "><strong>Gross</strong></td>
                <td style="width: 8%; text-align:center; background-color: gray; "><strong>Tax</strong></td>
                <td style="width: 9%; text-align:center; background-color: gray; "><strong>Gross</strong></td>
                <td style="width: 8%; text-align:center; background-color: gray; "><strong>Tax</strong></td>
                <td style="width: 9%; text-align:center; background-color: gray; "><strong>Gross</strong></td>
                <td style="width: 8%; text-align:center; background-color: gray; "><strong>Tax</strong></td>
            </tr>
            <tr>
                <td style=" width:100% ; text-align:left ; "></td>
            </tr>
    <?php }?>
    <tr>
        <td style="width: 5%; text-align:center; "><?php echo $count++; ?></td>
        <td style="width: 8%; text-align:center; "><?php echo $row['Id Number']; ?></td>
        <td style="width: 25%; text-align:left; "><?php echo $row['Full Name']; ?></td>
        <td style="width: 11%; text-align:center; "><?php echo $row['Tin']; ?></td>
        <td style="width: 9%; text-align:right; "><?php echo number_format( $row['Gross Pay1'] ,2,'.',','); ?></td>
        <td style="width: 8%; text-align:right; "><?php echo number_format( $row['Whtax1'] ,2,'.',','); ?></td>
        <td style="width: 9%; text-align:right; "><?php echo number_format( $row['Gross Pay2'] ,2,'.',','); ?></td>
        <td style="width: 8%; text-align:right; "><?php echo number_format( $row['Whtax2'] ,2,'.',','); ?></td>
        <?php 
        $gross1 = $row['Gross Pay1'];
        $gross2 = $row['Gross Pay2'];
        $wtax1 = $row['Whtax1'];
        $wtax2 = $row['Whtax2'];
        $total_gross = $row['Gross Pay1'] + $row['Gross Pay2']; 
        $total_tax = $row['Whtax1'] + $row['Whtax2']; 
        ?>
        <td style="width: 9%; text-align:right; "><?php echo number_format( $total_gross ,2,'.',','); ?></td>
        <td style="width: 8%; text-align:right; "><?php echo number_format( $total_tax ,2,'.',','); ?></td>
    </tr>
    <?php 
    $whtax += $total_tax;
    $gross_pay += $total_gross;
    $g_gross1 +=  $gross1;
    $g_gross2 +=  $gross2;
    $g_wtax1 +=  $wtax1;
    $g_wtax2 +=  $wtax2;
    if($ctr == $allow_cnt) {
        $ctr = 0;
    ?>
        <tr><td style=" width:100% ; text-align:left ; "></td></tr>
        <tr><td style=" width:100% ; text-align:left ; "></td></tr>
        <tr><td style=" width:100% ; text-align:left ; "></td></tr>
        <tr><td style=" width:100% ; text-align:left ; "></td></tr>
        <tr><td style=" width:100% ; text-align:left ; "></td></tr>
        <tr><td style=" width:100% ; text-align:left ; "></td></tr>
    <?php } 
    endforeach; ?>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr>
        <td style="width: 11%; text-align:center; ">TOTAL</td>
        <td style="width: 38%; text-align:center; "></td>
        <td style="width: 9%; text-align:right; "><?php echo number_format( $g_gross1 ,2,'.',','); ?></td>
        <td style="width: 8%; text-align:right; "><?php echo number_format( $g_wtax1 ,2,'.',','); ?></td>
        <td style="width: 9%; text-align:right; "><?php echo number_format( $g_gross2 ,2,'.',','); ?></td>
        <td style="width: 8%; text-align:right; "><?php echo number_format( $g_wtax2 ,2,'.',','); ?></td>
        <td style="width: 9%; text-align:right; "><?php echo number_format( $gross_pay ,2,'.',','); ?></td>
        <td style="width: 8%; text-align:right; "><?php echo number_format( $whtax ,2,'.',','); ?></td>
    </tr>
</table>
<br>
<br>
<br>
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
