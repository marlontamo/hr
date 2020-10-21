<div class="portlet">

	<style>
		.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
	</style>

	<div class="portlet-title" style="margin-bottom:3px;">
		<div class="caption">{{ lang('leave_balance_admin.leave_type') }}</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted margin-bottom-10">{{ lang('leave_balance_admin.filter_lb_lt') }}</span>
		<div class="margin-top-10">
			<span class="filter-type event-block label label-success" filter_value="">{{ lang('common.all') }}</span>
			@foreach( $leave_forms as $index => $leave_form )
	        	<span href="javascript:void(0)" class="filter-type event-block label label-default" filter_value="{{ $index }}">{{ $leave_form }}</span>
	        @endforeach
		</div>
	</div>

	<div class="portlet-title margin-top-20" style="margin-bottom:3px;">
		<div class="caption">{{ lang('leave_balance_admin.year') }}</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted">{{ lang('leave_balance_admin.filter_lb_yc') }}</span>
		<div class="margin-top-10">
			<span class="filter-status event-block label label-success" filter_value="">{{ lang('common.all') }}</span>
			@foreach( $years as $index => $year )
				<span class="filter-status event-block label label-default" filter_value="{{$year}}">{{$year}}</span>
	        @endforeach
		</div>
	</div>
</div>