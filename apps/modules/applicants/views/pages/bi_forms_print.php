<?php
    if ($result && $result->num_rows() > 0){
        $ctr = 1;
        foreach ($result->result() as $row) {
            if ($ctr > 1){
?>
                <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'> 
                    <tr>
                        <td style="width:100%;border-bottom: 1px solid #000">&nbsp;</td>
                    </tr> 
                </table>
<?php
            }
?>
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'> 
                <tr>
                    <td style="width:25%">Company</td>
                    <td><?php echo $row->company ?></td>
                </tr> 
                <tr>
                    <td style="width:25%">Department</td>
                    <td><?php echo $row->department ?></td>
                </tr> 
                <tr>
                    <td style="width:25%">Reference Person</td>
                    <td><?php echo $row->reference_person ?></td>
                </tr>                                                 
                <tr>
                    <td style="width:25%">Position</td>
                    <td><?php echo $row->position ?></td>
                </tr> 
                <tr>
                    <td stye="width:25%">Employment Status:</td>
                    <td><?php echo $row->employment_status ?></td>
                </tr>  
                <tr>
                    <td stye="width:25%">Date Hired:</td>
                    <td><?php echo ($row->date_hired != '1970-01-01' ? date('M d Y',strtotime($row->date_hired)) : '') ?></td>
                </tr>              
                <tr>
                    <td stye="width:25%">Date Resigned:</td>
                    <td><?php echo ($row->date_resigned != '1970-01-01' ? date('M d Y',strtotime($row->date_resigned)) : '') ?></td>
                </tr>
                <tr>
                    <td stye="width:25%">Reason for Leaving:</td>
                    <td><?php echo $row->reason_for_leaving ?></td>
                </tr>                                     
            </table>   
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'> 
                <tr>
                    <td style="width:3%">1.</td>
                    <td>Did s/he handle cash or important matter during his/her stay in the company?</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff;'> 
                            <tr>
                                <td style="width:15%;text-align:center;">&nbsp;</td>
                                <td style="width:2%;text-align:center;">&nbsp;</td>
                                <td style="width:41%;text-align:left;"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q1 == 1 ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes</td>
                                <td style="width:41%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q1 == 0 ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No</td>
                            </tr>                                                                                             
                        </table>                      
                    </td>
                </tr>                                                                        
            </table> 
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'> 
                <tr>
                    <td colspan="2">
                        <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff;'> 
                            <tr>
                                <td style="width:10%;text-align:center">&nbsp;</td>
                                <td colspan="3">If yes, was s/he able to handle it</td>
                            </tr>   
                            <tr>
                                <td style="width:10%;text-align:center">&nbsp;</td>
                                <td colspan="3">properly? <u><?php echo $row->q1_ans ?></u></td>
                            </tr>                                                                                           
                        </table>                      
                    </td>
                </tr>                                                                        
            </table>         
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'>  
                <tr>
                    <td style="width:3%">2.</td>
                    <td>Was s/he involved in any disciplinary action?</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff;'> 
                            <tr>
                                <td style="width:16%;text-align:center">&nbsp;</td>
                                <td style="width:10%;text-align:center">&nbsp;</td>
                                <td style="width:37%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q2 == 1 ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes</td>
                                <td style="width:37%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q2 == 0 ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No</td>
                            </tr>                                                                                             
                        </table>                      
                    </td>
                </tr> 
                <tr>
                    <td style="width:3%">3.</td>
                    <td>Did s/he suffer from any illnes?</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff;'> 
                            <tr>
                                <td style="width:16%;text-align:center">&nbsp;</td>
                                <td style="width:10%;text-align:center">&nbsp;</td>
                                <td style="width:37%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q3 == 1 ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes</td>
                                <td style="width:37%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q3 == 0 ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No</td>
                            </tr>                                                                                             
                        </table>                      
                    </td>
                </tr>                                                                       
            </table>         
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'>
                <tr>
                    <td><STRONG>PREVIOUS WORK RELATED INFORMATION</STRONG></td>
                </tr>      
            </table> 
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'> 
                <tr>
                    <td style="width:3%">4.</td>
                    <td>How would you describe his/her attendance record?</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff;'> 
                            <tr>
                                <td style="width:62px;text-align:center">&nbsp;</td>
                                <td colspan="3" style="width:500px;border-bottom: 1px solid #e4e4e4;"><?php echo $row->q4_ans ?></td>
                            </tr>                                                                                           
                        </table>                                         
                    </td>
                </tr>                                                                       
            </table>  
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'> 
                <tr>
                    <td style="width:3%">5.</td>
                    <td>How would you rate his/her sense of integrity, trustwothiness and honestly?</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff;'> 
                            <tr>
                                <td style="width:16%;text-align:center">&nbsp;</td>
                                <td style="width:28%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q5 == 'High' ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;High</td>
                                <td style="width:28%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q5 == 'Average' ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Average</td>
                                <td style="width:28%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q5 == 'Low' ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Low</td>
                            </tr>                                                                                                                                           
                        </table>                                         
                    </td>
                </tr>                                                                       
            </table> 
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'> 
                <tr>
                    <td colspan="2">
                        <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff;'> 
                            <tr>
                                <td style="width:62px;text-align:center">&nbsp;</td>
                                <td colspan="3" style="width:500px;">Why?</td>
                            </tr>
                            <tr>
                                <td style="width:62px;text-align:center">&nbsp;</td>
                                <td colspan="3" style="width:500px;border-bottom: 1px solid #e4e4e4;"><?php echo $row->q5_ans ?></td>
                            </tr>                                                                                                                    
                        </table>                                         
                    </td>
                </tr>                                                                       
            </table>
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'> 
                <tr>
                    <td style="width:3%">6.</td>
                    <td>How would you describe his/her work performance in terms of quality of output & timeliness of result?</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff;'> 
                            <tr>
                                <td style="width:62px;text-align:center">&nbsp;</td>
                                <td colspan="3" style="width:500px;border-bottom: 1px solid #e4e4e4;"><?php echo $row->q6_ans ?></td>
                            </tr>                                                                                           
                        </table>                                         
                    </td>
                </tr>                                                                       
            </table> 
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'>
                <tr>
                    <td><STRONG>ATTITUDE TOWARDS SUBORDINATES</STRONG></td>
                </tr>      
            </table>  
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'> 
                <tr>
                    <td style="width:3%">7.</td>
                    <td>How would you describe his/her relationship with subordinates/co-employees?</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff;'> 
                            <tr>
                                <td style="width:62px;text-align:center">&nbsp;</td>
                                <td colspan="3" style="width:500px;border-bottom: 1px solid #e4e4e4;"><?php echo $row->q7_ans ?></td>
                            </tr>                                                                                           
                        </table>                                         
                    </td>
                </tr>                                                                       
            </table> 
            <br><br><br>         
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'>
                <tr>
                    <td><STRONG>ATTITUDE TOWARDS COMPANY</STRONG></td>
                </tr>      
            </table>
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'> 
                <tr>
                    <td style="width:3%">8.</td>
                    <td>Is your company unionized?</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff;'> 
                            <tr>
                                <td style="width:16%;text-align:center">&nbsp;</td>
                                <td style="width:10%;text-align:center">&nbsp;</td>
                                <td style="width:37%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q8 == 1 ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes</td>
                                <td style="width:37%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q8 == 0 ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No</td>
                            </tr>                                                                                             
                        </table>                      
                    </td>
                </tr>                                                                       
            </table>
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'> 
                <tr>
                    <td style="width:3%">9.</td>
                    <td>What are some his/her significant contributions to your company?</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff;'> 
                            <tr>
                                <td style="width:62px;text-align:center">&nbsp;</td>
                                <td colspan="3" style="width:500px;border-bottom: 1px solid #e4e4e4;"><?php echo $row->q9_ans ?></td>
                            </tr>                                                                                           
                        </table>                                         
                    </td>
                </tr>                                                                       
            </table>
            <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff; margin-bottom: 10px;'> 
                <tr>
                    <td style="width:4%">10.</td>
                    <td>To your knowledge, has this person ever been charged administratively or criminally for any offense?</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff;'> 
                            <tr>
                                <td style="width:16%;text-align:center">&nbsp;</td>
                                <td style="width:10%;text-align:center">&nbsp;</td>
                                <td style="width:37%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q10 == 1 ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes</td>
                                <td style="width:37%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q10 == 0 ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No</td>
                            </tr>                                                                                             
                        </table>                      
                    </td>
                </tr>       
                <tr>
                    <td style="width:4%">11.</td>
                    <td>Wa s/he cleared of accountability after resignation/termination?</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff;'> 
                            <tr>
                                <td style="width:16%;text-align:center">&nbsp;</td>
                                <td style="width:10%;text-align:center">&nbsp;</td>
                                <td style="width:37%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q11 == 1 ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes</td>
                                <td style="width:37%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q11 == 0 ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No</td>
                            </tr>                                                                                             
                        </table>                      
                    </td>
                </tr>  
                <tr>
                    <td style="width:4%">12.</td>
                    <td>Would you recommend him/her for hiring? why?</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table align='center' cellpadding="2px" cellspacing="0" style='width: 95%; height: auto; background: #fff;'> 
                            <tr>
                                <td style="width:16%;text-align:center">&nbsp;</td>
                                <td style="width:10%;text-align:center">&nbsp;</td>
                                <td style="width:37%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q12 == 1 ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes</td>
                                <td style="width:37%;text-align:left"><u>&nbsp;&nbsp;&nbsp;<?php echo ($row->q12 == 0 ? 'x' : '') ?>&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No</td>
                            </tr>                                                                                             
                        </table>                      
                    </td>
                </tr>                                                                                       
            </table> 
<?php
            $ctr++;
        }
    }
?>            