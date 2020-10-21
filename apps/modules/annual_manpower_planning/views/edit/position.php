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
				foreach ($plan as $plans)
				{
					// $plan = $plan[0];
					$total_hire += $plans->needed;
				}
			}
		}

		$incumbents = $this->mod->get_incumbents( $post['company_id'], $post['department_id'], $position->position_id );
		if( $incumbents )
			$incumbents = sizeof( $incumbents );
		else
			$incumbents = 0;
	?>
	<td>
		<span class="text-muted small"><?=lang('annual_manpower_planning.incumbent')?>:</span> <span type="button" class="btn green btn-xs margin-bottom-6"> <?php echo $incumbents?></span>
		<br>
		<span class="text-muted small"><?=lang('annual_manpower_planning.to_hire')?>:</span> <span type="button" class="btn default btn-xs margin-bottom-6"><?php echo $total_hire?></span>
		<br>
		<?php if ($this->input->post('view_type') == 'edit') { ?>
			<a href="javascript:edit_to_hire(<?php echo $position->position_id?>)" class="small text-primary"><?=lang('common.edit')?></a>
		<?php } ?>
	</td>
	<?php
		$total = 0;
		for($i=1;$i<=12;$i++)
		{
			$plan = $this->mod->get_position_plans( $post['plan_id'], $position->position_id, $i);
			if($plan){ 
				$needed = 0;
				$budget = 0;
				foreach ($plan as $plans)
				{
					// $plan = $plan[0];
					$total += ($plans->budget*$plans->needed);
					$needed += $plans->needed;
					$budget += ($plans->budget*$plans->needed);
				}?>
				<td class="text-center">
					<?php
						echo $needed;
						if( $budget != 0 ) echo '<p class="small text-muted">P'. number_format($budget, 2, '.', ',') .'</p>';
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