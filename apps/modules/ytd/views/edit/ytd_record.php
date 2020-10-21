<?php foreach( $ytd_record as $ytd ){ ?>
	<tr>
		<td rowspan="3">
			<?php if( empty($ytd['transaction_class']) ){
					echo $ytd['summary_code'];
				}else{
					echo $ytd['transaction_class'];
				}
			?>
		</td>
		<td rowspan="3"><?php echo $ytd['ytd']; ?>
		</td>
		<td><?php echo $ytd['january']; ?> <br><span class="text-muted small">Jan</span></td>
		<td><?php echo $ytd['april']; ?> <br><span class="text-muted small">Apr</span></td>
		<td><?php echo $ytd['july']; ?> <br><span class="text-muted small">Jul</span></td>
		<td><?php echo $ytd['october']; ?> <br><span class="text-muted small">Oct</span></td>
	</tr>
	<tr>
		<td><?php echo $ytd['february']; ?> <br><span class="text-muted small">Feb</span></td>
		<td><?php echo $ytd['may']; ?> <br><span class="text-muted small">May</span></td>
		<td><?php echo $ytd['august']; ?> <br><span class="text-muted small">Aug</span></td>
		<td><?php echo $ytd['november']; ?> <br><span class="text-muted small">Nov</span></td>
	</tr>
	<tr>
		<td><?php echo $ytd['march']; ?> <br><span class="text-muted small">Mar</span></td>
		<td><?php echo $ytd['june']; ?> <br><span class="text-muted small">Jun</span></td>
		<td><?php echo $ytd['september']; ?> <br><span class="text-muted small">Sept</span></td>
		<td><?php echo $ytd['december']; ?> <br><span class="text-muted small">Dec</span></td>
	</tr>
<?php } ?>