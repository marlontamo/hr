<?php
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>
<?php
	//prep data
	$result = $result->result_array();
	$headers = array('Id_Number' => 'Id Number','Full_Name' => 'Full Name');
	$headers_checking = array();
	$template = '';
	foreach( $result as $row )
	{
 		foreach( $row as $index => $value )
 		{

 			$a_index = str_replace(' ', '_', $index);
 			if (!in_array($a_index,array('Time_Period_Date_From','Time_Period_Date_To','Payroll_Date','Company_Id'))){
	 			if( floatval($value) != 0 && !isset($headers[$a_index]) )
	 			{
	 				$headers[$a_index] = $index;
	 			}
 			}

 			$headers_checking[$index] = $a_index;
 		}	
	}
?>
<table cellspacing="0" cellpadding="1" border="1">
	<tr>
		<?php
			foreach($headers as $header): ?>
				<td style="font-weight:bold; text-align:center"><?php echo strtoupper($header)?></td> <?php
			endforeach;
		?>
		
	</tr> 
	<?php foreach( $result as $key => $val ): ?>
		<tr>
	<?php 
		$ctr = 1;	
		foreach ($headers as $key1 => $val1) { 
			$style = 'text-align:right';
			if ($ctr < 3){
				$style = 'text-align:left';
			}
	?>
			<td style="<?php echo $style ?>"><?php echo $val[$val1] ?></td>
	<?php 
			$ctr++;
		} 
	?>
		</tr>
	<?php endforeach; ?>
</table>
<?php
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
?>