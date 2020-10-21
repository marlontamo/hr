<tr>
    <td><input type="checkbox" class="checkboxes employee-checker" name="add_employee[]" value="<?php echo $employee->user_id?>" /></td>
    <td>
        <span class="text-success"><?php echo $employee->full_name?></span>
        <br>
        <a id="date_name" href="#" class="text-muted small"><?php echo $employee->id_number?></a>
    </td> 
    <td><?php echo $employee->company?></td>
    <td><?php echo $employee->department?></td>
</tr>