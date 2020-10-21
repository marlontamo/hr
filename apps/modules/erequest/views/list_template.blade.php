<tr class="record">
	<!-- this first column shows the year of this holiday item -->
	<td>
		<a href="{{$edit_url}}" class="text-success">{{$resources_request_request}}</a>
	</td>
    <td class="hidden-xs"><?php echo date("M-d",strtotime($resources_request_created_on)); ?> <span class="text-muted small"><?php echo date("D",strtotime($resources_request_created_on)); ?></span><br>
        <span class="text-muted small"><?php echo date("Y",strtotime($resources_request_created_on)); ?></span>
    </td>
    <td class="hidden-xs"><?php echo date("M-d",strtotime($resources_request_date_needed)); ?> <span class="text-muted small"><?php echo date("D",strtotime($resources_request_date_needed)); ?></span><br>
        <span class="text-muted small"><?php echo date("Y",strtotime($resources_request_date_needed)); ?></span>
    </td>
	<td>
		@if($status == 'Open')
		<span class="badge badge-warning">{{$status}}</span><br>
		@elseif($status == 'Close')
		<span class="badge badge-success">{{$status}}</span><br>
		@else
		<span class="badge badge-danger">{{$status}}</span><br>
		@endif

		<span class="text-muted small">{{$request_status}}</span>

		@if($status == 'Open' AND $discussion_count > 0)
		<br>
		<span class="text-muted small">Discussion 
			<span class="badge badge-info">{{$discussion_count}}</span>
		</span>
		@endif
	</td>
	<td>
		@if(in_array($request_status_id, array(1,2,3,5)))
	        <div class="btn-group">
	            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>
	        </div>
	    @else
		    <div class="btn-group">
				<a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> {{ lang('common.view') }}</a>
			</div>
	    @endif		
	<!-- 	@if(in_array($request_status_id, array(1,2,3,5)))
			<div class="btn-group">
				<a class="btn btn-xs text-muted"><i class="fa fa-ban"></i> Cancel</a>
			</div>
		@endif -->
	</td>
</tr>