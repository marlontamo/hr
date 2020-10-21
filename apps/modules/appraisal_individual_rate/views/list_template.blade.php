<tr class="record">
	<td>
		{{ $performance_appraisal_year }}
	</td>
	<td>
		@if( in_array($applicable_status_id, array(8,9,10) ) )
			<a class="text-success" href="{{ $mod->url }}/crowdsource/{{ $record_id }}/{{ $user_id }}">{{ $performance_type }}</a>
        @elseif( $applicable_status_id > 1 )
        	<a class="text-success" href="{{ $mod->url }}/review/{{ $record_id }}/{{ $user_id }}">{{ $performance_type }}</a>
        @else
        	<a class="text-success" href="{{ $edit_url }}/{{ $user_id }}">{{ $performance_type }}</a>
    	@endif
		<br>
		<span class="small" id="date_set">{{ date('M d, Y', strtotime( $performance_appraisal_date_from ) ) }} to {{ date('M d, Y', strtotime( $performance_appraisal_date_to ) ) }}</span>
	</td>
    <td class="hidden-xs text-muted">
    {{ $performance_appraisal_notes }}
    </td>
	<td>
		@if($status_id == 1)
			<span class="badge badge-info">Open</span>
		@else
			<span class="badge badge-success">Closed</span>
		@endif
		<br/>
		<span class="small">{{ $applicable_status }}</span>
	</td>
	<td>
        <div class="btn-group">
            @if( in_array($applicable_status_id, array(8,9,10) ) )
            	<a class="small text-muted" href="{{ $mod->url }}/crowdsource/{{ $record_id }}/{{ $user_id }}"><i class="fa fa-search"></i> View</a>
            @elseif( $applicable_status_id > 1 )
            	<a class="small text-muted" href="{{ $mod->url }}/review/{{ $record_id }}/{{ $user_id }}"><i class="fa fa-search"></i> View</a>
            @else
            	<a class="small text-muted" href="{{ $edit_url }}/{{ $user_id }}"><i class="fa fa-search"></i> View</a>
        	@endif
        </div>
    </td>
</tr>