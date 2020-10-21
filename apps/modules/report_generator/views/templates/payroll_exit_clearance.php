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
        <td colspan="11" width="100%" style="font-size:10;">Exit Clearance</td>
    </tr>
    <tr>
        <td colspan="11" width="100%" style="font-size:10;">Date Processed: <?php echo date("m/d/Y"); ?></td>
    </tr>
      

    <?php 

        $user_id = '';
        $gross = 0;
        $tax = 0;
        $sssee = 0;
        $ssser = 0;
        $sssec = 0;
        $hdmfee = 0;
        $hdmfer = 0;
        $phicee = 0;
        $phicer = 0;

        foreach ($results as $dtl_res) {
            if(empty($user_id)){ ?>
                <tr>
                    <td colspan="11" width="100%" style="font-size:10;"></td>
                 </tr>  
                <tr>
                    <td>EMPLOYEE NAME: </td>
                    <td colspan="4"><?php echo $dtl_res['Full Name']; ?></td>
                    <td>ID No: </td>
                    <td colspan="5"><?php echo $dtl_res['Id Number']; ?></td>
                </tr>

                <tr>
                    <td>Date Hired: </td>
                    <td colspan="4"><?php echo date("m/d/Y", strtotime($dtl_res['Effectivity Date'])); ?></td>
                    <td>Project Name: </td>
                    <td colspan="5"><?php echo $dtl_res['Project']; ?></td>
                </tr>

                <tr>
                    <td>Date Separated: </td>
                    <td colspan="4"><?php echo date("m/d/Y", strtotime($dtl_res['Resigned Date'])); ?></td>
                    <td>Tax Status: </td>
                    <td colspan="5"><?php ?></td>
                </tr> 

                <tr>
                    <td>Reason of Separation: </td>
                    <td colspan="10"> </td>
                </tr>

                <tr>
                    <td colspan="11" width="100%" style="font-size:10;"></td>
                </tr>

                <tr>
                    <td>PAY PERIOD</td>  
                    <td>GROSS</td>   
                    <td>TAX</td> 
                    <td>SSS EE</td>  
                    <td>SSS ER</td>  
                    <td>SSS EC</td>  
                    <td>HDMF EE</td> 
                    <td>HDMF ER</td> 
                    <td>PHIC EE</td> 
                    <td>PHIC ER</td> 
                    <td>REMARKS</td>
                </tr>

<?php
            }//if
            else {


                if($user_id != $dtl_res['User Id']) { ?>
               
                <tr>
                    <td>TOTAL</td>  
                    <td><?php echo number_format($gross,2,".",","); ?></td>
                    <td><?php echo number_format($tax,2,".",","); ?></td>
                    <td><?php echo number_format($sssee,2,".",","); ?></td>
                    <td><?php echo number_format($ssser,2,".",","); ?></td>
                    <td><?php echo number_format($sssec,2,".",","); ?></td>
                    <td><?php echo number_format($hdmfee,2,".",","); ?></td>
                    <td><?php echo number_format($hdmfer,2,".",","); ?></td>
                    <td><?php echo number_format($phicee,2,".",","); ?></td>
                    <td><?php echo number_format($phicer,2,".",","); ?></td> 
                    <td></td>
                </tr>

                <tr>
                    <td colspan="11" width="100%" style="font-size:10;"></td>
                </tr>  
                <tr>
                    <td>EMPLOYEE NAME: </td>
                    <td colspan="4"><?php echo $dtl_res['Full Name']; ?></td>
                    <td>ID No: </td>
                    <td colspan="5"><?php echo $dtl_res['Id Number']; ?></td>
                </tr>

                <tr>
                    <td>Date Hired: </td>
                    <td colspan="4"><?php echo date("m/d/Y", strtotime($dtl_res['Effectivity Date'])); ?></td>
                    <td>Project Name: </td>
                    <td colspan="5"><?php echo $dtl_res['Project']; ?></td>
                </tr>

                <tr>
                    <td>Date Separated: </td>
                    <td colspan="4"><?php echo date("m/d/Y", strtotime($dtl_res['Resigned Date'])); ?></td>
                    <td>Tax Status: </td>
                    <td colspan="5"><?php ?></td>
                </tr> 

                <tr>
                    <td>Reason of Separation: </td>
                    <td colspan="10"> </td>
                </tr>

                <tr>
                    <td colspan="11" width="100%" style="font-size:10;"></td>
                </tr>  

                <tr>
                    <td>PAY PERIOD</td>  
                    <td>GROSS</td>   
                    <td>TAX</td> 
                    <td>SSS EE</td>  
                    <td>SSS ER</td>  
                    <td>SSS EC</td>  
                    <td>HDMF EE</td> 
                    <td>HDMF ER</td> 
                    <td>PHIC EE</td> 
                    <td>PHIC ER</td> 
                    <td>REMARKS</td>
                </tr>

    <?php       
            $gross = 0;
            $tax = 0;
            $sssee = 0;
            $ssser = 0;
            $sssec = 0;
            $hdmfee = 0;
            $hdmfer = 0;
            $phicee = 0;
            $phicer = 0;
    }//if
}//else

    ?>

    

    

    <tr>
        <td><?php echo date("m/d/Y", strtotime($dtl_res['Payroll Date'])); ?></td>  
        <td><?php echo number_format($dtl_res['Gross'],2,".",","); ?></td>   
        <td><?php echo number_format($dtl_res['Tax'],2,".",","); ?></td> 
        <td><?php echo number_format($dtl_res['Sss Ee'],2,".",","); ?></td>  
        <td><?php echo number_format($dtl_res['Sss Er'],2,".",","); ?></td>  
        <td><?php echo number_format($dtl_res['Sss Ec'],2,".",","); ?></td>  
        <td><?php echo number_format($dtl_res['Hdmf Ee'],2,".",","); ?></td> 
        <td><?php echo number_format($dtl_res['Hdmf Er'],2,".",","); ?></td> 
        <td><?php echo number_format($dtl_res['Phic Ee'],2,".",","); ?></td> 
        <td><?php echo number_format($dtl_res['Phic Er'],2,".",","); ?></td> 
        <td><?php echo $dtl_res['Remarks']; ?></td>
    </tr>

    <?php
            $user_id = $dtl_res['User Id'];
            $gross += $dtl_res['Gross'];
            $tax += $dtl_res['Tax'];
            $sssee += $dtl_res['Sss Ee'];
            $ssser += $dtl_res['Sss Er'];
            $sssec += $dtl_res['Sss Ec'];
            $hdmfee += $dtl_res['Hdmf Ee'];
            $hdmfer += $dtl_res['Hdmf Er'];
            $phicee += $dtl_res['Phic Ee'];
            $phicer += $dtl_res['Phic Er'];

    }//foreach

    ?>
    <tr>
                    <td>TOTAL</td>  
                    <td><?php echo number_format($gross,2,".",","); ?></td>
                    <td><?php echo number_format($tax,2,".",","); ?></td>
                    <td><?php echo number_format($sssee,2,".",","); ?></td>
                    <td><?php echo number_format($ssser,2,".",","); ?></td>
                    <td><?php echo number_format($sssec,2,".",","); ?></td>
                    <td><?php echo number_format($hdmfee,2,".",","); ?></td>
                    <td><?php echo number_format($hdmfer,2,".",","); ?></td>
                    <td><?php echo number_format($phicee,2,".",","); ?></td>
                    <td><?php echo number_format($phicer,2,".",","); ?></td> 
                    <td></td>
                </tr>

</table>


