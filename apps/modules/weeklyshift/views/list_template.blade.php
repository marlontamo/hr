<tr class="record">
	<td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
        </div>
    </td>
	<td>
		<a id="time_shift_shift" href="<?php echo $edit_url; ?>" class="text-success">{{ $time_shift_weekly_calendar; }}</a>

	</td>
	<td class="hidden-xs small">{{ $time_shift_weekly_workingdays; }}</td>
	<td class="hidden-xs small">{{ $time_shift_weekly_restdays; }}</td>
	<td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>