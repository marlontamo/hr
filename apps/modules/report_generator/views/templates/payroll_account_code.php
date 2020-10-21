<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>

<table>
    <tr>
        <td style=" width:100% ; text-align:center ; "><strong>ACCOUNTS</strong></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:left ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:left ; "></td>
    </tr>
    <tr style="">
        <td style="width: 12.5%; text-align:center;"></td>
        <td style="width: 25%; text-align:center; background-color:grey;"><strong>Account Code </strong></td>
        <td style="width: 25%; text-align:center; background-color:grey;"><strong>Account Name</strong></td>
        <td style="width: 25%; text-align:center; background-color:grey;"><strong>Account Type</strong></td>
        <td style="width: 12.5%; text-align:center;"></td>
    </tr>
    <tr>
        <td style=" width:100% ; font-size:2 ; "></td>
    </tr>
    <?php 
    $count = 0;
    $result = $result->result_array();
    foreach ($result as $row): 
        if($count > 67){?>
            <tr>
                <td style=" width:100% ; text-align:left ; "></td>
            </tr>
            <tr>
                <td style=" width:100% ; text-align:left ; "></td>
            </tr>
            <tr style="">
                <td style="width: 12.5%; text-align:center;"></td>
                <td style="width: 25%; text-align:center; background-color:grey;"><strong>Account Code </strong></td>
                <td style="width: 25%; text-align:center; background-color:grey;"><strong>Account Name</strong></td>
                <td style="width: 25%; text-align:center; background-color:grey;"><strong>Account Type</strong></td>
                <td style="width: 12.5%; text-align:center;"></td>
            </tr>
            <tr>
                <td style=" width:100% ; font-size:2 ; "></td>
            </tr><?php
            $count = 0;
        }
    ?>
    <tr>
        <td style="width: 12.5%; text-align:center;"></td>
        <td style="width: 25%; text-align:center; "><?php echo $row['Account Code']; ?></td>
        <td style="width: 25%; text-align:left; "><?php echo $row['Account Name']; ?></td>
        <td style="width: 25%; text-align:center; "><?php echo $row['Account Type']; ?></td>
        <td style="width: 12.5%; text-align:center;"></td>
    </tr>
    <?php     
        $count++;
    endforeach; ?>
</table>