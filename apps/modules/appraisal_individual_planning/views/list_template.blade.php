<tr class="record">
	<!-- <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td> -->
	<td>
		{{ $performance_planning_year }}
	</td>
	<td class="hidden-xs">
		<a class="text-success" href="{{ $edit_url }}/{{ $user_id }}">{{ $performance_type }}</a>
		<br>
		<span class="small" id="date_set">{{ date('M d, Y', strtotime( $performance_planning_date_from ) ) }} to {{ date('M d, Y', strtotime( $performance_planning_date_to ) ) }}</span>
	</td>
    <td class="text-muted">
        {{ $performance_planning_notes }}
    </td>
	<td class="hidden-xs">
		@if($status_id == 1)
			<span class="badge badge-info">Open</span>
		@else
			<span class="badge badge-success">Closed</span>
		@endif
		<br>
		<span class="text-muted small">
         	 {{ $performance_status }}
        </span>
        <br>
        @if(strtolower($performance_planning_applicable_status_id) != 4)
            <span class="text-muted small">ATTENTION: {{ $to_user }}</span>
        @endif
	</td>
	<td>
        <div class="btn-group">
            <?php $edit_status_id = array(0,1,3); ?>
            @if($to_user_id == $user_id AND (in_array($applicable_status_id, $edit_status_id)))
            <a class="small text-muted" href="{{ $edit_url }}/{{ $user_id }}"><i class="fa fa-pencil"></i> 
             {{ lang('common.edit') }}
         	</a>
         	@else         	
            <a class="small text-muted" href="{{ $edit_url }}/{{ $user_id }}"><i class="fa fa-search"></i> 
            	{{ lang('common.view') }}
         	</a>
         	@endif
			
        </div>
    </td>
</tr>