<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, false);
    }
    
?>
<table cellspacing="0" cellpadding="1" border="1"> 
    <tr>
        <td>PHILHEALT NO</td> 
        <td>LASTNAME</td> 
        <td>FIRST NAME</td> 
        <td>MIDDLE NAME</td> 
        <td>COMPENSATION</td> 
        <td>EE AMT</td> 
        <td>ER AMT</td> 
    </tr>

    <?php
    $result = $result->result_array();
    foreach( $result as $row ) : 
    ?>
    <tr>
        <td><?php echo $row['Phic No']; ?></td>
        <td><?php echo $row['Lastname']; ?></td>
        <td><?php echo $row['Firstname']; ?></td>
        <td><?php echo $row['Middlename']; ?></td>
        <td><?php echo $row['Salary']; ?></td>
        <td><?php echo number_format($row['Phic Emp'],2,'.',''); ?></td>
        <td><?php echo number_format($row['Phic Com'],2,'.',''); ?></td>
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