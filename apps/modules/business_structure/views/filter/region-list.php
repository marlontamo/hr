<?php
foreach( $regions as $region ): ?>
	<tr>
		<td><input type="radio" name="region_id" class="toggle" value="<?php echo $region->region_id ?>" /></td>
		<td>
			<a class="text-success"><?php echo  $region->region ?></a><br>
			<span class="small text-muted"><?php echo  $region->region_code ?></span>
		</td>
		<td>
			<div class="btn-group">
				<a class="btn btn-xs text-muted" href="javascript:edit_region(<?php echo  $region->region_id ?>)" ><i class="fa fa-pencil"></i> Edit</a>
				<a class="btn btn-xs text-muted" href="javascript:delete_region(<?php echo  $region->region_id ?>)"><i class="fa fa-trash-o"></i> Delete</a></a>
			</div>
		</td>	
	</tr> <?php
endforeach; ?>