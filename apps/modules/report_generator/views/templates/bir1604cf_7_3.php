<?php
    $result = $result->result_array();

    $return_period = date('m/d/Y');
    if (isset($filter)){
    	$return_period = date('12/31/').(end($filter));
    }

    if (count($result) > 0){

        $total_gross_compensation = 0;
        $total_pres_nontax_13th_month = 0;
        $total_pres_nontax_de_minimis = 0;
        $total_pres_nontax_sss_etc = 0;
        $total_pres_nontax_salaries = 0;
        $total_total_nontax_com_income = 0;
        $total_pres_taxable_basic_salary = 0;
        $total_pres_taxable_13th_month = 0;
        $total_taxable_salaries = 0;
        $total_total_taxable_comp_income = 0;
        $total_exmpn_amt = 0;
        $total_premium_paid = 0;
        $total_net_table_comp_income = 0;
        $total_tax_due = 0;
        $total_pres_tax_wthld = 0;
        $total_amt_wthld_dec = 0;
        $total_over_wthld = 0;
        $total_actual_amt_wthld = 0;

        $ftype_code_init =     				    $result[0]['Ftype Code'];
        $comp_tin_init =    					$result[0]['Comp Tin'];
        $branch_code_employer_init =    		$result[0]['Branch Code Employer'];

		// for the header
		echo 'H1604CF' . ',' .
		     substr(str_replace('-', '', $result[0]['Comp Tin']),0,9) . ',' .
			 '0000' . ',' .
			 $return_period ."\r\n";
		// for the header
		$ctr = 1;
		foreach( $result as $row ){
			if (strtotime($row['Resigned Date']) < strtotime($return_period)) {
		        $schedule_num = 				$row['Schedule Num'];
		        $ftype_code =     				$row['Ftype Code'];
		        $comp_tin =    					$row['Comp Tin'];
		        $branch_code_employer =    		$row['Branch Code Employer'];
		        //$return_period =    			$row['Return Period'];
		        $seq_num =     					$row['Seq Num'];
		        $emp_tin =     					str_replace('-', '', $row['Emp Tin']);
		        $branch_code_employees =    	$row['Branch Code Employees'];
		        $lastname =    					$row['Lastname'];
		        $firstname =    				$row['Firstname'];
		        $middle_name =    				$row['Middlename'];
		        $employment_from =   			$row['Employment From'];
		        $employment_to =    			$row['Employment To'];
		        $gross_compensation =    		$row['Gross Compensation'];
		        $pres_nontax_13th_month =   	$row['Pres Nontax 13th Month'];
		        $pres_nontax_de_minimis =  	 	$row['Pres Nontax De Minimis'];
		        $pres_nontax_sss_etc =    		$row['Pres Nontax Sss Etc'];
		        $pres_nontax_salaries =    		$row['Pres Nontax Salaries'];
		        $total_nontax_com_income =    	$row['Total Nontax Comp Income'];
		        $pres_taxable_basic_salary =	$row['Pres Taxable Basic Salary'];
		        $pres_taxable_13th_month =    	$row['Pres Taxable 13th Month'];
		        $pres_taxable_salaries =    	$row['Pres Taxable Salaries'];
		        $total_taxable_comp_income =    $row['Total Taxable Comp Income'];
		        $exmpn_code =    				$row['Exmpn Code'];
		        $exmpn_amt =   				 	$row['Exmpn Amt'];
		        $premium_paid =    				$row['Premium Paid'];
		        $net_table_comp_income =    	$row['Net Table Comp Income'];
		        $tax_due =    					$row['Tax Due'];
		        $pres_tax_wthld =    			$row['Pres Tax Wthld'];
		        $amt_wthld_dec =    			$row['Amt Wthld Dec'];
		        $over_wthld =    				$row['Over Wthld'];
		        $actual_amt_wthld =    			$row['Actual Amt Wthld'];
		        $subs_filing =    				$row['Subs Filing'];

		        $total_gross_compensation += $gross_compensation;
		        $total_pres_nontax_13th_month += $pres_nontax_13th_month;
		        $total_pres_nontax_de_minimis += $pres_nontax_de_minimis;
		        $total_pres_nontax_sss_etc += $pres_nontax_sss_etc;
		        $total_pres_nontax_salaries += $pres_nontax_salaries;
		        $total_total_nontax_com_income += $total_nontax_com_income;
		        $total_pres_taxable_basic_salary += $pres_taxable_basic_salary;
		        $total_pres_taxable_13th_month += $pres_taxable_13th_month;
		        $total_taxable_salaries += $pres_taxable_salaries;
		        $total_total_taxable_comp_income += $total_taxable_comp_income;
		        $total_exmpn_amt += $exmpn_amt;
		        $total_premium_paid += $premium_paid;
		        $total_net_table_comp_income += $net_table_comp_income;
		        $total_tax_due += $tax_due;
		        $total_pres_tax_wthld += $pres_tax_wthld;
		        $total_amt_wthld_dec += $amt_wthld_dec;
		        $total_over_wthld += $over_wthld;
		        $total_actual_amt_wthld += $actual_amt_wthld;


				echo $schedule_num . ',' .
					 $ftype_code . ',' .
					 substr(str_replace('-', '', $comp_tin),0,9) . ',' .
					 $branch_code_employer . ',' .
					 $return_period . ',' .
					 str_pad($ctr,6," ",STR_PAD_RIGHT) . ',' .
					 str_pad($emp_tin,9," ",STR_PAD_RIGHT) . ',' .
					 str_pad('0',4,"0",STR_PAD_RIGHT) . ',' .
					 '"'. str_pad($lastname, 30," ",STR_PAD_RIGHT) . '"' . ',' .
					 '"'. str_pad($firstname, 30," ",STR_PAD_RIGHT) . '"' . ',' .
					 '"'. str_pad($middle_name, 30," ",STR_PAD_RIGHT) . '"' . ',' .
					 $gross_compensation . ',' .
					 $pres_nontax_13th_month . ',' .
					 $pres_nontax_de_minimis . ',' .
					 $pres_nontax_sss_etc . ',' .
					 $pres_nontax_salaries . ',' .
					 $total_nontax_com_income . ',' .
					 $pres_taxable_basic_salary . ',' .
					 $pres_taxable_13th_month . ',' .
					 $pres_taxable_salaries . ',' .
					 $total_taxable_comp_income . ',' .
					 $exmpn_code . ',' .
					 $exmpn_amt . ',' .
					 $premium_paid . ',' .
					 $net_table_comp_income . ',' .
					 $tax_due . ',' .
					 $pres_tax_wthld . ',' .
					 $amt_wthld_dec . ',' .
					 $over_wthld . ',' .
					 $actual_amt_wthld . ',' .
					 $subs_filing . "\r\n"; 

				$ctr++;
			}
	    }

		echo 'C7.3,' .
			 $ftype_code_init . ',' .
			 substr(str_replace('-', '', $comp_tin_init),0,9) . ',' .
			 $branch_code_employer_init . ',' .
			 $return_period . ',' .
			 $total_gross_compensation . ',' .
			 $total_pres_nontax_13th_month . ',' .
			 $total_pres_nontax_de_minimis . ',' .
			 $total_pres_nontax_sss_etc . ',' .
			 $total_pres_nontax_salaries . ',' .
			 $total_total_nontax_com_income . ',' .
			 $total_pres_taxable_basic_salary . ',' .
			 $total_pres_taxable_13th_month . ',' .
			 $total_taxable_salaries . ',' .
			 $total_total_taxable_comp_income . ',' .
			 $total_exmpn_amt . ',' .
			 $total_premium_paid . ',' .
			 $total_net_table_comp_income . ',' .
			 $total_tax_due . ',' .
			 $total_pres_tax_wthld . ',' .
			 $total_amt_wthld_dec . ',' .
			 $total_over_wthld . ',' .
			 $total_actual_amt_wthld ."\r\n";     
	}

?>
