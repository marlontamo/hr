<tr class="record">
    <td class="hidden-xs"><input type="checkbox" value="{{ $record_id }}" class="record-checker checkboxes"></td>
	<td>
		<span class="text-info">{{ $requisition_project_name }}</span><br>
		<span class="text-muted small">{{ date('M d, Y', strtotime($requisition_created_on)) }}</span>
	</td>
	<td class="hidden-xs">
		{{ $requisition_approver }}
		@if( $requisition_total_price >= $requisition_cfg['mc_approval'] )
			<br/>
			<span class="text-muted small">w/ MC Approval</span>
		@endif
	</td>
	<td class="hidden-xs">{{ number_format($requisition_total_price, 2, '.', ',') }}</td>
	
	<td class="hidden-xs">
		<span class="label {{ $status_class }}">{{ $requisition_status }}</span><br>
		<span class="text-muted small">{{ $requisition_priority_id }}</span>
	</td>
	<td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> View</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>