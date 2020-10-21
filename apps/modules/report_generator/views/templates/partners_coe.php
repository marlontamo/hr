<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>
<table style="font-size: x-large;">
    <tr>
        <td style=" width:100% ;"></td>
    </tr>
    <tr>
        <td style=" width:100% ;"></td>
    </tr>
    <tr>
        <td style=" width:100% ;"></td>
    </tr>
    <tr>
        <td style="width:100%; text-align:left;"><?php echo date('d M Y'); ?></td>
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
        <td style=" width:100% ; text-align:center;"><strong>CERTIFICATE OF EMPLOYMENT</strong></td>
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
        <td style=" width:100% ; text-align:justify ; ">This is to certify that <strong>Ms.</strong> _______________ is an employee of The Bayleaf Intramuros, (a company owned and operated by Lyceum of the Philippines University) as our _________________ since ________________. She is receiving a monthly gross remuneration of __amount in words_____ (Php _________) plus Service Charge.
        </td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; "></td>
    </tr>
    <tr>
        <td style=" width:100% ; text-align:justify ; ">This certification is issued upon the request of Ms. ___________ for ___________.
        </td>
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
        <td style=" width:100% ; ">________________</td>
    </tr>
    <tr>
        <td style="width:100%; text-align:left;">HR Supervisor</td>
    </tr>
</table>


<?php
    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>