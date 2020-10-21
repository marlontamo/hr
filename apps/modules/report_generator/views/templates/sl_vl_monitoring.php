<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>
<?php
    //prep data
    $result = $result->result_array();
    $headers = array();
    $template = '';

    $total_used_sl = 0;
    $total_used_vl = 0;
    $last_running_bal_sl = 0;
    $last_running_bal_vl = 0;
    $beginning_bal_sl = 0;
    $beginning_bal_vl = 0;

    foreach( $result as $row )
    {
        $rowx = array(
            'name' => $row['NAME'],
            'id_number' => $row['Id Number'],
            'position' => $row['Position'],
            'date_hired' => $row['Date Hired'],
            'month' => $row['MONTH'],
            'type' => $row['TYPE'],
	        '1' => $row['1'],
	        '2' => $row['2'],
	        '3' => $row['3'],
	        '4' => $row['4'],
	        '5' => $row['5'],
	        '6' => $row['6'],
	        '7' => $row['7'],
	        '8' => $row['8'],
	        '9' => $row['9'],
	        '10' => $row['10'],
	        '11' => $row['11'],
	        '12' => $row['12'],
	        '13' => $row['13'],
	        '14' => $row['14'],
	        '15' => $row['15'],
	        '16' => $row['16'],
	        '17' => $row['17'],
	        '18' => $row['18'],
	        '19' => $row['19'],
	        '20' => $row['20'],
	        '21' => $row['21'],
	        '22' => $row['22'],
	        '23' => $row['23'],
	        '24' => $row['24'],
	        '25' => $row['25'],
	        '26' => $row['26'],
	        '27' => $row['27'],
	        '28' => $row['28'],
	        '29' => $row['29'],
	        '30' => $row['30'],
	        '31' => $row['31'],
            'running_balance' => $row['Running Balance'],
	        'monthly_earning' => $row['Monthly Earning'],
	        'used' => $row['Used'],
	        'total_balance' => $row['Total Balance'],
	        'current' => $row['Current']

        );

        unset( $row['NAME'] );
        unset( $row['Id Number'] );
        unset( $row['Position'] );
        unset( $row['Date Hired'] );
        unset( $row['MONTH'] );

        unset( $row['TYPE']);
        unset( $row['1']);
        unset( $row['2']);
        unset( $row['3']);
        unset( $row['4']);
        unset( $row['5']);
        unset( $row['6']);
        unset( $row['7']);
        unset( $row['8']);
        unset( $row['9']);
        unset( $row['10']);
        unset( $row['11']);
        unset( $row['12']);
        unset( $row['13']);
        unset( $row['14']);
        unset( $row['16']);
        unset( $row['17']);
        unset( $row['18']);
        unset( $row['19']);
        unset( $row['20']);
        unset( $row['21']);
        unset( $row['22']);
        unset( $row['23']);
        unset( $row['24']);
        unset( $row['26']);
        unset( $row['27']);
        unset( $row['28']);
        unset( $row['29']);
        unset( $row['30']);
        unset( $row['31']);
        unset( $row['Running Balance']);
        unset( $row['Monthly Earning']);
        unset( $row['Used']);
        unset( $row['Total Balance']);
        unset( $row['Current']);
        

        if($r_company == 'all'){
            $company = ucfirst($r_company);
        } else {
            $company = $row['Company'];
        }
        
        if($r_project == 'all') {
            $project = ucfirst($r_project);
        } else {
            $project = $row['Project'];
        }

        if($r_department == 'all') {
            $department = ucfirst($r_department);
        } else {
            $department = $row['Department'];
        }

        if($r_payroll_year == 'all') {
            $payroll_year = ucfirst($r_payroll_year);
        } else {
            $payroll_year = $row['Year'];
        }

    $com['<tr><td colspan="23" width="5%" style="text-align:left;">Name: '.$rowx['name'].'</td><td colspan="14" width="5%" style="text-align:left;">Date Hired: '.$rowx['date_hired'].'</td></tr><tr><td colspan="23" width="5%" style="text-align:left;">Position: '.$rowx['position'].'</td><td colspan="10" width="5%" style="text-align:left;">ID Number: '.$rowx['id_number'].' </td><td colspan="4" width="5%" style="text-align:left;">Year: '.$payroll_year.'</td></tr>'][$rowx['name']][] = $rowx;
	}
?>

 
<table  style="page-break-after:always;">
	<tr>
        <td colspan="35" width="100%" style="text-align:center; font-size:10; "><strong>VACATION AND SICK LEAVE RECORD</strong></td>
    </tr>
	<tr>
        <td width="100%" style="text-align:left;">Company : <?php echo $company; ?> </td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left;">Department : <?php echo $department; ?> </td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left;">Project : <?php echo $project; ?> </td>
    </tr>
    
    <tr>
        <td colspan="35" width="100%" style="font-size:10px;"></td>
    </tr>

    <?php
    foreach( $com as $comp => $emp ): ?>
    
    <?php echo $comp; ?>

    <tr>
        <td style="font-weight:bold">DATE</td>
        <td>TYPE</td>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
        <td>8</td>
        <td>9</td>
        <td>10</td>
        <td>11</td>
        <td>12</td>
        <td>13</td>
        <td>14</td>
        <td>15</td>
        <td>16</td>
        <td>17</td>
        <td>18</td>
        <td>19</td>
        <td>20</td>
        <td>21</td>
        <td>22</td>
        <td>23</td>
        <td>24</td>
        <td>25</td>
        <td>26</td>
        <td>27</td>
        <td>28</td>
        <td>29</td>
        <td>30</td>
        <td>31</td>
        <td>Running Balance</td>
        <td>Monthly Earning</td>
        <td>USED VL/SL</td>
        <td>TOTAL BAL.</td>
    </tr>

    <tr></tr>

    <?php foreach( $emp as $idno => $rows ){

    $beginning_bal_sl = 0;
    $beginning_bal_vl = 0;
    	foreach( $rows as $row ){
    		if($row['type'] == 'SL'){
					    	//$total_used_sl += $row['used'];
					    	//$last_running_bal_sl = $row['running_balance'];
					    	$beginning_bal_sl = $row['current'];
					    }
					    else if ($row['type'] == 'VL'){
					    	//$total_used_vl += $row['used'];
					    	//$last_running_bal_vl = $row['running_balance'];
					    	$beginning_bal_vl = $row['current'];
					    }
    	}
    }

            ?>
    <tr>
    	<td>Beginning</td>
        <td>SL</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo number_format( $beginning_bal_sl ,2,'.',','); ?></td>
        <td></td>
        <td></td>
        <td><?php echo number_format( $beginning_bal_sl ,2,'.',','); ?></td>
    </tr>
    <tr>
    	<td>Balance</td>
        <td>VL</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo number_format( $beginning_bal_vl, 2,'.',','); ?></td>
        <td></td>
        <td></td>
        <td><?php echo number_format( $beginning_bal_vl, 2,'.',','); ?></td>
    </tr>

    <tr></tr>
   
        
        <?php
        foreach( $emp as $idno => $rows ):
        	$total_used_sl = 0;
		    $total_used_vl = 0;
		    $last_running_bal_sl = 0;
		    $last_running_bal_vl = 0;
    //$beginning_bal_sl = 0;
    //$beginning_bal_vl = 0;
$row_month = '';
            foreach( $rows as $row ): ?>
        		
            	 <tr>

			        <td ><?php  
                    if ($row_month== '' || $row_month != $row['month']){
                        echo date("F", mktime(0, 0, 0, $row['month'], 10));
                    }
                    else { echo '';} ?></td>
			        <td><?php echo $row['type']; ?></td>
			        <td><?php echo ($row['1'] == 0) ? '' : $row['1']; ?></td>
			        <td><?php echo ($row['2'] == 0) ? '' : $row['2']; ?></td>
			        <td><?php echo ($row['3'] == 0) ? '' : $row['3']; ?></td>
			        <td><?php echo ($row['4'] == 0) ? '' : $row['4']; ?></td>
			        <td><?php echo ($row['5'] == 0) ? '' : $row['5']; ?></td>
			        <td><?php echo ($row['6'] == 0) ? '' : $row['6']; ?></td>
			        <td><?php echo ($row['7'] == 0) ? '' : $row['7']; ?></td>
			        <td><?php echo ($row['8'] == 0) ? '' : $row['8']; ?></td>
			        <td><?php echo ($row['9'] == 0) ? '' : $row['9']; ?></td>
			        <td><?php echo ($row['10'] == 0) ? '' : $row['10']; ?></td>
			        <td><?php echo ($row['11'] == 0) ? '' : $row['11']; ?></td>
			        <td><?php echo ($row['12'] == 0) ? '' : $row['12']; ?></td>
			        <td><?php echo ($row['13'] == 0) ? '' : $row['13']; ?></td>
			        <td><?php echo ($row['14'] == 0) ? '' : $row['14']; ?></td>
			        <td><?php echo ($row['15'] == 0) ? '' : $row['15']; ?></td>
			        <td><?php echo ($row['16'] == 0) ? '' : $row['16']; ?></td>
			        <td><?php echo ($row['17'] == 0) ? '' : $row['17']; ?></td>
			        <td><?php echo ($row['18'] == 0) ? '' : $row['18']; ?></td>
			        <td><?php echo ($row['19'] == 0) ? '' : $row['19']; ?></td>
			        <td><?php echo ($row['20'] == 0) ? '' : $row['20']; ?></td>
			        <td><?php echo ($row['21'] == 0) ? '' : $row['21']; ?></td>
			        <td><?php echo ($row['22'] == 0) ? '' : $row['22']; ?></td>
			        <td><?php echo ($row['23'] == 0) ? '' : $row['23']; ?></td>
			        <td><?php echo ($row['24'] == 0) ? '' : $row['24']; ?></td>
			        <td><?php echo ($row['25'] == 0) ? '' : $row['25']; ?></td>
			        <td><?php echo ($row['26'] == 0) ? '' : $row['26']; ?></td>
			        <td><?php echo ($row['27'] == 0) ? '' : $row['27']; ?></td>
			        <td><?php echo ($row['28'] == 0) ? '' : $row['28']; ?></td>
			        <td><?php echo ($row['29'] == 0) ? '' : $row['29']; ?></td>
			        <td><?php echo ($row['30'] == 0) ? '' : $row['30']; ?></td>
			        <td><?php echo ($row['31'] == 0) ? '' : $row['31']; ?></td>
			        <td><?php echo $row['running_balance']; ?></td>
			        <td><?php echo $row['monthly_earning']; ?></td>
			        <td><?php echo number_format($row['used'],2,'.',','); ?></td>
			        <td><?php echo $row['total_balance']; ?></td>

			        <?php 
			        	if($row['type'] == 'SL'){
					    	$total_used_sl += $row['used'];
					    	$last_running_bal_sl = $row['running_balance'];
					    	//$beginning_bal_sl = $row['current'];
					    }
					    else if ($row['type'] == 'VL'){
					    	$total_used_vl += $row['used'];
					    	$last_running_bal_vl = $row['running_balance'];
					    	//$beginning_bal_vl = $row['current'];
					    }
                        $row_month = $row['month'];
			        ?>
			    </tr>
			 <?php
            endforeach; ?>
            	<tr></tr>

    <tr>
    	<td>Total Used</td>
        <td>SL</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo number_format( $total_used_sl ,2,'.',','); ?></td>
        <td></td>
    </tr>
    <tr>
    	<td></td>
        <td>VL</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo number_format( $total_used_vl ,2,'.',','); ?></td>
        <td></td>
    </tr>

    <tr></tr>
    <tr>
    	<td>Conversion</td>
        <td>SL</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo number_format( $last_running_bal_sl, 2,'.',','); ?></td>
        <td></td>
        <td><?php echo number_format( abs($total_used_sl - 15), 2,'.',','); ?></td>
        <td><?php echo number_format( abs($last_running_bal_sl - 15), 2,'.',','); ?><</td>
    </tr>
    <tr>
    	<td></td>
        <td>VL</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo number_format( $last_running_bal_vl, 2,'.',','); ?></td>
        <td></td>
        <td><?php echo number_format( abs($total_used_vl - 15), 2,'.',','); ?></td>
        <td><?php echo number_format( abs($last_running_bal_vl - 15), 2,'.',','); ?></td>
    </tr>
            <?php
        endforeach;
    ?>
</table>
<?php endforeach;?>


<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>