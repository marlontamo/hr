<?php 
foreach($movement_details as $index => $movement_detail){
	?>
	<tr class="record">
		<td>
			<a id="type" href="#" class="text-success">
				<?php echo $movement_detail['type']; ?>	
			</a>
			<br />
			<span id="date_set" class="small">
				<?php echo $movement_detail['display_name']; ?>	
			</span>
		</td>
		<td class="hidden-xs">
			<?php echo ($movement_detail['effectivity_date'] && $movement_detail['effectivity_date']!= '0000-00-00' ? date('F d, Y', strtotime($movement_detail['effectivity_date'])) : ''); ?>		
		</td>
		<td class="hidden-xs">
			<?php echo $movement_detail['action_remarks']; ?>	
		</td>		
		<td>
			<div class="btn-group">
				<input type="hidden" id="action_id" name="action_id" value="<?=$movement_detail['action_id']?>" />
				<a  href="javascript:edit_movement_details(<?=$movement_detail['type_id']?>, <?=$movement_detail['action_id']?>);" class="btn btn-xs text-muted"  ><i class="fa fa-pencil"></i> Edit</a>
			</div>
			<div class="btn-group">
				<a href="javascript:delete_movement_type(<?=$movement_detail['action_id']?>)" class="btn btn-xs text-muted"><i class="fa fa-trash-o"></i> Delete</a>
			</div>
		</td>
	</tr>
<?php } ?>