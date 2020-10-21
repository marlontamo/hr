<?php if($type_id == 17) //for Developmental Assignment 
 { ?>
<div class="form-group">
	<label class="col-md-4 text-muted text-right">
		Grade:
	</label>	
	<div class="col-md-7">
		<?php echo $record['partners_movement_action.grade']  ?>
	</div>	
</div>	
<?php } ?>	

<div class="form-group">
	<label class="col-md-4 text-muted text-right">
		Months:
	</label>	
	<div class="col-md-7">
		<?php echo $record['partners_movement_action_extension.no_of_months']  ?>
	</div>	
</div>

<div class="form-group">
	<label class="col-md-4 text-muted text-right">
		End Date:
	</label>
	<div class="col-md-7">
		<?php echo ($record['partners_movement_action_extension.end_date'] && $record['partners_movement_action_extension.end_date'] != '0000-00-00' && $record['partners_movement_action_extension.end_date'] != 'January 01, 1970' && $record['partners_movement_action_extension.end_date'] != 'November 30, -0001' ? $record['partners_movement_action_extension.end_date'] : '') ?>
	</div>	
</div>	