<li class="dd-item" company_id="<?php echo $dept->company_id ?>" department_id="<?php echo $dept->department_id ?>">
	<button type="button" data-action="expand-department" style="display: block;">Expand</button>
	<button type="button" data-action="collapse-department" style="display: none;">Collapse</button>
	<div class="dd-handle"><?php echo $dept->department?></div>
	<span class="dd-action pull-right">
		<a class="btn btn-xs text-muted" href="javascript:get_department_signatories(<?php echo $dept->department_id?>, <?php echo $dept->company_id?>)"><i class="fa fa-gears"></i> Set</a>
	</span>
	<ol class="dd-list" department_id="<?php echo $dept->department_id?>"></ol>
</li>