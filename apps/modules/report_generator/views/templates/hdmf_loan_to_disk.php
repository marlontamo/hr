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

    $reg_company = get_registered_company();
    if(is_array($reg_company)) {
        $company = $reg_company['registered_company'];
    }else{
        $company = $records->{'Company'}; 
    }

    // Header
    $header = 'EH'.$records->{'Pagibig Branch Code'}.$doc_year.str_pad(str_replace('-', '', $records->{'Co Hdmf'}),15," ",STR_PAD_RIGHT).'PST'.str_pad($company,103," ",STR_PAD_RIGHT).str_pad($records->{'Co Address'},100," ",STR_PAD_RIGHT).str_pad($records->{'Zipcode'},7," ",STR_PAD_RIGHT).str_pad($records->{'Contact No'},7," ",STR_PAD_RIGHT)."\r\n";

    echo $header;
    
    // details
	foreach( $result->result() as $key => $row ){
        if ($row->{'Record'} != '' && $row->{'Record'} != NULL){
		  echo $row->{'Record'} . "\r\n";  
        }
    }
?>