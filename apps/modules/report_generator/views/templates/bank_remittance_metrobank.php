<?php
    $result = $result->result_array();
	foreach( $result as $row ){
		echo 
			str_pad($row['Cola'], 1," ",STR_PAD_LEFT).
			str_pad($row['Colb'], 3," ",STR_PAD_LEFT).
			str_pad($row['Colc'], 2," ",STR_PAD_LEFT).
			str_pad($row['Cold'], 3," ",STR_PAD_LEFT).
			str_pad($row['Cole'], 3," ",STR_PAD_LEFT).
			str_pad($row['Colf'], 7," ",STR_PAD_LEFT).
			str_pad($row['Colg'],40," ",STR_PAD_RIGHT).
			str_pad($row['Colh'],10," ",STR_PAD_LEFT).
			str_pad(number_format( $row['Coli'] , 2, '',''),15,"0",STR_PAD_LEFT).
			str_pad($row['Colj'], 1," ",STR_PAD_LEFT).
			str_pad($row['Colk'], 5," ",STR_PAD_LEFT).
			str_pad(date("mdY", strtotime($row['Coll'])), 8," ",STR_PAD_LEFT). "\r\n";
	}  
?>