<?php
if ($leave_accrual && $leave_accrual->num_rows() > 0){
	foreach ($leave_accrual->result() as $row) {
?>
		<tr class="record">
			<td class="hidden-xs"><?php echo $row->form_code ?></td>
			<td><?php echo $row->accrual ?></td>
			<td><?php echo date('M Y',strtotime($row->date_accrued)) ?></td>
			<td>
				<div class="btn-group">
	                <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="edit_credits(<?php echo $record_id ?>,'<?php echo $row->date_accrued ?>')"><i class="fa fa-pencil"></i> Edit</a>
	                <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_credit(<?php echo $record_id ?>,'<?php echo $row->date_accrued ?>',this)"><i class="fa fa-trash-o"></i> Delete</a>
	            </div>	    				
			</td>
		</tr>				
<?php
	}
}
?>