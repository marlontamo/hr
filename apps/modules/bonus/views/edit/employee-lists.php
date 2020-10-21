<tr employee_id="<?php echo $employee->employee_id?>">
	<td>
		<input type="checkbox" class="added-employee checkboxes" value="<?php echo $employee->employee_id?>" />
		<input type="hidden" name="payroll_bonus_employee[employee_id][]" value="<?php echo $employee->employee_id?>" />
	</td>
	<td>
		<span class="text-success"><?php echo $employee->full_name?></span>
		<br>
		<a id="date_name" href="#" class="text-muted small"><?php echo $employee->id_number?></a>
	</td> 
	<td>
		<input type="text" class="form-control text-right" name="payroll_bonus_employee[amount][]" placeholder="Enter Amount.." value="<?php echo $employee->amount?>" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false">
	</td>
	<td>
		<div class="btn-group">
			<a class="btn btn-xs text-muted" href="javascript:delete_employee(<?php echo $employee->employee_id?>)"><i class="fa fa-trash-o"></i> Delete</a>
		</div>
	</td>
</tr>