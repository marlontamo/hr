<?php   
// change $this->db to $db for multidb config  
    $em_info_array = array();
    $em_info_gtotal_array = array();
    foreach ($result->result() as $row) {
        if (!isset($em_info_gtotal_array[$row->{'Transaction Label'}]))
            $em_info_gtotal_array[$row->{'Transaction Label'}] = 0;

        $em_info_array[$row->{'Id Number'}][$row->{'Transaction Label'}] = $row->{'Amount'};
        $em_info_gtotal_array[$row->{'Transaction Label'}] += $row->{'Amount'};
    }

    $hdr = $db->query($query)->row();

    $header = $query.' GROUP BY transaction_label ORDER BY transaction_label';
    $header_result = $db->query($header)->result();

    $header_row_count = $db->query($header)->num_rows();

    $tot_emp = $query.' GROUP BY id_number';
    $total_no_employees = $db->query($tot_emp)->num_rows();

    $branch = '';
    if (isset($filter)){
        $new_arr = array();
        foreach ($filter as $key => $value) {
            $new_arr[] = $value;
        }
        $branch_id = $new_arr[2];
        $branch_result = $this->db->get_where('users_branch',array('branch_id' => $branch_id));
        if ($branch_result && $branch_result->num_rows() > 0){
            $row_branch = $branch_result->row();
            $branch = $row_branch->branch;
        }
    }   

	if( $header_row_count > 9 ){
	    $allowed_count_per_page = 22;
	}
	else{
		$allowed_count_per_page = 37;
	}
    $page_with = $total_no_employees/$allowed_count_per_page;
    $page_floor = floor($page_with);

    $number_of_page = $page_floor;
    if($page_with > $page_floor)
    {
        $number_of_page = $page_floor + 1;
    }        
    if($total_no_employees != 0)
    {	
    	if($header_row_count > 0){
            $gtotal_amount = 0;
            for($i=1;$i<=$number_of_page; $i++):

                if ( $i == 1 ){?>
                    <div>&nbsp;</div>
                    <?php
                } else {?>
                    <div style="page-break-before: always;">&nbsp;</div>
                    <?php
                }
                ?>

                <table>
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong><?php echo $hdr->{'Company'}; ?></strong></td>
                    </tr>
                    <?php
                        if ($branch != ''){
                    ?>
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong>Branch : <?php echo $branch; ?></strong></td>
                    </tr>    
                    <?php
                        }
                    ?>                       
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong><?php echo $report_name; ?></strong></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong>ATTENDANCE PERIOD : <?php echo date("m/d/Y",strtotime($hdr->{'Date From'})).'  - '.date("m/d/Y",strtotime($hdr->{'Date To'})); ?></strong></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:center ; "><strong>PAYROLL PERIOD : <?php echo date("m/d/Y",strtotime("+1month",strtotime($hdr->{'Date From'}))).'  - '.date("m/d/Y",strtotime("+1month",strtotime($hdr->{'Date To'}))); ?></strong></td>
                    </tr>                    
                    <tr>
                        <td style=" width:100% ; text-align:left ; "></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="text-align:left; font-size:7;"><strong>EMP. NO.</strong></td>
                        <td colspan="2" style="text-align:left; font-size:7;"><strong>EMPLOYEE NAME</strong></td>
                    <?php 
                    for ($count=0; $count < $header_row_count  ; $count++):
                        $tran_lbl = $header_result[$count]->{'Transaction Label'}; ?>
                        <td style="text-align:right;vertical-align:top;"><strong><?php echo $tran_lbl; ?></strong></td>
                    <?php 
                    endfor;?>
                        <td style="text-align:right;vertical-align:top; font-size:7;"><strong>TOTAL</strong></td>
                    </tr> 
                    <tr>
                        <td style=" width:100%; border-top:1px solid black; font-size:3;">&nbsp;</td>
                    </tr>
                </table>
                <table>
                <?php
                $query_emp = $query;
                $limit = ($i - 1) * $allowed_count_per_page;

                $query_dtl_emp = $query_emp." GROUP BY id_number ORDER BY full_name LIMIT {$limit},{$allowed_count_per_page}";
                $emp = $db->query($query_dtl_emp);

                $count_emp = 0;
                foreach ($emp->result() as $key => $employee):?>
                    <tr>
                        <td style="text-align:left;"><?php echo $employee->{'Id Number'}; ?></td>
                        <td colspan = "2" style="text-align:left;"><?php echo $employee->{'Full Name'}; ?></td>
                    <?php 

                    $total_amount = 0;
                    foreach ($header_result as $header_row) {
                        if (array_key_exists($header_row->{'Transaction Label'}, $em_info_array[$employee->{'Id Number'}])) { 
                            $total_amount += $em_info_array[$employee->{'Id Number'}][$header_row->{'Transaction Label'}];
                    ?>
                            <td style="text-align:right;vertical-align:top;"><?php echo ($em_info_array[$employee->{'Id Number'}][$header_row->{'Transaction Label'}] != 0 ? number_format($em_info_array[$employee->{'Id Number'}][$header_row->{'Transaction Label'}],2,'.',',') : '-' ); ?></td>
                    <?php
                        }
                        else {
                    ?>
                            <td style="text-align:center;vertical-align:top;"> - </td>
                    <?php
                        }
                    }                    
                    ?>
                        <td style="text-align:right;vertical-align:top;"><?php echo ($total_amount != 0 ? number_format($total_amount,2,'.',',') : '-' ); ?></td>
                    </tr> <?php
                    $count_emp++;
                endforeach;
                $total_sum_value = 0; ?>
                </table><?php
                if($i == $number_of_page) { ?>
                    <table>
                        <tr><td style=" width:100%; border-top:1px solid black; font-size:3;">&nbsp;</td></tr>
                    </table><table>
                        <tr>
                            <td colspan = "3" >Grand Total</td><?php 
                            
                            $res_total = 0;
                            foreach ($header_result as $header_row) {
                                $total_sum_value += $em_info_gtotal_array[$header_row->{'Transaction Label'}];
                                if (array_key_exists($header_row->{'Transaction Label'}, $em_info_gtotal_array)) {
                            ?>
                                    <td style="text-align:right;vertical-align:top; font-size:7;"><?php echo ($em_info_gtotal_array[$header_row->{'Transaction Label'}] != 0 ? number_format($em_info_gtotal_array[$header_row->{'Transaction Label'}],2,'.',',') : '-' ); ?></td>
                            <?php
                                }
                                else {
                            ?>
                                    <td style="text-align:center;vertical-align:top; font-size:7;"> - </td>
                            <?php
                                }
                            }
                            ?>
                            <td style="text-align:right;vertical-align:top;font-size:7;"><?php echo ($total_sum_value != 0 ? number_format($total_sum_value,2,'.',',') : '-' ); ?></td>
                        </tr>
                        <tr>
                        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
                        </tr>
                        <tr>
                        <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
                        </tr>
                    </table><?php
                }
            endfor;
        }
    }
?>
