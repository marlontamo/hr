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
    foreach( $result as $row )
    {
        $rowx = array(
            'docnumber' => $row['Doc Number'],
            'status' => $row['Status'],
            'nature' => $row['Nature'],
            'quantity' => $row['Quantity'],
            'dateneed' => $row['Date Needed'],
            'dateapproved' => $row['Date Approved'],
            'deliverydate' => $row['Delivery Date']
        );

        unset( $row['DocNumber'] );
        unset( $row['Status'] );
        unset( $row['Nature'] );
        unset( $row['Quantity'] );
        unset( $row['Date Needed'] );
        unset( $row['Date Approved'] );
        unset( $row['Delivery Date'] );

        if($r_company == 'all'){
            $company = ucfirst($r_company);
        } else {
		  	$company = "Market Place Christian Church Transport and Multi-Purpose Cooperative";
        }
        
		if($r_branch == 'all') {
            $branch = ucfirst($r_branch);
        } else {
            $branch = $row['Branch'];
        }
		
        if($r_department == 'all') {
            $department = ucfirst($r_department);
        } else {
            $department = $row['Department'];
        }
        

        //$com[$rowx['lastname'].', '.$rowx['firstname'].' - '.$rowx['id_number']][$rowx['lastname']][] = $rowx;        
    }
?>
<table>
    <tr>
        <td width="100%" style="text-align:left; font-size:12; "><strong>Personnel Requisition Summary Report</strong></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left;"><strong>Period : </strong><?php echo $first_period.' - '.$second_period; ?></td>
    </tr>
    <tr>
        <td width="100%"></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td style="font-weight:bold; text-align:center">Doc Number</td>
        <td style="font-weight:bold; text-align:center">Status</td>
        <td style="font-weight:bold; text-align:center">Nature</td>
        <td style="font-weight:bold; text-align:center">Quantity</td>
		<td style="font-weight:bold; text-align:center">Date Needed</td>
		<td style="font-weight:bold; text-align:center">Date Approved</td>
		<td style="font-weight:bold; text-align:center">Delivery Date</td>
    </tr> 
    <?php
            $countdoc=0;
			$totqty=0;
			foreach( $rows as $row ):
			
			?>
                <tr>
                    <td style="text-align:center"><?php echo $row['docnumber']?></td>
                    <td style="text-align:center"><?php echo $row['status']?></td>
                    <td style="text-align:center"><?php echo $row['nature']?></td>
                    <td style="text-align:center"><?php echo $row['quantity']?></td>
					<td style="text-align:center"><?php echo $row['dateneed']?></td>
					<td style="text-align:center"><?php echo $row['dateapproved']?></td>
					<td style="text-align:center"><?php echo $row['deliverydate']?></td>
                </tr> <?php
				$countdoc = $countdoc + 1;
				$totqty = $totqty + $row['quantity'];
            endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td style="text-align:right"><strong>TOTAL</strong></td>
                <td style="text-align:center"><strong><?php echo $totqty; ?></strong></td>
                <td></td>
                <td></td>
                <td style="text-align:center"><strong><?php echo $countdoc; ?></strong></td>
            </tr>  
</table>
<?php
    if (CLIENT_DIR == 'bayleaf'){
        echo '<p>&nbsp;</p><table>
            <tr>
                <td style=" width: 45%; text-align:left  ; font-size: 7; ">Noted By: </td>
                <td style=" width:  5%; text-align:center; font-size: 7; "></td>
                <td style=" width: 45%; text-align:left  ; font-size: 7; ">Verified By:</td>
                <td style=" width:  5%; text-align:center; font-size: 7; "></td>
            </tr>
            <tr><td></td></tr><tr><td></td></tr>
            <tr>
                <td style=" width: 45%; text-align:left; border-top: 1px solid black ; font-size: 7; "></td>
                <td style=" width:  5%; text-align:right; font-size: 7; "></td>
                <td style=" width: 50%; text-align:left; border-top: 1px solid black ; font-size: 7; "></td>
                <td style="text-align:right; font-size: 7; "></td>                                    
            </tr>
        </table>';       
    }

    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>