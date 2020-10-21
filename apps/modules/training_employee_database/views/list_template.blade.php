<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
        </div>
    </td>
   <td>{{ $training_employee_database_employee}}</td>
<td>{{ $training_employee_database_position}}</td>
<td>{{ $training_employee_database_department}}</td>
<td>{{ $training_employee_database_training_balance}}</td>
<td>{{ $training_employee_database_daily_training_cost}}</td>
<td>{{ $training_employee_database_start_date}}</td>
<td>{{ $training_employee_database_end_date}}</td>
    <td>
        <div class="btn-group">
            <!-- <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a> -->
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div> 
    </td>
</tr>