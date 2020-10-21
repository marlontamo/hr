<?php
    $result = $result->result_array();
    echo "H".
		 str_pad($result[0]['Bank Code Numeric'],10,' ',STR_PAD_LEFT) .
		 $result[0]['Batch No'] .
		 str_pad($result[0]['Account No'],10) . 
		 str_pad($result[0]['Branch Code'],10) .
		 date('Ymd', strtotime($result[0]['Posting Date'])) . "\r\n";
    
	$amount = 0;
    $linectr = 0;
    
	foreach( $result as $row ){
        $linectr++;
		$amount += $row['Amount'];

		echo str_pad($row['Bank Account'],16) .
			 number_format($row['Amount'],2,'.','') . "\r\n";  
    }

    echo "T".
		 str_pad($linectr,10,' ',STR_PAD_LEFT).
		 number_format($amount,2,'.','');
?>

<?php
	$reg_company = get_registered_company();
	if(is_array($reg_company)) {
		$company = $reg_company['registered_company'];
	}
	$result = $result->result_array();
	// HEADER
	echo '00'.
		str_pad($company,30," ",STR_PAD_RIGHT).
		$result[0]['Period Month'].
		$result[0]['Year'].
		$result[0]['Co Sss']."\r\n";
	foreach ($result as $row) {
		
		echo '20'.
			$row['Lastname'].
			$row['Firstname'].
			$row['Middleinitial'].
			$row['Sss No'].
			( $cont_1 != '' ? $cont_1 : $c ).
			( $cont_2 != '' ? $cont_2 : $c ).
			( $cont_3 != '' ? $cont_3 : $c ).
			$pc.
			$pc.
			$pc.
			( $ec_1 != '' ? $ec_1 : $pc ).
			( $ec_2 != '' ? $ec_2 : $pc ).
			( $ec_3 != '' ? $ec_3 : $pc ).
			$spaceN."\r\n";
	}
?>