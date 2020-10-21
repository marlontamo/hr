<html><head><meta charset="utf-8"></head>
<body style="background-color:#F9F9F9;">
<div style="font-family: Verdana, Helvetica, Arial, sans-serif; font-size: 13px; font-weight: normal; color: #333;  background-color: #fff;">
	
	<p style="text-align:center"><img src="<?php echo ($logo != '' ? $logo : '') ?>" alt="Please enable images to load system logo" title="Please enable images"></p>
		
	
	<p style="line-height:5px">Certificate of</p>
    <h1 style="line-height:15px">Employment <br /> & Compensation</h1>

    <div class="clearfix"><br/></div>
    <div class="clearfix"><br/></div>

    <p>This is to certify that</p> 

    <h1><?php echo $employee_name ?></h1>

    <p>is employed with <?php echo $company ?> since <?php echo $date_hired ?> and is presently holding regular position as <?php echo $position ?>. <?php echo $firstname ?> is receiving monthly remunerations as follows.</p>

    <table>
    	<tbody>
    		<tr>
    			<td style="width:20%">&nbsp;</td>
    			<td style="text-align:left;width:25%">Basic Salary</td>
    			<td style="text-align:center;width:10%"> : </td>
    			<td style="text-align:right;width:20%">P <?php echo number_format($basic, 2, '.', ',') ?></td>
    			<td style="width:25%">&nbsp;</td>
    		</tr>
    		<tr>
    			<td style="width:20%">&nbsp;</td>
    			<td style="text-align:left;width:25%">Allowances</td>
    			<td style="text-align:center;width:10%"> : </td>
    			<td style="text-align:right;width:20%">P <?php echo number_format($total_alowance, 2, '.', ',') ?></td>
    			<td style="width:25%">&nbsp;</td>
    		</tr>
    		<tr>
    			<td style="width:20%">&nbsp;</td>
    			<td style="text-align:left;width:25%">Gross</td>
    			<td style="text-align:center;width:10%"> : </td>
    			<td style="text-align:right;width:20%">P <?php echo number_format($gross, 2, '.', ',') ?></td>
    			<td style="width:25%">&nbsp;</td>
    		</tr>    		    		
    	</tbody>
    </table>

    <p>This further certifies that is <?php echo $firstname ?> also receiving annual Benefit of:</p>

    <table>
    	<tbody>
    		<tr>
    			<td style="width:20%">&nbsp;</td>
    			<td style="text-align:left;width:25%"><?php echo date('13<\s\u\p\>S\<\/\s\u\p\>') ?> Month Pay</td>
    			<td style="text-align:center;width:10%"> : </td>
    			<td style="text-align:right;width:20%"><?php echo number_format($basic, 2, '.', ',') ?></td>
    			<td style="width:25%">&nbsp;</td>
    		</tr>		    		
    	</tbody>
    </table>

    <p>This certification is being issued this <?php echo $day ?> day of <?php echo $month_year ?> upon the reques of above-mentioned employee as a requirement for <?php echo $his_her ?> <?php echo $purpose ?> only.</p>
	
	<div class="clearfix"><br/></div>
	<div class="clearfix"><br/></div>

	<p style="text-align:right">Certified True and Correct by:</p>
	
	<div class="clearfix"><br/></div>

    <p style="text-align:right"><b>NELSON C. CHAVEZ</b><br/>HRD Manager</p>
	
	<div class="clearfix"><br/></div>

</div>
</body>
</html>
