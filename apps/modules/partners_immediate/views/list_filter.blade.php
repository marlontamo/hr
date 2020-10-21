<div class="portlet">

	<style>
		.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
	</style>

	<div class="portlet-title margin-top-20" style="margin-bottom:3px;">
		<div class="caption">{{ lang('partners_immediate.status') }}</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted">{{ lang('partners_immediate.filter_by_emp_status') }}</span>
		<div class="margin-top-10">
			<span class="filter-status event-block label label-default" filter_value="">{{ lang('common.all') }}</span>
			<span class="filter-status event-block label label-success" filter_value="1">{{ lang('partners_immediate.active') }}</span>
			<span class="filter-status event-block label label-default" filter_value="0">{{ lang('partners_immediate.inactive') }}</span>
		</div>
	</div>
</div>