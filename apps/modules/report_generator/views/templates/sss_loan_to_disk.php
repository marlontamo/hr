<?php
    $records = $result->row();
    //$doc_no = str_pad($records->{'Doc No'},6,"0",STR_PAD_LEFT);
    //$doc_date = date('Ymd', strtotime($records->{'Doc Date'}));
    $doc_no = str_pad(date('His'),6,"0",STR_PAD_LEFT);
    $doc_date = '';
    if (isset($filter)){
        $doc_date = date('Ymd', strtotime(end($filter)));
        $doc_year = date('ym', strtotime(end($filter)));
    }       

/*    $reg_company = get_registered_company();
    if(is_array($reg_company)) {
        $company = $reg_company['registered_company'];
    }else{
        $company = $records->{'Company'}; 
    }*/

    $company = $records->{'Company'};

    // Header
    $header = '00'.$records->{'Sss'}.str_pad($company,30," ",STR_PAD_RIGHT).$doc_year.$records->{'Sss Branch Code'}."\r\n";

    echo $header;
    
    $tot_ec = 0;
    $linectr = 0;
    $tot_due = 0;
    // details
	foreach( $result->result() as $key => $row ){
        $linectr++;
        $tot_due += number_format($row->{'Due'}, 2, '.', '');
        
        if ($row->{'Record'} != '' && $row->{'Record'} != NULL){
		  echo $row->{'Record'}.str_repeat(' ', 2)."\r\n";  
        }
    }

    $tot_due = number_format($tot_due, 2, '.', '');

    // Footer
    $footer = "99" . str_pad($linectr,6, "0",STR_PAD_LEFT) . str_pad(str_replace('.','',$tot_due),20,"0",STR_PAD_LEFT) ."\r\n";
    echo $footer;
?>