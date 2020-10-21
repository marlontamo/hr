<tr class="record">
    <td class="hidden-xs"><input type="checkbox" value="{{ $record_id }}" class="record-checker checkboxes"></td>
    <td>
    	<span class="text-success">{{ $requisition_created_by }}</span>
		<br>
		<span class="text-muted small">{{ $requisition_id_no }}</span>
    </td>
	<td>
		<span class="text-info">{{ $requisition_project_name }}</span><br>
		<span class="text-muted small">{{ date('M d, Y', strtotime($requisition_created_on)) }}</span>
	</td>
	<td class="hidden-xs">{{ number_format($requisition_no_of_items, 2, '.', ',') }}<br></td>
	<td class="hidden-xs">
		{{ number_format($requisition_total_price, 2, '.', ',') }}
		@if( $requisition_total_price >= $requisition_cfg['mc_approval'] )
			<br/>
			<span class="text-muted small">w/ MC Approval</span>
		@endif
	</td>
	<td class="hidden-xs">
		<span class="label {{ $status_class }}">{{ $requisition_status }}</span><br>
		<span class="text-muted small">{{ $requisition_priority_id }}</span>
	</td>
	<td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> View</a>
        </div>
    </td>
</tr>