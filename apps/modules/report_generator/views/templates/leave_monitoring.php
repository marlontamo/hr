<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>

<?php
    //prep data
    $result = $result->result_array();
    $headers = array();
    $template = '';
 //debug($result);
 //   exit();

    //$result_sl = (array_filter($array, function ($var) { return (stripos($var, 'Jan') === false); }));
    //$result_sl = array_filter($result, 'Form Code' => 'SL');

   /* function result_sl($value){
        return ($value == 'SL');
    }

    $filtered_result_sl = array_filter($result, 'result_sl');
    var_dump($filtered_result_sl); */

    $filtered_result_sl = array_filter($result, function ($var) {
    return ($var['Form Code'] == 'SL');});

    $filtered_result_vl = array_filter($result, function ($var) {
    return ($var['Form Code'] == 'VL');});

    $filtered_result_sil = array_filter($result, function ($var) {
    return ($var['Form Code'] == 'SIL');});
    
?>
 <?php
 $earned = 0;
    $balance_sl = 0;
    $balance_vl = 0;
    $balance_sil = 0;
    $user_id_vl = '';
    $user_id_sl = '';
    $user_id_sil = '';
    foreach ($filtered_result_sl as $key => $value) { 
$earned = 0;

     if(empty($user_id_sl)) { ?>
            <table >
                
                <tr>
                    <td colspan="12" width="100%" style="text-align:left;"><?php echo $value['Company']; ?> </td>
                </tr>
                <tr>
                   <td colspan="12" width="100%" style="text-align:left;">Sick Leave </td>
                </tr>
                <tr>
                    <td width:"100%"></td>
                </tr>
                <tr>
                    <td width="100%" style="text-align:left;">Name : </td>
                    <td width="100%" colspan="3" style="text-align:left;"><?php echo $value['Full Name']; ?> </td>
                    <td></td>
                    <td width="100%" style="text-align:left;">Date Hired : <?php echo $value['Effectivity Date']; ?> </td>
                </tr>
                <tr>
                    <td width="100%" style="text-align:left;">Project :</td>
                    <td width="100%" colspan="3" style="text-align:left;"><?php echo $value['Project']; ?> </td>
                </tr>
                              
                <tr>
                    <td width:"100%"></td>
                </tr>
                <tr>
                    <th colspan="2" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Project</th>
                    <th colspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Duration</th>
                    <th colspan="3" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Period Covered</th>
                    <th colspan="3" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Sick Leave</th>
                    <th colspan="2" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Remarks</th>
                </tr>

                <tr>
                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">From</td>
                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">To</td>
                    
                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Earned</td>
                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Used</td>  
                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Balance</td>

                </tr>

                 <tr>
                    <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">As of <?php echo date("F d, Y"); ?></td>
                    <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Effectivity Date']; ?></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['End Date']; ?></td>
                    <td colspan="3" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">
                    <?php //echo $value['Current']

                        $date1 = new DateTime($value['Effectivity Date']);
                        $date2 = new DateTime($value['End Date']);
                        $diff = $date1->diff($date2);
                        $days = ($date2->format('d') + 30 - $date1->format('d')) % 30;
                        $day360 = $diff->y * 360 + $diff->m * 30 + $days;
                        $earned = $day360/30 *(5/12);
                        
                        echo number_format( $earned ,2,'.',',');
                    ?></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo number_format( $earned ,2,'.',',');?></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                </tr>
                </table>
        <?php } else { ?>
                <?php if($user_id_sl != $value['User Id']) { 
                    $balance_sl = 0;?>
                                            
                <table >
                <tr>
                    <td colspan="12" width="100%" style="text-align:left;"><?php echo $value['Company']; ?> </td>
                </tr>
                <tr>
                   <td colspan="12" width="100%" style="text-align:left;">Sick Leave </td>
                </tr>
                <tr>
                    <td width:"100%"></td>
                </tr>
                <tr>
                    <td width="100%" style="text-align:left;">Name : </td>
                    <td width="100%" colspan="3" style="text-align:left;"><?php echo $value['Full Name']; ?> </td>
                    <td></td>
                    <td width="100%" style="text-align:left;">Date Hired : <?php echo $value['Effectivity Date']; ?> </td>
                </tr>
                <tr>
                    <td width="100%" style="text-align:left;">Project :</td>
                    <td width="100%" colspan="3" style="text-align:left;"><?php echo $value['Project']; ?> </td>
                </tr>
                             
                <tr>
                    <td width:"100%"></td>
                </tr>
                <tr>
                    <th colspan="2" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Project</th>
                    <th colspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Duration</th>
                    <th colspan="3" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Period Covered</th>
                    <th colspan="3" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Sick Leave</th>
                    <th colspan="2" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Remarks</th>
                </tr>

                <tr>
                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">From</td>
                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">To</td>
                   
                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Earned</td>
                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Used</td>  
                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Balance</td>
                    

                </tr>

                 <tr>
                    <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">As of <?php echo date("F d, Y"); ?></td>
                    <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Effectivity Date']; ?></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['End Date']; ?></td>
                    <td colspan="3" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">
                    <?php //echo $value['Current']

                        $date1 = new DateTime($value['Effectivity Date']);
                        $date2 = new DateTime($value['End Date']);
                        $diff = $date1->diff($date2);
                        $days = ($date2->format('d') + 30 - $date1->format('d')) % 30;
                        $day360 = $diff->y * 360 + $diff->m * 30 + $days;
                        $earned = $day360/30 *(5/12);
                        
                        echo number_format( $earned ,2,'.',',');
                    ?></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo number_format( $earned ,2,'.',',');?></td>
                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                </tr>
                <?php }?>
        <?php }?>


             <tr>
                <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"></td>
                <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                <td colspan="3" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Date Used']?></td>
                <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Day']?></td>
                <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">
                <?php 
                if($balance_sl == 0){
                    $bal_sl = $earned - $value['Day'];
                }
                else{
                    $bal_sl = $balance_sl - $value['Day'];
                }
                echo number_format( $bal_sl ,2,'.',',');?></td>
                <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Reason']?></td>
            </tr>
            </table>
        <?php
            $user_id_sl = $value['User Id'];
            $balance_sl = $bal_sl;
            $earned = 0;
        } 



        foreach ($filtered_result_vl as $key => $value) { 
$earned = 0;

             if(empty($user_id_vl)) { ?>
                    <table >
                        
                        <tr>
                            <td colspan="12" width="100%" style="text-align:left;"><?php echo $value['Company']; ?> </td>
                        </tr>
                        <tr>
                            <td colspan="12"  width="100%" style="text-align:left;">Vacation Leave </td>
                        </tr>
                        <tr>
                            <td width:"100%"></td>
                        </tr>
                        <tr>
                            <td width="100%" style="text-align:left;">Name : </td>
                            <td width="100%" colspan="3" style="text-align:left;"><?php echo $value['Full Name']; ?> </td>
                            <td></td>
                            <td width="100%" style="text-align:left;">Date Hired : <?php echo $value['Effectivity Date']; ?> </td>
                        </tr>
                        <tr>
                            <td width="100%" style="text-align:left;">Project :</td>
                            <td width="100%" colspan="3" style="text-align:left;"><?php echo $value['Project']; ?> </td>
                        </tr>
                                       
                        <tr>
                            <td width:"100%"></td>
                        </tr>
                        <tr>
                            <th colspan="2" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Project</th>
                            <th colspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Duration</th>
                            <th colspan="3" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Period Covered</th>
                            <th colspan="3" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Sick Leave</th>
                            <th colspan="2" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Remarks</th>
                        </tr>

                        <tr>
                            <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">From</td>
                            <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">To</td>
                            
                            <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Earned</td>
                            <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Used</td>  
                            <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Balance</td>

                        </tr>

                         <tr>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">As of <?php echo date("F d, Y"); ?></td>
                            <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Effectivity Date']; ?></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['End Date']; ?></td>
                            <td colspan="3" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">
                                <?php //echo $value['Current']

                                    $date1 = new DateTime($value['Effectivity Date']);
                                    $date2 = new DateTime($value['End Date']);
                                    $diff = $date1->diff($date2);
                                    $days = ($date2->format('d') + 30 - $date1->format('d')) % 30;
                                    $day360 = $diff->y * 360 + $diff->m * 30 + $days;
                                    $earned = $day360/30 *(5/12);
                                    
                                    echo number_format( $earned ,2,'.',',');
                                ?>
                            </td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo number_format( $earned ,2,'.',',');?></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                        </tr>
                        </table>
                <?php } else { ?>
                        <?php if($user_id_vl != $value['User Id']) { 
                            $balance_vl = 0;?>
                                                    
                        <table >
                        <tr>
                            <td colspan="12" width="100%" style="text-align:left;"><?php echo $value['Company']; ?> </td>
                        </tr>
                        <tr>
                            <td colspan="12"  width="100%" style="text-align:left;">Vacation Leave </td>
                        </tr>
                        <tr>
                            <td width:"100%"></td>
                        </tr>
                        <tr>
                            <td width="100%" style="text-align:left;">Name : </td>
                            <td width="100%" colspan="3" style="text-align:left;"><?php echo $value['Full Name']; ?> </td>
                            <td></td>
                            <td width="100%" style="text-align:left;">Date Hired : <?php echo $value['Effectivity Date']; ?> </td>
                        </tr>
                        <tr>
                            <td width="100%" style="text-align:left;">Project :</td>
                            <td width="100%" colspan="3" style="text-align:left;"><?php echo $value['Project']; ?> </td>
                        </tr>
                                      
                        <tr>
                            <td width:"100%"></td>
                        </tr>
                        <tr>
                            <th colspan="2" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Project</th>
                            <th colspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Duration</th>
                            <th colspan="3" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Period Covered</th>
                            <th colspan="3" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Sick Leave</th>
                            <th colspan="2" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Remarks</th>
                        </tr>

                        <tr>
                            <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">From</td>
                            <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">To</td>
                           
                            <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Earned</td>
                            <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Used</td>  
                            <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Balance</td>
                            

                        </tr>

                         <tr>
                            <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">As of <?php echo date("F d, Y"); ?></td>
                            <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Effectivity Date']; ?></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['End Date']; ?></td>
                            <td colspan="3" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">
                                <?php //echo $value['Current']

                                    $date1 = new DateTime($value['Effectivity Date']);
                                    $date2 = new DateTime($value['End Date']);
                                    $diff = $date1->diff($date2);
                                    $days = ($date2->format('d') + 30 - $date1->format('d')) % 30;
                                    $day360 = $diff->y * 360 + $diff->m * 30 + $days;
                                    $earned = $day360/30 *(5/12);
                                    
                                    echo number_format( $earned ,2,'.',',');
                                ?>
                            </td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo number_format( $earned ,2,'.',',');?></td>
                            <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                        </tr>
                        <?php }?>
                <?php }?>


                     <tr>
                        <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                        <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"></td>
                        <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                        <td colspan="3" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Date Used']?></td>
                        <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                        <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Day']?></td>
                        <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">
                            <?php 
                                if($balance_vl == 0){
                                    $bal_vl = $earned - $value['Day'];
                                }
                                else{
                                    $bal_vl = $balance_vl - $value['Day'];
                                }
                                echo number_format( $bal_vl ,2,'.',',');?>
                        </td>
                        <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Reason']?></td>
                    </tr>
                    </table>
                <?php
                    $user_id_vl = $value['User Id'];
                    $balance_vl = $bal_vl;
                    $earned = 0;
                } 

                foreach ($filtered_result_sil as $key => $value) { 
$earned = 0;

                     if(empty($user_id_sil)) { ?>
                            <table >
                                
                                <tr>
                                    <td colspan="12" width="100%" style="text-align:left;"><?php echo $value['Company']; ?> </td>
                                </tr>
                                <tr>
                                    <td colspan="12" width="100%" style="text-align:left;">Incentive Leave </td>
                                </tr>
                                <tr>
                                    <td width:"100%"></td>
                                </tr>
                                <tr>
                                    <td width="100%" style="text-align:left;">Name : </td>
                                    <td width="100%" colspan="3" style="text-align:left;"><?php echo $value['Full Name']; ?> </td>
                                    <td></td>
                                    <td width="100%" style="text-align:left;">Date Hired : <?php echo $value['Effectivity Date']; ?> </td>
                                </tr>
                                <tr>
                                    <td width="100%" style="text-align:left;">Project :</td>
                                    <td width="100%" colspan="3" style="text-align:left;"><?php echo $value['Project']; ?> </td>
                                </tr>
                                              
                                <tr>
                                    <td width:"100%"></td>
                                </tr>
                                <tr>
                                    <th colspan="2" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Project</th>
                                    <th colspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Duration</th>
                                    <th colspan="3" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Period Covered</th>
                                    <th colspan="3" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Sick Leave</th>
                                    <th colspan="2" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Remarks</th>
                                </tr>

                                <tr>
                                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">From</td>
                                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">To</td>
                                    
                                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Earned</td>
                                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Used</td>  
                                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Balance</td>

                                </tr>

                                 <tr>
                                    <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">As of <?php echo date("F d, Y"); ?></td>
                                    <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Effectivity Date']; ?></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['End Date']; ?></td>
                                    <td colspan="3" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">
                                        <?php //echo $value['Current']

                                            $date1 = new DateTime($value['Effectivity Date']);
                                            $date2 = new DateTime($value['End Date']);
                                            $diff = $date1->diff($date2);
                                            $days = ($date2->format('d') + 30 - $date1->format('d')) % 30;
                                            $day360 = $diff->y * 360 + $diff->m * 30 + $days;
                                            $earned = $day360/30 *(5/12);
                                            
                                            echo number_format( $earned ,2,'.',',');
                                        ?>
                                    </td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo number_format( $earned ,2,'.',',');?></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                </tr>
                                </table>
                        <?php } else { ?>
                                <?php if($user_id_sil != $value['User Id']) { 
                                    $balance_sil = 0;?>
                                                            
                                <table >
                                <tr>
                                    <td colspan="12" width="100%" style="text-align:left;"><?php echo $value['Company']; ?> </td>
                                </tr>
                                <tr>
                                    <td colspan="12" width="100%" style="text-align:left;">Incentive Leave </td>
                                </tr>
                                <tr>
                                    <td width:"100%"></td>
                                </tr>
                                <tr>
                                    <td width="100%" style="text-align:left;">Name : </td>
                                    <td width="100%" colspan="3" style="text-align:left;"><?php echo $value['Full Name']; ?> </td>
                                    <td></td>
                                    <td width="100%" style="text-align:left;">Date Hired : <?php echo $value['Effectivity Date']; ?> </td>
                                </tr>
                                <tr>
                                    <td width="100%" style="text-align:left;">Project :</td>
                                    <td width="100%" colspan="3" style="text-align:left;"><?php echo $value['Project']; ?> </td>
                                </tr>
                                               
                                <tr>
                                    <td width:"100%"></td>
                                </tr>
                                <tr>
                                    <th colspan="2" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Project</th>
                                    <th colspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Duration</th>
                                    <th colspan="3" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Period Covered</th>
                                    <th colspan="3" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Sick Leave</th>
                                    <th colspan="2" rowspan="2" style="font-weight:bold; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Remarks</th>
                                </tr>

                                <tr>
                                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">From</td>
                                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">To</td>
                                   
                                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Earned</td>
                                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Used</td>  
                                    <td style="font-weight:bold; text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">Balance</td>
                                    

                                </tr>

                                 <tr>
                                    <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">As of <?php echo date("F d, Y"); ?></td>
                                    <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Effectivity Date']; ?></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['End Date']; ?></td>
                                    <td colspan="3" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">
                                        <?php //echo $value['Current']

                                            $date1 = new DateTime($value['Effectivity Date']);
                                            $date2 = new DateTime($value['End Date']);
                                            $diff = $date1->diff($date2);
                                            $days = ($date2->format('d') + 30 - $date1->format('d')) % 30;
                                            $day360 = $diff->y * 360 + $diff->m * 30 + $days;
                                            $earned = $day360/30 *(5/12);
                                            
                                            echo number_format( $earned ,2,'.',',');
                                        ?>
                                    </td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo number_format( $earned ,2,'.',',');?></td>
                                    <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                </tr>
                                <?php }?>
                        <?php }?>


                             <tr>
                                <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                <td style="text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;"></td>
                                <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                <td colspan="3" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Date Used']?></td>
                                <td colspan="3" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
                                <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Day']?></td>
                                <td style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">
                                    <?php 
                                        if($balance_sil == 0){
                                            $bal_sil = $earned - $value['Day'];
                                        }
                                        else{
                                            $bal_sil = $balance_sil - $value['Day'];
                                        }
                                        echo number_format( $bal_sil ,2,'.',',');?>
                                </td>
                                <td colspan="2" style="text-align:center;  border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"><?php echo $value['Reason']?></td>
                            </tr>
                            </table>
                        <?php
                            $user_id_sil = $value['User Id'];
                            $balance_sil = $bal_sil;
                            $earned = 0;
                        } ?>
    
<?php
    // exit();
    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>