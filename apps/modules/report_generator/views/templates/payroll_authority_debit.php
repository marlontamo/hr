<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>
<table style="font-size: large; font-family: Calibri,Arial,sans-serif;">
    <?php $result = $result->result_array();?>
    <?php 
    $amount = 0;
    foreach( $result as $row ) : 
        $amount += $row['Amount'];
        $bank_name = $row['Bank Name'];
        $bank_address1 = $row['Address1'];
        $bank_address2 = $row['Address2'];
        $company = $row['Company'];
        $payroll_date = $row['Payroll Date'];
        $bank_account_no = $row['Bank Account No'];
        $date_from = date('F d', strtotime($row['Date From']));
        $date_to = date('F d Y', strtotime($row['Date To']));
        $branch_officer = $row['Branch Officer'];
        $branch_position = $row['Branch Position'];
        $signatory_1 = $row['Signatory 1'];
        $signatory_2 = $row['Signatory 2'];
        $account_name = $row['Account Name'];
    endforeach; ?>
    <tr>
        <td style="width:100%; text-align:center;"><h2>AUTHORITY TO DEBIT</h2></td>
    </tr>
        <tr>
        <td style=" width:100% ;"></td>
    </tr>
    
    <tr>
        <td style="width:100%; text-align:right;">Date : <?php echo date('d M Y'); ?></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style="width:100%; text-align:left;" ><strong><?php echo $bank_name; ?></strong></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ;"><?php echo $bank_address1; ?></td>
    </tr>
    <tr>
        <td style=" width:100% ;"><?php echo $bank_address2; ?></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style="width:100%; text-align:left;">ATTENTION: <strong><?php echo $branch_officer; ?></strong></td>
    </tr>
    <tr>
        <td style=" width:100% ;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $branch_position; ?></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td><p style="line-height: 200%; " align="justify">This is to authorized <?php echo $bank_name; ?> to debit  <strong><u><?php echo $account_name; ?></u></strong> CA/SA No. <strong><u><?php echo $bank_account_no; ?></u></strong> for the amount of <strong><u><?php echo strtoupper(convert_number_to_words($amount));?> PESOS ONLY (Php <?php echo number_format($amount,2); ?>)</u></strong> with Payroll File in diskette or USB.</p></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td><p style="line-height: 200%;" align="justify">This authority to debit is issued pursuant to and subject to terms and conditions of the Company's Regular Payroll Agreement with the Bank.</p></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td>Very truly yours,</td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "><?php echo $signatory_1; ?></td>
    </tr>
    <tr>
        <td>Authorized Signatory</td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "><?php echo $signatory_2; ?></td>
    </tr>
    <tr>
        <td>Authorized Signatory</td>
    </tr> 
</table>


<?php
    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>