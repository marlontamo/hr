<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>

<table>
    <tr>
        <td style=" width:100% ; text-align:center ; "><strong>Leave Credit Accrual and Usage</strong></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:left ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:left ; ">Print Date: <?php echo date('m d, Y'); ?></td>
    </tr>
        <tr>
        <td style=" width:100% ; text-align:left ; ">Print Time: <?php echo date('g:i a'); ?></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:left ; "></td>
    </tr>
    <?php 
    $result = $result->result_array();

    $sub_accrual = 0;
    $sub_usage = 0;
    $sub_balance = 0;

    $accrual = 0;
    $usage = 0;
    $balance = 0;

    $form_id = '';
    $user_id = '';

    foreach ($result as $row):
        // DETAILS
        if($form_id == '') { 
            if($user_id == '') { ?>
                <tr>
                    <td style=" width:100% ; text-align:left ; "><strong><?php echo $row['Fullname']; ?></strong></td>
                </tr> 
                <tr>
                    <td style=" width:100% ; text-align:left ; "></td>
                </tr> <?php
            } else {
                if( $user_id != $row['User Id']){
                    ?>
                <tr>
                    <td style=" width:100% ; text-align:left ; "><strong><?php echo $row['Fullname']; ?></strong></td>
                </tr> 
                <tr>
                    <td style=" width:100% ; text-align:left ; "></td>
                </tr> <?php
                }
            }
            ?>
            <tr>
                <td style=" width:100% ; text-align:left ; "><strong><?php echo $row['Form']; ?></strong></td>
            </tr>
            <tr style="">
                <td style="width: 20%; text-align:center;"></td>
                <td style="width: 15%; text-align:left; background-color:grey;"><strong>Date</strong></td>
                <td style="width: 15%; text-align:center; background-color:grey;"><strong>Accrual</strong></td>
                <td style="width: 15%; text-align:center; background-color:grey;"><strong>Usage</strong></td>
                <td style="width: 15%; text-align:center; background-color:grey;"></td>
                <td style="width: 20%; text-align:center;"></td>
            </tr><?php
        } else {
            if( $form_id != $row['Form Id'] || $user_id != $row['User Id'] ){ ?>
            <tr>
                <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
            </tr>
            <tr>
                <td style="width: 20%; text-align:center;"></td>
                <td style="width: 15%; text-align:left; ">Total: </td>
                <td style="width: 15%; text-align:center; "><?php echo $sub_accrual ?></td>
                <td style="width: 15%; text-align:center; "><?php echo $sub_usage ?></td>
                <td style="width: 15%; text-align:right ; "><strong> Balance: (<?php echo number_format( $sub_balance ,2,'.',','); ?>)</strong></td>
                <td style="width: 20%; text-align:center;"></td>
            </tr>
            <tr>
                <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
            </tr>
            <?php
                $sub_accrual =0;
                $sub_usage =0;
                $sub_balance =0;  
            ?>
            <tr>
                <td style=" width:100% ; text-align:left ; "></td>
            </tr> <?php
            if($user_id == '') { ?>
                <tr>
                    <td style=" width:100% ; text-align:left ; "><strong><?php echo $row['Fullname']; ?></strong></td>
                </tr> 
                <tr>
                    <td style=" width:100% ; text-align:left ; "></td>
                </tr> <?php
            } else {
                if( $user_id != $row['User Id'] ){
                    ?>
                <tr>
                    <td style=" width:100% ; text-align:left ; "><strong><?php echo $row['Fullname']; ?></strong></td>
                </tr> 
                <tr>
                    <td style=" width:100% ; text-align:left ; "></td>
                </tr> <?php
                }
            }
            ?>
            <tr>
                <td style=" width:100% ; text-align:left ; "></td>
            </tr>
            <tr>
                <td style=" width:100% ; text-align:left ; "><strong><?php echo $row['Form']; ?></strong></td>
            </tr> 
            <tr style="">
                <td style="width: 20%; text-align:center;"></td>
                <td style="width: 15%; text-align:left; background-color:grey;"><strong>Date</strong></td>
                <td style="width: 15%; text-align:center; background-color:grey;"><strong>Accrual</strong></td>
                <td style="width: 15%; text-align:center; background-color:grey;"><strong>Usage</strong></td>
                <td style="width: 15%; text-align:center; background-color:grey;"></td>
                <td style="width: 20%; text-align:center;"></td>
            </tr>
        <?php }
        }?>
        <tr>
            <td style="width: 20%; text-align:center;"></td>
            <td style="width: 15%; text-align:left; "><?php echo date('M d, Y', strtotime($row['Date'])); ?></td>
            <td style="width: 15%; text-align:center; "><?php echo $row['Accrual'] == '0.00' ? '-' : $row['Accrual']; ?></td>
            <td style="width: 15%; text-align:center; "><?php echo $row['Usage'] == '0.00' ? '-' : $row['Usage']; ?></td>
            <td style="width: 15%; text-align:center; "></td>
            <td style="width: 20%; text-align:center;"></td>
        </tr>
        <?php  
        $sub_accrual += $row['Accrual'];
        $sub_usage += $row['Usage'];
        $sub_balance =  $sub_accrual - $sub_usage; 

    	$accrual += $row['Accrual'];
        $usage += $row['Usage'];
        $balance = $accrual - $usage;
        $user_id = $row['User Id'];
        $form_id = $row['Form Id'];
    endforeach; ?>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr>
        <td style="width: 20%; text-align:center;"></td>
        <td style="width: 15%; text-align:left; ">Total: </td>
        <td style="width: 15%; text-align:center; "><?php echo $sub_accrual ?></td>
        <td style="width: 15%; text-align:center; "><?php echo $sub_usage ?></td>
        <td style="width: 15%; text-align:right ; "><strong> Balance: (<?php echo number_format( $sub_balance ,2,'.',','); ?>)</strong></td>
        <td style="width: 20%; text-align:center;"></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:left ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:left ; "></td>
    </tr>
    <br/><br/>
    <tr>
        <td style=" width:100% ; text-align:left ; "><strong>Grand Total</strong></td>
    </tr>
    <tr>
        <td style="width: 20%; text-align:center;"></td>
    	<td style="width: 15%; text-align:left; ">Total: </td>
    	<td style="width: 15%; text-align:center; "><?php echo $accrual ?></td>
    	<td style="width: 15%; text-align:center; "><?php echo $usage ?></td>
    	<td style="width: 15%; text-align:right ; "><strong><?php echo number_format( $balance ,2,'.',','); ?></strong></td>
        <td style="width: 20%; text-align:center;"></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
    </tr>
</table>