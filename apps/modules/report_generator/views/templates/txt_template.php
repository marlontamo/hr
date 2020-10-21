<?php
    $records = $result->row();
    //$doc_no = str_pad($records->{'Doc No'},6,"0",STR_PAD_LEFT);
    //$doc_date = date('Ymd', strtotime($records->{'Doc Date'}));
    $doc_no = str_pad(date('His'),6,"0",STR_PAD_LEFT);
    $doc_date = '';
    if (isset($filter)){
        $doc_date = date('Ymd', strtotime(end($filter)));
        $doc_year = date('Ym', strtotime(end($filter)));
    }       

/*    $reg_company = get_registered_company();
    if(is_array($reg_company)) {
        $company = $reg_company['registered_company'];
    }else{
        $company = $records->{'Company'};
    }*/

    $company = $records->{'Company'};
    
    // Header
    switch ($report_code) {
    	case 'SSSTD':
    		 	$header = '00'.str_pad(" ",3)."1".$doc_no.str_pad(" ",9).str_pad($doc_date,8,"0",STR_PAD_LEFT).$doc_year.str_pad($company,40," ",STR_PAD_RIGHT).str_pad(str_replace("-","",$records->{'Co Sss'}),13," ",STR_PAD_RIGHT)."C"."\r\n";
    		break;
    	default:
    		break;
    }
    echo $header;
    
	$tot_contri = 0;
    $tot_ec = 0;
    // details
	foreach( $result->result() as $key => $row ){
        // $linectr++;
        switch ($report_code) {
        case 'SSSTD':
            if ($row->{'Record'} != '' && $row->{'Record'} != NULL){
                $tot_contri += $row->{'Contribution'};
                $tot_ec += $row->{'Ec'};
            }
            break;
        default:
            break;
        }

        if ($row->{'Record'} != '' && $row->{'Record'} != NULL){
		  echo $row->{'Record'} . "\r\n";  
        }
    }

    // Footer
    switch ($report_code) {
    	case 'SSSTD':
    			$tot_contri = str_pad( number_format($tot_contri,2,'.',''),12,"0",STR_PAD_LEFT);
    			$tot_ec = str_pad( number_format($tot_ec,2,'.',''),12,"0",STR_PAD_LEFT);
    			//$tot_medicare = str_pad( "0.00",12," ",STR_PAD_LEFT);
    		 	$footer = str_pad("99", 5, " ") . $tot_contri . $tot_ec . str_pad($doc_no,8,"00",STR_PAD_LEFT) . "\r\n";
    		break;
    	
    	default:
    		break;
    }
    echo $footer;
?>