<?php
    //prep data
    $res = $result->row();
    $company = $res->{'Company'};
    $address = $res->{'Address'};
    $payroll_date = $res->{'Payroll Date'};
    $phone_no = $res->{'Phone No'};
    $fax_no = $res->{'Fax No'};
    $year = $res->{'Year'};
    $month = date("F", mktime(0, 0, 0, $res->{'Month'}, 10));
    $results = $result->result_array();
    $res = array();
    $fields = array();
    foreach ($results as $_value) {
        $res[$_value['User Id']]['fullname'] = $_value['Full Name'];
        $res[$_value['User Id']]['id_number'] = $_value['Id Number'];
        $res[$_value['User Id']]['department'] = $_value['Department'];
        foreach ($_value as $_key => $val) {
            if(strpos(strtolower($_value['Transaction Label']), 'loan') !== false){
                $res[$_value['User Id']]['details'][$_value['Transaction Label']] = $_value['Amount']; 
                array_push($fields, $_value['Transaction Label']);
            } else {
                $label = substr($_value['Transaction Label'], 0, strpos($_value['Transaction Label'], ' '));
                $res[$_value['User Id']][$label] = $_value['Amount']; 
            }
        }
    }
    $fields = array_unique($fields);
?>
<table>
    <tr><td></td></tr>
    <tr>
        <td width="100%" style="text-align:left; font-size:10; "><strong><?php echo $company; ?></strong></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left; font-size:5;"><?php echo $address; ?></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left; font-size:5;">Phone No: <?php echo $phone_no; ?> Fax No: <?php echo $fax_no;?></td>
    </tr>
    <tr>
        <td width="100%" style="font-size:10;"></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left; font-size:10; "><strong>Payroll Contribution and Loan Summary</strong></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left; font-size:10; "><strong>Payroll Period : <?php echo $month . " " . $year?></strong></td>
    </tr>
    <tr>
        <td width="100%" style="font-size:10;"></td>
    </tr>
    <tr>
        <td width="2%" style="text-align:center;"></td>
        <td width="20%" style="text-align:left;">Employee Name</td>
        <td width="10%" style="text-align:right;">SSS</td>
        <td width="10%" style="text-align:right;">PHIC</td>
        <td width="10%" style="text-align:right;">HDMF</td>
        <?php $width = 48 / count($fields);  
            foreach ($fields as $_fields) { ?>
                <td width="<?php echo $width; ?>%" style="text-align:right;"><?php echo $_fields; ?></td>
        <?php }?>
    </tr>
    <tr> 
        <td width="100%" style="font-size:1; border-bottom:1px solid black;"></td>
    </tr>
    <tr> 
        <td width="100%" style="font-size:4;"></td>
    </tr>
    <?php
    $count = 0;
    $tot_amount = 0;
    $total_line = 0;
    $gtot_amount = 0;
    $gtot_adv_amt = 0;
    $t_sss = 0;
    $t_phic = 0;
    $t_hdmf = 0;
    $tot = array();
    foreach ($res as $dtl_res) {
            if($count == 54){
                $count = 0; ?>
                <table>
                    <tr><td></td></tr><tr><td></td></tr>
                    <tr>
                        <td width="30%"  style="text-align:left;">Prepared By: </td>
                        <td width="3%"  style="text-align:center;"></td>
                        <td width="30%"  style="text-align:left;">Checked By: </td>
                        <td width="3%"  style="text-align:center;"></td>
                        <td width="30%"  style="text-align:left;">Approved By:</td>
                        <td width="3%"  style="text-align:center;"></td>
                    </tr>
                    <tr><td></td></tr><tr><td></td></tr>
                    <tr>
                        <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
                        <td style="text-align:right;"></td>                                    
                    </tr>
                    <tr><td></td></tr><tr><td></td></tr>
                    <tr>
                        <td width="12%" style="text-align:left; "></td>
                        <td width="5%" style="text-align:center; "></td>
                        <td width="20%" style="text-align:left; "></td>
                        <td width="63%" ></td>
                    </tr>
                </table>
                <div style="page-break-before: always;">
                <table>
                    <tr><td></td></tr>
                    <tr>
                        <td width="100%" style="text-align:left; font-size:10; "><strong><?php echo $company; ?></strong></td>
                    </tr>
                    <tr>
                        <td width="100%" style="text-align:left; font-size:5;"><?php echo $address; ?></td>
                    </tr>
                    <tr>
                        <td width="100%" style="text-align:left; font-size:5;">Phone No: <?php echo $phone_no; ?> Fax No: <?php echo $fax_no;?></td>
                    </tr>
                    <tr>
                        <td width="100%" style="font-size:10;"></td>
                    </tr>
                    <tr>
                        <td width="100%" style="text-align:left;"><strong>Payroll Contribution and Loan Summary</strong></td>
                    </tr>
                    <tr>
                        <td width="100%" style="text-align:left;"><strong> Payroll Period <?php echo $month . " " . $year?></strong></td>
                    </tr>
                    <tr>
                        <td width="100%" style="font-size:10;"></td>
                    </tr>
                    <tr>
                        <td width="2%" style="text-align:center;"></td>
                        <td width="35%" style="text-align:left;">Employee Name</td>
                        <td width="10%" style="text-align:right;">SSS</td>
                        <td width="10%" style="text-align:right;">PHIC</td>
                        <td width="10%" style="text-align:right;">HDMF</td>
                        <?php $width = 48 / count($fields);  
                            foreach ($fields as $_fields) { ?>
                                <td width="<?php echo $width; ?>%" style="text-align:right;"><?php echo $_fields; ?></td>
                        <?php }?>
                    </tr>
                    <tr> 
                        <td width="100%" style="font-size:1; border-bottom:1px solid black;"></td>
                    </tr>
                    <tr> 
                        <td width="100%" style="font-size:4;"></td>
                    </tr>
                </table>
                </div><?php 

            } 
            $count++;
            ?>
            <tr>
                <td width="2%" style="text-align:left;"><?php echo $count; ?></td>
                <td width="20%" style="text-align:left;"><?php echo $dtl_res['fullname']; ?></td>
                <td width="10%" style="text-align:right;"><?php echo $dtl_res['SSS']; ?></td>
                <td width="10%" style="text-align:right;"><?php echo $dtl_res['PhilHealth']; ?></td>
                <td width="10%" style="text-align:right;"><?php echo $dtl_res['PagIBIG']; ?></td>
                <?php
                    $t_sss +=  $dtl_res['SSS'];
                    $t_phic +=  $dtl_res['PhilHealth'];
                    $t_hdmf +=  $dtl_res['PagIBIG']; 
                    foreach ($dtl_res['details'] as $key_d => $_dtl_res) { ?>
                    <td width="<?php echo $width; ?>%" style="text-align:right;"><?php echo $_dtl_res; ?></td>
                <?php 
                        if(!isset($tot[$key_d]))
                        {
                           $tot[$key_d]=0;
                        }
                        $tot[$key_d] += $_dtl_res;
                    } ?>
            </tr>
    <?php
            $total_line++;
            
    } 
    ?>

    <tr>
        <td width="22%"  style="text-align:Left;font-size:2;"></td>
        <td width="10%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
        <td width="10%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
        <td width="10%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
        <td width="48%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
    </tr>
    <tr>
        <td width="22%"  style="text-align:left;"></td>
        <td width="10%" style="text-align:right;"><strong><?php echo $t_sss; ?></strong></td>
        <td width="10%" style="text-align:right;"><strong><?php echo $t_phic; ?></strong></td>
        <td width="10%" style="text-align:right;"><strong><?php echo $t_hdmf; ?></strong></td>
        <?php foreach ($tot as $_tot) { ?>
           <td width="<?php echo $width; ?>%"  style="text-align:right; "><strong><?php echo $_tot; ?></strong></td>
        <?php }?>
    </tr>
    <tr>
        <td width="22%"  style="text-align:Left;font-size:2;"></td>
        <td width="10%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
        <td width="10%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
        <td width="10%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
        <td width="48%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
    </tr>
    <tr>
        <td width="22%"  style="text-align:Left;font-size:2;"></td>
        <td width="10%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
        <td width="10%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
        <td width="10%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
        <td width="48%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
    </tr>
    <?php 
    if($total_line != 54)
    {
        for ($space=1; $space <= (54 - $count); $space++) 
        { ?>
            <tr><td></td></tr>
        <?php }   
    } ?>
</table>
<table>
    <tr><td></td></tr><tr><td></td></tr>
    <tr>
        <td width="30%"  style="text-align:left;">Prepared By: </td>
        <td width="3%"  style="text-align:center;"></td>
        <td width="30%"  style="text-align:left;">Checked By: </td>
        <td width="3%"  style="text-align:center;"></td>
        <td width="30%"  style="text-align:left;">Approved By:</td>
        <td width="3%"  style="text-align:center;"></td>
    </tr>
    <tr><td></td></tr><tr><td></td></tr>
    <tr>
        <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
        <td style="text-align:right;"></td>
        <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
        <td style="text-align:right;"></td>
        <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
        <td style="text-align:right;"></td>                                    
    </tr>
    <tr><td></td></tr><tr><td></td></tr>
    <tr>
        <td width="12%" style="text-align:left; "></td>
        <td width="5%" style="text-align:center; "></td>
        <td width="20%" style="text-align:left; "></td>
        <td width="63%" ></td>
    </tr>
</table>