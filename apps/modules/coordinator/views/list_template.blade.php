<tr class="record">
	<td class="hidden-xs"></td>
    <td>{{ $users_coordinator_company}}</td>
    <td>{{ $users_coordinator_branch}}</td>
    <td>{{ $users_coordinator_coordinator}}</td>
    <td>{{ $users_coordinator_user}}</td>
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