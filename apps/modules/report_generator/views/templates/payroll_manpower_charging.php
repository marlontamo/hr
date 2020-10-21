<?php
    //prep data
    $res = $result->row();
    $company = $res->{'Company'};
    //$payroll_rate_type = $res->{'Payroll Rate Type'};
    $payroll_date = $res->{'Payroll Date'};
    $date_from = $res->{'Date From'};
    $date_to = $res->{'Date To'};
    $results = $result->result_array();

    

        if($r_payroll_rate_type == 'all') {
            $payroll_rate_type = ucfirst($r_payroll_rate_type);
        } else {
            $payroll_rate_type = $res->{'Payroll Rate Type'};
        } 

    $query_project_list = 'SELECT project_id, project_code, project FROM ww_users_project WHERE deleted = 0 ORDER BY project_code';

    $project_list = $this->db->query($query_project_list)->result_array();
   // debug();die();
    
?>
<table>
	<tr>
	    <td colspan="22" width="100%" style="text-align:center; font-size:10; "><strong><?php echo strtoupper($company); ?></strong></td>
	</tr>
	<tr>
        <td colspan="22" width="100%" style="font-size:10;">PAYROLL TYPE: <?php echo $payroll_rate_type; ?></td>
    </tr>
    <tr>
	    <td colspan="22" width="100%" style="font-size:10;">PAY DATE: <?php 
        echo date("m/d/Y", strtotime($payroll_date)); 
        ?></td>
	</tr>
    <tr>
        <td colspan="22" width="100%" style="font-size:10;"><?php 
        echo date("F d", strtotime($date_from)).'-'.date("d, Y", strtotime($date_to)); 
        ?></td>
    </tr>
    <tr>
        <td width="100%" style="font-size:10;"></td>
    </tr>

    <tr>

        <td rowspan="2">EMPLOYEE</br> ID.</td>
        <td rowspan="2">EMPLOYEE NAME</td>
        <?php foreach ($project_list as $row) { ?>
           
        <td><?php 

        echo $row['project_code']; ?></td>
        <?php } ?>
        <td rowspan="2">TOTAL</td>
    </tr>
    <tr>

        <?php foreach ($project_list as $row) { ?>
           
        <td><?php 

        echo $row['project']; ?></td>
        <?php } ?>
    </tr>

    <?php 
    $cost_center_lbl = '';
    $count_emp = 0;

    foreach ($results as $dtl_res) {
        if( $cost_center_lbl == '' || $cost_center_lbl != $dtl_res['Cost Center'] ) {
            if($cost_center_lbl == '') { ?>
                <tr>
                <td></td>
                </tr>
                <tr>
                    <td colspan="11" width="100%"><strong><?php echo 'COST CENTER: '.$dtl_res['Project Code']." - ".$dtl_res['Project']; ?></strong></td>
                </tr>
    <?php   }
            else{ ?>
                <tr>
                <td></td>
                </tr>
                 <tr>
                    <td colspan="2" width="50%"  style="text-align:right; background-color: gray;"><strong>EMP Per Cost Center: <?php echo $count_emp; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="11" width="50%"  style="text-align:right; background-color: gray;"><strong><?php echo $label; ?></strong></td>
                </tr>
    <?php   
                $count_emp = 0;
            }
        }
         ?>
    <tr>
        <td><?php echo $dtl_res['Id Number']; ?></td>
        <td><?php echo $dtl_res['Full Name']; ?></td>
        <td><?php echo ($dtl_res['P14007'] == 0) ? '': $dtl_res['P14007']; ?></td>
        <td><?php echo ($dtl_res['P15024'] == 0) ? '': $dtl_res['P15024']; ?></td>
        <td><?php echo ($dtl_res['P16000'] == 0) ? '': $dtl_res['P16000']; ?></td>
        <td><?php echo ($dtl_res['P16003'] == 0) ? '': $dtl_res['P16003']; ?></td>
        <td><?php echo ($dtl_res['P16004'] == 0) ? '': $dtl_res['P16004']; ?></td>
        <td><?php echo ($dtl_res['P16010'] == 0) ? '': $dtl_res['P16010']; ?></td>
        <td><?php echo ($dtl_res['P16014'] == 0) ? '': $dtl_res['P16014']; ?></td>
        <td><?php echo ($dtl_res['P16015'] == 0) ? '': $dtl_res['P16015']; ?></td>
        <td><?php echo ($dtl_res['P16016'] == 0) ? '': $dtl_res['P16016']; ?></td>
        <td><?php 
        $tot_percent =    $dtl_res['P14007']
                        + $dtl_res['P15024']
                        + $dtl_res['P16000']
                        + $dtl_res['P16003']
                        + $dtl_res['P16004']
                        + $dtl_res['P16010']
                        + $dtl_res['P16014']
                        + $dtl_res['P16015']
                        + $dtl_res['P16016'] ;

        echo $tot_percent;

        ?></td> 
        
    </tr>
    <?php 
        $label = 'COST CENTER: '.$dtl_res['Project Code']." - ".$dtl_res['Project'];
        $count_emp++;
    }?>
</table>