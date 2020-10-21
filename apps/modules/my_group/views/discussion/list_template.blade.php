<tr class="record">
    <td>
        <a id="group_name" href="{{ $mod->url }}/discussion/{{ $record_id }}" class="text-success" data-toggle="modal" href="#process">{{ $groups_group_name }}</a>
		<br>
		<span id="created" class="small text-muted">{{ date('M d, Y', strtotime( $groups_created_on )) }} / {{ sizeof( $mod->_get_members($record_id) ) }} member(s)</span>
    </td>
    <td>
        <span class="small">{{ $groups_description }}</span>
    </td>
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