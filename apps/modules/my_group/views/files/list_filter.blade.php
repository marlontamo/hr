<style>
	.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
</style>

<?php
	$groups = $mod->get_groups( $user['user_id'] );
	if( $groups )
	{ ?>
		<div class="portlet">
			<div style="margin-bottom:3px;" class="portlet-title">
				<div class="caption">Groups</div>
			</div>
			<div class="portlet-body">
				<span class="small text-muted">Joined Groups</span>
				<div class="margin-top-10"> <?php
					foreach( $groups as $group )
					{
						if( isset( $current_group ) && $current_group->group_id == $group->group_id )
							$class= "label-success";
						else
							$class= "label-default";
						echo '<a class="event-block label '.$class.'" href="'.$mod->url.'/discussion/'.$group->group_id.'">'.$group->group_name.'</a> ';
					} ?>
				</div>
			</div>
		</div><?php
	}
?>

<?php
	$groups = $mod->get_avail_groups( $user['user_id'] );
	if( $groups )
	{ ?>
		<div class="portlet">
			<div style="margin-bottom:3px;" class="portlet-title">
				<div class="caption">Suggested Groups</div>
			</div>
			<div class="portlet-body">
				<span class="small text-muted">Favorites</span>
				<div class="margin-top-10"> <?php
					shuffle($groups);
					$ctr = 5;
					foreach( $groups as $group )
					{
						if( isset( $current_group ) && $current_group->group_id == $group->group_id )
							$class= "label-success";
						else
							$class= "label-default";
						echo '<a class="event-block label '.$class.'" href="'.$mod->url.'/discussion/'.$group->group_id.'">'.$group->group_name.'</a> ';

						$ctr--;
						if( !$ctr )
							break;
					} ?>
				</div>
			</div>
		</div><?php
	}
?>