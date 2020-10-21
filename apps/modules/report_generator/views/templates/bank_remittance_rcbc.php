<?php
    $result = $result->result_array();
	foreach( $result as $row ){
		echo 
			'010012500000000'.
			str_pad($row['Bank Account'],10,"0",STR_PAD_LEFT).
			'80111'.
			str_pad( number_format( $row['Amount'],2,'',''),16,"0",STR_PAD_LEFT).
			str_pad( date('mdy',strtotime($row['Payroll Date']) ), 6,"0",STR_PAD_LEFT).
			'0                         00001'. "\r\n";
	}  
?>