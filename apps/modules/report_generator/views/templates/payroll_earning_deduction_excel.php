<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>
<?php   
// change $this->db to $db for multidb config  
    $hdr = $db->query($query)->row();

    $header = $query.' GROUP BY transaction_label ORDER BY transaction_label';
    $header_result = $db->query($header)->result();

    $header_row = $db->query($header)->num_rows();

    $tot_emp = $query.' GROUP BY id_number';
 
    $colspan = $header_row+4;      
    
    	if($header_row > 0){
            $gtotal_amount = 0; ?>
                <table>
                    <tr>
                        <td colspan="<?php echo $colspan; ?>" style=" width:100% ; text-align:center ; "><strong><?php echo $hdr->{'Company'}; ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="<?php echo $colspan; ?>" style=" width:100% ; text-align:center ; "><strong><?php echo $report_name; ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="<?php echo $colspan; ?>" style=" width:100% ; text-align:center ; "><strong>PAYROLL PERIOD : <?php echo date("m/d/Y",strtotime($hdr->{'Date From'})).'  - '.date("m/d/Y",strtotime($hdr->{'Date To'})); ?></strong></td>
                    </tr>
                    <tr>
                        <td style=" width:100% ; text-align:left ; "></td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="1" border="1">
                    <tr>
                        <td style="text-align:left; font-size:7;"><strong>EMP. NO.</strong></td>
                        <td colspan="2" style="text-align:left; font-size:7;"><strong>EMPLOYEE NAME</strong></td>
                    <?php 
                    for ($count=0; $count < $header_row  ; $count++):
                        $tran_lbl = $header_result[$count]->{'Transaction Label'}; ?>
                        <td style="text-align:right;vertical-align:top;"><strong><?php echo $tran_lbl; ?></strong></td>
                    <?php 
                    endfor;?>
                        <td style="text-align:right;vertical-align:top; font-size:7;"><strong>TOTAL</strong></td>
                    </tr>
                </table>
                <table>
                <?php
                $query_emp = $query;
                
                $query_dtl_emp = $query_emp." GROUP BY id_number ORDER BY full_name";
                $emp = $db->query($query_dtl_emp);

                $count_emp = 0;
                foreach ($emp->result() as $key => $employee):?>
                    <tr>
                        <td style="text-align:left;"><?php echo $employee->{'Id Number'}; ?></td>
                        <td colspan = "2" style="text-align:left;"><?php echo $employee->{'Full Name'}; ?></td>
                    <?php 
                    $dtl_result = $header_result;
                    $total_amount = 0;
                    for ($ctr2=0; $ctr2 < $header_row  ; $ctr2++) {    
                    	$dtl_value = $query." AND id_number = '".$employee->{'Id Number'}."' AND transaction_label = '".$dtl_result[$ctr2]->{'Transaction Label'}."'";

                        $res_value = $db->query($dtl_value)->row();
                        if($res_value){ ?>
                        	<td style="text-align:right;vertical-align:top;"><?php echo ($res_value->Amount != 0 ? number_format($res_value->Amount,2,'.',',') : '-' ); ?></td>
                        <?php $total_amount += $res_value->Amount;
                        }
                        else { ?>
                        	<td style="text-align:right;vertical-align:top;"> - </td>
                        <?php }
                        
                    } ?>
                        <td style="text-align:right;vertical-align:top;"><?php echo ($total_amount != 0 ? number_format($total_amount,2,'.',',') : '-' ); ?></td>
                    </tr> <?php
                    $count_emp++;
                endforeach;
                $total_sum_value = 0; ?>
                </table>
                    <table>
                        <tr style="border-bottom: double;">
                            <td colspan = "3" >Grand Total</td><?php 
                    $res_total = 0;

                    for ($ctr2=0; $ctr2 < $header_row  ; $ctr2++):    

                        $dtl_total = $query." AND transaction_label = '".$dtl_result[$ctr2]->{'Transaction Label'}."'";
                        $result_total = $db->query($dtl_total)->result();
                        $sum_value = 0;
                        foreach ($result_total as $value) {
                        		$sum_value += $value->Amount;
                        } ?>
                            <td style="text-align:right;vertical-align:top; font-size:7;"><?php echo ($sum_value != 0 ? number_format($sum_value,2,'.',',') : '-' ); ?></td>
                        <?php 
                        $total_sum_value += $sum_value;
                    endfor; ?>
                            <td style="text-align:right;vertical-align:top;font-size:7;"><?php echo ($total_sum_value != 0 ? number_format($total_sum_value,2,'.',',') : '-' ); ?></td>
                        </tr>
                    </table><?php
                
        }
?>
<?php
    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>