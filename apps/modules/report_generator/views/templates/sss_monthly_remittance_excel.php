<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, false);
    }
    
?>
<table cellspacing="0" cellpadding="1" border="1"> 
    <tr><td>SSS Monthly Remittance</td></tr>
    <tr>
        <td>SURNAME</td> 
        <td>FIRSTNAME</td> 
        <td>MIDDLE INITIAL</td> 
        <td>SSS NUMBER</td> 
        <td>SSS AMT</td> 
        <td>EC AMT</td> 
        <td>DATE HIRED</td> 
        <td>E STATUS</td>
    </tr>

    <?php
    $result = $result->result_array();
    foreach( $result as $row ) : 
    ?>
    <tr>
        <td><?php echo $row['Lastname']; ?></td>
        <td><?php echo $row['Firstname']; ?></td>
        <td><?php echo substr($row['Middlename'] , 0, 1 ); ?></td>
        <td><?php echo $row['Sss No']; ?></td>
        <td><?php echo number_format($row['Sss Emp'] + $row['Sss Com'],2,'.',''); ?></td>
        <td><?php echo number_format($row['Sss Ecc'],2,'.',''); ?></td>
        <td><?php echo date("m/d/Y",strtotime($row['Hired Date'])); ?></td>
        <td><?php echo $row['Govt Status']; ?></td>
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