<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>

<?php 
	$res = $result->row();
	$hdr = $db->query($query. " AND T0.arrange = 'F' GROUP BY T0.label ORDER BY T0.label ASC ");
	$dept = $db->query($query. " GROUP BY T0.department_name ORDER BY T0.department_name ASC ");
	$trows = $dept->num_rows() * 2;
	$header_result = $hdr->result();
?>
<?php if( $result && $result->num_rows() > 0){?> 

<!-- HEADER ROW's (2) -->
<table>
	<tr><td><?php echo $res->{'Company Name'}; ?></td></tr>
	<tr><td><?php echo $report_name; ?></td></tr>
</table>
<table>
	<li>
		<table>
			<tr>
		        <td rowspan="2">DEPARTMENT</td>
		        <td rowspan="2">PAYROLL</td>
		        <td rowspan="2">REG. SAL.</td>
				<td rowspan="2">OVERTIME</td>
				<td rowspan="2">SALARY ADJUSTMENT</td>
				<td rowspan="2">ABSENCES</td>
				<td rowspan="2">UT/TARDINESS</td>
				<td rowspan="2">SALARIES & WAGES</td>
			    <!-- ENTRY FOR OTHER TRANSACTION DEPEND ON THE PERIODS -->
		    <?php 
		    for ($count=0; $count < $hdr->num_rows()  ; $count++):
		        $tran_lbl = $header_result[$count]->{'Label'}; ?>
		        <td rowspan="2"><?php echo strtoupper($tran_lbl); ?> </td>
		    <?php 
		    endfor;?>
		    	<td rowspan="2">TOTAL</td>
		    </tr>
		</table>
		<table>
            <li>
            	<table>
            		<tr>
            			<td colspan="3">EMPLOYERS CONTRIBUTION</td>
        			</tr>
            		<tr>
		                <td>SSS</td>
		                <td>PAG-IBIG</td>
		                <td>PHILHEALTH</td>
		            </tr>
		        </table>
            </li>
        </table>
	</li><?php
	foreach ($dept->result() as $value) :
		$f_c1 = 0;
		$f_c2 = 0;
		$f_c3 = 0;
		$f_c4 = 0;
		$f_c5 = 0;
		$f_sss = 0;
		$f_hdmf = 0;
		$f_phic = 0;

		$s_c1 = 0;
		$s_c2 = 0;
		$s_c3 = 0;
		$s_c4 = 0;
		$s_c5 = 0;
		$s_sss = 0;
		$s_hdmf = 0;
		$s_phic = 0;

		$salaries = 0;
		$total = 0;
		$f_dtl = $db->query($query. " AND T0.department = ".$value->{'Department'}." AND T0.payroll = '1st Half' AND T0.arrange != 'F' ORDER BY T0.`department_name` ASC, T0.arrange ASC, T0.`payroll` ASC ");
		foreach ($f_dtl->result() as $value) :
			switch ($value->{'Label'}) {
				case 'reg_sal':
					$f_c1 =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
				case 'overtime':
					$f_c2 =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
				case 'salary_adjustment':
					$f_c3 =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
				case 'absences':
					$f_c4 =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
				case 'ut_tardiness':
					$f_c5 =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
				case 'sss':
					$f_sss =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
				case 'pagibig':
					$f_hdmf =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
				case 'philhealth':
					$f_phic =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
			}
		endforeach;
		$s_dtl = $db->query($query. " AND T0.department = ".$value->{'Department'}." AND T0.payroll = '2nd Half' AND T0.arrange != 'F' ORDER BY T0.`department_name` ASC, T0.arrange ASC, T0.`payroll` ASC ");
		foreach ($s_dtl->result() as $value) :
			switch ($value->{'Label'}) {
				case 'reg_sal':
					$s_c1 =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
				case 'overtime':
					$s_c2 =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
				case 'salary_adjustment':
					$s_c3 =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
				case 'absences':
					$s_c4 =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
				case 'ut_tardiness':
					$s_c5 =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
				case 'sss':
					$s_sss =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
				case 'pagibig':
					$s_hdmf =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
				case 'philhealth':
					$s_phic =  $value->{'Amount'} > 0 ? $value->{'Amount'} : 0.00;
					break;
			}
		endforeach;
		$salaries = $f_c1 +	$f_c2 +	$f_c3 +	$f_c4 +	$f_c5 +	$s_c1 +	$s_c2 +	$s_c3 +	$s_c4 +	$s_c5; ?>
	<li>
		<table>
			<td rowspan="2"><?php echo $value->{'Department Name'}; ?></td>
			<td>
			<table>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td>1st Half</td>
					<td><?php echo $f_c1; ?></td>
					<td><?php echo $f_c2; ?></td>
					<td><?php echo $f_c3; ?></td>
					<td><?php echo $f_c4; ?></td>
					<td><?php echo $f_c5; ?></td>
					<td rowspan="2"><?php echo $salaries; ?></td>
				<?php 
			    for ($a=0; $a < $hdr->num_rows()  ; $a++):
			        $tran_lbl = '';
			        $tran_lbl = $header_result[$a]->{'Label'}; 
			    	$f_amt = $db->query($query. " AND T0.department = ".$value->{'Department'}." AND T0.label = '".$tran_lbl."' AND T0.payroll = '1st Half' AND T0.arrange = 'F'")->row();
			    	?>
			        <td><?php echo $f_amt ? $f_amt->{'Amount'} : 0.00; ?> </td>
			    <?php 
			    	$total += $f_amt ? $f_amt->{'Amount'} : 0.00;
			    endfor;
			    // TO COMPUTE TOTAL AMOUNT
			    for ($b=0; $b < $hdr->num_rows()  ; $b++):
			        $tran_lbl = '';
			        $tran_lbl = $header_result[$b]->{'Label'}; 
			    	$s_amt = $db->query($query. " AND T0.department = ".$value->{'Department'}." AND T0.label = '".$tran_lbl."' AND T0.payroll = '2nd Half' AND T0.arrange = 'F'")->row();
			    	$total += $s_amt ? $s_amt->{'Amount'} : 0.00;
			    endfor;?>
			    
			    	<td rowspan="2"><?php echo $total + $salaries; ?></td>
					<td><?php echo $f_sss; ?></td>
					<td><?php echo $f_hdmf; ?></td>
					<td><?php echo $f_phic; ?></td>
				</tr>
				<tr>
					<td>2nd Half</td>
					<td><?php echo $s_c1; ?></td>
					<td><?php echo $s_c2; ?></td>
					<td><?php echo $s_c3; ?></td>
					<td><?php echo $s_c4; ?></td>
					<td><?php echo $s_c5; ?></td>
				<?php 
			    for ($a=0; $a < $hdr->num_rows()  ; $a++):
			        $tran_lbl = '';
			        $tran_lbl = $header_result[$a]->{'Label'}; 
			    	$s_amt = $db->query($query. " AND T0.department = ".$value->{'Department'}." AND T0.label = '".$tran_lbl."' AND T0.payroll = '2nd Half' AND T0.arrange = 'F'")->row();
			    	?>
			        <td><?php echo $s_amt ? $s_amt->{'Amount'} : 0.00; ?> </td>
			    <?php 
			    endfor;?>
			    	<td><?php echo $s_sss; ?></td>
					<td><?php echo $s_hdmf; ?></td>
					<td><?php echo $s_phic; ?></td>
				</tr>
			</table>
			</td>		
		</table>
	</li><?php
	endforeach;
	?>
	<li>
		<table>
			<tr>
				<td>GRAND TOTAL</td>
				<td>&nbsp;</td>
		<?php 
			$sub_ctr   = 0;         
		    $alpha_ctr = 0;
			$letters = array();
		    $letter = 'C';
		    while ($letter !== 'AAA') {
		        $letters[] = $letter++;
		    }
		    for ($i=0; $i < $trows ; $i++) : 
		    	if ($alpha_ctr >= count($letters)) {
		            $alpha_ctr = 0;
		            $sub_ctr++;
		        }
		        if ($sub_ctr > 2) {
		            $char = $letters[$sub_ctr - 1] . $letters[$alpha_ctr];
		        } 
		        else {
		            $char = $letters[$alpha_ctr];
		        }?>
		        
		        <td>=SUM(<?php echo $char;?>5:<?php echo $char;?><?php echo $trows + 4;?>)</td>
		        <?php
		    	
		        $alpha_ctr++; 
		    endfor;
		?>
				
			</tr>
		</table>
	</li>
</table>

	<?php
}?>
<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>