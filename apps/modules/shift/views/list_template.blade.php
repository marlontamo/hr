<tr class="record">
	<td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
        </div>
    </td>
	<td>
		<a id="time_shift_shift" href="<?php echo $edit_url; ?>" class="text-success"><?php echo $time_shift_shift; ?></a><br>
        <span class="text-muted small">{{ $time_shift_time_start . ' to '. $time_shift_time_end }}</span>
	</td>
	<td>
        <?php $companies = $mod->_get_shift_options( $record_id, true , false, 2); ?>
        @if(empty($companies))
            <span id="time_shift_company" class="text-muted small">-</span>
        @else
            @foreach ($companies as $company)
                <span id="time_shift_company" class="text-muted small">{{ $company }} / </span>
            @endforeach
        @endif    
	</td>
	<!-- td>< ?php $departments = $mod->_get_shift_options( $record_id, true , false, 4); ?>
        @if(empty($departments))
            <span id="time_shift_department" class="badge badge-default">All</span>
        @else
            @foreach ($departments as $department)
                <span id="time_shift_department" class="badge badge-default">{{ $department }}</span>
            @endforeach
        @endif
    </td -->
	<!-- td class="hidden-xs">
        <span id="time_shift_color;" class="{{ (isset($time_shift_color) && $time_shift_color != '') ? 'badge' : '' }}" style="background-color:{{ strtoupper($time_shift_color) }};"> {{ strtoupper($time_shift_color) }}</span>
    </td -->
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
                <li><a href="{{ get_mod_route('shift'). '/shift_policy/'. $record_id }}"><i class="fa fa-cogs"></i> Set Policy</a></li>
            </ul>
        </div>
    </td>
</tr>