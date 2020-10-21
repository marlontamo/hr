<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, false);
    }
    $res = $result->row();

	$reg_company = get_registered_company();
	if(is_array($reg_company)) {
		$company = $reg_company['registered_company'];
	}else{
		$company = $res->{'Company'};
	}

?>
<table cellspacing="0" cellpadding="1" border="1"> 
    <tr><td>PagIBIG Monthly Remittance</td></tr>
    <tr>
        <td><b>Employer ID</b></td>
        <td><b><?php echo $res->{'Co Hdmf'} ?></b></td>
    </tr>
    <tr>
        <td><b>Employer Name</b></td>
        <td><b><?php echo $company ?></b></td>
    </tr>
    <tr>
        <td><b>Address</b></td>
        <td><b><?php echo $res->{'Co Address'} ?></b></td>
    </tr>
    <tr>
        <td><strong>Pag-IBIG ID/RTN</strong></td> 
        <td>ACCOUNT NO.</td> 
        <td>MEMBERSHIP PROGRAM</td> 
        <td>LAST NAME</td> 
        <td>FIRST NAME</td> 
        <td>NAME EXTENSION</td> 
        <td>MIDDLE NAME</td> 
        <td>PERCOV</td>
        <td>EESHARE</td> 
        <td>ERSHARE</td> 
        <td>REMARKS</td>
    </tr>

    <?php
    $result = $result->result_array();
    foreach( $result as $row ) : 
    ?>
    <tr>
        <td><?php echo $row['Hdmf No']; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php echo $row['Lastname']; ?></td>
        <td><?php echo $row['Firstname']; ?></td>
        <td><?php echo $row['Suffix']; ?></td>
        <td><?php echo $row['Middlename']; ?></td>
        <td><?php echo date("Ym",strtotime($row['Payroll Date'])); ?></td>
        <td><?php echo number_format($row['Hdmf Emp'],2,'.',''); ?></td>
        <td><?php echo number_format($row['Hdmf Com'],2,'.',''); ?></td>
    </tr>
    <?php

    endforeach;
    ?>
</table>
<?php
    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, false);
    }
?>