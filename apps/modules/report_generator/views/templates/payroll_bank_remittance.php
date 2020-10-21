<?php
    $result = $result->result_array();

    $bank = $result[0]['Bank Id'];
    
    $schedule = '';
    $bank_posting_date = $result[0]['Posting Date'];
    if (isset($filter)){
    	$bank_posting_date = end($filter);
    	$schedule = prev($filter);
    }

    switch ($bank) {
    	case 1: // security bank
    	case 22:
    		// for the header
		    $total_amount_sec = 0;
		    $ceiling_amount_sec = 0;
		    $bank_acct_total = 0;
			foreach( $result as $row ){
				$ramount = $row['Amount'];
				if ($schedule != '' && $schedule == 1){
		            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 0 )){	
		            	$total_amount_sec += $ramount;
		            	$ceiling_amount_sec = ($ramount > $ceiling_amount_sec) ? $ramount : $ceiling_amount_sec;  
		            	$bank_acct_total += $row['Bank Account']; 
					}
				}
				elseif ($schedule != '' && $schedule == 2){
		            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 1 )){
						$total_amount_sec += $ramount;        	
						$ceiling_amount_sec = ($ramount > $ceiling_amount_sec) ? $ramount : $ceiling_amount_sec;
						$bank_acct_total += $row['Bank Account'];
		            }
		        }		
		    }

    		echo 'PHP01' .
    			 str_pad($result[0]['Account No'],13,"0",STR_PAD_LEFT) .
    			 date('mdy',strtotime($bank_posting_date)) .
    			 '200' .
    			 str_pad(str_replace('.','',$total_amount_sec),13,"0",STR_PAD_LEFT)."\r\n";
    		// for the header

			foreach( $result as $row ){
				$ramount = str_replace('.','',$row['Amount']);
				if ($schedule != '' && $schedule == 1){
		            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 0 )){	
				        $linectr++;
						$amount += $ramount;

						echo 'PHP10' .
							 str_pad(str_replace('-', '', $row['Bank Account']),13,"0",STR_PAD_LEFT) .
							 str_pad(substr(str_pad(str_replace('-', '', $row['Bank Account']),13,"0",STR_PAD_LEFT),0,4),4,"0",STR_PAD_LEFT) .
							 '00700' .
							 str_pad($ramount,13,"0",STR_PAD_LEFT)."\r\n"; 
					}
				}
				elseif ($schedule != '' && $schedule == 2){
		            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 1 )){
				        $linectr++;
						$amount += $ramount;

						echo 'PHP10' .
							 str_pad(str_replace('-', '', $row['Bank Account']),13,"0",STR_PAD_LEFT) .
							 str_pad(substr(str_pad(str_replace('-', '', $row['Bank Account']),13,"0",STR_PAD_LEFT),0,4),4,"0",STR_PAD_LEFT) .
							 '00700' .
							 str_pad($ramount,13,"0",STR_PAD_LEFT)."\r\n";              	
		            }
		        }
		        else{
					echo 'PHP10' .
						 str_pad(str_replace('-', '', $row['Bank Account']),13,"0",STR_PAD_LEFT) .
						 str_pad(substr(str_pad(str_replace('-', '', $row['Bank Account']),13,"0",STR_PAD_LEFT),0,4),4,"0",STR_PAD_LEFT) .
						 '00700' .
						 str_pad($ramount,13,"0",STR_PAD_LEFT)."\r\n";    		        	
		        }		
		    }
    		break;
    	case 3: // BPI
    		// for the header
		    $total_amount_bpi = 0;
		    $ceiling_amount_bpi = 0;
		    $bank_acct_total = 0;
			foreach( $result as $row ){
				$ramount = $row['Amount'];
		        if ($schedule != '' && $schedule == 1){
		            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 0 )){	
		            	$total_amount_bpi += $ramount;
		            	$ceiling_amount_bpi = ($ramount > $ceiling_amount_bpi) ? $ramount : $ceiling_amount_bpi;  
		            	$bank_acct_total += $row['Bank Account']; 
					}
				}
				elseif ($schedule != '' && $schedule == 2){
		            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 1 )){
						$total_amount_bpi += $ramount;        	
						$ceiling_amount_bpi = ($ramount > $ceiling_amount_bpi) ? $ramount : $ceiling_amount_bpi;
						$bank_acct_total += $row['Bank Account'];
		            }
		        }
		        else{
					$total_amount_bpi += $ramount;        	
					$ceiling_amount_bpi = ($ramount > $ceiling_amount_bpi) ? $ramount : $ceiling_amount_bpi;
					$bank_acct_total += $row['Bank Account'];		        	
		        }	
		        $total_amount_bpi = number_format($total_amount_bpi,2,'.','');	
		    }

			$ceiling_amount_bpi = str_replace('.','',$ceiling_amount_bpi);
			$total_amount_bpi = str_replace('.','',$total_amount_bpi);

    	    echo 	'H' .
    	    	 	str_pad($result[0]['Bank Code Numeric'],5,"0",STR_PAD_LEFT) .
    	    		date('mdy',strtotime($bank_posting_date)) .
    	    		str_pad($result[0]['Batch No'],2,"0",STR_PAD_LEFT) .
    	    		'1' .
    	    		str_pad($result[0]['Account No'],10,"0",STR_PAD_LEFT) .
    	    		substr($result[0]['Account No'], 0, -7) .
    	    		str_pad($total_amount_bpi,12,"0",STR_PAD_LEFT) .
    	    		str_pad($total_amount_bpi,12,"0",STR_PAD_LEFT).'1'."\r\n";
    	    // for the header

			$amount = 0;
		    $linectr = 0;
		    $hash_total = 0;

			foreach( $result as $row ){
				$row['Bank Account'] = str_pad($row['Bank Account'],10,"0",STR_PAD_LEFT);
				$ramount = str_replace('.','',$row['Amount']);
				if ($schedule != '' && $schedule == 1){		        	
		            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 0 )){	
				        $linectr++;
						$amount += $row['Amount'];

						$hash = (substr($row['Bank Account'],4,2) * $row['Amount']) + (substr($row['Bank Account'],6,2) * $row['Amount']) + (substr($row['Bank Account'],8,2) * $row['Amount']);
						$hash_total += $hash;

						echo "D" .
							 str_pad($row['Bank Code Numeric'],5,"0",STR_PAD_LEFT) .
							 date('mdy',strtotime($bank_posting_date)) .
							 str_pad($row['Batch No'],2,"0",STR_PAD_LEFT) .
							 '3'.str_pad($row['Bank Account'],10,"0",STR_PAD_LEFT) .
							 str_pad($ramount,12,"0",STR_PAD_LEFT) .
							 str_pad(str_replace('.', '', number_format($hash,2,'.','')),12,"0",STR_PAD_LEFT)."\r\n"; 
					}
				}
				elseif ($schedule != '' && $schedule == 2){
		            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 1 )){
				        $linectr++;
						$amount += $row['Amount'];

						$hash = (substr($row['Bank Account'],4,2) * $row['Amount']) + (substr($row['Bank Account'],6,2) * $row['Amount']) + (substr($row['Bank Account'],8,2) * $row['Amount']);
						$hash_total += $hash;

						echo "D" .
							 str_pad($row['Bank Code Numeric'],5,"0",STR_PAD_LEFT) .
							 date('mdy',strtotime($bank_posting_date)) .
							 str_pad($row['Batch No'],2,"0",STR_PAD_LEFT) .
							 '3'.str_pad($row['Bank Account'],10,"0",STR_PAD_LEFT) .
							 str_pad($ramount,12,"0",STR_PAD_LEFT) .
							 str_pad(str_replace('.', '', number_format($hash,2,'.','')),12,"0",STR_PAD_LEFT)."\r\n";              	
		            }
		        }
		        else{
			        $linectr++;
					$amount += $row['Amount'];

					$hash = (substr($row['Bank Account'],4,2) * $row['Amount']) + (substr($row['Bank Account'],6,2) * $row['Amount']) + (substr($row['Bank Account'],8,2) * $row['Amount']);
					$hash_total += $hash;

					echo "D" .
						 str_pad($row['Bank Code Numeric'],5,"0",STR_PAD_LEFT) .
						 date('mdy',strtotime($bank_posting_date)) .
						 str_pad($row['Batch No'],2,"0",STR_PAD_LEFT) .
						 '3'.str_pad($row['Bank Account'],10,"0",STR_PAD_LEFT) .
						 str_pad($ramount,12,"0",STR_PAD_LEFT) .
						 str_pad(str_replace('.', '', number_format($hash,2,'.','')),12,"0",STR_PAD_LEFT)."\r\n"; 		        	
		        }		
		    }

		    echo "T" .
		    	 str_pad($result[0]['Bank Code Numeric'],5,"0",STR_PAD_LEFT) .
		    	 date('mdy',strtotime($bank_posting_date)) .
		    	 str_pad($result[0]['Batch No'],2,"0",STR_PAD_LEFT) .
		    	 '2' .
		    	 str_pad($result[0]['Account No'],10,"0",STR_PAD_LEFT) .
		    	 str_pad($bank_acct_total,15,"0",STR_PAD_LEFT) .
		    	 str_pad(str_replace('.','',$total_amount_bpi),15,"0",STR_PAD_LEFT) .
		    	 str_pad(str_replace('.', '', number_format($hash_total,2,'.','')),18,"0",STR_PAD_LEFT) . // pending
		    	 str_pad($linectr,5,"0",STR_PAD_LEFT)."\r\n";
    		break;  
    	case 100: // BDO
		    echo "H".
				 str_pad($result[0]['Bank Code Numeric'].trim($result[0]['Batch No']),10,' ',STR_PAD_LEFT) .
				 str_pad($result[0]['Account No'],10) . 
				 str_pad($result[0]['Bank Code Alpha'],10,' ',STR_PAD_LEFT) .
				 date('Ymd', strtotime($bank_posting_date)) . "\r\n";
		    
			$amount = 0;
		    $linectr = 0;
		    
			foreach( $result as $row ){
				if ($schedule != '' && $schedule == 1){	
		            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 0 )){	
				        $linectr++;
						$amount += $row['Amount'];

						echo str_pad($row['Bank Account'],16) .
							 number_format($row['Amount'],2,'.','') . "\r\n";  
					}
				}
				elseif ($schedule != '' && $schedule == 2){
		            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 1 )){
				        $linectr++;
						$amount += $row['Amount'];

						echo str_pad($row['Bank Account'],16) .
							 number_format($row['Amount'],2,'.','') . "\r\n";              	
		            }
		        }
		        else{
					echo str_pad($row['Bank Account'],16) .
						 number_format($row['Amount'],2,'.','') . "\r\n";  		        	
		        }		
		    }

		    echo "T".
				 str_pad($linectr,10,' ',STR_PAD_LEFT).
				 number_format($amount,2,'.','');
    		break;
    	default:
    		// for the header
		    $total_amount_bpi = 0;
		    $ceiling_amount_bpi = 0;
		    $bank_acct_total = 0;
			foreach( $result as $row ){
				$ramount = $row['Amount'];
				if ($schedule != '' && $schedule == 1){
		            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 0 )){	
		            	$total_amount_bpi += $ramount;
		            	$ceiling_amount_bpi = ($ramount > $ceiling_amount_bpi) ? $ramount : $ceiling_amount_bpi;  
		            	$bank_acct_total += $row['Bank Account']; 
					}
				}
				elseif ($schedule != '' && $schedule == 2){
		            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 1 )){
						$total_amount_bpi += $ramount;        	
						$ceiling_amount_bpi = ($ramount > $ceiling_amount_bpi) ? $ramount : $ceiling_amount_bpi;
						$bank_acct_total += $row['Bank Account'];
		            }
		        }
		        else{
					$total_amount_bpi += $ramount;        	
					$ceiling_amount_bpi = ($ramount > $ceiling_amount_bpi) ? $ramount : $ceiling_amount_bpi;
					$bank_acct_total += $row['Bank Account'];		        	
		        }	
		        $total_amount_bpi = number_format($total_amount_bpi,2,'.','');	
		    }

			$ceiling_amount_bpi = str_replace('.','',$ceiling_amount_bpi);
			$total_amount_bpi = str_replace('.','',$total_amount_bpi);

    	    echo 	'H' .
    	    	 	str_pad($result[0]['Bank Code Numeric'],5,"0",STR_PAD_LEFT) .
    	    		date('mdy',strtotime($bank_posting_date)) .
    	    		str_pad($result[0]['Batch No'],2,"0",STR_PAD_LEFT) .
    	    		'1' .
    	    		str_pad($result[0]['Account No'],10,"0",STR_PAD_LEFT) .
    	    		substr($result[0]['Account No'], 0, -7) .
    	    		str_pad($total_amount_bpi,12,"0",STR_PAD_LEFT) .
    	    		str_pad($total_amount_bpi,12,"0",STR_PAD_LEFT).'1'."\r\n";
    	    // for the header

			$amount = 0;
		    $linectr = 0;
		    $hash_total = 0;

			foreach( $result as $row ){
				$row['Bank Account'] = str_pad($row['Bank Account'],10,"0",STR_PAD_LEFT);
				$ramount = str_replace('.','',$row['Amount']);
				if ($schedule != '' && $schedule == 1){		        	
		            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 0 )){	
				        $linectr++;
						$amount += $row['Amount'];

						$hash = (substr($row['Bank Account'],4,2) * $row['Amount']) + (substr($row['Bank Account'],6,2) * $row['Amount']) + (substr($row['Bank Account'],8,2) * $row['Amount']);
						$hash_total += $hash;

						echo "D" .
							 str_pad($row['Bank Code Numeric'],5,"0",STR_PAD_LEFT) .
							 date('mdy',strtotime($bank_posting_date)) .
							 str_pad($row['Batch No'],2,"0",STR_PAD_LEFT) .
							 '3'.str_pad($row['Bank Account'],10,"0",STR_PAD_LEFT) .
							 str_pad($ramount,12,"0",STR_PAD_LEFT) .
							 str_pad(str_replace('.', '', number_format($hash,2,'.','')),12,"0",STR_PAD_LEFT)."\r\n"; 
					}
				}
				elseif ($schedule != '' && $schedule == 2){
		            if ($row['Payout Scheme'] == 1 || ($row['Payout Scheme'] == 0 && $row['Payout Schedule'] == 1 )){
				        $linectr++;
						$amount += $row['Amount'];

						$hash = (substr($row['Bank Account'],4,2) * $row['Amount']) + (substr($row['Bank Account'],6,2) * $row['Amount']) + (substr($row['Bank Account'],8,2) * $row['Amount']);
						$hash_total += $hash;

						echo "D" .
							 str_pad($row['Bank Code Numeric'],5,"0",STR_PAD_LEFT) .
							 date('mdy',strtotime($bank_posting_date)) .
							 str_pad($row['Batch No'],2,"0",STR_PAD_LEFT) .
							 '3'.str_pad($row['Bank Account'],10,"0",STR_PAD_LEFT) .
							 str_pad($ramount,12,"0",STR_PAD_LEFT) .
							 str_pad(str_replace('.', '', number_format($hash,2,'.','')),12,"0",STR_PAD_LEFT)."\r\n";              	
		            }
		        }
		        else{
			        $linectr++;
					$amount += $row['Amount'];

					$hash = (substr($row['Bank Account'],4,2) * $row['Amount']) + (substr($row['Bank Account'],6,2) * $row['Amount']) + (substr($row['Bank Account'],8,2) * $row['Amount']);
					$hash_total += $hash;

					echo "D" .
						 str_pad($row['Bank Code Numeric'],5,"0",STR_PAD_LEFT) .
						 date('mdy',strtotime($bank_posting_date)) .
						 str_pad($row['Batch No'],2,"0",STR_PAD_LEFT) .
						 '3'.str_pad($row['Bank Account'],10,"0",STR_PAD_LEFT) .
						 str_pad($ramount,12,"0",STR_PAD_LEFT) .
						 str_pad(str_replace('.', '', number_format($hash,2,'.','')),12,"0",STR_PAD_LEFT)."\r\n"; 		        	
		        }		
		    }

		    echo "T" .
		    	 str_pad($result[0]['Bank Code Numeric'],5,"0",STR_PAD_LEFT) .
		    	 date('mdy',strtotime($bank_posting_date)) .
		    	 str_pad($result[0]['Batch No'],2,"0",STR_PAD_LEFT) .
		    	 '2' .
		    	 str_pad($result[0]['Account No'],10,"0",STR_PAD_LEFT) .
		    	 str_pad($bank_acct_total,15,"0",STR_PAD_LEFT) .
		    	 str_pad(str_replace('.','',$total_amount_bpi),15,"0",STR_PAD_LEFT) .
		    	 str_pad(str_replace('.', '', number_format($hash_total,2,'.','')),18,"0",STR_PAD_LEFT) . // pending
		    	 str_pad($linectr,5,"0",STR_PAD_LEFT)."\r\n";
    	    break;    		  	
    } 

?>