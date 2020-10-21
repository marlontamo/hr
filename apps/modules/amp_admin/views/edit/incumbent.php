<tr class="warning">
	<td colspan="14">
		<b><?php echo $incumbent->position?></b>
	</td>
</tr>
<tr>
	<td>
		<?php echo $incumbent->full_name?>
		<br>
		<span class="small text-muted"><?php echo $incumbent->employment_status?></span>
		<br>
		<a href="javascript:edit_incumbent(<?php echo $incumbent->user_id?>, <?php echo $incumbent->position_id?>)" class="small text-primary"><?=lang('common.edit')?></a>
	</td>
	<?php
		$total = 0;
		for($i=1;$i<=12;$i++)
		{
			$plan = $this->mod->get_incumbent_plans( $post['plan_id'], $incumbent->user_id, $i);
			if($plan){ 
				$plan = $plan[0];?>
				<td class="text-center <?php echo $plan->class?>">
					<?php
						echo $plan->action;
						$total += $plan->budget;
						if( $plan->budget != 0 ) echo '<p class="small text-muted">P'. number_format($plan->budget, 2, '.', ',') .'</p>';
					?>
				</td>
			<?
			}
			else{
				echo '<td>&nbsp;</td>';
			}?> <?php	
		}	
	?>
	<td><?php if( $total != 0 ) echo 'P'.number_format($total, 2, '.', ',');?></td>
</tr>