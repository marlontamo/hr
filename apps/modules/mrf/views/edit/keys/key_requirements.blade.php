<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title">
			{{ $key->length }} {{ $key->key_label }}
		</h3>
	</div>
	<!-- Table -->
	<?php 
	if(property_exists($key, 'key_value'))
		$values = unserialize($key->key_value) 
	?>
	<table class="table">
		<thead>
			<tr>
				<th width="10%">#</th>
				<th width="80%">Details</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			$count = 1;
			while($key->length >= $count){
		?>
			<tr>
				<td>
					{{ $count++ }}
				</td>
				<td>
					<textarea class="form-control" rows="1" name="key[{{ $key->key_id }}][]" {{ $record['disabled'] }}>{{ ( isset($values) ) ? $values[($count-2)] : '' }} </textarea>
				</td>
			</tr>
		<?php 	
			}
		?>
		</tbody>
	</table>
</div>