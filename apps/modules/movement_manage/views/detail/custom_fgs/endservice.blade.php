<div class="form-group">
	<label class="col-md-4 text-muted text-right">
		End Date:
	</label>
	<div class="col-md-7">
		<?php echo ($record['partners_movement_action_moving.end_date'] && $record['partners_movement_action_moving.end_date'] != '0000-00-00' && $record['partners_movement_action_moving.end_date'] != 'January 01, 1970' && $record['partners_movement_action_moving.end_date'] != 'November 30, -0001' ? $record['partners_movement_action_moving.end_date'] : '') ?>
	</div>		
</div>			
<div class="form-group">
	<label class="col-md-4 text-muted text-right">
		Blacklisted:
	</label>
	<div class="col-md-7">
		<?php echo ($record['partners_movement_action_moving.blacklisted'] ? 'Yes' : 'No') ?>
	</div>
</div>	
<div class="form-group">
	<label class="col-md-4 text-muted text-right">
		Reason:
	</label>
	<div class="col-md-7">
		<?php echo $record['partners_movement_action_moving.reason'] ?>
	</div>	
</div>		
<div class="form-group">
	<label class="col-md-4 text-muted text-right">
		Further Reason:
	</label>
	<div class="col-md-7">
		<?php echo $record['partners_movement_action_moving.further_reason'] ?>
	</div>	
</div>