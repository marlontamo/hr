<tr class="record">
	<!-- <td><input type="checkbox" class="checkboxes" value="1" /></td> -->
	<td>
		<a id="date_name" href="#" class="text-success">{{$display_name}}</a>
		<br />
		<span id="date_set" class="small">{{$position}}</span>
	</td>
<!-- 	<td class="hidden-xs">
		@if(strtotime($date_cleared))
			<?php $date_to = (strtotime($turn_around_time)) ? $turn_around_time : date('Y-m-d');
				$tat = no_days_between_dates( $date_cleared,  $date_to); ?> -->
			<!-- {{ ($tat > 0) ? $tat : 0}} day/s -->
<!-- 			{{ $tat }} day/s -->
<!-- 			<br>
			<span class="small">{{ date('F d, Y', strtotime($date_cleared))}}</span>
		@endif

		<br> -->
		<!-- <span class="text-danger small">Turnaround Time Exceeded</span> -->
<!-- 	</td> -->
	<td class="hidden-xs">{{date('F d, Y', strtotime($effectivity_date))}}</td>
	<td>
		@if( $clearance_status == 'Cleared' )
			<span class="badge badge-success">{{$clearance_status}}</span>
		@elseif($clearance_status == 'Cancelled')
			<span class="badge badge-default">{{$clearance_status}}</span>
		@else
			<span class="badge badge-warning">{{$clearance_status}}</span>
		@endif
	</td>
	
	<td>
		@if( $clearance_status_id <= 3 )
			<div class="btn-group">
				<a class="btn btn-xs text-muted" href="{{$edit_url}}"><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>
			</div>
		@endif
		<div class="btn-group">
			<a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('common.options') }}</a>
			<ul class="dropdown-menu pull-right">
				<li><a href="{{ $detail_url }}"><i class="fa fa-search"></i> {{ lang('common.view') }}</a></li>
<!--         		<li><a href="#"><i class="fa fa-check text-success"></i> {{ lang('common.clear') }}</a></li>
        		<li><a href="#"><i class="fa fa-ban text-danger"></i> {{ lang('common.cancel') }}</a></li> -->
    		</ul>
		</div>
	</td>
</tr>