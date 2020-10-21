<html>
	<body>
		<div>
			<br><br><br>
			<br><br><br>
			<table width="100%" >
				<tr>
					<td font-size="5" style="width: 50%">
						<table >
							<tr>
								<td font-size="5" align="center">
								<?php echo $birData['year'][0]?>
								&nbsp;
								<?php echo $birData['year'][1]?>
								&nbsp;
								<?php echo $birData['year'][2]?>
								&nbsp;
								<?php echo $birData['year'][3]?>
								</td>
							</tr>
						</table>
					</td>
					<td style="width: 50%" align="left" font-size="5">
						<table >
							<tr>
								<td font-size="5" style="width: 50%" align="right">
								<?php echo $birData['month_from'] ?> 
								</td>
								<td font-size="5" style="width: 50%" align="center">
								<?php echo $birData['month_to']  ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding-right:10px" align="left" font-size="5">
						<?php echo $birData['emp_tin']?>
					</td>
				</tr>
				<tr>
					<td style="padding-right:10px" align="left" font-size="5">
						<?php echo $birData['full_name']?>
					</td colspan>
				</tr>
				<tr>
					<td style="padding-right:10px" align="left" font-size="5">
						<?php echo $birData['emp_address']?>
					</td colspan>
					<td style="padding-right:10px" align="left" font-size="5">
						<?php echo $birData['emp_zipcode']?>
					</td colspan>
				</tr>
				<tr>
					<td style="padding-right:10px" align="left" font-size="5">
						<?php echo $birData['emp_address']?>
					</td colspan>
					<td style="padding-right:10px" align="left" font-size="5">
						<?php echo $birData['emp_zipcode']?>
					</td colspan>
				</tr>
				
			</table>
		</div>
	</body>
</html>
