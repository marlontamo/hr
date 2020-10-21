<?php
foreach( $groups as $group ): ?>
	<tr>
		<td><input type="radio" name="group_id" class="toggle" value="<?php echo $group->group_id ?>" /></td>
		<td>
			<a class="text-success"><?php echo  $group->group ?></a><br>
			<span class="small text-muted"><?php echo  $group->group_code ?></span>
		</td>
		<td>
			<div class="btn-group">
				<a class="btn btn-xs text-muted" href="javascript:edit_group(<?php echo  $group->group_id ?>)" ><i class="fa fa-pencil"></i> Edit</a>
				<a class="btn btn-xs text-muted" href="javascript:delete_group(<?php echo  $group->group_id ?>)"><i class="fa fa-trash-o"></i> Delete</a></a>
			</div>
		</td>	
	</tr> <?php
endforeach; ?>