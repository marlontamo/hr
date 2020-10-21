<div class="portlet">

	<style>
		.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
	</style>

	<div class="portlet-title" style="margin-bottom:3px;">
		<div class="caption">Appraisal Status</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted margin-bottom-10">Filter by appraisal status.</span>
		<div class="margin-top-10">
			<span class="list-filter event-block label label-success" filter_value="">All</span>
			@foreach( $status as $stat )
			<span class="list-filter event-block label label-default" filter_by="ww_performance_appraisal_applicable.status_id" filter_value="{{ $stat->performance_status_id }}">{{ $stat->performance_status }}</span>
	        @endforeach
		</div>
	</div>

</div>