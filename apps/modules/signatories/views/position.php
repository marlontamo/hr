<li class="dd-item" company_id="<?php echo $pos->company_id?>" department_id="<?php echo $pos->department_id?>" position_id="<?php echo $pos->position_id?>">
	<button type="button" data-action="expand-position" style="display: block;">Expand</button>
	<button type="button" data-action="collapse-position" style="display: none;">Collapse</button>
	<div class="dd-handle"><?php echo $pos->position?></div>
	<span class="dd-action pull-right">
		<a class="btn btn-xs text-muted" href="javascript:get_position_signatories(<?php echo $pos->position_id?>, <?php echo $pos->department_id?>, <?php echo $pos->company_id?>)"><i class="fa fa-gears"></i> Set</a>
	</span>
	<ol class="dd-list" position_id="<?php echo $pos->position_id?>"></ol>
</li>