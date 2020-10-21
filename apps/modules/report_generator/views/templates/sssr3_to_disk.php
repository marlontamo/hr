<?php
	$records = $result->row();
    echo '00'.
		substr(str_pad($records->{'Company'},30," ",STR_PAD_RIGHT),0,30).
		str_pad($records->{'Period Month'},2,"0",STR_PAD_LEFT).
		str_pad($records->{'Year'},4,"0",STR_PAD_LEFT).
		str_replace('-', '', $records->{'Co Sss'})."\r\n";

    $sss_1	= 0.00;
    $sss_2	= 0.00;
    $sss_3	= 0.00;
    $ec_1	= 0.00;
    $ec_2	= 0.00;
    $ec_3	= 0.00;
	
	foreach( $result->result() as $key => $row ){
        $sss_1 += $row->{'Sss 1'};
        $sss_2 += $row->{'Sss 2'};
        $sss_3 += $row->{'Sss 3'};
        $ec_1 += $row->{'Ec 1'};
        $ec_2 += $row->{'Ec 2'};
        $ec_3 += $row->{'Ec 3'};
		echo $row->{'Record'} . "\r\n";  
    }

    echo '99'.
    	str_pad(number_format( $sss_1, 2,'.',''),12," ",STR_PAD_LEFT).
    	str_pad(number_format( $sss_2, 2,'.',''),12," ",STR_PAD_LEFT).
    	str_pad(number_format( $sss_3, 2,'.',''),12," ",STR_PAD_LEFT).
    	str_pad('0.00',10," ",STR_PAD_LEFT).
    	str_pad('0.00',10," ",STR_PAD_LEFT).
    	str_pad('0.00',10," ",STR_PAD_LEFT).
    	str_pad(number_format( $ec_1, 2,'.',''),10," ",STR_PAD_LEFT).
    	str_pad(number_format( $ec_2, 2,'.',''),10," ",STR_PAD_LEFT).
    	str_pad(number_format( $ec_3, 2,'.',''),10," ",STR_PAD_LEFT)."\r\n";
?>
