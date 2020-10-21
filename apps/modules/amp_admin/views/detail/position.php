<tr class="warning">
	<td colspan="15">
		<b><?php echo $position->position?></b>
	</td>
</tr>
<tr>
	<?php
		$total_hire = 0;
		for($i=1;$i<=12;$i++)
		{
			$plan = $this->mod->get_position_plans( $post['plan_id'], $position->position_id, $i);
			if($plan){ 
				$plan = $plan[0];
				$total_hire += $plan->needed;
			}?> <?php	
		}

		$incumbents = $this->mod->get_incumbents( $post['company_id'], $post['department_id'], $position->position_id );
		if( $incumbents )
			$incumbents = sizeof( $incumbents );
		else
			$incumbents = 0;
	?>
	<td>
		<span class="text-muted small">Incumbent:</span> <span type="button" class="btn green btn-xs margin-bottom-6"> <?php echo $incumbents?></span>
		<br>
		<span class="text-muted small">To Hire:</span> <span type="button" class="btn default btn-xs margin-bottom-6"><?php echo $total_hire?></span>
		<br>
		<a href="javascript:edit_to_hire(<?php echo $position->position_id?>)" class="small text-primary"><?=lang('common.view')?></a>
	</td>
	<?php
		$total = 0;
		for($i=1;$i<=12;$i++)
		{
			$plan = $this->mod->get_position_plans( $post['plan_id'], $position->position_id, $i);
			if($plan){ 
				$plan = $plan[0];?>
				<td class="text-center">
					<?php
						echo $plan->needed;
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
	<td></td>
	<td><?php if( $total != 0 ) echo 'P'.number_format($total, 2, '.', ',');?></td>
</tr>