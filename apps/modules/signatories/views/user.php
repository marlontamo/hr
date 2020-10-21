<li class="dd-item">
	<div class="dd-handle"><?php echo $user->full_name?></div>
	<span class="dd-action pull-right">
		<a class="btn btn-xs text-muted" href="javascript:get_user_signatories(<?php echo $user->user_id?>, <?php echo $user->position_id?>, <?php echo $user->department_id?>, <?php echo $user->company_id?>)"><i class="fa fa-gears"></i> Set</a>
	</span>
</li>